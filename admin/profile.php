<?php
require_once __DIR__ . '/../includes/auth.php';

// Require admin access
$auth->requireAdmin();

$currentUser = $auth->getCurrentUser();
$error = '';
$success = '';

// Get user ID from URL (for editing other users) or use current user
$userId = isset($_GET['id']) ? intval($_GET['id']) : $currentUser['id'];
$isOwnProfile = $userId === $currentUser['id'];

// Get user data
$user = $isOwnProfile ? $currentUser : null;
if (!$isOwnProfile) {
    // Get other user's data (admin only)
    $users = $auth->getAllUsers();
    foreach ($users as $u) {
        if ($u['id'] === $userId) {
            $user = $u;
            break;
        }
    }
    if (!$user) {
        redirect('/admin/users.php');
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitizeInput($_POST['full_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validate data
    if (empty($fullName) || empty($email)) {
        $error = 'Le nom complet et l\'email sont requis.';
    } elseif (!validateEmail($email)) {
        $error = 'L\'adresse email n\'est pas valide.';
    } elseif (!empty($password) && strlen($password) < PASSWORD_MIN_LENGTH) {
        $error = 'Le mot de passe doit contenir au moins ' . PASSWORD_MIN_LENGTH . ' caractères.';
    } elseif (!empty($password) && $password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        $updateData = [
            'full_name' => $fullName,
            'email' => $email
        ];
        
        if (!empty($password)) {
            $updateData['password'] = $password;
        }
        
        if ($auth->updateProfile($userId, $updateData)) {
            $success = 'Profil mis à jour avec succès.';
            
            // Update session if it's the current user
            if ($isOwnProfile) {
                $_SESSION['full_name'] = $fullName;
                $_SESSION['email'] = $email;
                $currentUser = $auth->getCurrentUser(); // Refresh current user data
            }
            
            // Refresh user data
            if ($isOwnProfile) {
                $user = $currentUser;
            } else {
                $users = $auth->getAllUsers();
                foreach ($users as $u) {
                    if ($u['id'] === $userId) {
                        $user = $u;
                        break;
                    }
                }
            }
        } else {
            $error = 'Erreur lors de la mise à jour du profil.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isOwnProfile ? 'Mon profil' : 'Profil utilisateur'; ?> - MBC Expert Comptable</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #334155;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .sidebar-header img {
            max-width: 120px;
            height: auto;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            display: block;
            padding: 12px 20px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover, .nav-item.active {
            background: #f1f5f9;
            color: #667eea;
            border-left-color: #667eea;
        }

        .nav-item i {
            width: 20px;
            margin-right: 12px;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1e293b;
            font-size: 28px;
            font-weight: 600;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-header h3 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
        }

        .card-content {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .help-text {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 600;
        }

        .user-details h2 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .user-details p {
            color: #64748b;
            margin-bottom: 4px;
        }

        .user-role {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            margin-top: 8px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .user-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/mbc.png" alt="MBC Expert Comptable">
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    Tableau de bord
                </a>
                <a href="blog.php" class="nav-item">
                    <i class="fas fa-blog"></i>
                    Articles de blog
                </a>
                <a href="blog-create.php" class="nav-item">
                    <i class="fas fa-plus"></i>
                    Nouvel article
                </a>
                <a href="contact.php" class="nav-item">
                    <i class="fas fa-envelope"></i>
                    Messages de contact
                </a>
                <a href="users.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    Utilisateurs
                </a>
                <a href="profile.php" class="nav-item active">
                    <i class="fas fa-user"></i>
                    Mon profil
                </a>
            </nav>

            <div class="logout-btn">
                <a href="logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1><?php echo $isOwnProfile ? 'Mon profil' : 'Profil utilisateur'; ?></h1>
                <?php if (!$isOwnProfile): ?>
                    <a href="users.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Retour aux utilisateurs
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                </div>
                <div class="user-details">
                    <h2><?php echo htmlspecialchars($user['full_name']); ?></h2>
                    <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><i class="fas fa-calendar"></i> Membre depuis <?php echo formatDate($user['created_at']); ?></p>
                    <span class="user-role"><?php echo htmlspecialchars($user['role']); ?></span>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Modifier le profil</h3>
                </div>
                <div class="card-content">
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">Nom complet *</label>
                                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                <div class="help-text">Prénom et nom</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <div class="help-text">Adresse email valide</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" placeholder="Laissez vide pour ne pas changer">
                                <div class="help-text">Minimum <?php echo PASSWORD_MIN_LENGTH; ?> caractères</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password">Confirmer le mot de passe</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez le nouveau mot de passe">
                                <div class="help-text">Doit correspondre au nouveau mot de passe</div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn">
                                <i class="fas fa-save"></i>
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password && confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            const confirmPassword = document.getElementById('confirm_password');
            if (confirmPassword.value && this.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
