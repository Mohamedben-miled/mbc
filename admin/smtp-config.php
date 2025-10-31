<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/email.php';

// Require admin access
$auth->requireAdmin();

$user = $auth->getCurrentUser();
$emailManager = new EmailManager();

$success = '';
$error = '';
$testResult = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'test') {
        // Test SMTP connection
        $testConfig = [
            'host' => $_POST['host'] ?? '',
            'port' => intval($_POST['port'] ?? 587),
            'encryption' => $_POST['encryption'] ?? 'tls'
        ];
        $testResult = $emailManager->testConnection($testConfig);
    } else {
        // Save configuration
        $data = [
            'enabled' => isset($_POST['enabled']) ? 1 : 0,
            'host' => $_POST['host'] ?? '',
            'port' => intval($_POST['port'] ?? 587),
            'encryption' => $_POST['encryption'] ?? 'tls',
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
            'from_email' => $_POST['from_email'] ?? '',
            'from_name' => $_POST['from_name'] ?? 'MBC Expert Comptable',
            'notification_email' => $_POST['notification_email'] ?? ''
        ];

        if ($emailManager->saveConfig($data)) {
            $success = 'Configuration SMTP sauvegardée avec succès !';
            // Reload config
            $emailManager = new EmailManager();
        } else {
            $error = 'Erreur lors de la sauvegarde de la configuration.';
        }
    }
}

