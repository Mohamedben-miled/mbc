<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/blog.php';
require_once __DIR__ . '/includes/translations.php';

// Initialize auth object
$auth = new Auth();

// Get post ID from URL
$postId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$postId) {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit;
}

// Get the blog post
$post = $blog->getPost($postId);

if (!$post || $post['status'] !== 'published') {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit;
}

// Get recent posts for sidebar
$recentPosts = $blog->getRecentPosts(5);

// Get categories
$categories = $blog->getCategories();

// Increment view count (optional - you can add this to the database schema)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - MBC Expert Comptable</title>
    <meta name="description" content="<?php echo htmlspecialchars($post['excerpt'] ?: $blog->generateExcerpt($post['content'], 160)); ?>">
    <meta name="keywords" content="expert comptable, comptabilité, fiscalité, conseil, MBC">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($post['excerpt'] ?: $blog->generateExcerpt($post['content'], 160)); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://mbc-expertcomptable.fr/blog-post.php?id=<?php echo $post['id']; ?>">
    <?php if ($post['cover_image']): ?>
    <meta property="og:image" content="https://mbc-expertcomptable.fr/uploads/images/<?php echo htmlspecialchars($post['cover_image']); ?>">
    <?php endif; ?>
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($post['title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($post['excerpt'] ?: $blog->generateExcerpt($post['content'], 160)); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://mbc-expertcomptable.fr/blog-post.php?id=<?php echo $post['id']; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/mbc.png">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="styles.css">
    
    <style>
        .blog-post {
            padding: 100px 0 50px;
        }
        
        .blog-post-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .post-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .post-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .post-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
        }
        
        .post-meta-item i {
            color: #667eea;
        }
        
        .post-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        
        .post-excerpt {
            font-size: 1.2rem;
            color: #64748b;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .post-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            margin: 40px 0;
        }
        
        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #374151;
        }
        
        .post-content h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1e293b;
            margin: 40px 0 20px;
        }
        
        .post-content h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1e293b;
            margin: 30px 0 15px;
        }
        
        .post-content p {
            margin-bottom: 20px;
        }
        
        .post-content ul,
        .post-content ol {
            margin: 20px 0;
            padding-left: 30px;
        }
        
        .post-content li {
            margin-bottom: 8px;
        }
        
        .post-content blockquote {
            border-left: 4px solid #667eea;
            padding-left: 20px;
            margin: 30px 0;
            font-style: italic;
            color: #64748b;
        }
        
        .post-attachment {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .attachment-icon {
            width: 40px;
            height: 40px;
            background: #667eea;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .attachment-info h4 {
            margin: 0 0 5px;
            color: #1e293b;
        }
        
        .attachment-info p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }
        
        .post-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 30px;
            margin-top: 40px;
        }
        
        .back-to-blog {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 30px;
        }
        
        .back-to-blog:hover {
            color: #5a67d8;
        }
        
        .share-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: transform 0.3s ease;
        }
        
        .share-btn:hover {
            transform: translateY(-2px);
        }
        
        .share-facebook { background: #1877f2; }
        .share-twitter { background: #1da1f2; }
        .share-linkedin { background: #0077b5; }
        .share-whatsapp { background: #25d366; }
        
        @media (max-width: 768px) {
            .post-title {
                font-size: 2rem;
            }
            
            .post-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .post-image {
                height: 250px;
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
                <nav class="nav" role="navigation" aria-label="<?php echo __('common.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link">Accueil</a></li>
                        <li><a href="mbc.php" class="nav-link">MBC</a></li>
                        <li><a href="services.php" class="nav-link">Services</a></li>
                        <li><a href="#simulators" class="nav-link simulators-link" onclick="openSimulatorsModal()">Simulateurs</a></li>
                        <li><a href="blog-dynamic.php" class="nav-link active">Blog</a></li>
                        <li><a href="contact-form.php" class="nav-link">Contact</a></li>
                    </ul>
                </nav>
                
                <!-- Header Utils -->
                <div class="header-utils">
                    <!-- Language Selector -->
                    <select class="language-selector" aria-label="Sélectionner la langue" onchange="changeLanguage(this.value)">
                        <option value="fr" selected>FR</option>
                        <option value="en">EN</option>
                        <option value="zh">中文</option>
                    </select>
                    
                    <!-- Authentication Section -->
                    <div class="auth-section">
                        <?php
                        if ($auth->isLoggedIn()) {
                            $currentUser = $auth->getCurrentUser();
                            ?>
                            <!-- User is logged in -->
                            <div class="user-menu">
                                <span class="user-greeting">Bonjour, <?php echo htmlspecialchars($currentUser['full_name']); ?></span>
                                <div class="user-dropdown">
                                    <button class="user-dropdown-toggle" aria-expanded="false">
                                        <i class="fas fa-user-circle"></i>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="user-dropdown-menu">
                                        <a href="admin/dashboard.php" class="dropdown-item">
                                            <i class="fas fa-tachometer-alt"></i>
                                            Dashboard
                                        </a>
                                        <a href="admin/blog.php" class="dropdown-item">
                                            <i class="fas fa-blog"></i>
                                            Gestion Blog
                                        </a>
                                        <a href="admin/contact.php" class="dropdown-item">
                                            <i class="fas fa-envelope"></i>
                                            Messages
                                        </a>
                                        <a href="admin/users.php" class="dropdown-item">
                                            <i class="fas fa-users"></i>
                                            Utilisateurs
                                        </a>
                                        <a href="admin/profile.php" class="dropdown-item">
                                            <i class="fas fa-user"></i>
                                            Mon Profil
                                        </a>
                                        <a href="admin/logout.php" class="dropdown-item logout">
                                            <i class="fas fa-sign-out-alt"></i>
                                            Déconnexion
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <!-- User is not logged in -->
                            <div class="auth-buttons">
                                <a href="admin/login.php" class="btn btn-outline btn-sm">
                                    <i class="fas fa-sign-in-alt"></i> Connexion
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" aria-label="<?php echo __('common.open_mobile_menu'); ?>" aria-expanded="false">
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
                <li><a href="index.php" class="mobile-nav-link"><?php echo __('nav.home'); ?></a></li>
                <li><a href="mbc.php" class="mobile-nav-link"><?php echo __('nav.about'); ?></a></li>
                <li><a href="services.php" class="mobile-nav-link"><?php echo __('nav.services'); ?></a></li>
                <li><a href="#simulators" class="mobile-nav-link"><?php echo __('nav.simulators'); ?></a></li>
                <li><a href="blog-dynamic.php" class="mobile-nav-link"><?php echo __('nav.blog'); ?></a></li>
                <li><a href="contact-form.php" class="mobile-nav-link"><?php echo __('nav.contact'); ?></a></li>
            </ul>
            
            <!-- Mobile Auth Section -->
            <div class="mobile-auth">
                <?php if ($auth->isLoggedIn()): ?>
                    <div class="mobile-user-info">
                        <p><?php echo __('nav.hello'); ?>, <?php echo htmlspecialchars($currentUser['full_name']); ?></p>
                    </div>
                    <div class="mobile-user-actions">
                        <a href="admin/dashboard.php" class="mobile-nav-link">
                            <i class="fas fa-tachometer-alt"></i> <?php echo __('nav.dashboard'); ?>
                        </a>
                        <a href="admin/blog.php" class="mobile-nav-link">
                            <i class="fas fa-blog"></i> <?php echo __('nav.blog_management'); ?>
                        </a>
                        <a href="admin/contact.php" class="mobile-nav-link">
                            <i class="fas fa-envelope"></i> <?php echo __('nav.messages'); ?>
                        </a>
                        <a href="admin/profile.php" class="mobile-nav-link">
                            <i class="fas fa-user-edit"></i> <?php echo __('nav.my_profile'); ?>
                        </a>
                        <a href="admin/logout.php" class="mobile-nav-link logout">
                            <i class="fas fa-sign-out-alt"></i> <?php echo __('nav.logout'); ?>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Mobile Language Selector -->
                    <div class="mobile-language-section">
                        <select class="language-selector mobile-language-selector" aria-label="<?php echo __('nav.select_language'); ?>" onchange="changeLanguage(this.value)">
                            <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>FR</option>
                            <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>EN</option>
                            <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>中文</option>
                        </select>
                    </div>
                    
                    <!-- Mobile Login Button -->
                    <div class="mobile-login-section">
                        <a href="admin/login.php" class="btn btn-primary btn-mobile">
                            <i class="fas fa-sign-in-alt"></i>
                            <?php echo __('btn.login'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Blog Post Content -->
    <section class="blog-post">
        <div class="container">
            <div class="blog-post-content">
                <div class="post-header">
                    <div class="post-meta">
                        <div class="post-meta-item">
                            <i class="fas fa-calendar"></i>
                            <span><?php echo formatDate($post['created_at']); ?></span>
                        </div>
                        <div class="post-meta-item">
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars($post['author_name']); ?></span>
                        </div>
                        <div class="post-meta-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo $post['read_time']; ?> min de lecture</span>
                        </div>
                    </div>
                    
                    <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                    
                    <?php if ($post['excerpt']): ?>
                        <p class="post-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($post['cover_image']): ?>
                    <img src="<?php echo UPLOAD_URL; ?>images/<?php echo htmlspecialchars($post['cover_image']); ?>" 
                         alt="<?php echo htmlspecialchars($post['title']); ?>" 
                         class="post-image">
                <?php endif; ?>

                <div class="post-content">
                    <?php echo $post['content']; ?>
                </div>

                <?php if ($post['content_file']): ?>
                    <div class="post-attachment">
                        <div class="attachment-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="attachment-info">
                            <h4>Document attaché</h4>
                            <p>Fichier complémentaire à télécharger</p>
                        </div>
                        <a href="<?php echo UPLOAD_URL; ?>documents/<?php echo htmlspecialchars($post['content_file']); ?>" 
                           class="btn btn-secondary" 
                           download>
                            <i class="fas fa-download"></i>
                            Télécharger
                        </a>
                    </div>
                <?php endif; ?>

                <div class="post-footer">
                    <a href="blog-dynamic.php" class="back-to-blog">
                        <i class="fas fa-arrow-left"></i>
                        Retour au blog
                    </a>

                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://mbc-expertcomptable.fr/blog-post.php?id=' . $post['id']); ?>" 
                           class="share-btn share-facebook" 
                           target="_blank" 
                           title="<?php echo __('common.share_facebook'); ?>">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://mbc-expertcomptable.fr/blog-post.php?id=' . $post['id']); ?>&text=<?php echo urlencode($post['title']); ?>" 
                           class="share-btn share-twitter" 
                           target="_blank" 
                           title="<?php echo __('common.share_twitter'); ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('https://mbc-expertcomptable.fr/blog-post.php?id=' . $post['id']); ?>" 
                           class="share-btn share-linkedin" 
                           target="_blank" 
                           title="<?php echo __('common.share_linkedin'); ?>">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode($post['title'] . ' - ' . 'https://mbc-expertcomptable.fr/blog-post.php?id=' . $post['id']); ?>" 
                           class="share-btn share-whatsapp" 
                           target="_blank" 
                           title="<?php echo __('common.share_whatsapp'); ?>">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <?php include 'includes/simulators-modal.php'; ?>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/chatbot-multilingual-db.js"></script>
    <script>
        // Language change function
        function changeLanguage(lang) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'change-language.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'language';
            input.value = lang;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        // Simulators modal function
        function openSimulatorsModal() {
            const modal = document.getElementById('simulatorsModal');
            if (modal) {
                modal.style.display = 'block';
            }
        }

        // Close modal function
        function closeModal() {
            const modal = document.getElementById('simulatorsModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

            // User dropdown functionality
            const userDropdownToggle = document.querySelector('.user-dropdown-toggle');
            const userDropdownMenu = document.querySelector('.user-dropdown-menu');
            
            if (userDropdownToggle && userDropdownMenu) {
                userDropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    
                    if (!isExpanded) {
                        userDropdownMenu.style.opacity = '1';
                        userDropdownMenu.style.visibility = 'visible';
                        userDropdownMenu.style.transform = 'translateY(0)';
                    } else {
                        userDropdownMenu.style.opacity = '0';
                        userDropdownMenu.style.visibility = 'hidden';
                        userDropdownMenu.style.transform = 'translateY(-10px)';
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                        userDropdownToggle.setAttribute('aria-expanded', 'false');
                        userDropdownMenu.style.opacity = '0';
                        userDropdownMenu.style.visibility = 'hidden';
                        userDropdownMenu.style.transform = 'translateY(-10px)';
                    }
                });
            }

            // Mobile navigation functionality
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileNav = document.querySelector('.mobile-nav');
            const mobileNavClose = document.querySelector('.mobile-nav-close');
            
            if (mobileMenuToggle && mobileNav) {
                let isMenuOpen = false;
                
                // Toggle mobile menu
                function toggleMobileMenu() {
                    isMenuOpen = !isMenuOpen;
                    
                    if (isMenuOpen) {
                        mobileNav.classList.add('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'true');
                        document.body.style.overflow = 'hidden';
                        document.body.style.touchAction = 'none';
                    } else {
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    }
                }
                
                // Open mobile menu
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleMobileMenu();
                });
                
                // Close mobile menu
                if (mobileNavClose) {
                    mobileNavClose.addEventListener('click', function(e) {
                        e.preventDefault();
                        isMenuOpen = false;
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    });
                }
                
                // Close mobile menu when clicking on links
                const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
                mobileNavLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        isMenuOpen = false;
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    });
                });
                
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (isMenuOpen && !mobileNav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                        isMenuOpen = false;
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    }
                });
                
                // Handle escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && isMenuOpen) {
                        isMenuOpen = false;
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    }
                });
            }

            // Add event listener for simulators link
            const simulatorsLink = document.querySelector('.simulators-link');
            if (simulatorsLink) {
                simulatorsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    openSimulatorsModal();
                });
            }

            // Modal close functionality
            const modalClose = document.querySelector('.modal-close');
            if (modalClose) {
                modalClose.addEventListener('click', closeModal);
            }

            // Close modal when clicking outside
            const modal = document.getElementById('simulatorsModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }
        });
    </script>
    <script src="chatbot.js"></script>

    <!-- Initialize chatbot -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the multilingual chatbot
            if (typeof window.multilingualChatbotDB !== 'undefined') {
                window.multilingualChatbotDB.init();
            }
        });
    </script>
</body>
</html>
