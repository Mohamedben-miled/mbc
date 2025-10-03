<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/blog.php';

// Require admin access
$auth->requireAdmin();

$user = $auth->getCurrentUser();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $excerpt = sanitizeInput($_POST['excerpt'] ?? '');
    $readTime = intval($_POST['read_time'] ?? 5);
    $status = sanitizeInput($_POST['status'] ?? 'draft');
    
    // Validate required fields
    if (empty($title) || empty($content)) {
        $error = 'Le titre et le contenu sont requis.';
    } else {
        // Handle file uploads
        $coverImage = '';
        $contentFile = '';
        
        // Upload cover image
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadedImage = $blog->uploadFile($_FILES['cover_image'], 'image');
            if ($uploadedImage) {
                $coverImage = $uploadedImage;
            } else {
                $error = 'Erreur lors de l\'upload de l\'image de couverture.';
            }
        }
        
        // Upload content file
        if (isset($_FILES['content_file']) && $_FILES['content_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $blog->uploadFile($_FILES['content_file'], 'document');
            if ($uploadedFile) {
                $contentFile = $uploadedFile;
            } else {
                $error = 'Erreur lors de l\'upload du fichier de contenu.';
            }
        }
        
        // Generate excerpt if not provided
        if (empty($excerpt)) {
            $excerpt = $blog->generateExcerpt($content);
        }
        
        // Estimate reading time if not provided
        if ($readTime <= 0) {
            $readTime = $blog->estimateReadingTime($content);
        }
        
        if (empty($error)) {
            // Create the blog post
            $postData = [
                'title' => $title,
                'content' => $content,
                'excerpt' => $excerpt,
                'cover_image' => $coverImage,
                'content_file' => $contentFile,
                'read_time' => $readTime,
                'author_id' => $user['id'],
                'status' => $status
            ];
            
            if ($blog->createPost($postData)) {
                $success = 'Article créé avec succès.';
                // Redirect to blog list after a short delay
                header("refresh:2;url=blog.php");
            } else {
                $error = 'Erreur lors de la création de l\'article.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article - MBC Expert Comptable</title>
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

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: border-color 0.3s ease;
        }

        .file-upload:hover {
            border-color: #667eea;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload-label {
            cursor: pointer;
            color: #667eea;
            font-weight: 500;
        }

        .file-upload-label:hover {
            color: #5a67d8;
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
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .help-text {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
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
                <a href="blog-create.php" class="nav-item active">
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
                <h1>Créer un nouvel article</h1>
                <a href="blog.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
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

            <div class="card">
                <div class="card-header">
                    <h3>Informations de l'article</h3>
                </div>
                <div class="card-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Titre de l'article *</label>
                            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>
                            <div class="help-text">Le titre doit être accrocheur et descriptif</div>
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Extrait (optionnel)</label>
                            <textarea id="excerpt" name="excerpt" rows="3" placeholder="Résumé court de l'article..."><?php echo htmlspecialchars($_POST['excerpt'] ?? ''); ?></textarea>
                            <div class="help-text">Si non renseigné, un extrait sera généré automatiquement</div>
                        </div>

                        <div class="form-group">
                            <label for="content">Contenu de l'article *</label>
                            <textarea id="content" name="content" rows="15" required placeholder="Rédigez votre article ici..."><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                            <div class="help-text">Utilisez le HTML pour la mise en forme</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="cover_image">Image de couverture</label>
                                <div class="file-upload">
                                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                                    <label for="cover_image" class="file-upload-label">
                                        <i class="fas fa-image"></i> Choisir une image
                                    </label>
                                    <div class="help-text">JPG, PNG, GIF, WebP (max 10MB)</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_file">Fichier de contenu (optionnel)</label>
                                <div class="file-upload">
                                    <input type="file" id="content_file" name="content_file" accept=".pdf,.doc,.docx,.txt">
                                    <label for="content_file" class="file-upload-label">
                                        <i class="fas fa-file"></i> Choisir un fichier
                                    </label>
                                    <div class="help-text">PDF, DOC, DOCX, TXT (max 10MB)</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="read_time">Temps de lecture (minutes)</label>
                                <input type="number" id="read_time" name="read_time" value="<?php echo $_POST['read_time'] ?? 5; ?>" min="1" max="60">
                                <div class="help-text">Estimation du temps de lecture</div>
                            </div>

                            <div class="form-group">
                                <label for="status">Statut</label>
                                <select id="status" name="status">
                                    <option value="draft" <?php echo ($_POST['status'] ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Brouillon</option>
                                    <option value="published" <?php echo ($_POST['status'] ?? '') === 'published' ? 'selected' : ''; ?>>Publié</option>
                                </select>
                                <div class="help-text">Choisissez si l'article doit être publié immédiatement</div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="blog.php" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn">
                                <i class="fas fa-save"></i>
                                Créer l'article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate reading time based on content length
        document.getElementById('content').addEventListener('input', function() {
            const content = this.value;
            const wordCount = content.split(/\s+/).length;
            const estimatedTime = Math.max(1, Math.ceil(wordCount / 200)); // 200 words per minute
            document.getElementById('read_time').value = estimatedTime;
        });

        // File upload preview
        document.getElementById('cover_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = this.nextElementSibling;
                label.innerHTML = `<i class="fas fa-image"></i> ${file.name}`;
            }
        });

        document.getElementById('content_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = this.nextElementSibling;
                label.innerHTML = `<i class="fas fa-file"></i> ${file.name}`;
            }
        });
    </script>
</body>
</html>
