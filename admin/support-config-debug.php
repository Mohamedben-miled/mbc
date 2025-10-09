<?php
// Debug version of support-config.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log debug info
$debug_log = "DEBUG LOG - admin/support-config.php\n";
$debug_log .= "=====================================\n";
$debug_log .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
$debug_log .= "PHP Version: " . phpversion() . "\n";
$debug_log .= "Error Reporting: " . error_reporting() . "\n";
$debug_log .= "Memory Limit: " . ini_get('memory_limit') . "\n";
$debug_log .= "Max Execution Time: " . ini_get('max_execution_time') . "\n";
$debug_log .= "=====================================\n";

try {
    $debug_log .= "Step 1: Starting file execution\n";
    
    // Check if files exist
    $debug_log .= "Step 2: Checking required files\n";
    if (!file_exists('../includes/auth.php')) {
        $debug_log .= "ERROR: auth.php not found\n";
        throw new Exception("auth.php not found");
    }
    if (!file_exists('../includes/translations.php')) {
        $debug_log .= "ERROR: translations.php not found\n";
        throw new Exception("translations.php not found");
    }
    if (!file_exists('../includes/db.php')) {
        $debug_log .= "ERROR: db.php not found\n";
        throw new Exception("db.php not found");
    }
    
    $debug_log .= "Step 3: Including required files\n";
    require_once '../includes/auth.php';
    $debug_log .= "Step 4: auth.php included successfully\n";
    
    require_once '../includes/translations.php';
    $debug_log .= "Step 5: translations.php included successfully\n";
    
    require_once '../includes/db.php';
    $debug_log .= "Step 6: db.php included successfully\n";
    
    $debug_log .= "Step 7: Creating Auth object\n";
    $auth = new Auth();
    $debug_log .= "Step 8: Auth object created successfully\n";
    
    $debug_log .= "Step 9: Checking login status\n";
    $auth->requireLogin();
    $debug_log .= "Step 10: Login check passed\n";
    
    $debug_log .= "Step 11: Checking admin status\n";
    $auth->requireAdmin();
    $debug_log .= "Step 12: Admin check passed\n";
    
    $debug_log .= "Step 13: Getting current user\n";
    $currentUser = $auth->getCurrentUser();
    $debug_log .= "Step 14: Current user: " . ($currentUser['username'] ?? 'unknown') . "\n";
    
    $debug_log .= "Step 15: Getting language from session\n";
    $currentLanguage = $_SESSION['language'] ?? 'fr';
    $debug_log .= "Step 16: Current language: " . $currentLanguage . "\n";
    
    $debug_log .= "Step 17: All checks passed successfully\n";
    
} catch (Exception $e) {
    $debug_log .= "ERROR: " . $e->getMessage() . "\n";
    $debug_log .= "Stack trace: " . $e->getTraceAsString() . "\n";
} catch (Error $e) {
    $debug_log .= "FATAL ERROR: " . $e->getMessage() . "\n";
    $debug_log .= "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Write debug log to file
file_put_contents('../debug.txt', $debug_log, FILE_APPEND);

// Display debug info
echo "<h1>Debug Information</h1>";
echo "<pre>" . htmlspecialchars($debug_log) . "</pre>";

// If we get here, show success message
echo "<h2>All checks passed! The issue might be in the original file.</h2>";
echo "<p>Check the debug.txt file for detailed logs.</p>";
?>
