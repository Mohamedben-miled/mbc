<?php
/**
 * Temporary Password Change Page
 * This page allows changing a user's password
 */

require_once 'includes/encoding.php';
require_once 'config/database.php';
require_once 'includes/auth.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'Tous les champs sont requis.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($newPassword) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            // Check if user exists
            $stmt = $connection->prepare("SELECT id, username, full_name FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            
            if (!$user) {
                $error = 'Utilisateur non trouvé.';
            } else {
                // Update password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $connection->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                
                if ($stmt->execute([$hashedPassword, $user['id']])) {
                    $message = "Mot de passe modifié avec succès pour l'utilisateur : " . htmlspecialchars($user['full_name']);
                } else {
                    $error = "Erreur lors de la modification du mot de passe.";
                }
            }
        } catch (Exception $e) {
            $error = "Erreur : " . $e->getMessage();
        }
    }
}

// Get all users for reference
$users = [];
try {
    $db = Database::getInstance();
    $connection = $db->getConnection();
    $stmt = $connection->prepare("SELECT id, username, email, full_name, role, created_at FROM users ORDER BY created_at DESC");
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    $error = "Erreur lors du chargement des utilisateurs : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mot de passe - MBC Expert Comptable</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            margin: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            max-width: 120px;
            height: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            width: 100%;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background: #5a67d8;
        }

        .btn-secondary {
            background: #6c757d;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .message {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .users-list {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .users-list h3 {
            margin-top: 0;
            color: #333;
        }

        .user-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .user-item:last-child {
            border-bottom: none;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-details {
            font-size: 14px;
            color: #666;
        }

        .user-role {
            background: #667eea;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .user-role.admin {
            background: #dc3545;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            .user-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .user-role {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="assets/mbc.png" alt="MBC Expert Comptable">
        </div>
        
        <div class="header">
            <h1>Modifier mot de passe</h1>
            <p>Changez le mot de passe d'un utilisateur</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur ou Email</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required placeholder="Entrez le nom d'utilisateur ou l'email">
            </div>

            <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password" required placeholder="Nouveau mot de passe">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirmer le nouveau mot de passe">
            </div>

            <button type="submit" class="btn">Modifier le mot de passe</button>
        </form>

        <?php if (!empty($users)): ?>
            <div class="users-list">
                <h3>Utilisateurs existants</h3>
                <?php foreach ($users as $user): ?>
                    <div class="user-item">
                        <div class="user-info">
                            <div class="user-name"><?php echo htmlspecialchars($user['full_name']); ?></div>
                            <div class="user-details">
                                <strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?> | 
                                <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
                            </div>
                        </div>
                        <div class="user-role <?php echo $user['role'] === 'admin' ? 'admin' : ''; ?>">
                            <?php echo ucfirst($user['role']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="links">
            <a href="create-user.php">Créer un utilisateur</a>
            <a href="admin/login.php">Se connecter</a>
            <a href="index.php">Retour au site</a>
        </div>
    </div>
</body>
</html>
