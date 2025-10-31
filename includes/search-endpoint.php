<?php
/**
 * Search API Endpoint
 */

require_once __DIR__ . '/search.php';

header('Content-Type: application/json');

if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    echo json_encode(['results' => []]);
    exit;
}

$query = trim($_GET['q']);
$search = new SiteSearch();
$results = $search->search($query, 10);

echo json_encode(['results' => $results]);

