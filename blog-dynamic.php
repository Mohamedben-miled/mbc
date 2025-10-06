<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("blog.title") . " - MBC Expert Comptable";
$pageDescription = __("blog.subtitle");

// SEO Meta Tags
$seoKeywords = "blog expert comptable, articles comptabilité, fiscalité, création entreprise, conseils";
$ogImage = "https://mbc-expertcomptable.fr/assets/blog-og.jpg";
$twitterImage = "https://mbc-expertcomptable.fr/assets/blog-twitter.jpg";
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
    <meta property="og:title" content="Blog - MBC High Value Business Consulting">
    <meta property="og:description" content="Articles d'experts sur l'expertise comptable et la création d'entreprise">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mbc-expertcomptable.fr/blog">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blog - MBC High Value Business Consulting">
    <meta name="twitter:description" content="Articles d'experts sur l'expertise comptable et la création d'entreprise">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://mbc-expertcomptable.fr/blog">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/mbc.png">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="blog-page">
    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.html#accueil" aria-label="MBC Expert Comptable - Retour à l'accueil">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" loading="eager" class="logo-img">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#" class="nav-link simulators-link"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php" class="nav-link active" aria-current="page"><?php echo __('nav.blog'); ?></a></li>
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
                                <a href="admin/login.php" class="btn btn-outline btn-sm">
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


    <!-- Blog Content -->
    <section class="blog-content">
        <div class="container">
            <div class="blog-layout">
                <!-- Main Content -->
                <main class="blog-main">
                    <?php
                    // Include blog functions
                    require_once 'config/database.php';
                    require_once 'includes/blog.php';
                    
                    // Get page number from URL
                    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                    $limit = 6; // Posts per page
                    
                    // Get search query
                    $search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
                    
                    // Get category filter
                    $category = isset($_GET['category']) ? intval($_GET['category']) : null;
                    
                    // Get posts based on filters
                    if (!empty($search)) {
                        $posts = $blog->searchPosts($search, $page, $limit);
                        $totalPosts = $blog->countSearchPosts($search);
                    } elseif ($category) {
                        $posts = $blog->getPostsByCategory($category, $page, $limit);
                        $totalPosts = $blog->countPostsByCategory($category);
                    } else {
                        $posts = $blog->getAllPosts($page, $limit);
                        $totalPosts = $blog->countAllPosts();
                    }
                    
                    $totalPages = ceil($totalPosts / $limit);
                    
                    // Featured Article (first post)
                    if (!empty($posts)) {
                        $featuredPost = $posts[0];
                        ?>
                        <article class="featured-article">
                            <div class="article-image">
                                <?php if ($featuredPost['cover_image']): ?>
                                    <img src="<?php echo htmlspecialchars(UPLOAD_URL . 'images/' . $featuredPost['cover_image']); ?>" alt="<?php echo htmlspecialchars($featuredPost['title']); ?>">
                                <?php else: ?>
                                    <img src="assets/hero.jpg" alt="<?php echo htmlspecialchars($featuredPost['title']); ?>">
                                <?php endif; ?>
                                <div class="article-category"><?php echo htmlspecialchars($featuredPost['category_name'] ?? 'Article'); ?></div>
                            </div>
                            <div class="article-content">
                                <div class="article-meta">
                                    <span class="article-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo formatDate($featuredPost['created_at']); ?>
                                    </span>
                                    <span class="article-author">
                                        <i class="fas fa-user"></i>
                                        <?php echo htmlspecialchars($featuredPost['author_name']); ?>
                                    </span>
                                    <span class="article-read-time">
                                        <i class="fas fa-clock"></i>
                                        <?php echo htmlspecialchars($featuredPost['read_time'] ?? 5); ?> min de lecture
                                    </span>
                                </div>
                                <h2 class="article-title"><?php echo htmlspecialchars($featuredPost['title']); ?></h2>
                                <p class="article-excerpt"><?php echo htmlspecialchars(substr($featuredPost['content'], 0, 150) . '...'); ?></p>
                                <a href="blog-post.php?id=<?php echo $featuredPost['id']; ?>" class="article-link"><?php echo __('btn.read_article'); ?> <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </article>
                        <?php
                    }
                    ?>

                    <!-- Articles Grid -->
                    <div class="articles-grid">
                        <?php
                        // Display remaining posts (skip first one as it's featured)
                        $remainingPosts = array_slice($posts, 1);
                        
                        if (empty($remainingPosts)) {
                            echo '<p class="no-posts">' . __('blog.no_posts') . '</p>';
                        } else {
                            foreach ($remainingPosts as $post) {
                                ?>
                                <article class="article-card">
                                    <div class="article-image">
                                        <?php if ($post['cover_image']): ?>
                                            <img src="<?php echo htmlspecialchars(UPLOAD_URL . 'images/' . $post['cover_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                        <?php else: ?>
                                            <img src="assets/hero.jpg" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                        <?php endif; ?>
                                        <div class="article-category"><?php echo htmlspecialchars($post['category_name'] ?? 'Article'); ?></div>
                                    </div>
                                    <div class="article-content">
                                        <div class="article-meta">
                                            <span class="article-date"><?php echo formatDate($post['created_at']); ?></span>
                                            <span class="article-read-time"><?php echo htmlspecialchars($post['read_time'] ?? 5); ?> min</span>
                                        </div>
                                        <h3 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                        <p class="article-excerpt"><?php echo htmlspecialchars(substr($post['content'], 0, 100) . '...'); ?></p>
                                        <a href="blog-post.php?id=<?php echo $post['id']; ?>" class="article-link"><?php echo __('btn.read'); ?> <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </article>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $category ? '&category=' . $category : ''; ?>" class="pagination-btn">
                                <i class="fas fa-chevron-left"></i>
                                <?php echo __('btn.previous'); ?>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <i class="fas fa-chevron-left"></i>
                                <?php echo __('btn.previous'); ?>
                            </span>
                        <?php endif; ?>
                        
                        <div class="pagination-numbers">
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            for ($i = $startPage; $i <= $endPage; $i++):
                                $activeClass = ($i == $page) ? 'active' : '';
                                $url = '?page=' . $i;
                                if ($search) $url .= '&search=' . urlencode($search);
                                if ($category) $url .= '&category=' . $category;
                            ?>
                                <a href="<?php echo $url; ?>" class="pagination-number <?php echo $activeClass; ?>"><?php echo $i; ?></a>
                            <?php endfor; ?>
                        </div>
                        
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $category ? '&category=' . $category : ''; ?>" class="pagination-btn">
                                <?php echo __('btn.next'); ?>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <?php echo __('btn.next'); ?>
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </main>

                <!-- Sidebar -->
                <aside class="blog-sidebar">
                    <!-- Search -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title"><?php echo __('blog.search'); ?></h3>
                        <form class="search-form" method="GET">
                            <input type="text" name="search" placeholder="<?php echo __('blog.search_placeholder'); ?>" class="search-input" value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title"><?php echo __('blog.categories'); ?></h3>
                        <ul class="category-list">
                            <?php
                            $categories = $blog->getAllCategories();
                            foreach ($categories as $cat) {
                                $count = $blog->countPostsByCategory($cat['id']);
                                $activeClass = ($category == $cat['id']) ? 'active' : '';
                                ?>
                                <li><a href="?category=<?php echo $cat['id']; ?>" class="category-link <?php echo $activeClass; ?>"><?php echo htmlspecialchars($cat['name']); ?> <span class="category-count">(<?php echo $count; ?>)</span></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Recent Articles -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title"><?php echo __('blog.recent_articles'); ?></h3>
                        <div class="recent-articles">
                            <?php
                            $recentPosts = $blog->getRecentPosts(3);
                            foreach ($recentPosts as $recentPost) {
                                ?>
                                <article class="recent-article">
                                    <div class="recent-article-image">
                                        <?php if ($recentPost['cover_image']): ?>
                                            <img src="<?php echo htmlspecialchars(UPLOAD_URL . 'images/' . $recentPost['cover_image']); ?>" alt="<?php echo htmlspecialchars($recentPost['title']); ?>">
                                        <?php else: ?>
                                            <img src="assets/hero.jpg" alt="<?php echo htmlspecialchars($recentPost['title']); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="recent-article-content">
                                        <h4 class="recent-article-title"><?php echo htmlspecialchars($recentPost['title']); ?></h4>
                                        <span class="recent-article-date"><?php echo formatDate($recentPost['created_at'], 'd M Y'); ?></span>
                                    </div>
                                </article>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="sidebar-widget newsletter-widget">
                        <h3 class="widget-title"><?php echo __('blog.newsletter'); ?></h3>
                        <p class="newsletter-text"><?php echo __('blog.newsletter_text'); ?></p>
                        <form class="newsletter-form" action="newsletter-handler.php" method="POST">
                            <input type="email" name="email" placeholder="<?php echo __('contact.email'); ?>" class="newsletter-input" required>
                            <button type="submit" class="newsletter-btn"><?php echo __('btn.subscribe'); ?></button>
                        </form>
                    </div>
                </aside>
            </div>
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
                    <p>Votre partenaire comptable pour entrepreneurs franco-maghrébins. Expertise, innovation et accompagnement personnalisé.</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.html">Accueil</a></li>
                        <li><a href="mbc.html">À propos</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="blog-dynamic.php">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Nos services</h3>
                    <ul>
                        <li><a href="index.html#expertise">Expertise Comptable</a></li>
                        <li><a href="index.html#fiscalite">Fiscalité</a></li>
                        <li><a href="index.html#social">Social & Paie</a></li>
                        <li><a href="index.html#conseil">Conseil</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <ul>
                        <li><i class="fas fa-phone" aria-hidden="true"></i> +33 1 23 45 67 89</li>
                        <li><i class="fas fa-envelope" aria-hidden="true"></i> contact@mbc-expertcomptable.fr</li>
                        <li><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Paris, France</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MBC Expert Comptable. Tous droits réservés.</p>
                <div>
                    <a href="#mentions">Mentions légales</a>
                    <a href="#confidentialite">Confidentialité</a>
                    <a href="#cookies">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simulators Modal -->
    <div id="simulatorsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Simulateurs en ligne</h2>
                <p>Utilisez nos outils de simulation pour estimer rapidement vos charges, impôts et aides</p>
                <button class="modal-close" onclick="closeSimulatorsModal()">&times;</button>
            </div>
            
            <div class="modal-body">
                <!-- Navigation Tabs -->
                <div class="simulators-nav">
                    <button class="nav-tab active" data-tab="fiscalite">Fiscalité</button>
                    <button class="nav-tab" data-tab="charges">Charges sociales</button>
                    <button class="nav-tab" data-tab="epargne">Épargne & Retraite</button>
                    <button class="nav-tab" data-tab="aides">Aides</button>
                </div>
                
                <div class="simulators-content">
                    <div class="simulators-main">
                        <!-- Fiscalité Tab -->
                        <div class="tab-content active" id="fiscalite">
                            <div class="simulator-card">
                                <h3>Calculateur de TVA</h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="tva-ht">Montant HT</label>
                                        <input type="number" id="tva-ht" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-rate">Taux de TVA</label>
                                        <select id="tva-rate">
                                            <option value="20">20%</option>
                                            <option value="10">10%</option>
                                            <option value="5.5">5.5%</option>
                                            <option value="2.1">2.1%</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-amount">Montant TVA</label>
                                        <input type="text" id="tva-amount" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-ttc">Montant TTC</label>
                                        <input type="text" id="tva-ttc" readonly>
                                    </div>
                                    <div class="simulator-actions">
                                        <button class="btn btn-secondary">
                                            <i class="fas fa-save"></i> Sauvegarder / Charger
                                        </button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Other tabs -->
                        <div class="tab-content" id="charges">
                            <div class="simulator-card">
                                <h3>Simulateur de charges sociales</h3>
                                <p>Fonctionnalité en cours de développement...</p>
                            </div>
                        </div>
                        
                        <div class="tab-content" id="epargne">
                            <div class="simulator-card">
                                <h3>Simulateur d'épargne & retraite</h3>
                                <p>Fonctionnalité en cours de développement...</p>
                            </div>
                        </div>
                        
                        <div class="tab-content" id="aides">
                            <div class="simulator-card">
                                <h3>Simulateur d'aides</h3>
                                <p>Fonctionnalité en cours de développement...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script>
        // Add event listener for simulators link
        document.addEventListener('DOMContentLoaded', function() {
            const simulatorsLink = document.querySelector('.simulators-link');
            if (simulatorsLink) {
                simulatorsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    openSimulatorsModal();
                });
            }
        });
        
        // Language change function
        function changeLanguage(lang) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'change-language.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'lang';
            input.value = lang;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    <script src="script.js"></script>
    <script src="chatbot.js"></script>
</body>
</html>
