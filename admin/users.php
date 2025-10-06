<?php
require_once __DIR__ . '/../includes/auth.php';

// Require admin access
$auth->requireAdmin();

$user = $auth->getCurrentUser();

$error = '';
$success = '';

// Handle user creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = sanitizeInput($_POST['username'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $fullName = sanitizeInput($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = sanitizeInput($_POST['role'] ?? 'admin');
    
    // Validate data
    if (empty($username) || empty($email) || empty($fullName) || empty($password)) {
        $error = 'Tous les champs sont requis.';
    } elseif (!validateEmail($email)) {
        $error = 'L\'adresse email n\'est pas valide.';
    } elseif (strlen($password) < PASSWORD_MIN_LENGTH) {
        $error = 'Le mot de passe doit contenir au moins ' . PASSWORD_MIN_LENGTH . ' caractères.';
    } else {
        $userData = [
            'username' => $username,
            'email' => $email,
            'full_name' => $fullName,
            'password' => $password,
            'role' => $role
        ];
        
        if ($auth->createUser($userData)) {
            $success = 'Utilisateur créé avec succès.';
        } else {
            $error = 'Erreur lors de la création de l\'utilisateur. L\'utilisateur ou l\'email existe peut-être déjà.';
        }
    }
}

// Handle user deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    
    // Prevent self-deletion
    if ($userId === $user['id']) {
        $error = 'Vous ne pouvez pas supprimer votre propre compte.';
    } else {
        if ($auth->deleteUser($userId)) {
            $success = 'Utilisateur supprimé avec succès.';
        } else {
            $error = 'Erreur lors de la suppression de l\'utilisateur.';
        }
    }
    
    if (isset($success) || isset($error)) {
        // Refresh the page
        redirect('/admin/users.php');
    }
}

// Get all users
$users = $auth->getAllUsers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - MBC Expert Comptable</title>
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

        .btn-danger {
            background: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th,
        .users-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .users-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .users-table tr:hover {
            background: #f8fafc;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .actions .btn {
            padding: 6px 12px;
            font-size: 12px;
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

        .current-user {
            background: #f0f9ff;
            border-left: 4px solid #0ea5e9;
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

            .users-table {
                font-size: 14px;
            }

            .actions {
                flex-direction: column;
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
                <a href="users.php" class="nav-item active">
                    <i class="fas fa-users"></i>
                    Utilisateurs
                </a>
                <a href="profile.php" class="nav-item">
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
                <h1>Gestion des utilisateurs</h1>
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

            <!-- Create User Form -->
            <div class="card">
                <div class="card-header">
                    <h3>Créer un nouvel utilisateur</h3>
                </div>
                <div class="card-content">
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur *</label>
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                                <div class="help-text">Nom d'utilisateur unique</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                                <div class="help-text">Adresse email valide</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">Nom complet *</label>
                                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                                <div class="help-text">Prénom et nom</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Mot de passe *</label>
                                <input type="password" id="password" name="password" required>
                                <div class="help-text">Minimum <?php echo PASSWORD_MIN_LENGTH; ?> caractères</div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="role">Rôle</label>
                            <select id="role" name="role">
                                <option value="admin" <?php echo ($_POST['role'] ?? 'admin') === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                            </select>
                            <div class="help-text">Tous les utilisateurs sont administrateurs</div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="create_user" class="btn">
                                <i class="fas fa-user-plus"></i>
                                Créer l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users List -->
            <div class="card">
                <div class="card-header">
                    <h3>Liste des utilisateurs (<?php echo count($users); ?> total)</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($users)): ?>
                        <div style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                            <h3>Aucun utilisateur pour le moment</h3>
                            <p>Créez votre premier utilisateur pour commencer.</p>
                        </div>
                    <?php else: ?>
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>Nom d'utilisateur</th>
                                    <th>Email</th>
                                    <th>Nom complet</th>
                                    <th>Rôle</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $userItem): ?>
                                    <tr class="<?php echo $userItem['id'] === $user['id'] ? 'current-user' : ''; ?>">
                                        <td>
                                            <strong><?php echo htmlspecialchars($userItem['username']); ?></strong>
                                            <?php if ($userItem['id'] === $user['id']): ?>
                                                <span style="color: #0ea5e9; font-size: 12px;">(Vous)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($userItem['email']); ?></td>
                                        <td><?php echo htmlspecialchars($userItem['full_name']); ?></td>
                                        <td>
                                            <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 6px; font-size: 11px; text-transform: uppercase;">
                                                <?php echo htmlspecialchars($userItem['role']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo formatDate($userItem['created_at']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a href="profile.php?id=<?php echo $userItem['id']; ?>" class="btn btn-secondary" title="Modifier le profil">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if ($userItem['id'] !== $user['id']): ?>
                                                    <a href="?action=delete&id=<?php echo $userItem['id']; ?>" class="btn btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
