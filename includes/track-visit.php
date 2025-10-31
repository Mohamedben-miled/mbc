<?php
/**
 * Endpoint to track page visits
 */

require_once __DIR__ . '/traffic.php';

header('Content-Type: application/json');

// Only track on non-admin pages
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
if (strpos($currentPath, '/admin/') !== false) {
    echo json_encode(['success' => false, 'message' => 'Admin pages not tracked']);
    exit;
}

// Get data from request
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
} else {
    // GET request for duration update
    $data = [
        'page_url' => $_GET['page_url'] ?? '',
        'duration' => $_GET['duration'] ?? 0
    ];
}

if (empty($data)) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

// Get client IP
$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';

$trackData = [
    'page_url' => $data['page_url'] ?? $_SERVER['REQUEST_URI'] ?? '',
    'page_title' => $data['page_title'] ?? '',
    'referrer' => $data['referrer'] ?? $_SERVER['HTTP_REFERER'] ?? '',
    'user_agent' => $data['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '',
    'ip_address' => $ip_address,
    'session_id' => $data['session_id'] ?? session_id()
];

$tracker = new TrafficTracker();
$result = $tracker->trackVisit($trackData);

echo json_encode([
    'success' => $result,
    'message' => $result ? 'Visit tracked' : 'Tracking failed'
]);

