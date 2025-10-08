<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("services.hero.title") . " - MBC Expert Comptable";
$pageDescription = __("services.hero.subtitle");

// SEO Meta Tags
$seoKeywords = "services expert comptable, fiscalité, social paie, conseil entreprise, franco-maghrébin";
$ogImage = "https://mbc-expertcomptable.fr/assets/services-og.jpg";
$twitterImage = "https://mbc-expertcomptable.fr/assets/services-twitter.jpg";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo __('services.hero_description'); ?>">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.php#accueil" aria-label="<?php echo __('nav.home_aria'); ?>">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" loading="eager" class="logo-img">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link active" aria-current="page"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#" class="nav-link simulators-link"><?php echo __('nav.simulators'); ?></a></li>
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

    <!-- Chatbot -->
    <div class="mbc-chatbot">
        <div class="chatbot-toggle" onclick="toggleChat()">
            <i class="fas fa-comments"></i>
            <span><?php echo __('chatbot.assistant'); ?></span>
        </div>
        <div class="chatbot-window" id="chatbotWindow">
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <i class="fas fa-robot"></i>
                    <span><?php echo __('chatbot.assistant'); ?></span>
                </div>
                <button class="chatbot-close" onclick="toggleChat()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chatbot-messages" id="chatMessages">
                <div class="message bot-message">
                    <div class="message-content">
                        <?php echo __('chatbot.welcome_message'); ?>
                    </div>
                </div>
            </div>
            <div class="chatbot-input">
                <input type="text" id="chatInput" placeholder="<?php echo __('chatbot.placeholder'); ?>" onkeypress="handleEnter(event)">
                <button onclick="sendMessage()" class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

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

    <!-- Enhanced Hero Section -->
    <section class="services-hero hero section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title"><?php echo __('services.hero_title'); ?></h1>
                    <h2 class="hero-subtitle"><?php echo __('services.hero_subtitle'); ?></h2>
                    <p class="hero-description"><?php echo __('services.hero_description'); ?></p>
                    <div class="hero-cta">
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20découvrir%20vos%20services%20comptables." target="_blank" class="btn btn-primary btn-large">
                            <i class="fab fa-whatsapp"></i>
                            <?php echo __('btn.discover_services'); ?>
                        </a>
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20une%20consultation%20gratuite." target="_blank" class="btn btn-secondary btn-large">
                            <i class="fas fa-phone"></i>
                            <?php echo __('btn.free_consultation'); ?>
                        </a>
                    </div>
                </div>
                <div class="hero-image">
                    <!-- Background image handles the visual -->
                </div>
            </div>
        </div>
    </section>

    <!-- Services Stats -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label"><?php echo __('stats.companies'); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15+</div>
                    <div class="stat-label"><?php echo __('stats.years'); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label"><?php echo __('stats.satisfied'); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">24h</div>
                    <div class="stat-label"><?php echo __('stats.response'); ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="services section" id="services">
        <div class="container">
            <header class="section-header">
                <div class="section-badge">
                    <i class="fas fa-star"></i>
                    <span><?php echo __('services.premium_title'); ?></span>
                </div>
                <h2><?php echo __('services.premium_subtitle'); ?></h2>
                <p class="section-subtitle"><?php echo __('services.premium_description'); ?></p>
            </header>
            
            <div class="services-carousel">
                <div class="services-grid" id="servicesGrid">
                    <!-- Page 1 -->
                    <div class="services-page active" data-page="1">
                        <article class="service-card featured">
                            <div class="service-badge">
                                <span><?php echo __('services.most_popular'); ?></span>
                            </div>
                            <div class="service-icon">
                                <i class="fas fa-calculator" aria-hidden="true"></i>
                            </div>
                            <div class="service-content">
                                <h3><?php echo __('services.expertise_title'); ?></h3>
                                <p><?php echo __('services.expertise_description'); ?></p>
                                <div class="service-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.expertise_feature1'); ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.expertise_feature2'); ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.expertise_feature3'); ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.expertise_feature4'); ?></span>
                                    </div>
                                </div>
                                <div class="service-features">
                                    <span class="feature-tag"><?php echo __('services.expertise_feature1'); ?></span>
                                    <span class="feature-tag"><?php echo __('services.expertise_feature2'); ?></span>
                                    <span class="feature-tag"><?php echo __('services.expertise_feature3'); ?></span>
                                </div>
                                <div class="service-cta">
                                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20l%27expertise%20comptable." target="_blank" class="btn btn-primary">
                                        <i class="fab fa-whatsapp"></i>
                                        <?php echo __('btn.learn_more'); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <article class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            </div>
                            <div class="service-content">
                                <h3><?php echo __('services.fiscalite_title'); ?></h3>
                                <p><?php echo __('services.fiscalite_description'); ?></p>
                                <div class="service-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.fiscalite_feature1'); ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.fiscalite_feature2'); ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.fiscalite_feature3'); ?></span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo __('services.fiscalite_feature4'); ?></span>
                                    </div>
                                </div>
                                <div class="service-features">
                                    <span class="feature-tag"><?php echo __('services.fiscalite_feature1'); ?></span>
                                    <span class="feature-tag"><?php echo __('services.fiscalite_feature2'); ?></span>
                                    <span class="feature-tag"><?php echo __('services.fiscalite_feature3'); ?></span>
                                </div>
                                <div class="service-cta">
                                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20la%20fiscalit%C3%A9." target="_blank" class="btn btn-primary">
                                        <i class="fab fa-whatsapp"></i>
                                        <?php echo __('btn.learn_more'); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <article class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="service-content">
                                <h3><?php echo __('services.social_title'); ?></h3>
                                <p><?php echo __('services.social_description'); ?></p>
                                <div class="service-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Bulletins de paie conformes</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Déclarations URSSAF</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Gestion des congés payés</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Suivi des contrats de travail</span>
                                    </div>
                                </div>
                                <div class="service-features">
                                    <span class="feature-tag">Bulletins de paie</span>
                                    <span class="feature-tag">Déclarations sociales</span>
                                    <span class="feature-tag">Conformité légale</span>
                                </div>
                                <div class="service-cta">
                                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20le%20social%20%26%20paie." target="_blank" class="btn btn-primary">
                                        <i class="fab fa-whatsapp"></i>
                                        <?php echo __('btn.learn_more'); ?>
                                    </a>
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
                                <h3>Conseil</h3>
                                <p>Construisez votre succès avec un accompagnement stratégique personnalisé</p>
                                <div class="service-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Création d'entreprise clé en main</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Stratégie business personnalisée</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Accompagnement juridique</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Suivi de performance</span>
                                    </div>
                                </div>
                                <div class="service-features">
                                    <span class="feature-tag">Création d'entreprise</span>
                                    <span class="feature-tag">Stratégie business</span>
                                    <span class="feature-tag">Accompagnement</span>
                                </div>
                                <div class="service-cta">
                                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20le%20conseil%20d%27entreprise." target="_blank" class="btn btn-primary">
                                        <i class="fab fa-whatsapp"></i>
                                        <?php echo __('btn.learn_more'); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <article class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-building" aria-hidden="true"></i>
                            </div>
                            <div class="service-content">
                                <h3>Audit & Contrôle</h3>
                                <p>Sécurisez vos comptes avec nos audits professionnels et contrôles rigoureux</p>
                                <div class="service-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Audit comptable complet</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Contrôle de gestion</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Analyse des risques</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Recommandations d'amélioration</span>
                                    </div>
                                </div>
                                <div class="service-features">
                                    <span class="feature-tag">Audit comptable</span>
                                    <span class="feature-tag">Contrôle qualité</span>
                                    <span class="feature-tag">Analyse risques</span>
                                </div>
                                <div class="service-cta">
                                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20l%27audit%20%26%20contr%C3%B4le." target="_blank" class="btn btn-primary">
                                        <i class="fab fa-whatsapp"></i>
                                        <?php echo __('btn.learn_more'); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <article class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-handshake" aria-hidden="true"></i>
                            </div>
                            <div class="service-content">
                                <h3>Accompagnement Juridique</h3>
                                <p>Bénéficiez d'un support juridique expert pour toutes vos démarches d'entreprise</p>
                                <div class="service-benefits">
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Rédaction de statuts</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Modifications statutaires</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Conseil en droit des sociétés</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-check"></i>
                                        <span>Formalités administratives</span>
                                    </div>
                                </div>
                                <div class="service-features">
                                    <span class="feature-tag">Droit des sociétés</span>
                                    <span class="feature-tag">Formalités légales</span>
                                    <span class="feature-tag">Conseil juridique</span>
                                </div>
                                <div class="service-cta">
                                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20l%27accompagnement%20juridique." target="_blank" class="btn btn-primary">
                                        <i class="fab fa-whatsapp"></i>
                                        <?php echo __('btn.learn_more'); ?>
                                    </a>
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
        </div>
    </section>

    <!-- Service Comparison Section -->
    <section class="comparison-section section">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('services.why_choose_title'); ?></h2>
                <p><?php echo __('services.why_choose_subtitle'); ?></p>
            </div>
            
            <div class="comparison-table">
                <div class="comparison-header">
                    <div class="comparison-cell empty"></div>
                    <div class="comparison-cell our-service">
                        <div class="service-logo">
                            <img src="assets/mbc.png" alt="MBC" class="logo-small">
                            <span><?php echo __('services.comparison_mbc'); ?></span>
                        </div>
                    </div>
                    <div class="comparison-cell competitor">
                        <span><?php echo __('services.comparison_others'); ?></span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature">
                        <i class="fas fa-clock"></i>
                        <span><?php echo __('services.response_time'); ?></span>
                    </div>
                    <div class="comparison-cell our-service">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('services.response_mbc'); ?></span>
                    </div>
                    <div class="comparison-cell competitor">
                        <i class="fas fa-times-circle"></i>
                        <span><?php echo __('services.response_others'); ?></span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature">
                        <i class="fas fa-globe"></i>
                        <span><?php echo __('services.expertise_franco'); ?></span>
                    </div>
                    <div class="comparison-cell our-service">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('services.expertise_specialized'); ?></span>
                    </div>
                    <div class="comparison-cell competitor">
                        <i class="fas fa-times-circle"></i>
                        <span><?php echo __('services.expertise_general'); ?></span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature">
                        <i class="fas fa-laptop"></i>
                        <span><?php echo __('services.digital_platform'); ?></span>
                    </div>
                    <div class="comparison-cell our-service">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('services.digital_online'); ?></span>
                    </div>
                    <div class="comparison-cell competitor">
                        <i class="fas fa-times-circle"></i>
                        <span><?php echo __('services.digital_partial'); ?></span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature">
                        <i class="fas fa-phone"></i>
                        <span><?php echo __('services.whatsapp_support'); ?></span>
                    </div>
                    <div class="comparison-cell our-service">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('services.whatsapp_available'); ?></span>
                    </div>
                    <div class="comparison-cell competitor">
                        <i class="fas fa-times-circle"></i>
                        <span><?php echo __('services.whatsapp_email'); ?></span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature">
                        <i class="fas fa-euro-sign"></i>
                        <span><?php echo __('services.transparent_pricing'); ?></span>
                    </div>
                    <div class="comparison-cell our-service">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo __('services.pricing_free'); ?></span>
                    </div>
                    <div class="comparison-cell competitor">
                        <i class="fas fa-times-circle"></i>
                        <span><?php echo __('services.pricing_hidden'); ?></span>
                    </div>
                </div>
                
                <div class="comparison-footer">
                    <div class="comparison-cell empty"></div>
                    <div class="comparison-cell our-service">
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20en%20savoir%20plus%20sur%20vos%20avantages." target="_blank" class="btn btn-primary">
                            <i class="fab fa-whatsapp"></i>
                            Nous choisir
                        </a>
                    </div>
                    <div class="comparison-cell competitor"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('services.work_method_title'); ?></h2>
                <p><?php echo __('services.work_method_subtitle'); ?></p>
            </div>
            
            <div class="process-steps">
                <div class="process-step">
                    <div class="process-number">1</div>
                    <h3><?php echo __('services.step1_title'); ?></h3>
                    <p><?php echo __('services.step1_description'); ?></p>
                </div>
                
                <div class="process-step">
                    <div class="process-number">2</div>
                    <h3><?php echo __('services.step2_title'); ?></h3>
                    <p><?php echo __('services.step2_description'); ?></p>
                </div>
                
                <div class="process-step">
                    <div class="process-number">3</div>
                    <h3><?php echo __('services.step3_title'); ?></h3>
                    <p><?php echo __('services.step3_description'); ?></p>
                </div>
                
                <div class="process-step">
                    <div class="process-number">4</div>
                    <h3><?php echo __('services.step4_title'); ?></h3>
                    <p><?php echo __('services.step4_description'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Testimonials Section -->
    <section class="reviews section">
        <div class="container">
            <div class="section-header">
                <div class="google-logo">
                    <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="Google" loading="lazy" width="92" height="30">
                </div>
                <div class="rating">
                    <div class="stars" aria-label="5 étoiles">★★★★★</div>
                    <span>(5 avis)</span>
                </div>
                <h2><?php echo __('services.testimonials_title'); ?></h2>
                <p><?php echo __('services.testimonials_subtitle'); ?></p>
            </div>
            
            <div class="reviews-grid">
                <div class="review-card featured">
                    <div class="review-badge">
                        <i class="fas fa-crown"></i>
                        <span><?php echo __('services.vip_client'); ?></span>
                    </div>
                    <div class="review-content">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <blockquote>"<?php echo __('services.testimonial_ahmed'); ?>"</blockquote>
                        <div class="review-metrics">
                            <div class="metric">
                                <span class="metric-value">20%</span>
                                <span class="metric-label"><?php echo __('services.savings'); ?></span>
                            </div>
                            <div class="metric">
                                <span class="metric-value">15h</span>
                                <span class="metric-label"><?php echo __('services.time_saved'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="review-author">
                        <div class="reviewer-avatar">
                            <img src="assets/Majdi.png" alt="<?php echo __('common.ahmed_benali'); ?>" class="avatar-img">
                        </div>
                        <div class="reviewer-info">
                            <h4>Ahmed Benali</h4>
                            <span>Directeur, TechStart SARL</span>
                            <div class="review-date">
                                <i class="fas fa-calendar"></i>
                                <span>Il y a 2 mois</span>
                            </div>
                        </div>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>">
                                <i class="fas fa-thumbs-up"></i> Utile (12)
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="review-card">
                    <div class="review-content">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <blockquote>"<?php echo __('testimonial.ahmed'); ?>"</blockquote>
                    </div>
                    <div class="review-author">
                        <div class="reviewer-avatar">
                            <img src="assets/conseille.png" alt="<?php echo __('common.fatima_alami'); ?>" class="avatar-img">
                        </div>
                        <div class="reviewer-info">
                            <h4>Fatima Alami</h4>
                            <span>Fondatrice, Consulting Pro</span>
                            <div class="review-date">
                                <i class="fas fa-calendar"></i>
                                <span>Il y a 1 mois</span>
                            </div>
                        </div>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>">
                                <i class="fas fa-thumbs-up"></i> Utile (8)
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="review-card">
                    <div class="review-content">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <blockquote>"Réactivité exceptionnelle ! Réponse en moins de 2h sur WhatsApp. MBC comprend parfaitement les enjeux des entrepreneurs franco-maghrébins. Je recommande vivement !"</blockquote>
                    </div>
                    <div class="review-author">
                        <div class="reviewer-avatar">
                            <img src="assets/expert.jpg" alt="<?php echo __('common.youssef_kaddouri'); ?>" class="avatar-img">
                        </div>
                        <div class="reviewer-info">
                            <h4>Youssef Kaddouri</h4>
                            <span>CEO, Digital Solutions</span>
                            <div class="review-date">
                                <i class="fas fa-calendar"></i>
                                <span>Il y a 3 semaines</span>
                            </div>
                        </div>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>">
                                <i class="fas fa-thumbs-up"></i> Utile (15)
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="review-card">
                    <div class="review-content">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <blockquote>"<?php echo __('testimonial.fatima'); ?>"</blockquote>
                    </div>
                    <div class="review-author">
                        <div class="reviewer-avatar">
                            <span class="avatar-initials">SM</span>
                        </div>
                        <div class="reviewer-info">
                            <h4>Sarah Moussaoui</h4>
                            <span>Gérante, Beauty & Co</span>
                            <div class="review-date">
                                <i class="fas fa-calendar"></i>
                                <span>Il y a 1 semaine</span>
                            </div>
                        </div>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>">
                                <i class="fas fa-thumbs-up"></i> Utile (6)
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="review-card">
                    <div class="review-content">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <blockquote>"<?php echo __('testimonial.youssef'); ?>"</blockquote>
                    </div>
                    <div class="review-author">
                        <div class="reviewer-avatar">
                            <span class="avatar-initials">RH</span>
                        </div>
                        <div class="reviewer-info">
                            <h4>Rachid Hamidi</h4>
                            <span>Fondateur, Import Export Plus</span>
                            <div class="review-date">
                                <i class="fas fa-calendar"></i>
                                <span>Il y a 2 jours</span>
                            </div>
                        </div>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>">
                                <i class="fas fa-thumbs-up"></i> Utile (9)
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="review-card">
                    <div class="review-content">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <blockquote>"<?php echo __('testimonial.omar'); ?>"</blockquote>
                    </div>
                    <div class="review-author">
                        <div class="reviewer-avatar">
                            <span class="avatar-initials">NB</span>
                        </div>
                        <div class="reviewer-info">
                            <h4>Nadia Benaissa</h4>
                            <span>Directrice, Web Agency</span>
                            <div class="review-date">
                                <i class="fas fa-calendar"></i>
                                <span>Il y a 5 jours</span>
                            </div>
                        </div>
                        <div class="review-actions">
                            <button class="btn-useful" aria-label="<?php echo __('btn.mark_useful'); ?>">
                                <i class="fas fa-thumbs-up"></i> Utile (11)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="reviews-cta">
                <h3>Rejoignez nos clients satisfaits</h3>
                <p>Plus de 500 entrepreneurs nous font confiance</p>
                <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20rejoindre%20vos%20clients%20satisfaits." target="_blank" class="btn btn-primary btn-large">
                    <i class="fab fa-whatsapp"></i>
                    Devenir client
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('services.faq_title'); ?></h2>
                <p><?php echo __('services.faq_subtitle'); ?></p>
            </div>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('services.faq1_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('services.faq1_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('services.faq2_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('services.faq2_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('services.faq3_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('services.faq3_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('services.faq4_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('services.faq4_answer'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section section">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('services.pricing_title'); ?></h2>
                <p><?php echo __('services.pricing_subtitle'); ?></p>
                <div class="pricing-toggle">
                    <span class="toggle-label"><?php echo __('services.monthly'); ?></span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="pricingToggle">
                        <span class="slider"></span>
                    </label>
                    <span class="toggle-label"><?php echo __('services.annual'); ?></span>
                </div>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card starter">
                    <div class="pricing-header">
                        <h3><?php echo __('services.starter_title'); ?></h3>
                        <p><?php echo __('services.starter_subtitle'); ?></p>
                        <div class="pricing-badge">
                            <i class="fas fa-seedling"></i>
                            <span><?php echo __('services.starter_ideal'); ?></span>
                        </div>
                    </div>
                    <div class="pricing-price">
                        <span class="currency">€</span>
                        <span class="amount monthly"><?php echo __('services.starter_price'); ?></span>
                        <span class="amount yearly" style="display: none;">71</span>
                        <span class="period">/mois</span>
                    </div>
                    <div class="pricing-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Tenue de comptabilité de base</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Déclarations TVA trimestrielles</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Bilan annuel</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Support email</span>
                        </div>
                        <div class="feature-item disabled">
                            <i class="fas fa-times"></i>
                            <span><?php echo __('services.whatsapp_support'); ?></span>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20souscrire%20à%20la%20formule%20Starter." target="_blank" class="btn btn-outline">
                            <?php echo __('services.choose_starter'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="pricing-card professional featured">
                    <div class="pricing-badge-top">
                        <i class="fas fa-crown"></i>
                        <span>Le plus populaire</span>
                    </div>
                    <div class="pricing-header">
                        <h3><?php echo __('services.professional_title'); ?></h3>
                        <p><?php echo __('services.professional_subtitle'); ?></p>
                        <div class="pricing-badge">
                            <i class="fas fa-rocket"></i>
                            <span><?php echo __('services.professional_ideal'); ?></span>
                        </div>
                    </div>
                    <div class="pricing-price">
                        <span class="currency">€</span>
                        <span class="amount monthly"><?php echo __('services.professional_price'); ?></span>
                        <span class="amount yearly" style="display: none;">119</span>
                        <span class="period">/mois</span>
                    </div>
                    <div class="pricing-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Tenue de comptabilité complète</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Déclarations TVA mensuelles</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Bilan + Liasses fiscales</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Tableaux de bord</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Support WhatsApp 7j/7</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Optimisation fiscale</span>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20souscrire%20à%20la%20formule%20Professional." target="_blank" class="btn btn-primary">
                            <?php echo __('services.choose_professional'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="pricing-card enterprise">
                    <div class="pricing-header">
                        <h3><?php echo __('services.enterprise_title'); ?></h3>
                        <p><?php echo __('services.enterprise_subtitle'); ?></p>
                        <div class="pricing-badge">
                            <i class="fas fa-building"></i>
                            <span><?php echo __('services.enterprise_ideal'); ?></span>
                        </div>
                    </div>
                    <div class="pricing-price">
                        <span class="currency">€</span>
                        <span class="amount monthly"><?php echo __('services.enterprise_price'); ?></span>
                        <span class="amount yearly" style="display: none;">199</span>
                        <span class="period">/mois</span>
                    </div>
                    <div class="pricing-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Tout de Professional +</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Gestion sociale & paie</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Audit comptable</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Conseil stratégique</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Expert dédié</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Réunions mensuelles</span>
                        </div>
                    </div>
                    <div class="pricing-cta">
                        <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20souscrire%20à%20la%20formule%20Enterprise." target="_blank" class="btn btn-outline">
                            <?php echo __('services.choose_enterprise'); ?>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="pricing-guarantee">
                <div class="guarantee-content">
                    <div class="guarantee-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <div class="guarantee-text">
                        <h4><?php echo __('services.guarantee_title'); ?></h4>
                        <p><?php echo __('services.guarantee_subtitle'); ?></p>
                    </div>
                </div>
                <div class="guarantee-features">
                    <div class="guarantee-feature">
                        <i class="fas fa-gift"></i>
                        <span><?php echo __('services.guarantee_feature1'); ?></span>
                    </div>
                    <div class="guarantee-feature">
                        <i class="fas fa-handshake"></i>
                        <span><?php echo __('services.guarantee_feature2'); ?></span>
                    </div>
                    <div class="guarantee-feature">
                        <i class="fas fa-clock"></i>
                        <span><?php echo __('services.guarantee_feature3'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced CTA Section -->
    <section class="services-cta">
        <div class="container">
            <div class="cta-content">
                <h3><?php echo __('services.cta_title'); ?></h3>
                <p><?php echo __('services.cta_subtitle'); ?></p>
                <div class="cta-buttons">
                    <a href="https://wa.me/33676570097?text=Bonjour%2C%20je%20souhaite%20obtenir%20un%20devis%20gratuit%20pour%20vos%20services%20comptables." target="_blank" class="btn btn-primary btn-large">
                        <i class="fab fa-whatsapp"></i>
                        <?php echo __('btn.get_quote'); ?>
                    </a>
                    <a href="tel:+33676570097" class="btn btn-outline btn-large">
                        <i class="fas fa-phone"></i>
                        <?php echo __('btn.call_now'); ?>
                    </a>
                </div>
                <div class="cta-guarantee">
                    <i class="fas fa-shield-alt"></i>
                    <span><?php echo __('services.cta_guarantee'); ?></span>
                </div>
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
                        <a href="#" aria-label="<?php echo __('social.facebook'); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.linkedin'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.twitter'); ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.instagram'); ?>"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="mbc.php">À propos</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="contact-form.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Nos services</h3>
                    <ul>
                        <li><a href="services.php#services"><?php echo __('services.expertise_title'); ?></a></li>
                        <li><a href="services.php#services"><?php echo __('services.fiscalite_title'); ?></a></li>
                        <li><a href="services.php#services"><?php echo __('services.social_title'); ?></a></li>
                        <li><a href="services.php#services"><?php echo __('nav.consulting'); ?></a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <ul>
                        <li><i class="fas fa-phone" aria-hidden="true"></i> +33 6 76 57 00 97</li>
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
                <h2><?php echo __('modal.simulators.title'); ?></h2>
                <p><?php echo __('modal.simulators.subtitle'); ?></p>
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
                                        <label for="tva-ht">Montant HT (€)</label>
                                        <input type="number" id="tva-ht" placeholder="10000" step="0.01" value="10000" onchange="calculateTVA()" oninput="calculateTVA()">
                                    </div>
                                    <div class="form-group">
                                        <label for="tva-rate">Taux de TVA</label>
                                        <select id="tva-rate" onchange="calculateTVA()">
                                            <option value="20">20% - Taux normal</option>
                                            <option value="10">10% - Taux intermédiaire</option>
                                            <option value="5.5">5,5% - Taux réduit</option>
                                            <option value="2.1">2,1% - Taux super réduit</option>
                                            <option value="0">0% - Exonéré</option>
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
                                            <i class="fas fa-save"></i> Sauvegarder
                                        </button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Charges sociales Tab -->
                        <div class="tab-content" id="charges">
                            <div class="simulator-card">
                                <h3>Simulateur de charges sociales</h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="charges-brut">Rémunération brute annuelle (€)</label>
                                        <input type="number" id="charges-brut" placeholder="50000" step="1000" value="50000" onchange="calculateCharges()" oninput="calculateCharges()">
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-status">Statut juridique</label>
                                        <select id="charges-status" onchange="calculateCharges()">
                                            <option value="salarie">Salarié</option>
                                            <option value="micro">Micro-entreprise</option>
                                            <option value="auto">Auto-entrepreneur</option>
                                            <option value="sarl">SARL (gérant minoritaire)</option>
                                            <option value="sas">SAS (président)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-total">Total charges sociales</label>
                                        <input type="text" id="charges-total" readonly value="0.00 €">
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-net">Net après charges</label>
                                        <input type="text" id="charges-net" readonly value="0.00 €">
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-taux">Taux de charges</label>
                                        <input type="text" id="charges-taux" readonly value="0.00 %">
                                    </div>
                                    <p class="disclaimer">* Ces calculs sont des estimations. Consultez un expert-comptable pour des calculs précis.</p>
                                    <div class="simulator-actions">
                                        <button class="btn btn-secondary">
                                            <i class="fas fa-save"></i> Sauvegarder
                                        </button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Épargne & Retraite Tab -->
                        <div class="tab-content" id="epargne">
                            <div class="simulator-card">
                                <h3>Simulateur d'épargne retraite</h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="epargne-age">Âge actuel</label>
                                        <input type="number" id="epargne-age" placeholder="35" min="18" max="65" value="35" onchange="calculateEpargne()" oninput="calculateEpargne()">
                                    </div>
                                    <div class="form-group">
                                        <label for="epargne-retraite">Âge de départ à la retraite</label>
                                        <input type="number" id="epargne-retraite" placeholder="62" min="55" max="70" value="62" onchange="calculateEpargne()" oninput="calculateEpargne()">
                                    </div>
                                    <div class="form-group">
                                        <label for="epargne-mensuel">Épargne mensuelle (€)</label>
                                        <input type="number" id="epargne-mensuel" placeholder="300" step="50" min="0" value="300" onchange="calculateEpargne()" oninput="calculateEpargne()">
                                    </div>
                                    <div class="form-group">
                                        <label for="epargne-rendement">Rendement annuel estimé (%)</label>
                                        <input type="number" id="epargne-rendement" placeholder="3.0" step="0.1" min="0" max="15" value="3.0" onchange="calculateEpargne()" oninput="calculateEpargne()">
                                    </div>
                                    <div class="form-group">
                                        <label for="epargne-duree">Durée d'épargne</label>
                                        <input type="text" id="epargne-duree" readonly value="27 ans">
                                    </div>
                                    <div class="form-group">
                                        <label for="epargne-total">Capital constitué</label>
                                        <input type="text" id="epargne-total" readonly value="0.00 €">
                                    </div>
                                    <div class="form-group">
                                        <label for="epargne-rente">Rente mensuelle estimée</label>
                                        <input type="text" id="epargne-rente" readonly value="0.00 €">
                                    </div>
                                    <p class="disclaimer">* Simulation basée sur un rendement constant. Les performances passées ne préjugent pas des performances futures.</p>
                                    <div class="simulator-actions">
                                        <button class="btn btn-secondary">
                                            <i class="fas fa-save"></i> Sauvegarder
                                        </button>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Aides Tab -->
                        <div class="tab-content" id="aides">
                            <div class="simulator-card">
                                <h3>Simulateur d'aides au logement</h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="aide-revenus">Revenus fiscaux annuels</label>
                                        <input type="number" id="aide-revenus" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="aide-loyer">Loyer mensuel (charges comprises)</label>
                                        <input type="number" id="aide-loyer" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="aide-famille">Situation familiale</label>
                                        <select id="aide-famille">
                                            <option value="celibataire">Célibataire</option>
                                            <option value="couple">Couple</option>
                                            <option value="divorce">Divorcé(e)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="aide-enfants">Nombre d'enfants à charge</label>
                                        <select id="aide-enfants">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4+</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="aide-zone">Zone géographique</label>
                                        <select id="aide-zone">
                                            <option value="1">Zone 1</option>
                                            <option value="2">Zone 2</option>
                                            <option value="3">Zone 3</option>
                                        </select>
                                    </div>
                                    <div class="aide-result">
                                        <span class="aide-label">Aide mensuelle estimée:</span>
                                        <span class="aide-amount" id="aide-amount">0 €</span>
                                    </div>
                                    <p class="disclaimer">* Cette estimation est donnée à titre indicatif. Le montant réel de votre aide peut varier en fonction de votre situation précise.</p>
                                    <div class="simulator-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Simulation History Sidebar -->
                    <div class="simulators-sidebar">
                        <div class="history-card">
                            <h4>Historique des simulations</h4>
                            <div class="history-content">
                                <i class="fas fa-file-alt"></i>
                                <p><?php echo __('simulators.no_saved'); ?></p>
                            </div>
                        </div>
                        
                        <div class="tips-card">
                            <h4>Conseils d'expert</h4>
                            <div class="tip-item">
                                <i class="fas fa-lightbulb"></i>
                                <p>Optimisez votre fiscalité en choisissant le bon statut juridique pour votre activité.</p>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-chart-line"></i>
                                <p>Planifiez votre retraite dès maintenant pour bénéficier de l'effet de capitalisation.</p>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-calculator"></i>
                                <p>Calculez régulièrement vos charges sociales pour éviter les mauvaises surprises.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chatbot functionality
        let chatOpen = false;

        function toggleChat() {
            const chatWindow = document.getElementById('chatbotWindow');
            
            if (chatWindow.style.display === 'flex') {
                chatWindow.style.display = 'none';
            } else {
                chatWindow.style.display = 'flex';
            }
        }

        function addMessage(message, isUser = false) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'user-message' : 'bot-message';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.textContent = message;
            
            messageDiv.appendChild(messageContent);
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (message) {
                addMessage(message, true);
                input.value = '';
                
                // Simulate bot response
                setTimeout(() => {
                    const response = getBotResponse(message);
                    addMessage(response);
                }, 1000);
            }
        }

        function getBotResponse(message) {
            const lowerMessage = message.toLowerCase();
            const currentLang = '<?php echo getCurrentLanguage(); ?>';
            
            const responses = {
                'fr': {
                    'expertise comptable': 'Notre service d\'expertise comptable comprend la tenue de comptabilité, les bilans, les liasses fiscales et les tableaux de bord personnalisés. Souhaitez-vous plus d\'informations ?',
                    'fiscalité': 'Nous vous accompagnons dans l\'optimisation fiscale, la déclaration d\'impôts et le choix du régime fiscal adapté à votre activité.',
                    'création entreprise': 'MBC vous guide dans toutes les étapes de création d\'entreprise : choix du statut, formalités administratives et accompagnement personnalisé.',
                    'contact': 'Vous pouvez nous contacter au +33 6 76 57 00 97 ou par email à contact@mbc-expertcomptable.fr',
                    'prix': 'Nos tarifs sont personnalisés selon vos besoins. Contactez-nous pour un devis gratuit et sans engagement.',
                    'default': 'Merci pour votre message ! Notre équipe vous répondra dans les plus brefs délais. En attendant, n\'hésitez pas à explorer nos services sur le site.'
                },
                'en': {
                    'accounting expertise': 'Our accounting expertise service includes bookkeeping, balance sheets, tax returns and personalized dashboards. Would you like more information?',
                    'taxation': 'We support you in tax optimization, tax declaration and choosing the tax regime adapted to your activity.',
                    'business creation': 'MBC guides you through all business creation steps: status choice, administrative formalities and personalized support.',
                    'contact': 'You can contact us at +33 6 76 57 00 97 or by email at contact@mbc-expertcomptable.fr',
                    'price': 'Our rates are personalized according to your needs. Contact us for a free and no-obligation quote.',
                    'default': 'Thank you for your message! Our team will respond to you as soon as possible. In the meantime, feel free to explore our services on the site.'
                },
                'zh': {
                    '会计专业知识': '我们的会计专业知识服务包括簿记、资产负债表、纳税申报和个性化仪表板。您想要更多信息吗？',
                    '税务': '我们在税务优化、税务申报和选择适合您活动的税务制度方面为您提供支持。',
                    '企业创建': 'MBC指导您完成所有企业创建步骤：地位选择、行政手续和个性化支持。',
                    '联系': '您可以通过+33 6 76 57 00 97或通过电子邮件contact@mbc-expertcomptable.fr联系我们',
                    '价格': '我们的费率根据您的需求个性化。联系我们获取免费且无义务的报价。',
                    'default': '感谢您的消息！我们的团队将尽快回复您。同时，请随时探索我们网站上的服务。'
                }
            };
            
            const langResponses = responses[currentLang] || responses['fr'];
            
            // Check for specific keywords in the message
            for (const [keyword, response] of Object.entries(langResponses)) {
                if (lowerMessage.includes(keyword)) {
                    return response;
                }
            }
            
            return langResponses['default'];
        }

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

        // FAQ accordion
        function initializeFAQ() {
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', function() {
                    const isActive = item.classList.contains('active');
                    
                    // Close all FAQ items
                    faqItems.forEach(faq => faq.classList.remove('active'));
                    
                    // Open clicked item if it wasn't active
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize pagination
            const prevBtn = document.getElementById('prevServices');
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    if (currentPage > 1) {
                        showPage(currentPage - 1);
                    }
                });
            }
            
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
            
            // Initialize FAQ
            initializeFAQ();
            
            // Simulators link
            const simulatorsLink = document.querySelector('.simulators-link');
            if (simulatorsLink) {
                simulatorsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    openSimulatorsModal();
                });
            }
        });

        function handleEnter(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        // Pricing toggle functionality
        const pricingToggle = document.getElementById('pricingToggle');
        if (pricingToggle) {
            pricingToggle.addEventListener('change', function() {
                const monthlyPrices = document.querySelectorAll('.amount.monthly');
                const yearlyPrices = document.querySelectorAll('.amount.yearly');
                
                if (this.checked) {
                    // Show yearly prices
                    monthlyPrices.forEach(price => price.style.display = 'none');
                    yearlyPrices.forEach(price => price.style.display = 'inline');
                } else {
                    // Show monthly prices
                    monthlyPrices.forEach(price => price.style.display = 'inline');
                    yearlyPrices.forEach(price => price.style.display = 'none');
                }
            });
        }

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

        // Initialize calculators when inputs change
        document.addEventListener('DOMContentLoaded', function() {
            // Charges sociales calculator
            const chargesInputs = ['charges-brut', 'charges-status'];
            chargesInputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('change', calculateCharges);
                    element.addEventListener('input', calculateCharges);
                }
            });

            // Épargne calculator
            const epargneInputs = ['epargne-age', 'epargne-retraite', 'epargne-mensuel', 'epargne-rendement'];
            epargneInputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('change', calculateEpargne);
                    element.addEventListener('input', calculateEpargne);
                }
            });

            // Aides calculator
            const aidesInputs = ['aide-revenus', 'aide-loyer', 'aide-famille', 'aide-enfants', 'aide-zone'];
            aidesInputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('change', calculateAides);
                    element.addEventListener('input', calculateAides);
                }
            });

            // Initial calculations
            calculateTVA();
            calculateCharges();
            calculateEpargne();
            calculateAides();
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
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
</body>
</html>