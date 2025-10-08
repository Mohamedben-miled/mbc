<?php
/**
 * UTF-8 Encoding Configuration
 * This file ensures proper UTF-8 encoding for all database operations
 */

// Set PHP internal encoding to UTF-8
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// Set default timezone
date_default_timezone_set('Europe/Paris');

// Set locale for French
setlocale(LC_ALL, 'fr_FR.UTF-8', 'fr_FR', 'french');

/**
 * Ensure UTF-8 encoding for database connection
 */
function ensureUtf8Encoding($connection) {
    if ($connection instanceof PDO) {
        $connection->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
        $connection->exec("SET CHARACTER SET utf8mb4");
        $connection->exec("SET collation_connection = utf8mb4_unicode_ci");
    }
}

/**
 * Clean and encode text for display
 */
function cleanText($text) {
    if (is_string($text)) {
        // Remove any non-UTF-8 characters
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        // Clean any remaining invalid characters
        $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        return $text;
    }
    return $text;
}

/**
 * Ensure proper encoding for database output
 */
function ensureUtf8Output($data) {
    if (is_array($data)) {
        return array_map('ensureUtf8Output', $data);
    } elseif (is_string($data)) {
        return cleanText($data);
    }
    return $data;
}

// Set headers for UTF-8
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}
?>

