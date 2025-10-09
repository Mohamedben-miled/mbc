<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("simulators.title") . " - MBC Expert Comptable";
$pageDescription = __("simulators.description");

// SEO Meta Tags
$seoKeywords = "simulateur comptable, calcul charges, TVA, seuil rentabilité, entrepreneur, France";
$ogImage = "https://mbc-expertcomptable.fr/assets/simulators-og.jpg";
$twitterImage = "https://mbc-expertcomptable.fr/assets/simulators-twitter.jpg";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="<?php echo $seoKeywords; ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mbc-expertcomptable.fr/simulators">
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mbc-expertcomptable.fr/simulators">
    <meta property="twitter:title" content="<?php echo $pageTitle; ?>">
    <meta property="twitter:description" content="<?php echo $pageDescription; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://mbc-expertcomptable.fr/simulators">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/mbc.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="simulators-page">

    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.php" aria-label="<?php echo __('nav.home_aria'); ?>">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" loading="eager" class="logo-img">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="simulators.php" class="nav-link active" aria-current="page"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php" class="nav-link"><?php echo __('nav.blog'); ?></a></li>
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
                            <a href="admin/login.php" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i>
                                <?php echo __('nav.login'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" aria-label="<?php echo __('nav.toggle_menu'); ?>" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
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
                    <!-- Login button removed from mobile navbar - available in sidebar only -->
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="simulators-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo __('simulators.hero_title'); ?></h1>
                <p class="hero-subtitle"><?php echo __('simulators.hero_subtitle'); ?></p>
                <p class="hero-description"><?php echo __('simulators.hero_description'); ?></p>
            </div>
        </div>
    </section>

    <!-- Simulators Grid -->
    <section class="simulators-section">
        <div class="container">
            <div class="simulators-grid">
                <!-- TVA Calculator -->
                <div class="simulator-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="simulator-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3><?php echo __('simulators.tva_title'); ?></h3>
                    <p><?php echo __('simulators.tva_description'); ?></p>
                    <div class="simulator-features">
                        <span class="feature-tag"><?php echo __('simulators.tva_feature1'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.tva_feature2'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.tva_feature3'); ?></span>
                    </div>
                    <button class="btn btn-primary simulator-btn" data-simulator="tva">
                        <?php echo __('simulators.use_simulator'); ?>
                    </button>
                </div>

                <!-- Charges Calculator -->
                <div class="simulator-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="simulator-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3><?php echo __('simulators.charges_title'); ?></h3>
                    <p><?php echo __('simulators.charges_description'); ?></p>
                    <div class="simulator-features">
                        <span class="feature-tag"><?php echo __('simulators.charges_feature1'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.charges_feature2'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.charges_feature3'); ?></span>
                    </div>
                    <button class="btn btn-primary simulator-btn" data-simulator="charges">
                        <?php echo __('simulators.use_simulator'); ?>
                    </button>
                </div>

                <!-- Break-even Calculator -->
                <div class="simulator-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="simulator-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3><?php echo __('simulators.break_even_title'); ?></h3>
                    <p><?php echo __('simulators.break_even_description'); ?></p>
                    <div class="simulator-features">
                        <span class="feature-tag"><?php echo __('simulators.break_even_feature1'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.break_even_feature2'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.break_even_feature3'); ?></span>
                    </div>
                    <button class="btn btn-primary simulator-btn" data-simulator="break-even">
                        <?php echo __('simulators.use_simulator'); ?>
                    </button>
                </div>

                <!-- Profitability Calculator -->
                <div class="simulator-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="simulator-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3><?php echo __('simulators.profitability_title'); ?></h3>
                    <p><?php echo __('simulators.profitability_description'); ?></p>
                    <div class="simulator-features">
                        <span class="feature-tag"><?php echo __('simulators.profitability_feature1'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.profitability_feature2'); ?></span>
                        <span class="feature-tag"><?php echo __('simulators.profitability_feature3'); ?></span>
                    </div>
                    <button class="btn btn-primary simulator-btn" data-simulator="profitability">
                        <?php echo __('simulators.use_simulator'); ?>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="simulators-cta">
        <div class="container">
            <div class="cta-content">
                <h2><?php echo __('simulators.cta_title'); ?></h2>
                <p><?php echo __('simulators.cta_description'); ?></p>
                <div class="cta-buttons">
                    <a href="contact-form.php" class="btn btn-primary btn-large">
                        <i class="fas fa-rocket"></i>
                        <?php echo __('btn.get_quote'); ?>
                    </a>
                    <a href="tel:+33676570097" class="btn btn-outline btn-large">
                        <i class="fas fa-phone"></i>
                        <?php echo __('btn.call_now'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" class="footer-logo-img">
                        <h3>MBC Expert Comptable</h3>
                    </div>
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
                        <li><a href="index.php"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="simulators.php"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact-form.php"><?php echo __('nav.contact'); ?></a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3><?php echo __('footer.services'); ?></h3>
                    <ul>
                        <li><a href="services.php#services"><?php echo __('services.expertise_title'); ?></a></li>
                        <li><a href="services.php#services"><?php echo __('services.fiscalite_title'); ?></a></li>
                        <li><a href="services.php#services"><?php echo __('services.social_title'); ?></a></li>
                        <li><a href="services.php#services"><?php echo __('nav.consulting'); ?></a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3><?php echo __('footer.contact'); ?></h3>
                    <ul>
                        <li><i class="fas fa-phone"></i> +33 6 76 57 00 97</li>
                        <li><i class="fas fa-envelope"></i> contact@mbc-expertcomptable.fr</li>
                        <li><i class="fas fa-map-marker-alt"></i> <?php echo __('location.paris'); ?></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MBC Expert Comptable. <?php echo __('footer.all_rights_reserved'); ?></p>
                <div class="footer-links">
                    <a href="#"><?php echo __('footer.legal_notice'); ?></a>
                    <a href="#"><?php echo __('footer.privacy'); ?></a>
                    <a href="#"><?php echo __('footer.cookies'); ?></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simulators Modal -->
    <div id="simulatorsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo __('modal.simulators.title'); ?></h2>
                <p><?php echo __('modal.simulators.subtitle'); ?></p>
                <button class="modal-close" onclick="closeSimulatorsModal()">&times;</button>
            </div>
            
            <div class="modal-body">
                <!-- Navigation Tabs -->
                <div class="simulators-nav">
                    <button class="nav-tab active" data-tab="fiscalite"><?php echo __('contact.simulators_fiscalite'); ?></button>
                    <button class="nav-tab" data-tab="charges"><?php echo __('contact.simulators_charges'); ?></button>
                    <button class="nav-tab" data-tab="epargne"><?php echo __('contact.simulators_epargne'); ?></button>
                    <button class="nav-tab" data-tab="aides"><?php echo __('contact.simulators_aides'); ?></button>
                </div>
                
                <div class="simulators-content">
                    <div class="simulators-main">
                        <!-- Fiscalité Tab -->
                        <div class="tab-content active" id="fiscalite">
                            <div class="simulator-card">
                                <h3><?php echo __('contact.simulator_tva_title'); ?></h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="tva-ht"><?php echo __('contact.simulator_tva_ht'); ?></label>
                                        <input type="number" id="tva-ht" placeholder="10000" step="0.01" value="10000" onchange="calculateTVA()" oninput="calculateTVA()">
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-rate"><?php echo __('contact.simulator_tva_rate'); ?></label>
                                        <select id="tva-rate" onchange="calculateTVA()">
                                            <option value="20">20% - <?php echo __('contact.simulator_tva_normal'); ?></option>
                                            <option value="10">10% - <?php echo __('contact.simulator_tva_intermediate'); ?></option>
                                            <option value="5.5">5,5% - <?php echo __('contact.simulator_tva_reduced'); ?></option>
                                            <option value="2.1">2,1% - <?php echo __('contact.simulator_tva_super_reduced'); ?></option>
                                            <option value="0">0% - <?php echo __('contact.simulator_tva_exempt'); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-amount"><?php echo __('contact.simulator_tva_amount'); ?></label>
                                        <input type="text" id="tva-amount" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-ttc"><?php echo __('contact.simulator_tva_ttc'); ?></label>
                                        <input type="text" id="tva-ttc" readonly>
                                    </div>
                                    <div class="simulator-actions">
                                        <button class="btn btn-secondary">
                                            <i class="fas fa-save"></i> <?php echo __('contact.simulator_save'); ?>
                                        </button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-download"></i> <?php echo __('contact.simulator_export'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Charges Tab -->
                        <div class="tab-content" id="charges">
                            <div class="simulator-card">
                                <h3><?php echo __('contact.simulator_charges_title'); ?></h3>
                                <p><?php echo __('contact.simulator_charges_dev'); ?></p>
                            </div>
                        </div>
                        
                        <!-- Épargne Tab -->
                        <div class="tab-content" id="epargne">
                            <div class="simulator-card">
                                <h3><?php echo __('contact.simulator_epargne_title'); ?></h3>
                                <p><?php echo __('contact.simulator_charges_dev'); ?></p>
                            </div>
                        </div>
                        
                        <!-- Aides Tab -->
                        <div class="tab-content" id="aides">
                            <div class="simulator-card">
                                <h3><?php echo __('contact.simulator_aides_title'); ?></h3>
                                <p><?php echo __('contact.simulator_charges_dev'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/main.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/simulators.js"></script>
    <script src="js/chatbot-multilingual.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Language change function
        function changeLanguage(lang) {
            fetch('includes/change-language.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'language=' + lang
            }).then(() => {
                location.reload();
            });
        }

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
