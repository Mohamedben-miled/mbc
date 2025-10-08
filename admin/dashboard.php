<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/blog.php';
require_once __DIR__ . '/../includes/contact.php';

// Require admin access
$auth->requireAdmin();

$user = $auth->getCurrentUser();

// Get dashboard statistics
$totalPosts = $blog->countAllPosts();
$publishedPosts = $blog->countAllPosts(); // All posts are published
$draftPosts = 0; // No draft posts for now
$newSubmissions = $contact->getNewSubmissionsCount();
$totalSubmissions = $contact->getSubmissionsCount();

// Get recent data
$recentPosts = $blog->getRecentPosts(5);
$recentSubmissions = $contact->getSubmissions(1, 5);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - MBC Expert Comptable</title>
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
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .mobile-sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: #3b82f6;
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
            justify-content: between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1e293b;
            font-size: 28px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-card .number {
            color: #1e293b;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-card .change {
            color: #10b981;
            font-size: 12px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .card-header h3 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
        }

        .card-header a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }

        .card-content {
            padding: 20px;
        }

        .list-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .list-item-icon {
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: #667eea;
        }

        .list-item-content {
            flex: 1;
        }

        .list-item-title {
            color: #1e293b;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .list-item-meta {
            color: #64748b;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-new {
            background: #fef3c7;
            color: #92400e;
        }

        .status-read {
            background: #d1fae5;
            color: #065f46;
        }

        .status-published {
            background: #d1fae5;
            color: #065f46;
        }

        .status-draft {
            background: #f3f4f6;
            color: #374151;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
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

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
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

            .content-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <button class="mobile-sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="mobile-overlay" onclick="closeSidebar()"></div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../assets/mbc.png" alt="MBC Expert Comptable">
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item active">
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
                <a href="profile.php" class="nav-item">
                    <i class="fas fa-user"></i>
                    Mon profil
                </a>
            </nav>

            <div class="logout-btn">
                <a href="../index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i>
                    Retour au site
                </a>
                <a href="logout.php" class="btn btn-secondary" style="margin-top: 10px;">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Tableau de bord</h1>
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                    </div>
                    <div>
                        <div style="font-weight: 500;"><?php echo $user['full_name']; ?></div>
                        <div style="font-size: 12px; color: #64748b;"><?php echo $user['role']; ?></div>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total des articles</h3>
                    <div class="number"><?php echo $totalPosts; ?></div>
                    <div class="change"><?php echo $publishedPosts; ?> publiés</div>
                </div>

                <div class="stat-card">
                    <h3>Articles en brouillon</h3>
                    <div class="number"><?php echo $draftPosts; ?></div>
                    <div class="change">En attente de publication</div>
                </div>

                <div class="stat-card">
                    <h3>Nouveaux messages</h3>
                    <div class="number"><?php echo $newSubmissions; ?></div>
                    <div class="change">Non lus</div>
                </div>

                <div class="stat-card">
                    <h3>Total messages</h3>
                    <div class="number"><?php echo $totalSubmissions; ?></div>
                    <div class="change">Tous les messages</div>
                </div>
            </div>

            <div class="content-grid">
                <div class="card">
                    <div class="card-header">
                        <h3>Articles récents</h3>
                        <a href="blog.php">Voir tout</a>
                    </div>
                    <div class="card-content">
                        <?php if (empty($recentPosts)): ?>
                            <p style="color: #64748b; text-align: center; padding: 20px;">Aucun article pour le moment</p>
                        <?php else: ?>
                            <?php foreach ($recentPosts as $post): ?>
                                <div class="list-item">
                                    <div class="list-item-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="list-item-content">
                                        <div class="list-item-title"><?php echo htmlspecialchars($post['title']); ?></div>
                                        <div class="list-item-meta">
                                            Par <?php echo htmlspecialchars($post['author_name']); ?> • 
                                            <?php echo formatDate($post['created_at']); ?> • 
                                            <span class="status-badge status-<?php echo $post['status']; ?>">
                                                <?php echo $post['status']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Messages récents</h3>
                        <a href="contact.php">Voir tout</a>
                    </div>
                    <div class="card-content">
                        <?php if (empty($recentSubmissions)): ?>
                            <p style="color: #64748b; text-align: center; padding: 20px;">Aucun message pour le moment</p>
                        <?php else: ?>
                            <?php foreach ($recentSubmissions as $submission): ?>
                                <div class="list-item">
                                    <div class="list-item-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="list-item-content">
                                        <div class="list-item-title"><?php echo htmlspecialchars($submission['subject']); ?></div>
                                        <div class="list-item-meta">
                                            <?php echo htmlspecialchars($submission['name']); ?> • 
                                            <?php echo formatDate($submission['created_at']); ?> • 
                                            <span class="status-badge status-<?php echo $submission['status']; ?>">
                                                <?php echo $submission['status']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <a href="blog-create.php" class="btn">
                    <i class="fas fa-plus"></i>
                    Créer un nouvel article
                </a>
                <a href="contact.php" class="btn btn-secondary">
                    <i class="fas fa-envelope"></i>
                    Voir les messages
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh stats every 30 seconds
        setInterval(function() {
            location.reload();
        }, 30000);

        // Mobile sidebar functions
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

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-sidebar-toggle');
            const overlay = document.querySelector('.mobile-overlay');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('mobile-visible');
                    overlay.classList.remove('active');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-visible');
                overlay.classList.remove('active');
            }
        });
    </script>
</body>
</html>
