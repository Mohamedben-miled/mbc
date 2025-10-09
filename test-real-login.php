<?php
session_start();

// Simulate a real login by creating a user in the database first
require_once 'includes/db.php';

try {
    require_once 'config/database.php';
    $db = Database::getInstance();
    $pdo = $db;
    
    // Check if test user exists
    $stmt = $pdo->prepare("SELECT id, username, full_name, role FROM users WHERE username = 'testuser'");
    $stmt->execute();
    $user = $stmt->fetch();
    
    if ($user) {
        // Set session like a real login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();
        $_SESSION['language'] = 'fr';
        
        echo "✅ Real user login successful!<br>";
        echo "User ID: " . $user['id'] . "<br>";
        echo "Username: " . $user['username'] . "<br>";
        echo "Full Name: " . $user['full_name'] . "<br>";
        echo "Role: " . $user['role'] . "<br>";
        echo "Session ID: " . session_id() . "<br>";
        
        // Test Auth class
        require_once 'includes/auth.php';
        $auth = new Auth();
        
        echo "isLoggedIn(): " . ($auth->isLoggedIn() ? 'true' : 'false') . "<br>";
        echo "isAdmin(): " . ($auth->isAdmin() ? 'true' : 'false') . "<br>";
        
        echo "<br><a href='index.php'>Go to index.php to test dropdown</a><br>";
        echo "<a href='admin/logout.php'>Logout</a>";
        
    } else {
        echo "❌ Test user not found in database.<br>";
        echo "Creating test user...<br>";
        
        // Create test user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, full_name, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $password_hash = password_hash('testpass', PASSWORD_DEFAULT);
        $stmt->execute(['testuser', 'test@example.com', $password_hash, 'Test User', 'admin']);
        
        echo "✅ Test user created!<br>";
        echo "<a href='test-real-login.php'>Try again</a>";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
    echo "Make sure the database is set up correctly.<br>";
}
?>
