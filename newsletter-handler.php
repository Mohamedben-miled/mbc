<?php
/**
 * Newsletter Subscription Handler
 */

require_once __DIR__ . '/includes/contact.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get email
$email = sanitizeInput($_POST['email'] ?? '');

// Validate email
if (empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'L\'adresse email est requise.'
    ]);
    exit;
}

if (!validateEmail($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'L\'adresse email n\'est pas valide.'
    ]);
    exit;
}

// Subscribe to newsletter
if ($contact->subscribeNewsletter($email)) {
    echo json_encode([
        'success' => true,
        'message' => 'Vous avez été abonné à notre newsletter avec succès.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue lors de l\'abonnement. Veuillez réessayer.'
    ]);
}
?>
