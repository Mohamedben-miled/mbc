<?php
require_once __DIR__ . '/../includes/auth.php';

// Logout user
$auth->logout();

// Redirect to login page
redirect('/admin/login.php');
?>
