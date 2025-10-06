<?php
/**
 * Authentication System for MBC Website
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Login user
     */
    public function login($username, $password) {
        try {
            $stmt = $this->db->prepare("SELECT id, username, email, password_hash, full_name, role FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_time'] = time();
                
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        // Check session timeout
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > SESSION_TIMEOUT) {
            $this->logout();
            return false;
        }

        return true;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin() {
        return $this->isLoggedIn() && $_SESSION['role'] === 'admin';
    }

    /**
     * Get current user data
     */
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'],
            'full_name' => $_SESSION['full_name'],
            'role' => $_SESSION['role']
        ];
    }

    /**
     * Logout user
     */
    public function logout() {
        session_destroy();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Require login
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            redirect('/admin/login.php');
        }
    }

    /**
     * Require admin access
     */
    public function requireAdmin() {
        if (!$this->isAdmin()) {
            redirect('../admin/login.php');
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile($userId, $data) {
        try {
            $fields = [];
            $values = [];

            if (isset($data['full_name'])) {
                $fields[] = "full_name = ?";
                $values[] = $data['full_name'];
            }

            if (isset($data['email'])) {
                $fields[] = "email = ?";
                $values[] = $data['email'];
            }

            if (isset($data['password']) && !empty($data['password'])) {
                $fields[] = "password_hash = ?";
                $values[] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if (empty($fields)) {
                return false;
            }

            $values[] = $userId;
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Profile update error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all users (admin only)
     */
    public function getAllUsers() {
        try {
            $stmt = $this->db->query("SELECT id, username, email, full_name, role, created_at FROM users ORDER BY created_at DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get users error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create new user (admin only)
     */
    public function createUser($data) {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, full_name, role) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['username'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['full_name'],
                $data['role'] ?? 'admin'
            ]);
        } catch (PDOException $e) {
            error_log("Create user error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete user (admin only)
     */
    public function deleteUser($userId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }
}

// Initialize auth instance
$auth = new Auth();
?>
