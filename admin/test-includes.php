<?php
echo "Testing includes step by step...<br>";

try {
    echo "Step 1: Including auth.php...<br>";
    require_once '../includes/auth.php';
    echo "Step 2: auth.php included successfully<br>";
    
    echo "Step 3: Creating Auth object...<br>";
    $auth = new Auth();
    echo "Step 4: Auth object created successfully<br>";
    
    echo "Step 5: Including translations.php...<br>";
    require_once '../includes/translations.php';
    echo "Step 6: translations.php included successfully<br>";
    
    echo "Step 7: Including db.php...<br>";
    require_once '../includes/db.php';
    echo "Step 8: db.php included successfully<br>";
    
    echo "Step 9: All includes successful!<br>";
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "<br>";
} catch (Error $e) {
    echo "Fatal Error: " . $e->getMessage() . "<br>";
}
?>
