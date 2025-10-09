<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/encoding.php';
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("home.hero.title") . " - MBC Expert Comptable";
$pageDescription = __("home.hero.subtitle");

// SEO Meta Tags
$seoKeywords = "expert comptable, comptabilité, fiscalité, création entreprise, France, Maghreb, digital";
$ogImage = "https://mbc-expertcomptable.fr/assets/og-image.jpg";
$twitterImage = "https://mbc-expertcomptable.fr/assets/twitter-image.jpg";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="<?php echo $seoKeywords; ?>">
    <meta name="author" content="MBC Expert Comptable">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mbc-expertcomptable.fr">
    <meta property="og:image" content="<?php echo $ogImage; ?>">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $pageTitle; ?>">
    <meta name="twitter:description" content="<?php echo $pageDescription; ?>">
    <meta name="twitter:image" content="<?php echo $twitterImage; ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" as="style">
    
    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/mbc.png">
</head>
<body>

    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="#accueil" aria-label="MBC Expert Comptable - Retour à l'accueil">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" loading="eager" class="logo-img">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="#accueil" class="nav-link active" aria-current="page"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#simulators" class="nav-link" onclick="openSimulatorsModal()"><?php echo __('nav.simulators'); ?></a></li>
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
            <button class="mobile-nav-close" aria-label="<?php echo __('btn.close_menu'); ?>">
                <i class="fas fa-times"></i>
            </button>
            <ul class="mobile-nav-list">
                <li><a href="#accueil" class="mobile-nav-link"><?php echo __('nav.home'); ?></a></li>
                <li><a href="mbc.php" class="mobile-nav-link"><?php echo __('nav.about'); ?></a></li>
                <li><a href="services.php" class="mobile-nav-link"><?php echo __('nav.services'); ?></a></li>
                <li><a href="#simulators" class="mobile-nav-link"><?php echo __('nav.simulators'); ?></a></li>
                <li><a href="blog-dynamic.php" class="mobile-nav-link"><?php echo __('nav.blog'); ?></a></li>
                <li><a href="contact-form.php" class="mobile-nav-link"><?php echo __('nav.contact'); ?></a></li>
            </ul>
            
            <!-- Mobile Auth Section -->
            <div class="mobile-auth">
                <!-- Mobile Language Selector -->
                <div class="mobile-language-section">
                    <select class="language-selector mobile-language-selector" aria-label="<?php echo __('nav.select_language'); ?>" onchange="changeLanguage(this.value)">
                        <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>🇫🇷 FR</option>
                        <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>🇬🇧 EN</option>
                        <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>🇨🇳 中文</option>
                    </select>
                </div>
                
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

    <!-- Main Content -->
    <main role="main">
        <!-- Hero Section -->
        <section id="accueil" class="hero section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">MBC</h1>
                    <h2 class="hero-subtitle"><?php echo __('home.hero.title'); ?></h2>
                    <p class="hero-description"><?php echo __('home.hero.subtitle'); ?></p>
                    <div class="hero-cta">
                        <a href="#services" class="btn btn-primary"><?php echo __('home.services.title'); ?></a>
                        <a href="contact-form.php" class="btn btn-secondary"><?php echo __('home.hero.cta'); ?></a>
                    </div>
                </div>
                <div class="hero-image">
                    <!-- Background image is set in CSS -->
                </div>
            </div>
        </section>

        <!-- Digital Ecosystem Section -->
        <section class="digital-ecosystem section" aria-labelledby="ecosystem-title">
            <div class="container">
                <div class="ecosystem-content">
                    <div class="ecosystem-cards">
                        <article class="ecosystem-card">
                            <div class="card-icon">
                                <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('home.digital_ecosystem.feature1'); ?></h3>
                            <p><?php echo __('home.digital_ecosystem.description'); ?></p>
                        </article>
                        <article class="ecosystem-card">
                            <div class="card-icon">
                                <i class="fas fa-cloud" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('home.digital_ecosystem.feature3'); ?></h3>
                            <p><?php echo __('home.digital_ecosystem.description'); ?></p>
                        </article>
                        <article class="ecosystem-card">
                            <div class="card-icon">
                                <i class="fas fa-lock" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('home.digital_ecosystem.feature3'); ?></h3>
                            <p><?php echo __('home.digital_ecosystem.description'); ?></p>
                        </article>
                        <article class="ecosystem-card">
                            <div class="card-icon">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('home.digital_ecosystem.feature2'); ?></h3>
                            <p><?php echo __('home.digital_ecosystem.description'); ?></p>
                        </article>
                    </div>
                    <div class="ecosystem-info">
                        <h2 id="ecosystem-title"><?php echo __('home.digital_ecosystem.title'); ?></h2>
                        <p><?php echo __('home.digital_ecosystem.subtitle'); ?></p>
                        <ul class="ecosystem-features">
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo __('home.digital_ecosystem.feature1'); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo __('home.digital_ecosystem.feature2'); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo __('home.digital_ecosystem.feature3'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="services section" aria-labelledby="services-title">
            <div class="container">
                <header class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-star"></i>
                        <span><?php echo __('home.services_premium.badge'); ?></span>
                    </div>
                    <h2 id="services-title"><?php echo __('home.services.title'); ?></h2>
                    <p class="section-subtitle"><?php echo __('home.services.subtitle'); ?></p>
                    <div class="services-stats">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo __('home.services_premium.stat1.number'); ?></span>
                            <span class="stat-label"><?php echo __('home.services_premium.stat1.label'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo __('home.services_premium.stat2.number'); ?></span>
                            <span class="stat-label"><?php echo __('home.services_premium.stat2.label'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo __('home.services_premium.stat3.number'); ?></span>
                            <span class="stat-label"><?php echo __('home.services_premium.stat3.label'); ?></span>
                        </div>
                    </div>
                </header>
                <div class="services-carousel">
                    <div class="services-grid" id="servicesGrid">
                        <!-- Page 1 -->
                        <div class="services-page active" data-page="1">
                            <article class="service-card featured">
                                <div class="service-badge">
                                    <span><?php echo __('home.service_expertise.badge'); ?></span>
                                </div>
                        <div class="service-icon">
                            <i class="fas fa-calculator" aria-hidden="true"></i>
                        </div>
                                <div class="service-content">
                        <h3><?php echo __('home.expertise.title'); ?></h3>
                        <p><?php echo __('home.expertise.description'); ?></p>
                                    <div class="service-benefits">
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_expertise.benefit1'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_expertise.benefit2'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_expertise.benefit3'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_expertise.benefit4'); ?></span>
                                        </div>
                                    </div>
                                    <div class="service-features">
                                        <span class="feature-tag"><?php echo __('home.service_expertise.feature1'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_expertise.feature2'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_expertise.feature3'); ?></span>
                                    </div>
                                </div>
                    </article>
                    <article class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-file-invoice" aria-hidden="true"></i>
                        </div>
                                <div class="service-content">
                        <h3><?php echo __('home.fiscalite.title'); ?></h3>
                                    <p><?php echo __('home.fiscalite.description'); ?></p>
                                    <div class="service-benefits">
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_fiscalite.benefit1'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_fiscalite.benefit2'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_fiscalite.benefit3'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_fiscalite.benefit4'); ?></span>
                                        </div>
                                    </div>
                                    <div class="service-features">
                                        <span class="feature-tag"><?php echo __('home.service_fiscalite.feature1'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_fiscalite.feature2'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_fiscalite.feature3'); ?></span>
                                    </div>
                                </div>
                    </article>
                    <article class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-users" aria-hidden="true"></i>
                        </div>
                                <div class="service-content">
                        <h3><?php echo __('home.social.title'); ?></h3>
                        <p><?php echo __('home.social.description'); ?></p>
                                    <div class="service-benefits">
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_social.benefit1'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_social.benefit2'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_social.benefit3'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_social.benefit4'); ?></span>
                                        </div>
                                    </div>
                                    <div class="service-features">
                                        <span class="feature-tag"><?php echo __('home.service_social.feature1'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_social.feature2'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_social.feature3'); ?></span>
                                    </div>
                                </div>
                    </article>
                        </div>
                        
                        <!-- Page 2 -->
                        <div class="services-page" data-page="2">
                    <article class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-chart-line" aria-hidden="true"></i>
                        </div>
                                <div class="service-content">
                        <h3><?php echo __('home.conseil.title'); ?></h3>
                        <p><?php echo __('home.conseil.description'); ?></p>
                                    <div class="service-benefits">
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_conseil.benefit1'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_conseil.benefit2'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_conseil.benefit3'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_conseil.benefit4'); ?></span>
                                        </div>
                                    </div>
                                    <div class="service-features">
                                        <span class="feature-tag"><?php echo __('home.service_conseil.feature1'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_conseil.feature2'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_conseil.feature3'); ?></span>
                                    </div>
                                </div>
                    </article>
                            <article class="service-card">
                                <div class="service-icon">
                                    <i class="fas fa-building" aria-hidden="true"></i>
                                </div>
                                <div class="service-content">
                                    <h3><?php echo __('home.service_audit.title'); ?></h3>
                                    <p><?php echo __('home.service_audit.description'); ?></p>
                                    <div class="service-benefits">
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_audit.benefit1'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_audit.benefit2'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_audit.benefit3'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_audit.benefit4'); ?></span>
                                        </div>
                                    </div>
                                    <div class="service-features">
                                        <span class="feature-tag"><?php echo __('home.service_audit.feature1'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_audit.feature2'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_audit.feature3'); ?></span>
                                    </div>
                                </div>
                            </article>
                            <article class="service-card">
                                <div class="service-icon">
                                    <i class="fas fa-handshake" aria-hidden="true"></i>
                                </div>
                                <div class="service-content">
                                    <h3><?php echo __('home.service_juridique.title'); ?></h3>
                                    <p><?php echo __('home.service_juridique.description'); ?></p>
                                    <div class="service-benefits">
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_juridique.benefit1'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_juridique.benefit2'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_juridique.benefit3'); ?></span>
                                        </div>
                                        <div class="benefit-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo __('home.service_juridique.benefit4'); ?></span>
                                        </div>
                                    </div>
                                    <div class="service-features">
                                        <span class="feature-tag"><?php echo __('home.service_juridique.feature1'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_juridique.feature2'); ?></span>
                                        <span class="feature-tag"><?php echo __('home.service_juridique.feature3'); ?></span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    
                    <!-- Navigation Controls -->
                    <div class="services-navigation">
                        <button class="nav-arrow nav-prev" id="prevServices" aria-label="<?php echo __('btn.previous_services'); ?>">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="pagination-dots">
                            <span class="dot active" data-page="1"></span>
                            <span class="dot" data-page="2"></span>
                        </div>
                        <button class="nav-arrow nav-next" id="nextServices" aria-label="<?php echo __('btn.next_services'); ?>">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="services-cta">
                    <div class="cta-content">
                        <h3><?php echo __('home.cta_ready.title'); ?></h3>
                        <p><?php echo __('home.cta_ready.subtitle'); ?></p>
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
                        <div class="cta-guarantee">
                            <i class="fas fa-shield-alt"></i>
                            <span><?php echo __('home.cta_ready.guarantee'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Company Creation Section -->
        <section class="company-creation section" aria-labelledby="creation-title">
            <div class="container">
                <div class="creation-content">
                    <article class="creation-card blue-card">
                        <div class="card-icon">
                            <i class="fas fa-building" aria-hidden="true"></i>
                        </div>
                        <h2 id="creation-title"><?php echo __('home.creation.title'); ?></h2>
                        <p><?php echo __('home.creation.subtitle'); ?></p>
                        <ul class="creation-features">
                            <li><i class="fas fa-file-alt" aria-hidden="true"></i> <?php echo __('home.creation.feature1'); ?></li>
                            <li><i class="fas fa-users" aria-hidden="true"></i> <?php echo __('home.creation.feature2'); ?></li>
                            <li><i class="fas fa-calendar-check" aria-hidden="true"></i> <?php echo __('home.creation.feature3'); ?></li>
                        </ul>
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20d%C3%A9marrer%20mon%20projet%20de%20cr%C3%A9ation%20d%27entreprise.%20Pouvez-vous%20m%27accompagner%20%3F" target="_blank" class="btn btn-white"><?php echo __('btn.start_project_whatsapp'); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </article>
                    <article class="creation-card white-card">
                        <h3><?php echo __('home.why_choose.title'); ?></h3>
                        <ul class="why-choose">
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo __('home.why_choose.reason1.title'); ?> - <?php echo __('home.why_choose.reason1.description'); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo __('home.why_choose.reason3.title'); ?> - <?php echo __('home.why_choose.reason3.description'); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo __('home.why_choose.reason4.title'); ?> - <?php echo __('home.why_choose.reason4.description'); ?></li>
                        </ul>
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20prendre%20rendez-vous%20avec%20un%20expert%20pour%20discuter%20de%20mon%20projet%20d%27entreprise." target="_blank" class="btn btn-link"><?php echo __('btn.book_expert'); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </article>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section class="reviews section" aria-labelledby="reviews-title">
            <div class="container">
                <header class="reviews-header">
                    <div class="google-logo">
                        <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="<?php echo __('common.google'); ?>" loading="lazy" width="92" height="30">
                    </div>
                    <div class="rating">
                        <div class="stars" aria-label="5 étoiles">★★★★★</div>
                        <span><?php echo __('home.reviews.rating'); ?></span>
                    </div>
                    <p id="reviews-title"><?php echo __('home.reviews.title'); ?></p>
                </header>
                <div class="reviews-grid">
                    <article class="review-card">
                        <header class="review-header">
                            <div class="reviewer-avatar">KB</div>
                            <div class="reviewer-info">
                                <h4><?php echo __('home.reviews.review1.author'); ?></h4>
                                <span><?php echo __('home.reviews.review1.date'); ?></span>
                            </div>
                        </header>
                        <div class="review-rating" aria-label="5 étoiles">★★★★★</div>
                        <p class="review-text"><?php echo __('home.reviews.review1.text'); ?></p>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>"><i class="fas fa-thumbs-up" aria-hidden="true"></i> <?php echo __('btn.useful'); ?></button>
                            <a href="#" class="btn-google"><?php echo __('btn.view_google'); ?> <i class="fas fa-external-link-alt" aria-hidden="true"></i></a>
                        </div>
                    </article>
                    <article class="review-card">
                        <header class="review-header">
                            <div class="reviewer-avatar">LM</div>
                            <div class="reviewer-info">
                                <h4><?php echo __('home.reviews.review2.author'); ?></h4>
                                <span><?php echo __('home.reviews.review2.date'); ?></span>
                            </div>
                        </header>
                        <div class="review-rating" aria-label="5 étoiles">★★★★★</div>
                        <p class="review-text"><?php echo __('home.reviews.review2.text'); ?></p>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>"><i class="fas fa-thumbs-up" aria-hidden="true"></i> <?php echo __('btn.useful'); ?></button>
                            <a href="#" class="btn-google"><?php echo __('btn.view_google'); ?> <i class="fas fa-external-link-alt" aria-hidden="true"></i></a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Resources Section -->
        <section class="resources section" aria-labelledby="resources-title">
            <div class="container">
                <header class="resources-header">
                    <a href="#" class="google-review-btn">
                        <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="<?php echo __('common.google'); ?>" loading="lazy">
                        <?php echo __('btn.google_review'); ?>
                    </a>
                    <h2 id="resources-title"><?php echo __('home.resources.title'); ?></h2>
                    <p><?php echo __('home.resources.subtitle'); ?></p>
                </header>
                <div class="resources-grid">
                    <article class="resource-card">
                        <header class="resource-header">
                            <div class="resource-icon">
                                <i class="fas fa-file-alt" aria-hidden="true"></i>
                            </div>
                            <div class="resource-content">
                                <h3><?php echo __('home.resources.resource1.title'); ?></h3>
                                <p><?php echo __('home.resources.resource1.description'); ?></p>
                            </div>
                        </header>
                        <div class="resource-footer">
                            <span class="resource-meta"><?php echo __('home.resources.resource1.meta'); ?></span>
                            <button class="btn-download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                                Télécharger
                            </button>
                        </div>
                    </article>
                    <article class="resource-card">
                        <header class="resource-header">
                            <div class="resource-icon">
                                <i class="fas fa-chart-line" aria-hidden="true"></i>
                            </div>
                            <div class="resource-content">
                                <h3><?php echo __('home.resources.resource2.title'); ?></h3>
                                <p><?php echo __('home.resources.resource2.description'); ?></p>
                            </div>
                        </header>
                        <div class="resource-footer">
                            <span class="resource-meta"><?php echo __('home.resources.resource2.meta'); ?></span>
                            <button class="btn-download">
                                <i class="fas fa-download" aria-hidden="true"></i>
                                Télécharger
                            </button>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section section" aria-labelledby="cta-title">
            <div class="container">
                <h2 id="cta-title"><?php echo __('home.cta_section.title'); ?></h2>
                <p><?php echo __('home.cta_section.subtitle'); ?></p>
                <div class="cta-buttons">
                    <a href="contact-form.php" class="btn btn-secondary btn-large"><?php echo __('home.cta_section.button2'); ?></a>
                    <a href="contact-form.php" class="btn btn-primary btn-large"><?php echo __('home.cta_section.button1'); ?></a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/chatbot-multilingual-db.js"></script>
    <script>
        // Initialize chatbot
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the multilingual chatbot
            if (typeof window.multilingualChatbotDB !== 'undefined') {
                window.multilingualChatbotDB.init();
            }

            // Header scroll effect
            const header = document.querySelector('.header');
            if (header) {
                function handleScroll() {
                    if (window.scrollY > 100) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                }
                window.addEventListener('scroll', handleScroll);
            }



        });
            initializeSlider('tva-ht', 0, 100000, 10000, (value) => {
                return value.toLocaleString('fr-FR');
            });
            
            // TVA Rate Slider (0 to 25%)
            initializeSlider('tva-rate', 0, 25, 20, (value) => {
                return value.toString();
            });
        }
        
        function initializeSlider(id, min, max, defaultValue, formatter) {
            const track = document.getElementById(id + '-thumb').parentElement;
            const thumb = document.getElementById(id + '-thumb');
            const fill = document.getElementById(id + '-fill');
            const valueSpan = document.getElementById(id + '-value');
            const hiddenInput = document.getElementById(id);
            
            let isDragging = false;
            let currentValue = defaultValue;
            
            // Set initial position
            updateSlider(currentValue);
            
            function updateSlider(value) {
                currentValue = Math.max(min, Math.min(max, value));
                const percentage = ((currentValue - min) / (max - min)) * 100;
                
                thumb.style.left = percentage + '%';
                fill.style.width = percentage + '%';
                valueSpan.textContent = formatter(currentValue);
                hiddenInput.value = currentValue;
                
                // Auto-calculate TVA if both values are set
                if (id === 'tva-ht' || id === 'tva-rate') {
                    calculateTVA();
                }
            }
            
            function getValueFromPosition(clientX) {
                const rect = track.getBoundingClientRect();
                const percentage = Math.max(0, Math.min(100, ((clientX - rect.left) / rect.width) * 100));
                return min + (percentage / 100) * (max - min);
            }
            
            // Mouse events
            thumb.addEventListener('mousedown', (e) => {
                isDragging = true;
                e.preventDefault();
            });
            
            track.addEventListener('click', (e) => {
                if (!isDragging) {
                    const value = getValueFromPosition(e.clientX);
                    updateSlider(value);
                }
            });
            
            document.addEventListener('mousemove', (e) => {
                if (isDragging) {
                    const value = getValueFromPosition(e.clientX);
                    updateSlider(value);
                }
            });
            
            document.addEventListener('mouseup', () => {
                isDragging = false;
            });
            
            // Touch events for mobile
            thumb.addEventListener('touchstart', (e) => {
                isDragging = true;
                e.preventDefault();
            });
            
            document.addEventListener('touchmove', (e) => {
                if (isDragging) {
                    const touch = e.touches[0];
                    const value = getValueFromPosition(touch.clientX);
                    updateSlider(value);
                }
            });
            
            document.addEventListener('touchend', () => {
                isDragging = false;
            });
        }
        
        function calculateTVA() {
            const htValue = parseFloat(document.getElementById('tva-ht').value) || 0;
            const rateValue = parseFloat(document.getElementById('tva-rate').value) || 0;
            
            const tvaAmount = htValue * (rateValue / 100);
            const ttcAmount = htValue + tvaAmount;
            
            document.getElementById('tva-amount').value = tvaAmount.toLocaleString('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' €';
            
            document.getElementById('tva-ttc').value = ttcAmount.toLocaleString('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' €';
        }
        
        // Initialize sliders when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeSliders();
            initializeUserDropdown();
        });


        // Intelligent Chatbot Functions
        function startChat() {
            document.getElementById('chatInterface').style.display = 'flex';
        }

        function minimizeChat() {
            document.getElementById('chatInterface').style.display = 'none';
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (message) {
                addMessage(message, 'user');
                input.value = '';
                
                // Simulate typing delay
            setTimeout(() => {
                    const response = getBotResponse(message);
                    addMessage(response, 'bot');
                }, 1000);
            }
        }

        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            
            const avatar = document.createElement('div');
            avatar.className = 'message-avatar';
            avatar.innerHTML = sender === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';
            
            const content = document.createElement('div');
            content.className = 'message-content';
            content.innerHTML = `<p>${text}</p>`;
            
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(content);
            messagesContainer.appendChild(messageDiv);
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function getBotResponse(message) {
            
            const lowerMessage = message.toLowerCase();
            
            // Simple keyword matching from the resume
            const responses = {
                // Greetings
                'bonjour': 'Bonjour ! Je suis l\'assistant MBC. Je peux vous renseigner sur nos services d\'expertise comptable, fiscalité, social & paie, et création d\'entreprise. Que souhaitez-vous savoir ?',
                'salut': 'Bonjour ! Je suis l\'assistant MBC. Je peux vous renseigner sur nos services d\'expertise comptable, fiscalité, social & paie, et création d\'entreprise. Que souhaitez-vous savoir ?',
                'hello': 'Bonjour ! Je suis l\'assistant MBC. Je peux vous renseigner sur nos services d\'expertise comptable, fiscalité, social & paie, et création d\'entreprise. Que souhaitez-vous savoir ?',
                
                // Help
                'aide': 'Je peux vous aider avec nos services (expertise comptable, fiscalité, social & paie, conseil), la création d\'entreprise (SARL, SAS, auto-entrepreneur), nos simulateurs, et nos tarifs. Que souhaitez-vous savoir en particulier ?',
                'help': 'Je peux vous aider avec nos services (expertise comptable, fiscalité, social & paie, conseil), la création d\'entreprise (SARL, SAS, auto-entrepreneur), nos simulateurs, et nos tarifs. Que souhaitez-vous savoir en particulier ?',
                
                // Services
                'service': 'Nos services sont : Expertise Comptable (tenue de comptabilité, bilans, liasses), Fiscalité (déclarations TVA, optimisation), Social & Paie (bulletins, charges sociales), et Conseil (création d\'entreprise, accompagnement stratégique).',
                'services': 'Nos services sont : Expertise Comptable (tenue de comptabilité, bilans, liasses), Fiscalité (déclarations TVA, optimisation), Social & Paie (bulletins, charges sociales), et Conseil (création d\'entreprise, accompagnement stratégique).',
                'comptabilité': 'Notre service d\'expertise comptable inclut : tenue de comptabilité complète, établissement des bilans et liasses fiscales, gestion des obligations comptables, conseil en organisation comptable, et formation de vos équipes.',
                'fiscalité': 'Notre service de fiscalité couvre : déclarations TVA (mensuelles/trimestrielles), optimisation fiscale légale, conseils en matière d\'impôts, gestion des crédits d\'impôt, accompagnement lors des contrôles, et veille fiscale.',
                'social': 'Notre service social & paie inclut : établissement des bulletins de paie, gestion des charges sociales, déclarations sociales (DSN), gestion des congés et absences, conformité législation du travail, et accompagnement RH.',
                'paie': 'Notre service social & paie inclut : établissement des bulletins de paie, gestion des charges sociales, déclarations sociales (DSN), gestion des congés et absences, conformité législation du travail, et accompagnement RH.',
                'conseil': 'Notre service de conseil inclut : création d\'entreprise, choix du statut juridique, accompagnement stratégique, optimisation de structure, développement business, et conseil personnalisé.',
                
                // TVA
                'tva': 'La TVA est un impôt indirect sur la consommation. Taux : 20% (normal), 10% (restauration), 5,5% (alimentaire), 2,1% (presse). Obligations selon votre chiffre d\'affaires : mensuel si >4,3M€, trimestriel entre 152k€-4,3M€, annuel si <152k€.',
                'taxe': 'La TVA est un impôt indirect sur la consommation. Taux : 20% (normal), 10% (restauration), 5,5% (alimentaire), 2,1% (presse). Obligations selon votre chiffre d\'affaires : mensuel si >4,3M€, trimestriel entre 152k€-4,3M€, annuel si <152k€.',
                
                // Legal statuses
                'sarl': 'La SARL est une société à responsabilité limitée. Avantages : responsabilité limitée, capital flexible (1€ min), statut social. Inconvénients : formalités, coûts, obligations comptables. Délai : 2-3 semaines.',
                'sas': 'La SAS offre une grande flexibilité statutaire. Avantages : flexibilité, statut avantageux, responsabilité limitée. Inconvénients : formalités, coûts, obligations comptables. Délai : 2-3 semaines.',
                'auto-entrepreneur': 'Statut simplifié pour débuter. Avantages : formalités simples, pas de capital, comptabilité allégée. Inconvénients : plafonds (176k€ vente, 72k€ prestations), statut limité. Délai : 1-2 semaines.',
                'micro-entreprise': 'Statut simplifié pour débuter. Avantages : formalités simples, pas de capital, comptabilité allégée. Inconvénients : plafonds (176k€ vente, 72k€ prestations), statut limité. Délai : 1-2 semaines.',
                
                // Charges sociales
                'charges': 'Cotisations obligatoires pour la protection sociale. Types : santé, retraite, chômage, famille, formation. Calcul : ~22% salarié + ~45% employeur = ~67% du brut total.',
                'charges sociales': 'Cotisations obligatoires pour la protection sociale. Types : santé, retraite, chômage, famille, formation. Calcul : ~22% salarié + ~45% employeur = ~67% du brut total.',
                
                // Creation
                'création': 'Étapes : choix du statut, rédaction des statuts, dépôt au greffe, publication BODACC, ouverture compte bancaire, immatriculation. Délais : 1-3 semaines selon le statut.',
                'créer': 'Étapes : choix du statut, rédaction des statuts, dépôt au greffe, publication BODACC, ouverture compte bancaire, immatriculation. Délais : 1-3 semaines selon le statut.',
                'entreprise': 'Étapes : choix du statut, rédaction des statuts, dépôt au greffe, publication BODACC, ouverture compte bancaire, immatriculation. Délais : 1-3 semaines selon le statut.',
                
                // Simulators
                'simulateur': 'Nous proposons 5 simulateurs : Calculateur de TVA, Simulateur de fiscalité des dividendes, Simulateur de charges sociales, Simulateur de sortie du PER, et Simulateur d\'aides au logement.',
                'simulateurs': 'Nous proposons 5 simulateurs : Calculateur de TVA, Simulateur de fiscalité des dividendes, Simulateur de charges sociales, Simulateur de sortie du PER, et Simulateur d\'aides au logement.',
                'calcul': 'Nous proposons 5 simulateurs : Calculateur de TVA, Simulateur de fiscalité des dividendes, Simulateur de charges sociales, Simulateur de sortie du PER, et Simulateur d\'aides au logement.',
                'outil': 'Nous proposons 5 simulateurs : Calculateur de TVA, Simulateur de fiscalité des dividendes, Simulateur de charges sociales, Simulateur de sortie du PER, et Simulateur d\'aides au logement.',
                
                // Contact
                'contact': 'Contactez-nous par email (contact@mbc-expertcomptable.fr) ou téléphone. Horaires : 9h-18h du lundi au vendredi. Consultation gratuite et devis personnalisé disponibles.',
                'téléphone': 'Contactez-nous par email (contact@mbc-expertcomptable.fr) ou téléphone. Horaires : 9h-18h du lundi au vendredi. Consultation gratuite et devis personnalisé disponibles.',
                'email': 'Contactez-nous par email (contact@mbc-expertcomptable.fr) ou téléphone. Horaires : 9h-18h du lundi au vendredi. Consultation gratuite et devis personnalisé disponibles.',
                'rendez-vous': 'Contactez-nous par email (contact@mbc-expertcomptable.fr) ou téléphone. Horaires : 9h-18h du lundi au vendredi. Consultation gratuite et devis personnalisé disponibles.',
                'devis': 'Contactez-nous par email (contact@mbc-expertcomptable.fr) ou téléphone. Horaires : 9h-18h du lundi au vendredi. Consultation gratuite et devis personnalisé disponibles.',
                
                // Company
                'mbc': 'MBC High Value Business Consulting est votre partenaire comptable spécialisé dans l\'accompagnement des entrepreneurs franco-maghrébins. Dirigé par Majdi Besbes, expert-comptable OEC Île-de-France.',
                'qui': 'MBC High Value Business Consulting est votre partenaire comptable spécialisé dans l\'accompagnement des entrepreneurs franco-maghrébins. Dirigé par Majdi Besbes, expert-comptable OEC Île-de-France.',
                'cabinet': 'MBC High Value Business Consulting est votre partenaire comptable spécialisé dans l\'accompagnement des entrepreneurs franco-maghrébins. Dirigé par Majdi Besbes, expert-comptable OEC Île-de-France.',
                
                // Pricing
                'prix': 'Nos tarifs sont adaptés à chaque situation. Contactez-nous pour un devis personnalisé gratuit selon vos besoins spécifiques.',
                'tarif': 'Nos tarifs sont adaptés à chaque situation. Contactez-nous pour un devis personnalisé gratuit selon vos besoins spécifiques.',
                'coût': 'Nos tarifs sont adaptés à chaque situation. Contactez-nous pour un devis personnalisé gratuit selon vos besoins spécifiques.',
                'coûts': 'Nos tarifs sont adaptés à chaque situation. Contactez-nous pour un devis personnalisé gratuit selon vos besoins spécifiques.',
                
                // Obligations
                'obligations': 'Vos obligations dépendent de votre statut juridique :\n\nSARL/SAS : Tenue de comptabilité, bilans annuels, déclarations TVA, charges sociales, IS.\n\nAuto-entrepreneur : Déclaration mensuelle/trimestrielle du CA, paiement des cotisations.\n\nTVA : Déclaration selon votre CA (mensuel si >4,3M€, trimestriel 152k€-4,3M€, annuel si <152k€).\n\nCharges sociales : Paiement des cotisations salarié/employeur selon votre statut.',
                'obligation': 'Vos obligations dépendent de votre statut juridique :\n\nSARL/SAS : Tenue de comptabilité, bilans annuels, déclarations TVA, charges sociales, IS.\n\nAuto-entrepreneur : Déclaration mensuelle/trimestrielle du CA, paiement des cotisations.\n\nTVA : Déclaration selon votre CA (mensuel si >4,3M€, trimestriel 152k€-4,3M€, annuel si <152k€).\n\nCharges sociales : Paiement des cotisations salarié/employeur selon votre statut.',
                'mes obligations': 'Vos obligations dépendent de votre statut juridique :\n\nSARL/SAS : Tenue de comptabilité, bilans annuels, déclarations TVA, charges sociales, IS.\n\nAuto-entrepreneur : Déclaration mensuelle/trimestrielle du CA, paiement des cotisations.\n\nTVA : Déclaration selon votre CA (mensuel si >4,3M€, trimestriel 152k€-4,3M€, annuel si <152k€).\n\nCharges sociales : Paiement des cotisations salarié/employeur selon votre statut.',
                'quelles sont mes obligations': 'Vos obligations dépendent de votre statut juridique :\n\nSARL/SAS : Tenue de comptabilité, bilans annuels, déclarations TVA, charges sociales, IS.\n\nAuto-entrepreneur : Déclaration mensuelle/trimestrielle du CA, paiement des cotisations.\n\nTVA : Déclaration selon votre CA (mensuel si >4,3M€, trimestriel 152k€-4,3M€, annuel si <152k€).\n\nCharges sociales : Paiement des cotisations salarié/employeur selon votre statut.',
                'quelles obligations': 'Vos obligations dépendent de votre statut juridique :\n\nSARL/SAS : Tenue de comptabilité, bilans annuels, déclarations TVA, charges sociales, IS.\n\nAuto-entrepreneur : Déclaration mensuelle/trimestrielle du CA, paiement des cotisations.\n\nTVA : Déclaration selon votre CA (mensuel si >4,3M€, trimestriel 152k€-4,3M€, annuel si <152k€).\n\nCharges sociales : Paiement des cotisations salarié/employeur selon votre statut.',
                'obligations comptables': 'Obligations comptables : Tenue de comptabilité, établissement des bilans et liasses fiscales, conservation des documents 6 ans, respect des normes comptables françaises.',
                'obligations fiscales': 'Obligations fiscales : Déclarations TVA, déclarations d\'impôts, paiement des impôts dans les délais, conservation des justificatifs.',
                'obligations sociales': 'Obligations sociales : Paiement des charges sociales, déclarations sociales (DSN), respect de la législation du travail, bulletins de paie.',
                
                // General questions
                'que dois-je faire': 'Cela dépend de votre situation :\n\nSi vous créez une entreprise : choisir le statut, rédiger les statuts, faire les démarches.\n\nSi vous avez une entreprise : respecter vos obligations comptables, fiscales et sociales.\n\nContactez-nous pour un conseil personnalisé selon votre situation.',
                'que faire': 'Cela dépend de votre situation :\n\nSi vous créez une entreprise : choisir le statut, rédiger les statuts, faire les démarches.\n\nSi vous avez une entreprise : respecter vos obligations comptables, fiscales et sociales.\n\nContactez-nous pour un conseil personnalisé selon votre situation.',
                'comment': 'Je peux vous expliquer comment créer une entreprise, gérer vos obligations, optimiser votre fiscalité, etc. Que souhaitez-vous savoir exactement ?',
                'quoi': 'Je peux vous renseigner sur nos services, la création d\'entreprise, la fiscalité, les charges sociales, etc. Que voulez-vous savoir ?',
                'que': 'Je peux vous renseigner sur nos services, la création d\'entreprise, la fiscalité, les charges sociales, etc. Que voulez-vous savoir ?',
                
                // Declarations sociales
                'déclaration sociale': 'Déclarations sociales : DSN (Déclaration Sociale Nominative) mensuelle, URSSAF, retraite, chômage, maladie. Obligatoire pour tous les employeurs.',
                'déclarations sociales': 'Déclarations sociales : DSN (Déclaration Sociale Nominative) mensuelle, URSSAF, retraite, chômage, maladie. Obligatoire pour tous les employeurs.',
                'dsn': 'DSN (Déclaration Sociale Nominative) : Déclaration mensuelle obligatoire pour tous les employeurs. Remplace les anciennes déclarations sociales.',
                'urssaf': 'URSSAF : Organisme de recouvrement des cotisations sociales. Déclarations mensuelles, paiement des charges sociales.',
                'retraite': 'Retraite : Cotisations retraite de base et complémentaire. Obligatoire pour tous les salariés et dirigeants.',
                'chômage': 'Chômage : Assurance chômage, cotisations Pôle Emploi. Obligatoire pour les salariés.',
                'maladie': 'Maladie : Assurance maladie, cotisations CPAM. Couverture santé obligatoire.',
                'famille': 'Famille : Prestations familiales, CAF. Cotisations pour les allocations familiales.',
                'formation': 'Formation : Formation professionnelle, OPCO. Cotisations pour la formation des salariés.',
                'accident': 'Accident : Accidents du travail, maladies professionnelles. Cotisations AT/MP.',
                
                // Fiscalité détaillée
                'is': 'IS (Impôt sur les Sociétés) : Impôt sur les bénéfices des sociétés. Taux : 15% jusqu\'à 38 120€, 25% au-delà.',
                'impôt sur les sociétés': 'IS (Impôt sur les Sociétés) : Impôt sur les bénéfices des sociétés. Taux : 15% jusqu\'à 38 120€, 25% au-delà.',
                'bénéfices': 'Bénéfices : Résultat comptable de l\'entreprise. Base de calcul pour l\'IS et l\'IR.',
                'résultat': 'Résultat : Différence entre produits et charges. Bénéfice ou perte de l\'exercice.',
                'exercice': 'Exercice : Période comptable de 12 mois. Clôture des comptes annuels.',
                'clôture': 'Clôture : Fin d\'exercice comptable. Établissement des comptes annuels.',
                'comptes annuels': 'Comptes annuels : Bilan, compte de résultat, annexe. Obligatoires pour toutes les sociétés.',
                'bilan': 'Bilan : État de la situation financière de l\'entreprise à une date donnée.',
                'compte de résultat': 'Compte de résultat : Évolution du patrimoine de l\'entreprise sur l\'exercice.',
                'annexe': 'Annexe : Informations complémentaires aux comptes annuels.',
                'liasse fiscale': 'Liasse fiscale : Déclarations fiscales annuelles. Bilan, compte de résultat, tableaux fiscaux.',
                
                // TVA détaillée
                'déclaration tva': 'Déclaration TVA : Mensuelle si CA > 4,3M€, trimestrielle entre 152k€-4,3M€, annuelle si < 152k€.',
                'déclarations tva': 'Déclaration TVA : Mensuelle si CA > 4,3M€, trimestrielle entre 152k€-4,3M€, annuelle si < 152k€.',
                'tva collectée': 'TVA collectée : TVA facturée sur les ventes. À reverser à l\'État.',
                'tva déductible': 'TVA déductible : TVA payée sur les achats. Récupérable sur la TVA collectée.',
                'reversement tva': 'Reversement TVA : Différence entre TVA collectée et TVA déductible. À payer à l\'État.',
                'crédit tva': 'Crédit TVA : Excédent de TVA déductible sur TVA collectée. Remboursable ou reportable.',
                
                // Statuts juridiques détaillés
                'eurl': 'EURL : Entreprise Unipersonnelle à Responsabilité Limitée. Un seul associé, responsabilité limitée.',
                'sasu': 'SASU : Société par Actions Simplifiée Unipersonnelle. Un seul associé, grande flexibilité.',
                'eirl': 'EIRL : Entrepreneur Individuel à Responsabilité Limitée. Statut individuel avec responsabilité limitée.',
                'sci': 'SCI : Société Civile Immobilière. Pour la gestion de patrimoine immobilier.',
                'sas': 'SAS : Société par Actions Simplifiée. Grande flexibilité statutaire, statut avantageux.',
                'sarl': 'SARL : Société à Responsabilité Limitée. Responsabilité limitée, capital flexible.',
                
                // Charges et cotisations
                'cotisations': 'Cotisations : Contributions obligatoires pour la protection sociale. Salarié + employeur.',
                'patronales': 'Cotisations patronales : Charges sociales à la charge de l\'employeur. ~45% du brut.',
                'salariales': 'Cotisations salariales : Charges sociales à la charge du salarié. ~22% du brut.',
                'cice': 'CICE : Crédit d\'Impôt Compétitivité Emploi. Aide pour les entreprises.',
                'c3s': 'C3S : Contribution Sociale de Solidarité des Sociétés. Cotisation sur les bénéfices.',
                'cfe': 'CFE : Cotisation Foncière des Entreprises. Taxe locale annuelle.',
                'cvae': 'CVAE : Cotisation sur la Valeur Ajoutée des Entreprises. Taxe sur le CA.',
                
                // Démarches administratives
                'greffe': 'Greffe : Tribunal de commerce. Dépôt des statuts, immatriculation.',
                'bodacc': 'BODACC : Bulletin Officiel des Annonces Civiles et Commerciales. Publication des créations.',
                'kbis': 'Kbis : Extrait d\'immatriculation au RCS. Carte d\'identité de l\'entreprise.',
                'rcs': 'RCS : Registre du Commerce et des Sociétés. Immatriculation des entreprises.',
                'siren': 'SIREN : Numéro d\'identification de l\'entreprise. Unique et permanent.',
                'siret': 'SIRET : Numéro d\'identification de l\'établissement. SIREN + numéro d\'établissement.',
                'tva intra': 'TVA intracommunautaire : Numéro de TVA pour les échanges européens.',
                'code ape': 'Code APE : Activité Principale Exercée. Classification de l\'activité.',
                'naf': 'NAF : Nomenclature d\'Activités Française. Classification des activités.',
                
                // Comptabilité détaillée
                'grand livre': 'Grand livre : Registre de tous les mouvements comptables. Obligatoire.',
                'journal': 'Journal : Enregistrement chronologique des opérations. Obligatoire.',
                'balance': 'Balance : État des comptes avec soldes. Vérification comptable.',
                'écritures': 'Écritures comptables : Enregistrement des opérations. Obligatoire et chronologique.',
                'justificatifs': 'Justificatifs : Pièces justificatives des opérations. Conservation 6 ans.',
                'conservation': 'Conservation : Documents comptables à conserver 6 ans minimum.',
                'normes': 'Normes comptables : Règles comptables françaises. PCG, IFRS.',
                'pcg': 'PCG : Plan Comptable Général. Règles comptables françaises.',
                'ifrs': 'IFRS : International Financial Reporting Standards. Normes internationales.',
                
                // Paie détaillée
                'bulletin de paie': 'Bulletin de paie : Document obligatoire remis au salarié. Détail des rémunérations et charges.',
                'bulletin': 'Bulletin de paie : Document obligatoire remis au salarié. Détail des rémunérations et charges.',
                'salaire': 'Salaire : Rémunération du travail. Brut, net, charges sociales.',
                'brut': 'Salaire brut : Rémunération avant déduction des charges sociales.',
                'net': 'Salaire net : Rémunération après déduction des charges sociales.',
                'heures': 'Heures : Temps de travail. Heures normales, supplémentaires, majorées.',
                'congés': 'Congés : Congés payés, RTT, jours fériés. Gestion des absences.',
                'rtt': 'RTT : Réduction du Temps de Travail. Jours de repos compensatoires.',
                'majoration': 'Majoration : Heures supplémentaires majorées. +25% ou +50%.',
                'prime': 'Prime : Rémunération complémentaire. Prime de transport, de panier, etc.',
                'indemnité': 'Indemnité : Remboursement de frais. Transport, repas, logement.',
                'avantage': 'Avantage en nature : Rémunération non monétaire. Logement, véhicule, repas.',
                
                // Aides et subventions
                'aide': 'Aides : Subventions, crédits d\'impôt, exonérations. Selon votre situation.',
                'subvention': 'Subvention : Aide financière publique. Conditions et démarches spécifiques.',
                'exonération': 'Exonération : Dispense d\'impôt ou de cotisation. Conditions à respecter.',
                'réduction': 'Réduction d\'impôt : Diminution de l\'impôt dû. Crédits d\'impôt.',
                'crédit': 'Crédit d\'impôt : Remboursement ou réduction d\'impôt. Recherche, formation, etc.',
                'cfe': 'CFE : Cotisation Foncière des Entreprises. Exonération possible la première année.',
                'tva': 'TVA : Taxe sur la Valeur Ajoutée. Régime normal, simplifié, franchise.',
                'franchise': 'Franchise de TVA : Dispense de TVA sous conditions de CA.',
                
                // Mots génériques
                'déclaration': 'Déclaration : Document obligatoire à transmettre aux administrations. TVA, sociales, fiscales.',
                'déclarations': 'Déclarations : Documents obligatoires à transmettre aux administrations. TVA, sociales, fiscales.',
                'paiement': 'Paiement : Versement des impôts et cotisations. Dans les délais obligatoires.',
                'délai': 'Délai : Date limite pour les déclarations et paiements. Respect obligatoire.',
                'pénalité': 'Pénalité : Sanction en cas de retard. Majorations, intérêts de retard.',
                'contrôle': 'Contrôle : Vérification par l\'administration. Fiscal, social, comptable.',
                'inspection': 'Inspection : Contrôle approfondi par l\'administration. Préparation nécessaire.',
                'redressement': 'Redressement : Correction des erreurs par l\'administration. Majorations possibles.',
                'litige': 'Litige : Conflit avec l\'administration. Procédure de réclamation.',
                'recours': 'Recours : Contestation d\'une décision administrative. Procédure spécifique.',
                
                // Additional common terms
                'merci': 'De rien ! N\'hésitez pas si vous avez d\'autres questions sur nos services.',
                'thanks': 'De rien ! N\'hésitez pas si vous avez d\'autres questions sur nos services.',
                'au revoir': 'Au revoir ! N\'hésitez pas à revenir si vous avez d\'autres questions.',
                'bye': 'Au revoir ! N\'hésitez pas à revenir si vous avez d\'autres questions.',
                'ok': 'Parfait ! Avez-vous d\'autres questions ?',
                'd\'accord': 'Parfait ! Avez-vous d\'autres questions ?',
                'oui': 'Parfait ! Avez-vous d\'autres questions ?',
                'non': 'Pas de problème ! Que souhaitez-vous savoir d\'autre ?',
                'peut-être': 'Pas de problème ! Que souhaitez-vous savoir d\'autre ?',
                'je ne sais pas': 'Pas de problème ! Je peux vous aider à clarifier vos besoins.',
                'je ne comprends pas': 'Pas de problème ! Je peux vous expliquer plus simplement.',
                'explique': 'Bien sûr ! Que souhaitez-vous que j\'explique ?',
                'expliquer': 'Bien sûr ! Que souhaitez-vous que j\'explique ?',
                'plus simple': 'Bien sûr ! Je peux expliquer de manière plus simple.',
                'simple': 'Bien sûr ! Je peux expliquer de manière plus simple.',
                'détails': 'Bien sûr ! Je peux vous donner plus de détails.',
                'détail': 'Bien sûr ! Je peux vous donner plus de détails.',
                'plus': 'Bien sûr ! Je peux vous donner plus d\'informations.',
                'information': 'Bien sûr ! Je peux vous donner plus d\'informations.',
                'informations': 'Bien sûr ! Je peux vous donner plus d\'informations.'
            };
            
            // Check for exact matches first
            for (const [keyword, response] of Object.entries(responses)) {
                if (lowerMessage.includes(keyword)) {
                    return response;
                }
            }
            
            // Enhanced default responses based on message length and content
            if (lowerMessage.length < 3) {
                return 'Bonjour ! Je suis là pour vous aider. Vous pouvez me poser des questions sur nos services, la création d\'entreprise, la fiscalité, ou tout autre sujet lié à la comptabilité. Que souhaitez-vous savoir ?';
            }
            
            if (lowerMessage.includes('?') || lowerMessage.includes('comment') || lowerMessage.includes('pourquoi') || lowerMessage.includes('quand') || lowerMessage.includes('où')) {
                return 'Excellente question ! Je peux vous aider avec :\n\n• Nos services (expertise comptable, fiscalité, social & paie, conseil)\n• La création d\'entreprise (SARL, SAS, auto-entrepreneur)\n• La fiscalité et les obligations\n• Les charges sociales\n• Nos simulateurs\n• Nos tarifs\n\nPouvez-vous être plus spécifique sur ce qui vous intéresse ?';
            }
            
            // Default response
            return 'Je comprends que vous cherchez des informations. Je peux vous aider avec :\n\n📊 **Nos Services** : Expertise comptable, fiscalité, social & paie, conseil\n🏢 **Création d\'entreprise** : SARL, SAS, auto-entrepreneur\n💰 **Fiscalité** : TVA, impôts, obligations\n👥 **Charges sociales** : URSSAF, cotisations\n🛠️ **Simulateurs** : 5 outils de calcul gratuits\n📞 **Contact** : Devis personnalisé gratuit\n\nQue souhaitez-vous savoir en particulier ?';
        }

        // Handle Enter key in chat input
        document.getElementById('chatInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Services Pagination Functionality
        let currentPage = 1;
        const totalPages = 2;

        function showPage(pageNumber) {
            // Hide all pages
            document.querySelectorAll('.services-page').forEach(page => {
                page.classList.remove('active');
            });
            
            // Show selected page
            const targetPage = document.querySelector(`.services-page[data-page="${pageNumber}"]`);
            if (targetPage) {
                targetPage.classList.add('active');
            }
            
            // Update dots
            document.querySelectorAll('.dot').forEach(dot => {
                dot.classList.remove('active');
            });
            const activeDot = document.querySelector(`.dot[data-page="${pageNumber}"]`);
            if (activeDot) {
                activeDot.classList.add('active');
            }
            
            // Update navigation buttons
            const prevBtn = document.getElementById('prevServices');
            const nextBtn = document.getElementById('nextServices');
            
            if (prevBtn) prevBtn.disabled = pageNumber === 1;
            if (nextBtn) nextBtn.disabled = pageNumber === totalPages;
            
            currentPage = pageNumber;
        }

        // Initialize pagination when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Previous button
            const prevBtn = document.getElementById('prevServices');
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    if (currentPage > 1) {
                        showPage(currentPage - 1);
                    }
                });
            }
            
            // Next button
            const nextBtn = document.getElementById('nextServices');
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    if (currentPage < totalPages) {
                        showPage(currentPage + 1);
                    }
                });
            }
            
            // Dot navigation
            document.querySelectorAll('.dot').forEach(dot => {
                dot.addEventListener('click', function() {
                    const pageNumber = parseInt(this.getAttribute('data-page'));
                    showPage(pageNumber);
                });
            });
            
            // Initialize first page
            showPage(1);
        });

        // TVA calculation function
        function calculateTVA() {
            const ht = parseFloat(document.getElementById('tva-ht').value) || 0;
            const rate = parseFloat(document.getElementById('tva-rate').value) / 100;
            const tva = ht * rate;
            const ttc = ht + tva;
            
            document.getElementById('tva-amount').value = tva.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' €';
            document.getElementById('tva-ttc').value = ttc.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' €';
        }

        // Simulator calculation functions
        function calculateCharges() {
            const brut = parseFloat(document.getElementById('charges-brut').value) || 0;
            const status = document.getElementById('charges-status').value;
            
            let taux = 0;
            switch(status) {
                case 'salarie': taux = 0.22; break; // 22% charges salariales
                case 'micro': taux = 0.22; break; // 22% charges micro-entreprise
                case 'auto': taux = 0.22; break; // 22% charges auto-entrepreneur
                case 'sarl': taux = 0.45; break; // 45% charges gérant SARL
                case 'sas': taux = 0.42; break; // 42% charges président SAS
            }
            
            const charges = brut * taux;
            const net = brut - charges;
            
            document.getElementById('charges-total').value = charges.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' €';
            document.getElementById('charges-net').value = net.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' €';
            document.getElementById('charges-taux').value = (taux * 100).toFixed(1) + ' %';
        }

        function calculateEpargne() {
            const ageActuel = parseInt(document.getElementById('epargne-age').value) || 35;
            const ageRetraite = parseInt(document.getElementById('epargne-retraite').value) || 62;
            const mensuel = parseFloat(document.getElementById('epargne-mensuel').value) || 300;
            const rendement = parseFloat(document.getElementById('epargne-rendement').value) / 100 || 0.03;
            
            const duree = ageRetraite - ageActuel;
            const mois = duree * 12;
            const rendementMensuel = rendement / 12;
            
            // Calcul du capital avec intérêts composés
            let capital = 0;
            for (let i = 0; i < mois; i++) {
                capital = (capital + mensuel) * (1 + rendementMensuel);
            }
            
            // Rente mensuelle estimée (4% du capital par an)
            const renteMensuelle = (capital * 0.04) / 12;
            
            document.getElementById('epargne-duree').value = duree + ' ans';
            document.getElementById('epargne-total').value = capital.toLocaleString('fr-FR', {minimumFractionDigits: 0}) + ' €';
            document.getElementById('epargne-rente').value = renteMensuelle.toLocaleString('fr-FR', {minimumFractionDigits: 0}) + ' €';
        }

        function calculateAides() {
            const revenus = parseFloat(document.getElementById('aide-revenus').value) || 0;
            const loyer = parseFloat(document.getElementById('aide-loyer').value) || 0;
            const famille = document.getElementById('aide-famille').value;
            const enfants = parseInt(document.getElementById('aide-enfants').value) || 0;
            const zone = parseInt(document.getElementById('aide-zone').value) || 1;
            
            // Calcul simplifié des APL (estimation)
            let plafondRessources = 12000; // Base célibataire
            if (famille === 'couple') plafondRessources += 6000;
            plafondRessources += enfants * 3000;
            
            let plafondLoyer = 300; // Zone 3
            if (zone === 2) plafondLoyer = 350;
            if (zone === 1) plafondLoyer = 400;
            
            let aide = 0;
            if (revenus <= plafondRessources && loyer <= plafondLoyer) {
                aide = Math.min(loyer * 0.4, plafondLoyer * 0.4);
                aide = Math.max(0, aide - (revenus * 0.01));
            }
            
            document.getElementById('aide-amount').textContent = Math.round(aide) + ' €';
        }

        // Initialize calculations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit for modal to be ready
            setTimeout(function() {
                if (typeof calculateTVA === 'function') calculateTVA();
                if (typeof calculateCharges === 'function') calculateCharges();
                if (typeof calculateEpargne === 'function') calculateEpargne();
                if (typeof calculateAides === 'function') calculateAides();
            }, 100);
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
        
        // Mobile navigation functionality - Optimized
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileNav = document.querySelector('.mobile-nav');
            
            if (mobileMenuToggle && mobileNav) {
                let isMenuOpen = false;
                
                // Optimized toggle function
                function toggleMobileMenu() {
                    isMenuOpen = !isMenuOpen;
                    
                    if (isMenuOpen) {
                        mobileNav.classList.add('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'true');
                        document.body.style.overflow = 'hidden';
                        // Add touch-action to prevent scrolling
                        document.body.style.touchAction = 'none';
                    } else {
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    }
                }
                
                // Use passive event listeners for better performance
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleMobileMenu();
                }, { passive: false });
                
                // Close mobile menu when clicking outside - Optimized
                document.addEventListener('click', function(e) {
                    if (isMenuOpen && !mobileNav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                        isMenuOpen = false;
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    }
                }, { passive: true);
                
                // Close mobile menu when clicking on links - Optimized
                const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
                mobileNavLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        isMenuOpen = false;
                        mobileNav.classList.remove('active');
                        mobileMenuToggle.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = '';
                        document.body.style.touchAction = '';
                    }, { passive: true });
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
                        userDropdownMenu.classList.add('show');
                    } else {
                        userDropdownMenu.style.opacity = '0';
                        userDropdownMenu.style.visibility = 'hidden';
                        userDropdownMenu.style.transform = 'translateY(-10px)';
                        userDropdownMenu.classList.remove('show');
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                        userDropdownMenu.style.opacity = '0';
                        userDropdownMenu.style.visibility = 'hidden';
                        userDropdownMenu.style.transform = 'translateY(-10px)';
                        userDropdownMenu.classList.remove('show');
                        userDropdownToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>

    <?php include 'includes/simulators-modal.php'; ?>
    <?php include 'includes/footer.php'; ?>
</body>
</html>