<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/encoding.php';
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';
require_once 'includes/blog.php';

$auth = new Auth();
$blog = new Blog();

// Get search parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 9; // 3x3 grid

// Get posts based on search/category
if (!empty($search)) {
    $posts = $blog->searchPosts($search, $page, $limit);
    $totalPosts = $blog->countSearchPosts($search);
} elseif ($category > 0) {
    $posts = $blog->getPostsByCategory($category, $page, $limit);
    $totalPosts = $blog->countPostsByCategory($category);
} else {
    $posts = $blog->getPosts($page, $limit);
    $totalPosts = $blog->countAllPosts();
}

// Get categories and recent posts
$categories = $blog->getAllCategories();
$recentPosts = $blog->getRecentPosts(5);

$pageTitle = __("blog.title") . " - MBC Expert Comptable";
$pageDescription = __("blog.subtitle");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Découvrez nos articles sur l'expertise comptable, la création d'entreprise, la fiscalité et le conseil en gestion. Conseils d'experts pour entrepreneurs franco-maghrébins.">
    <meta name="keywords" content="blog comptable, expertise comptable, création entreprise, fiscalité, conseil gestion, entrepreneur, France">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo __('common.blog_meta_title'); ?>">
    <meta property="og:description" content="<?php echo __('common.blog_meta_description'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mbc-expertcomptable.fr/blog">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo __('common.blog_meta_title'); ?>">
    <meta name="twitter:description" content="<?php echo __('common.blog_meta_description'); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://mbc-expertcomptable.fr/blog">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/mbc.png">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="styles.css">
    
    <style>
        /* Professional Blog Styles */
        .blog-hero {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }
        
        .blog-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .blog-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .blog-hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            line-height: 1.1;
        }
        
        .blog-hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.6;
        }
        
        .blog-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .stat-item {
            text-align: center;
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            display: block;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.8;
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        /* Blog Content */
        .blog-content {
            padding: 80px 0;
            background: #f8fafc;
        }
        
        .blog-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .blog-main {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        
        /* Search Form */
        .blog-search {
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, #296871, #2e6a6e);
            border-radius: 16px;
            color: white;
        }
        
        .search-form {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .search-input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            color: #1e293b;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }
        
        .search-btn {
            padding: 1rem 2rem;
            background: white;
            color: #296871;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .search-results {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }
        
        /* Articles Grid */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .article-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
        }
        
        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .article-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .article-content {
            padding: 2rem;
        }
        
        .article-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #64748b;
        }
        
        .article-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .article-title {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1rem;
            color: #1e293b;
        }
        
        .article-excerpt {
            font-size: 1rem;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 1.5rem;
        }
        
        .article-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #296871;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        
        .article-link:hover {
            color: #1e40af;
            transform: translateX(4px);
        }
        
        /* Sidebar */
        .blog-sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .sidebar-widget {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
        }
        
        .widget-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1e293b;
            border-bottom: 3px solid #296871;
            padding-bottom: 0.75rem;
        }
        
        /* Categories */
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-list li {
            margin-bottom: 0.75rem;
        }
        
        .category-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            background: #f8f9fa;
            border-radius: 12px;
            text-decoration: none;
            color: #374151;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .category-link:hover {
            background: #e9ecef;
            transform: translateX(4px);
        }
        
        .category-count {
            background: #296871;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        /* Recent Articles */
        .recent-articles {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .recent-article {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }
        
        .recent-article:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        
        .recent-article-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }
        
        .recent-article-content {
            flex: 1;
        }
        
        .recent-article-title {
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 0.5rem;
            color: #1e293b;
        }
        
        .recent-article-date {
            font-size: 0.8rem;
            color: #64748b;
        }
        
        /* Newsletter */
        .newsletter-widget {
            background: linear-gradient(135deg, #296871, #2e6a6e);
            color: white;
        }
        
        .newsletter-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .newsletter-form {
            display: flex;
            gap: 1rem;
        }
        
        .newsletter-input {
            flex: 1;
            padding: 1rem 1.25rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            color: #1e293b;
        }
        
        .newsletter-btn {
            padding: 1rem 1.5rem;
            background: white;
            color: #296871;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        
        .newsletter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin: 3rem 0;
        }
        
        .pagination-btn,
        .pagination-number {
            padding: 1rem 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            text-decoration: none;
            color: #374151;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s ease;
            min-width: 50px;
            text-align: center;
        }
        
        .pagination-btn:hover,
        .pagination-number:hover {
            background: #f8f9fa;
            border-color: #296871;
            transform: translateY(-2px);
        }
        
        .pagination-number.active {
            background: #296871;
            color: white;
            border-color: #296871;
        }
        
        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }
        
        .no-results i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #cbd5e1;
        }
        
        .no-results h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #374151;
        }
        
        .no-results p {
            font-size: 1rem;
            margin-bottom: 2rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .blog-hero {
                padding: 80px 0 60px;
            }
            
            .blog-hero-title {
                font-size: 2.5rem;
            }
            
            .blog-hero-subtitle {
                font-size: 1.1rem;
            }
            
            .blog-stats {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .blog-layout {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 0 1rem;
            }
            
            .blog-main {
                padding: 2rem 1.5rem;
            }
            
            .articles-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .blog-sidebar {
                order: -1;
            }
        }
    </style>
</head>
<body class="blog-page">
    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.php#accueil" aria-label="MBC Expert Comptable - Retour à l'accueil">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" loading="eager" class="logo-img">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#simulators" class="nav-link" onclick="openSimulatorsModal()"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic-new.php" class="nav-link active"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact-form.php" class="nav-link"><?php echo __('nav.contact'); ?></a></li>
                    </ul>
                </nav>

                <!-- Header Utils -->
                <div class="header-utils">
                    <select class="language-selector" aria-label="<?php echo __('nav.select_language'); ?>" onchange="changeLanguage(this.value)">
                        <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>🇫🇷 FR</option>
                        <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>🇬🇧 EN</option>
                        <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>🇨🇳 中文</option>
                    </select>
                    
                    <!-- Authentication Section -->
                    <div class="auth-section">
                        <?php
                        if ($auth->isLoggedIn()): 
                            $currentUser = $auth->getCurrentUser(); ?>
                            <!-- User is logged in -->
                            <div class="user-menu">
                                <span class="user-greeting"><?php echo __('nav.hello'); ?>, <?php echo htmlspecialchars($currentUser['full_name']); ?></span>
                            </div>
                            <div class="user-dropdown">
                                <button class="user-dropdown-toggle" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="user-dropdown-menu">
                                    <?php if ($auth->isAdmin()): ?>
                                        <a href="admin/dashboard.php" class="dropdown-item">
                                            <i class="fas fa-tachometer-alt"></i> <?php echo __('nav.dashboard'); ?>
                                        </a>
                                        <a href="admin/blog.php" class="dropdown-item">
                                            <i class="fas fa-blog"></i> <?php echo __('nav.manage_blog'); ?>
                                        </a>
                                        <a href="admin/contact.php" class="dropdown-item">
                                            <i class="fas fa-envelope"></i> <?php echo __('nav.messages'); ?>
                                        </a>
                                        <a href="admin/users.php" class="dropdown-item">
                                            <i class="fas fa-users"></i> <?php echo __('nav.users'); ?>
                                        </a>
                                        <a href="admin/profile.php" class="dropdown-item">
                                            <i class="fas fa-user-edit"></i> <?php echo __('nav.my_profile'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="admin/logout.php" class="dropdown-item logout">
                                        <i class="fas fa-sign-out-alt"></i> <?php echo __('nav.logout'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- User is not logged in -->
                            <div class="auth-buttons">
                                <a href="admin/login.php" class="btn btn-connection">
                                    <i class="fas fa-sign-in-alt"></i> <?php echo __('btn.login'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <button class="mobile-menu-toggle" aria-label="<?php echo __('btn.open_mobile_menu'); ?>">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-content">
            <button class="mobile-nav-close" aria-label="<?php echo __('common.close_menu'); ?>">
                <i class="fas fa-times"></i>
            </button>
            <ul class="mobile-nav-list">
                <li><a href="index.php#accueil" class="mobile-nav-link"><?php echo __('nav.home'); ?></a></li>
                <li><a href="mbc.php" class="mobile-nav-link"><?php echo __('nav.about'); ?></a></li>
                <li><a href="services.php" class="mobile-nav-link"><?php echo __('nav.services'); ?></a></li>
                <li><a href="#simulators" class="mobile-nav-link"><?php echo __('nav.simulators'); ?></a></li>
                <li><a href="blog-dynamic.php" class="mobile-nav-link active"><?php echo __('nav.blog'); ?></a></li>
                <li><a href="contact-form.php" class="mobile-nav-link"><?php echo __('nav.contact'); ?></a></li>
            </ul>
            
            <!-- Mobile Auth Section -->
            <div class="mobile-auth">
                <?php if ($auth->isLoggedIn()): ?>
                    <div class="mobile-user-info">
                        <p><?php echo __('nav.hello'); ?>, <?php echo htmlspecialchars($currentUser['full_name']); ?></p>
                        <?php if ($auth->isAdmin()): ?>
                            <a href="admin/dashboard.php" class="btn btn-primary btn-sm"><?php echo __('nav.dashboard'); ?></a>
                        <?php endif; ?>
                        <a href="admin/logout.php" class="btn btn-outline btn-sm"><?php echo __('nav.logout'); ?></a>
                    </div>
                <?php else: ?>
                    <!-- Login button removed from mobile navbar - available in sidebar only -->
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="blog-hero-content">
            <h1 class="blog-hero-title"><?php echo __('blog.title'); ?></h1>
            <p class="blog-hero-subtitle"><?php echo __('blog.subtitle'); ?></p>
            
            <div class="blog-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo $totalPosts; ?></span>
                    <span class="stat-label">Articles</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($categories); ?></span>
                    <span class="stat-label"><?php echo __('blog.categories_title'); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5+</span>
                    <span class="stat-label">Experts</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="blog-content">
        <div class="blog-layout">
            <!-- Main Content -->
            <main class="blog-main">
                <!-- Search Form -->
                <div class="blog-search">
                    <form class="search-form" method="GET">
                        <input type="text" name="search" class="search-input" placeholder="<?php echo __('blog.search_placeholder'); ?>" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i> <?php echo __('common.search'); ?>
                        </button>
                    </form>
                    <?php if (!empty($search)): ?>
                        <div class="search-results">
                            <i class="fas fa-search"></i> 
                            <?php echo $totalPosts; ?> résultat(s) pour "<?php echo htmlspecialchars($search); ?>"
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Articles Grid -->
                <?php if (!empty($posts)): ?>
                    <div class="articles-grid">
                        <?php foreach ($posts as $post): ?>
                            <article class="article-card">
                                <div class="article-image">
                                    <?php if (!empty($post['cover_image'])): ?>
                                        <img src="<?php echo UPLOAD_URL . 'images/' . $post['cover_image']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                    <?php else: ?>
                                        <img src="assets/blog-placeholder.jpg" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="article-content">
                                    <div class="article-meta">
                                        <div class="article-meta-item">
                                            <i class="fas fa-calendar"></i>
                                            <span><?php echo formatDate($post['created_at']); ?></span>
                                        </div>
                                        <div class="article-meta-item">
                                            <i class="fas fa-user"></i>
                                            <span><?php echo htmlspecialchars($post['author_name']); ?></span>
                                        </div>
                                        <div class="article-meta-item">
                                            <i class="fas fa-clock"></i>
                                            <span><?php echo $post['read_time']; ?> min</span>
                                        </div>
                                    </div>
                                    <h3 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                    <p class="article-excerpt"><?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 150)) . '...'; ?></p>
                                    <a href="blog-post.php?id=<?php echo $post['id']; ?>" class="article-link">
                                        Lire l'article <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPosts > $limit): ?>
                        <div class="pagination">
                            <?php
                            $totalPages = ceil($totalPosts / $limit);
                            $currentPage = $page;
                            
                            // Previous button
                            if ($currentPage > 1):
                                $prevPage = $currentPage - 1;
                                $prevUrl = '?page=' . $prevPage;
                                if (!empty($search)) $prevUrl .= '&search=' . urlencode($search);
                                if ($category > 0) $prevUrl .= '&category=' . $category;
                            ?>
                                <a href="<?php echo $prevUrl; ?>" class="pagination-btn">
                                    <i class="fas fa-chevron-left"></i> Précédent
                                </a>
                            <?php else: ?>
                                <span class="pagination-btn disabled">
                                    <i class="fas fa-chevron-left"></i> Précédent
                                </span>
                            <?php endif; ?>

                            <div class="pagination-numbers">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php
                                    $pageUrl = '?page=' . $i;
                                    if (!empty($search)) $pageUrl .= '&search=' . urlencode($search);
                                    if ($category > 0) $pageUrl .= '&category=' . $category;
                                    ?>
                                    <a href="<?php echo $pageUrl; ?>" class="pagination-number <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>
                            </div>

                            <?php
                            // Next button
                            if ($currentPage < $totalPages):
                                $nextPage = $currentPage + 1;
                                $nextUrl = '?page=' . $nextPage;
                                if (!empty($search)) $nextUrl .= '&search=' . urlencode($search);
                                if ($category > 0) $nextUrl .= '&category=' . $category;
                            ?>
                                <a href="<?php echo $nextUrl; ?>" class="pagination-btn">
                                    Suivant <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php else: ?>
                                <span class="pagination-btn disabled">
                                    Suivant <i class="fas fa-chevron-right"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>Aucun article trouvé</h3>
                        <p>Essayez avec d'autres mots-clés ou parcourez nos catégories.</p>
                        <a href="blog-dynamic-new.php" class="btn btn-primary">Voir tous les articles</a>
                    </div>
                <?php endif; ?>
            </main>

            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <!-- Categories -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php echo __('blog.categories_title'); ?></h3>
                    <ul class="category-list">
                        <li><a href="blog-dynamic-new.php" class="category-link <?php echo $category == 0 ? 'active' : ''; ?>">
                            Toutes <span class="category-count">(<?php echo $totalPosts; ?>)</span>
                        </a></li>
                        <?php foreach ($categories as $cat): ?>
                            <li><a href="?category=<?php echo $cat['id']; ?>" class="category-link <?php echo $category == $cat['id'] ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($cat['name']); ?> 
                                <span class="category-count">(<?php echo $blog->countPostsByCategory($cat['id']); ?>)</span>
                            </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Recent Articles -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php echo __('blog.recent_title'); ?></h3>
                    <div class="recent-articles">
                        <?php foreach ($recentPosts as $recent): ?>
                            <a href="blog-post.php?id=<?php echo $recent['id']; ?>" class="recent-article">
                                <div class="recent-article-image">
                                    <?php if (!empty($recent['cover_image'])): ?>
                                        <img src="<?php echo UPLOAD_URL . 'images/' . $recent['cover_image']; ?>" alt="<?php echo htmlspecialchars($recent['title']); ?>">
                                    <?php else: ?>
                                        <img src="assets/blog-placeholder.jpg" alt="<?php echo htmlspecialchars($recent['title']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="recent-article-content">
                                    <h4 class="recent-article-title"><?php echo htmlspecialchars($recent['title']); ?></h4>
                                    <p class="recent-article-date"><?php echo formatDate($recent['created_at']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="sidebar-widget newsletter-widget">
                    <h3 class="widget-title"><?php echo __('blog.newsletter_title'); ?></h3>
                    <p class="newsletter-text"><?php echo __('blog.newsletter_subtitle'); ?></p>
                    <form class="newsletter-form" action="newsletter-handler.php" method="POST">
                        <input type="email" name="email" placeholder="<?php echo __('blog.newsletter_placeholder'); ?>" class="newsletter-input" required>
                        <button type="submit" class="newsletter-btn"><?php echo __('btn.subscribe'); ?></button>
                    </form>
                </div>
            </aside>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-icon">
                        <i class="fas fa-building" aria-hidden="true"></i>
                    </div>
                    <h3>MBC Expert Comptable</h3>
                    <p><?php echo __('footer.description'); ?></p>
                    <div class="social-links">
                        <a href="#" aria-label="<?php echo __('social.facebook'); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.linkedin'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.twitter'); ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.instagram'); ?>"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3><?php echo __('footer.quick_links'); ?></h3>
                    <ul>
                        <li><a href="#accueil"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="contact-form.php"><?php echo __('nav.contact'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3><?php echo __('footer.services'); ?></h3>
                    <ul>
                        <li><a href="#expertise"><?php echo __('services.expertise.title'); ?></a></li>
                        <li><a href="#fiscalite"><?php echo __('services.fiscalite.title'); ?></a></li>
                        <li><a href="#social"><?php echo __('services.social.title'); ?></a></li>
                        <li><a href="#conseil"><?php echo __('services.conseil.title'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3><?php echo __('footer.contact'); ?></h3>
                    <ul>
                        <li><i class="fas fa-phone" aria-hidden="true"></i> +33 1 23 45 67 89</li>
                        <li><i class="fas fa-envelope" aria-hidden="true"></i> contact@mbc-expertcomptable.fr</li>
                        <li><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?php echo __('location.paris'); ?></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo __('footer.copyright'); ?></p>
                <div>
                    <a href="#mentions"><?php echo __('footer.legal'); ?></a>
                    <a href="#confidentialite"><?php echo __('footer.privacy'); ?></a>
                    <a href="#cookies"><?php echo __('footer.terms'); ?></a>
                </div>
            </div>
        </div>
    </footer>

        <?php include 'includes/simulators-modal.php'; ?>

<!-- Scripts -->
    <script src="script.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/chatbot-multilingual-db.js"></script>
    
    <script>
        // Check for #simulators anchor on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === '#simulators') {
                openSimulatorsModal();
            }
        });
        
        // Listen for hash changes
        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#simulators') {
                openSimulatorsModal();
            } else {
                closeSimulatorsModal();
            }
        });
    </script>
</body>
</html>
