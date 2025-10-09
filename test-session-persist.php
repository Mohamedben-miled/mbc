<?php
session_start();

// Set session data
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'testuser';
$_SESSION['full_name'] = 'Test User';
$_SESSION['role'] = 'admin';
$_SESSION['login_time'] = time();
$_SESSION['language'] = 'fr';

echo "Session set. Session ID: " . session_id() . "<br>";
echo "Session data: " . print_r($_SESSION, true) . "<br>";

// Test Auth class
require_once 'includes/auth.php';
$auth = new Auth();

echo "isLoggedIn(): " . ($auth->isLoggedIn() ? 'true' : 'false') . "<br>";
echo "isAdmin(): " . ($auth->isAdmin() ? 'true' : 'false') . "<br>";

if ($auth->isLoggedIn()) {
    echo "✅ User is logged in!<br>";
    echo "Go to <a href='index.php'>index.php</a> to test the dropdown.<br>";
} else {
    echo "❌ User is not logged in.<br>";
}

echo "<br><a href='debug-session.php'>Check session persistence</a>";
?>