$config = $emailManager->getConfig();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration SMTP - MBC Expert Comptable</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="admin-styles.css">
    <style>
        .admin-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        .config-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .config-card h2 {
            color: #1e293b;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 600;
            font-size: 0.9375rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #296871;
            box-shadow: 0 0 0 3px rgba(41, 104, 113, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #296871;
            color: white;
        }

        .btn-primary:hover {
            background: #1e4a52;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(41, 104, 113, 0.3);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #3b82f6;
        }

        .info-box {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 4px;
        }

        .info-box h3 {
            color: #1e40af;
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }

        .info-box p {
            color: #1e3a8a;
            margin: 0.25rem 0;
            font-size: 0.9375rem;
        }

        .test-result {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 8px;
        }

        .test-result.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .test-result.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

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
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .sidebar.mobile-visible {
            transform: translateX(0);
        }

        .mobile-sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: #296871;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-overlay.active {
            display: block;
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
            color: #296871;
            border-left-color: #296871;
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

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .admin-container {
                padding: 1rem;
            }

            .mobile-sidebar-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .mobile-overlay {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <button class="mobile-sidebar-toggle" onclick="toggleSidebar()" style="display: none;">
            <i class="fas fa-bars"></i>
        </button>
        <div class="mobile-overlay" onclick="closeSidebar()" style="display: none;"></div>
        <div class="sidebar" id="sidebar" style="width: 280px; background: white; position: fixed; height: 100vh; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.1);">
            <div class="sidebar-header" style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
                <img src="../assets/mbc.png" alt="MBC Expert Comptable" style="max-width: 120px;">
            </div>
            <nav class="sidebar-nav" style="padding: 20px 0;">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                </a>
                <a href="blog.php" class="nav-item">
                    <i class="fas fa-blog"></i> Articles de blog
                </a>
                <a href="contact.php" class="nav-item">
                    <i class="fas fa-envelope"></i> Messages de contact
                </a>
                <a href="users.php" class="nav-item">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
                <a href="profile.php" class="nav-item">
                    <i class="fas fa-user"></i> Mon profil
                </a>
                <a href="support-config.php" class="nav-item">
                    <i class="fas fa-robot"></i> Configuration Support
                </a>
                <a href="smtp-config.php" class="nav-item active">
                    <i class="fas fa-envelope"></i> Configuration SMTP
                </a>
            </nav>
            <div style="padding: 20px; border-top: 1px solid #e2e8f0;">
                <a href="../index.php" class="btn btn-secondary" style="width: 100%; margin-bottom: 10px;">
                    <i class="fas fa-home"></i> Retour au site
                </a>
                <a href="logout.php" class="btn btn-secondary" style="width: 100%;">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="admin-container">
        <h1 style="margin-bottom: 2rem; color: #1e293b;">Configuration SMTP</h1>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($testResult): ?>
            <div class="test-result <?php echo $testResult['success'] ? 'success' : 'error'; ?>">
                <i class="fas fa-<?php echo $testResult['success'] ? 'check' : 'times'; ?>-circle"></i>
                <?php echo htmlspecialchars($testResult['message']); ?>
            </div>
        <?php endif; ?>

        <div class="info-box">
            <h3><i class="fas fa-info-circle"></i> Configuration SMTP</h3>
            <p>Configurez vos paramètres SMTP pour recevoir des notifications par email lorsqu'un nouveau message est reçu via le formulaire de contact.</p>
            <p><strong>Note:</strong> Les emails de notification seront envoyés à l'adresse configurée dans "Email de notification".</p>
        </div>

        <div class="config-card">
            <h2><i class="fas fa-cog"></i> Paramètres SMTP</h2>
            
            <form method="POST" action="">
                <div class="checkbox-group form-group">
                    <input type="checkbox" id="enabled" name="enabled" value="1" <?php echo ($config['enabled'] ?? 0) ? 'checked' : ''; ?>>
                    <label for="enabled" style="margin: 0; cursor: pointer;">Activer les notifications par email</label>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="host">Serveur SMTP *</label>
                        <input type="text" id="host" name="host" value="<?php echo htmlspecialchars($config['host'] ?? 'smtp.gmail.com'); ?>" required>
                        <small style="color: #6b7280; font-size: 0.875rem;">Ex: smtp.gmail.com, smtp.outlook.com</small>
                    </div>

                    <div class="form-group">
                        <label for="port">Port *</label>
                        <input type="number" id="port" name="port" value="<?php echo htmlspecialchars($config['port'] ?? 587); ?>" required>
                        <small style="color: #6b7280; font-size: 0.875rem;">587 (TLS) ou 465 (SSL)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="encryption">Chiffrement *</label>
                    <select id="encryption" name="encryption" required>
                        <option value="tls" <?php echo ($config['encryption'] ?? 'tls') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                        <option value="ssl" <?php echo ($config['encryption'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                        <option value="none" <?php echo ($config['encryption'] ?? '') === 'none' ? 'selected' : ''; ?>>Aucun</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur SMTP *</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($config['username'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe SMTP *</label>
                        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($config['password'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="from_email">Email expéditeur *</label>
                        <input type="email" id="from_email" name="from_email" value="<?php echo htmlspecialchars($config['from_email'] ?? ''); ?>" required>
                        <small style="color: #6b7280; font-size: 0.875rem;">Email utilisé comme expéditeur</small>
                    </div>

                    <div class="form-group">
                        <label for="from_name">Nom expéditeur</label>
                        <input type="text" id="from_name" name="from_name" value="<?php echo htmlspecialchars($config['from_name'] ?? 'MBC Expert Comptable'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notification_email">Email de notification *</label>
                    <input type="email" id="notification_email" name="notification_email" value="<?php echo htmlspecialchars($config['notification_email'] ?? ''); ?>" required>
                    <small style="color: #6b7280; font-size: 0.875rem;">Email où seront envoyées les notifications de nouveaux messages</small>
                </div>

                <div class="btn-group">
                    <button type="submit" name="action" value="save" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <button type="submit" name="action" value="test" class="btn btn-secondary">
                        <i class="fas fa-vial"></i> Tester la connexion
                    </button>
                </div>
            </form>
        </div>

        <div class="config-card">
            <h2><i class="fas fa-question-circle"></i> Aide</h2>
            <h3>Configuration Gmail</h3>
            <ul>
                <li><strong>Serveur SMTP:</strong> smtp.gmail.com</li>
                <li><strong>Port:</strong> 587 (TLS) ou 465 (SSL)</li>
                <li><strong>Chiffrement:</strong> TLS ou SSL</li>
                <li><strong>Nom d'utilisateur:</strong> Votre adresse Gmail complète</li>
                <li><strong>Mot de passe:</strong> Utilisez un mot de passe d'application (pas votre mot de passe Gmail)</li>
            </ul>
            
            <h3 style="margin-top: 1.5rem;">Configuration Outlook/Hotmail</h3>
            <ul>
                <li><strong>Serveur SMTP:</strong> smtp-mail.outlook.com</li>
                <li><strong>Port:</strong> 587</li>
                <li><strong>Chiffrement:</strong> TLS</li>
            </ul>

            <h3 style="margin-top: 1.5rem;">Créer un mot de passe d'application Gmail</h3>
            <ol>
                <li>Allez sur <a href="https://myaccount.google.com/security" target="_blank">Votre compte Google</a></li>
                <li>Activez la validation en deux étapes</li>
                <li>Allez dans "Mots de passe des applications"</li>
                <li>Créez un nouveau mot de passe d'application</li>
                <li>Utilisez ce mot de passe dans la configuration SMTP</li>
            </ol>
        </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.toggle('mobile-visible');
            overlay.classList.toggle('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.remove('mobile-visible');
            overlay.classList.remove('active');
        }

        // Responsive sidebar
        if (window.innerWidth <= 768) {
            document.querySelector('.mobile-sidebar-toggle').style.display = 'block';
            document.querySelector('.mobile-overlay').style.display = 'block';
            document.getElementById('sidebar').classList.add('mobile-hidden');
        }
    </script>
</body>
</html>

