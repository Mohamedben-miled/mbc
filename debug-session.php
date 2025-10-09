<?php
session_start();

echo "<h2>Session Debug</h2>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Session data:\n";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Auth Test</h3>";
require_once 'includes/auth.php';
$auth = new Auth();

echo "isLoggedIn(): " . ($auth->isLoggedIn() ? 'true' : 'false') . "<br>";
echo "isAdmin(): " . ($auth->isAdmin() ? 'true' : 'false') . "<br>";

if ($auth->isLoggedIn()) {
    $user = $auth->getCurrentUser();
    echo "Current user: " . print_r($user, true) . "<br>";
} else {
    echo "User not logged in<br>";
}
?>
