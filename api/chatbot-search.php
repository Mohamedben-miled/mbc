<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['message']) || !isset($input['language'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$message = trim($input['message']);
$language = $input['language'];

if (empty($message) || !in_array($language, ['fr', 'en', 'zh'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

try {
    // Search for matching Q&A entries
    $searchTerms = explode(' ', strtolower($message));
    $searchConditions = [];
    $searchParams = [];
    
    // Build search conditions for each term
    foreach ($searchTerms as $term) {
        if (strlen($term) > 2) { // Only search for terms longer than 2 characters
            $searchConditions[] = "(LOWER(question_fr) LIKE ? OR LOWER(question_en) LIKE ? OR LOWER(question_zh) LIKE ? OR LOWER(keywords) LIKE ?)";
            $searchParam = "%$term%";
            $searchParams[] = $searchParam;
            $searchParams[] = $searchParam;
            $searchParams[] = $searchParam;
            $searchParams[] = $searchParam;
        }
    }
    
    if (empty($searchConditions)) {
        echo json_encode(['answer' => null]);
        exit;
    }
    
    $sql = "SELECT * FROM chatbot_qa WHERE " . implode(' AND ', $searchConditions) . " ORDER BY created_at DESC LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($searchParams);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($results)) {
        echo json_encode(['answer' => null]);
        exit;
    }
    
    // Find the best match based on keyword relevance
    $bestMatch = null;
    $bestScore = 0;
    
    foreach ($results as $result) {
        $score = 0;
        $questionField = "question_$language";
        $answerField = "answer_$language";
        
        // Check if we have the answer in the requested language
        if (empty($result[$answerField])) {
            continue;
        }
        
        // Calculate relevance score
        foreach ($searchTerms as $term) {
            if (strlen($term) > 2) {
                if (stripos($result[$questionField], $term) !== false) {
                    $score += 3; // High score for question match
                }
                if (stripos($result[$answerField], $term) !== false) {
                    $score += 2; // Medium score for answer match
                }
                if (stripos($result['keywords'], $term) !== false) {
                    $score += 2; // Medium score for keyword match
                }
            }
        }
        
        if ($score > $bestScore) {
            $bestScore = $score;
            $bestMatch = $result;
        }
    }
    
    if ($bestMatch) {
        $answerField = "answer_$language";
        echo json_encode([
            'answer' => $bestMatch[$answerField],
            'question' => $bestMatch["question_$language"],
            'category' => $bestMatch['category'],
            'score' => $bestScore
        ]);
    } else {
        echo json_encode(['answer' => null]);
    }
    
} catch (PDOException $e) {
    error_log("Database error in chatbot search: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
} catch (Exception $e) {
    error_log("General error in chatbot search: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
?>
