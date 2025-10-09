<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting support-config.php...<br>";

try {
    require_once '../includes/auth.php';
    echo "auth.php loaded<br>";
    
    require_once '../includes/translations.php';
    echo "translations.php loaded<br>";
    
    require_once '../includes/db.php';
    echo "db.php loaded<br>";
    
    $auth = new Auth();
    echo "Auth object created<br>";
    
    // Skip login check for testing
    // $auth->requireLogin();
    // $auth->requireAdmin();
    
    echo "All includes successful!<br>";
    echo "Page should work now.<br>";
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "Fatal Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
