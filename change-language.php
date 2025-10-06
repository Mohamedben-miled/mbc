<?php
/**
 * Language Change Handler
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/includes/translations.php';

// Check if language is provided
if (isset($_POST['lang']) && in_array($_POST['lang'], ['fr', 'en', 'zh'])) {
    setLanguage($_POST['lang']);
}

// Redirect back to the previous page or home
$redirect_url = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: $redirect_url");
exit();
?>
