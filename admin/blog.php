<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/blog.php';

// Require admin access
$auth->requireAdmin();

$user = $auth->getCurrentUser();

// Get page number from URL
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10;

// Get posts for admin (all statuses)
$posts = $blog->getPosts($page, $limit, null);
$totalPosts = $blog->countAllPosts();
$totalPages = ceil($totalPosts / $limit);

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $postId = intval($_GET['id']);
    if ($blog->deletePost($postId)) {
        $success = 'Article supprimé avec succès.';
        // Refresh the page to show updated list
        redirect('blog.php');
    } else {
        $error = 'Erreur lors de la suppression de l\'article.';
    }
}

// Handle status change
if (isset($_POST['change_status'])) {
    $postId = intval($_POST['post_id']);
    $newStatus = $_POST['status'];
    
    if ($blog->updatePost($postId, ['status' => $newStatus])) {
        $success = 'Statut de l\'article mis à jour.';
        // Refresh the page
        redirect('blog.php');
    } else {
        $error = 'Erreur lors de la mise à jour du statut.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des articles - MBC Expert Comptable</title>
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

        .btn-success {
            background: #10b981;
        }

        .btn-success:hover {
            background: #059669;
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

        .posts-table {
            width: 100%;
            border-collapse: collapse;
        }

        .posts-table th,
        .posts-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .posts-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .posts-table tr:hover {
            background: #f8fafc;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-published {
            background: #d1fae5;
            color: #065f46;
        }

        .status-draft {
            background: #f3f4f6;
            color: #374151;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .actions .btn {
            padding: 6px 12px;
            font-size: 12px;
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

        .form-inline {
            display: inline;
        }

        .form-inline select {
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 12px;
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

            .posts-table {
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
                <a href="blog.php" class="nav-item active">
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
                <h1>Gestion des articles</h1>
                <a href="blog-create.php" class="btn">
                    <i class="fas fa-plus"></i>
                    Nouvel article
                </a>
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

            <div class="card">
                <div class="card-header">
                    <h3>Liste des articles (<?php echo $totalPosts; ?> total)</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($posts)): ?>
                        <div style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fas fa-file-alt" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                            <h3>Aucun article pour le moment</h3>
                            <p>Créez votre premier article pour commencer.</p>
                            <a href="blog-create.php" class="btn" style="margin-top: 20px;">
                                <i class="fas fa-plus"></i>
                                Créer un article
                            </a>
                        </div>
                    <?php else: ?>
                        <table class="posts-table">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Temps de lecture</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                            <?php if ($post['excerpt']): ?>
                                                <br><small style="color: #64748b;"><?php echo htmlspecialchars($post['excerpt']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                                        <td><?php echo formatDate($post['created_at']); ?></td>
                                        <td>
                                            <form method="POST" class="form-inline">
                                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Brouillon</option>
                                                    <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Publié</option>
                                                </select>
                                                <input type="hidden" name="change_status" value="1">
                                            </form>
                                        </td>
                                        <td><?php echo $post['read_time']; ?> min</td>
                                        <td>
                                            <div class="actions">
                                                <a href="blog-edit.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="../blog-post.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary" title="Voir" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="?action=delete&id=<?php echo $post['id']; ?>" class="btn btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php if ($totalPages > 1): ?>
                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>">
                                        <i class="fas fa-chevron-left"></i> Précédent
                                    </a>
                                <?php endif; ?>

                                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <span class="active"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>">
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
