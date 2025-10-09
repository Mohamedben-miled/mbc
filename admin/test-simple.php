<?php
echo "PHP is working!<br>";
echo "Current time: " . date('Y-m-d H:i:s') . "<br>";

// Test if we can include files
try {
    echo "Testing includes...<br>";
    
    if (file_exists('../includes/auth.php')) {
        echo "auth.php exists<br>";
    } else {
        echo "auth.php NOT found<br>";
    }
    
    if (file_exists('../includes/translations.php')) {
        echo "translations.php exists<br>";
    } else {
        echo "translations.php NOT found<br>";
    }
    
    if (file_exists('../includes/db.php')) {
        echo "db.php exists<br>";
    } else {
        echo "db.php NOT found<br>";
    }
    
    echo "All file checks completed!<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>
