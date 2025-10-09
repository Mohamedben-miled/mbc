<?php
require_once __DIR__ . '/../config/database.php';

// Get database connection using existing configuration
$db = Database::getInstance();
$pdo = $db->getConnection();
?>
