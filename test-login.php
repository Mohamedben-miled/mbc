<?php
session_start();

// Simulate a logged-in user for testing
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'testuser';
$_SESSION['full_name'] = 'Test User';
$_SESSION['role'] = 'admin';
$_SESSION['login_time'] = time();
$_SESSION['language'] = 'fr';

echo "Session set for testing. User is now 'logged in'.<br>";
echo "Go to <a href='index.php'>index.php</a> to test the dropdown.<br>";
echo "Or <a href='admin/logout.php'>logout</a> to clear the session.";
?>
