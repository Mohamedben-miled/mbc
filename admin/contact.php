<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/contact.php';

// Require admin access
$auth->requireAdmin();

$user = $auth->getCurrentUser();

// Get page number from URL
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 20;
$status = isset($_GET['status']) ? sanitizeInput($_GET['status']) : null;

// Get submissions
$submissions = $contact->getSubmissions($page, $limit, $status);
$totalSubmissions = $contact->getSubmissionsCount($status);
$totalPages = ceil($totalSubmissions / $limit);

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $submissionId = intval($_GET['id']);
    
    switch ($_GET['action']) {
        case 'mark_read':
            $contact->updateStatus($submissionId, 'read');
            $success = 'Message marqué comme lu.';
            break;
        case 'mark_replied':
            $contact->updateStatus($submissionId, 'replied');
            $success = 'Message marqué comme répondu.';
            break;
        case 'delete':
            if ($contact->deleteSubmission($submissionId)) {
                $success = 'Message supprimé avec succès.';
            } else {
                $error = 'Erreur lors de la suppression du message.';
            }
            break;
    }
    
    if (isset($success) || isset($error)) {
        // Refresh the page
        redirect('/admin/contact.php' . ($status ? '?status=' . $status : ''));
    }
}

// Get statistics
$newCount = $contact->getNewSubmissionsCount();
$totalCount = $contact->getSubmissionsCount();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de contact - MBC Expert Comptable</title>
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .stat-card .number {
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
        }

        .filters {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
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
        }

        .card-header h3 {
            color: #1e293b;
            font-size: 18px;
            font-weight: 600;
        }

        .card-content {
            padding: 20px;
        }

        .submission-item {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .submission-header {
            background: #f8fafc;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .submission-info h4 {
            color: #1e293b;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .submission-meta {
            color: #64748b;
            font-size: 12px;
        }

        .submission-actions {
            display: flex;
            gap: 8px;
        }

        .submission-content {
            padding: 16px;
        }

        .submission-message {
            color: #374151;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .submission-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            font-size: 14px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-item i {
            color: #667eea;
            width: 16px;
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

        .status-replied {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #5a67d8;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-success {
            background: #10b981;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #f1f5f9;
            border-color: #667eea;
            color: #667eea;
        }

        .pagination .active {
            background: #667eea;
            border-color: #667eea;
            color: white;
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

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.5;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters {
                flex-wrap: wrap;
            }

            .submission-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .submission-details {
                grid-template-columns: 1fr;
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
                <a href="contact.php" class="nav-item active">
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
                <a href="logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Messages de contact</h1>
            </div>

            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total messages</h3>
                    <div class="number"><?php echo $totalCount; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Nouveaux messages</h3>
                    <div class="number"><?php echo $newCount; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Messages lus</h3>
                    <div class="number"><?php echo $contact->getSubmissionsCount('read'); ?></div>
                </div>
                <div class="stat-card">
                    <h3>Messages répondu</h3>
                    <div class="number"><?php echo $contact->getSubmissionsCount('replied'); ?></div>
                </div>
            </div>

            <div class="filters">
                <a href="contact.php" class="filter-btn <?php echo !$status ? 'active' : ''; ?>">
                    Tous (<?php echo $totalCount; ?>)
                </a>
                <a href="?status=new" class="filter-btn <?php echo $status === 'new' ? 'active' : ''; ?>">
                    Nouveaux (<?php echo $newCount; ?>)
                </a>
                <a href="?status=read" class="filter-btn <?php echo $status === 'read' ? 'active' : ''; ?>">
                    Lus (<?php echo $contact->getSubmissionsCount('read'); ?>)
                </a>
                <a href="?status=replied" class="filter-btn <?php echo $status === 'replied' ? 'active' : ''; ?>">
                    Répondu (<?php echo $contact->getSubmissionsCount('replied'); ?>)
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Liste des messages</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($submissions)): ?>
                        <div class="empty-state">
                            <i class="fas fa-envelope"></i>
                            <h3>Aucun message pour le moment</h3>
                            <p>Les messages de contact apparaîtront ici.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($submissions as $submission): ?>
                            <div class="submission-item">
                                <div class="submission-header">
                                    <div class="submission-info">
                                        <h4><?php echo htmlspecialchars($submission['subject']); ?></h4>
                                        <div class="submission-meta">
                                            <span class="status-badge status-<?php echo $submission['status']; ?>">
                                                <?php echo $submission['status']; ?>
                                            </span>
                                            • <?php echo formatDateTime($submission['created_at']); ?>
                                        </div>
                                    </div>
                                    <div class="submission-actions">
                                        <?php if ($submission['status'] === 'new'): ?>
                                            <a href="?action=mark_read&id=<?php echo $submission['id']; ?><?php echo $status ? '&status=' . $status : ''; ?>" class="btn btn-success" title="Marquer comme lu">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($submission['status'] !== 'replied'): ?>
                                            <a href="?action=mark_replied&id=<?php echo $submission['id']; ?><?php echo $status ? '&status=' . $status : ''; ?>" class="btn btn-secondary" title="Marquer comme répondu">
                                                <i class="fas fa-reply"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="mailto:<?php echo htmlspecialchars($submission['email']); ?>?subject=Re: <?php echo urlencode($submission['subject']); ?>" class="btn" title="Répondre par email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                        
                                        <a href="?action=delete&id=<?php echo $submission['id']; ?><?php echo $status ? '&status=' . $status : ''; ?>" class="btn btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="submission-content">
                                    <div class="submission-message">
                                        <?php echo nl2br(htmlspecialchars($submission['message'])); ?>
                                    </div>
                                    <div class="submission-details">
                                        <div class="detail-item">
                                            <i class="fas fa-user"></i>
                                            <span><?php echo htmlspecialchars($submission['name']); ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-envelope"></i>
                                            <span><?php echo htmlspecialchars($submission['email']); ?></span>
                                        </div>
                                        <?php if ($submission['phone']): ?>
                                            <div class="detail-item">
                                                <i class="fas fa-phone"></i>
                                                <span><?php echo htmlspecialchars($submission['phone']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($totalPages > 1): ?>
                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?><?php echo $status ? '&status=' . $status : ''; ?>">
                                        <i class="fas fa-chevron-left"></i> Précédent
                                    </a>
                                <?php endif; ?>

                                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <span class="active"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <a href="?page=<?php echo $i; ?><?php echo $status ? '&status=' . $status : ''; ?>"><?php echo $i; ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?php echo $page + 1; ?><?php echo $status ? '&status=' . $status : ''; ?>">
                                        Suivant <i class="fas fa-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
