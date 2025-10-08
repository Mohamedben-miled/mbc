<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("about.hero.title") . " - MBC Expert Comptable";
$pageDescription = __("about.hero.subtitle");

// SEO Meta Tags
$seoKeywords = "Majdi Besbes, expert comptable, OEC, Île-de-France, franco-maghrébin, comptabilité";
$ogImage = "https://mbc-expertcomptable.fr/assets/Majdi.png";
$twitterImage = "https://mbc-expertcomptable.fr/assets/Majdi.png";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Découvrez Majdi Besbes, expert-comptable inscrit au tableau de l'OEC Île-de-France. Spécialisé dans l'accompagnement des entrepreneurs franco-maghrébins.">
    <meta name="keywords" content="Majdi Besbes, expert comptable, OEC, Île-de-France, franco-maghrébin, comptabilité">
    <meta name="author" content="MBC Expert Comptable">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="MBC - À propos de Majdi Besbes | Expert-Comptable">
    <meta property="og:description" content="Découvrez Majdi Besbes, expert-comptable inscrit au tableau de l'OEC Île-de-France. Spécialisé dans l'accompagnement des entrepreneurs franco-maghrébins.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mbc-expertcomptable.fr/mbc.php">
    <meta property="og:image" content="https://mbc-expertcomptable.fr/assets/Majdi.png">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="MBC - À propos de Majdi Besbes | Expert-Comptable">
    <meta name="twitter:description" content="Découvrez Majdi Besbes, expert-comptable inscrit au tableau de l'OEC Île-de-France. Spécialisé dans l'accompagnement des entrepreneurs franco-maghrébins.">
    <meta name="twitter:image" content="https://mbc-expertcomptable.fr/assets/Majdi.png">
    
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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
</head>
<body>
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
                        <li><a href="mbc.php" class="nav-link active" aria-current="page"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
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
                    <div class="mobile-auth-buttons">
                        <a href="admin/login.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-in-alt"></i> <?php echo __('nav.login'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main role="main">
        <!-- Hero Section -->
        <section class="mbc-hero section">
            <div class="container">
                <div class="mbc-hero-content">
                    <div class="mbc-hero-text">
                        <h1 class="mbc-hero-title"><?php echo __('about.hero.title'); ?></h1>
                        <p class="mbc-hero-subtitle"><?php echo __('about.hero.subtitle'); ?></p>
                        <p class="mbc-hero-description"><?php echo __('about.hero.subtitle'); ?></p>
                        <div class="mbc-hero-cta">
                            <a href="#contact" class="btn btn-primary"><?php echo __('home.cta_section.button2'); ?></a>
                            <a href="#services" class="btn btn-secondary"><?php echo __('home.services.title'); ?></a>
                        </div>
                    </div>
                    <div class="mbc-hero-image">
                        <img src="assets/Majdi.png" alt="<?php echo __('common.majdi_besbes'); ?>" loading="eager" class="majdi-hero-photo">
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="mbc-about section" aria-labelledby="about-title">
            <div class="container">
                <div class="mbc-about-content">
                    <div class="mbc-about-text">
                        <h2 id="about-title"><?php echo __('about.expertise.title'); ?></h2>
                        <div class="mbc-description">
                            <p><?php echo __('mbc.intro'); ?></p>
                            
                            <p><?php echo __('mbc.approach'); ?></p>
                            
                            <p><?php echo __('mbc.experience'); ?></p>
                        </div>
                        
                        <div class="mbc-cta">
                            <a href="#contact" class="btn btn-primary btn-large"><?php echo __('btn.start_project'); ?></a>
                        </div>
                    </div>
                    
                    <div class="mbc-credentials">
                        <div class="credential-card">
                            <div class="credential-icon">
                                <i class="fas fa-certificate" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('mbc.expert_title'); ?></h3>
                            <p><?php echo __('mbc.registration'); ?></p>
                        </div>
                        
                        <div class="credential-card">
                            <div class="credential-icon">
                                <i class="fas fa-star" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('mbc.page_jaune'); ?></h3>
                            <p><?php echo __('mbc.certified'); ?></p>
                        </div>
                        
                        <div class="credential-card">
                            <div class="credential-icon">
                                <i class="fas fa-globe" aria-hidden="true"></i>
                            </div>
                            <h3><?php echo __('home.why_choose.reason1.title'); ?></h3>
                            <p><?php echo __('home.why_choose.reason1.description'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="mbc-values section" aria-labelledby="values-title">
            <div class="container">
                <h2 id="values-title"><?php echo __('mbc.values_title'); ?></h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake" aria-hidden="true"></i>
                        </div>
                        <h3><?php echo __('mbc.value_trust'); ?></h3>
                        <p><?php echo __('mbc.value_trust_desc'); ?></p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb" aria-hidden="true"></i>
                        </div>
                        <h3><?php echo __('mbc.value_innovation'); ?></h3>
                        <p><?php echo __('mbc.value_innovation_desc'); ?></p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-users" aria-hidden="true"></i>
                        </div>
                        <h3><?php echo __('mbc.value_support'); ?></h3>
                        <p><?php echo __('mbc.value_support_desc'); ?></p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-chart-line" aria-hidden="true"></i>
                        </div>
                        <h3><?php echo __('mbc.value_excellence'); ?></h3>
                        <p><?php echo __('mbc.value_excellence_desc'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Social Section -->
        <section class="mbc-social section" aria-labelledby="social-title">
            <div class="container">
                <div class="social-content">
                    <div class="social-text">
                        <h2 id="social-title"><?php echo __('mbc.stay_connected'); ?></h2>
                        <p><?php echo __('mbc.social_desc'); ?></p>
                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/majdi-besbes-12bb8a1b/?originalSubdomain=fr" target="_blank" rel="noopener" class="social-link linkedin">
                                <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                                <span>LinkedIn</span>
                            </a>
                            <a href="#" target="_blank" rel="noopener" class="social-link instagram">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                                <span>Instagram</span>
                            </a>
                            <a href="#" target="_blank" rel="noopener" class="social-link facebook">
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                <span>Facebook</span>
                            </a>
                        </div>
                    </div>
                    <div class="social-cta">
                        <h3><?php echo __('mbc.ready_to_join'); ?></h3>
                        <p><?php echo __('mbc.discover'); ?></p>
                        <a href="#contact" class="btn btn-primary btn-large"><?php echo __('btn.contact_us'); ?></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="mbc-cta-section section" aria-labelledby="cta-title">
            <div class="container">
                <div class="cta-content">
                    <h2 id="cta-title"><?php echo __('home.cta_section.title'); ?></h2>
                    <p><?php echo __('home.cta_section.subtitle'); ?></p>
                    <div class="cta-buttons">
                        <a href="#contact" class="btn btn-secondary btn-large"><?php echo __('home.cta_section.button2'); ?></a>
                        <a href="#devis" class="btn btn-primary btn-large"><?php echo __('home.cta_section.button1'); ?></a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Simulators Modal -->
    <div id="simulatorsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo __('modal.simulators.title'); ?></h2>
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
                            
                            <div class="simulator-card">
                                <h3>Simulateur de fiscalité des dividendes</h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="div-brut">Montant brut des dividendes</label>
                                        <input type="number" id="div-brut" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="div-option">Option d'imposition</label>
                                        <select id="div-option">
                                            <option value="flat">Prélèvement forfaitaire (30%)</option>
                                            <option value="progressif">Barème progressif</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="div-social">Prélèvements sociaux</label>
                                        <input type="text" id="div-social" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="div-impot">Impôt sur le revenu</label>
                                        <input type="text" id="div-impot" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="div-net">Net après impôt</label>
                                        <input type="text" id="div-net" readonly value="0.00 €">
                                    </div>
                                    <div class="simulator-actions">
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
                                        <label for="charges-brut">Rémunération brute annuelle</label>
                                        <input type="number" id="charges-brut" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-status">Statut juridique</label>
                                        <select id="charges-status">
                                            <option value="salarie">Salarié</option>
                                            <option value="micro">Micro-entreprise</option>
                                            <option value="auto">Auto-entrepreneur</option>
                                            <option value="sarl">SARL</option>
                                            <option value="sas">SAS</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-total">Total charges sociales</label>
                                        <input type="text" id="charges-total" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="charges-net">Net après charges</label>
                                        <input type="text" id="charges-net" readonly>
                                    </div>
                                    <p class="disclaimer">* Ces calculs sont des estimations. Consultez un expert-comptable pour des calculs précis.</p>
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
                        
                        <!-- Épargne & Retraite Tab -->
                        <div class="tab-content" id="epargne">
                            <div class="simulator-card">
                                <h3>Simulateur de sortie du PER</h3>
                                <div class="simulator-form">
                                    <div class="form-group">
                                        <label for="per-age">Âge</label>
                                        <input type="number" id="per-age" placeholder="<?php echo __('common.your_age'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="per-montant">Montant du rachat</label>
                                        <input type="number" id="per-montant" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="per-type">Type de sortie</label>
                                        <select id="per-type">
                                            <option value="partiel">Rachat partiel</option>
                                            <option value="total">Rachat total</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="per-situation">Situation</label>
                                        <select id="per-situation">
                                            <option value="actif">Actif</option>
                                            <option value="retraite">Retraité</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="per-impot">Imposition estimée</label>
                                        <input type="text" id="per-impot" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="per-net">Montant net estimé</label>
                                        <input type="text" id="per-net" readonly value="0.00 €">
                                    </div>
                                    <div class="simulator-actions">
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
                    </div>
                </div>
                
                <!-- Call to Action -->
                <div class="simulators-cta">
                    <h3>Besoin d'un calcul plus précis ?</h3>
                    <p>Ces simulateurs donnent des estimations. Pour des calculs précis adaptés à votre situation, prenez rendez-vous avec l'un de nos experts-comptables.</p>
                    <div class="cta-buttons">
                        <button class="btn btn-primary"><?php echo __('btn.book_expert'); ?></button>
                        <button class="btn btn-secondary"><?php echo __('btn.free_quote'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <a href="https://www.linkedin.com/in/majdi-besbes-12bb8a1b/?originalSubdomain=fr" target="_blank" rel="noopener" aria-label="<?php echo __('common.share_linkedin'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="#" target="_blank" rel="noopener" aria-label="<?php echo __('common.share_whatsapp'); ?>"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" target="_blank" rel="noopener" aria-label="<?php echo __('common.share_facebook'); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4><?php echo __('footer.quick_links'); ?></h4>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="mbc.php">À propos</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="contact-form.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4><?php echo __('footer.services'); ?></h4>
                    <ul>
                        <li><a href="services.php#expertise"><?php echo __('home.expertise.title'); ?></a></li>
                        <li><a href="services.php#fiscalite"><?php echo __('home.fiscalite.title'); ?></a></li>
                        <li><a href="services.php#social"><?php echo __('home.service_conseil.feature1'); ?></a></li>
                        <li><a href="services.php#conseil"><?php echo __('home.conseil.title'); ?></a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4><?php echo __('footer.contact'); ?></h4>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope" aria-hidden="true"></i> contact@mbc-expertcomptable.fr</p>
                        <p><i class="fas fa-phone" aria-hidden="true"></i> +33 1 XX XX XX XX</p>
                        <p><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Île-de-France, France</p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MBC Expert Comptable. Tous droits réservés.</p>
                <div class="legal-links">
                    <a href="#">Mentions légales</a>
                    <a href="#">Politique de confidentialité</a>
                    <a href="#">CGV</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script>

        // Chat functions
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
                
                // Simulate bot thinking
                setTimeout(() => {
                    const botResponse = getBotResponse(message);
                    addMessage(botResponse, 'bot');
                }, 1000);
            }
        }

        function addMessage(message, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            
            const avatar = sender === 'bot' ? 'fas fa-robot' : 'fas fa-user';
            const avatarBg = sender === 'bot' ? '#3b82f6' : '#10b981';
            
            messageDiv.innerHTML = `
                <div class="message-avatar" style="background: ${avatarBg};">
                    <i class="${avatar}"></i>
                </div>
                <div class="message-content">
                    <p>${message.replace(/\n/g, '<br>')}</p>
                </div>
            `;
            
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

        // Header scroll effect
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.header');
            
            function handleScroll() {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
            
            window.addEventListener('scroll', handleScroll);
            handleScroll();
        });
    </script>
    <script>
        // Business Suggestion Chatbot
        document.addEventListener('DOMContentLoaded', function() {
            const chatbot = document.getElementById('businessChatbot');
            const closeBtn = document.querySelector('.chatbot-close');
            const discoverBtn = document.querySelector('.btn-primary');
            const laterBtn = document.querySelector('.btn-secondary');
            const messageText = document.querySelector('.message-text');
            const header = document.querySelector('.header');

            // Business suggestion messages
            const businessMessages = [
                "💡 Prêt à créer votre entreprise ? Je peux vous accompagner !",
                "🚀 Votre idée d'entreprise mérite d'être réalisée ! Parlons-en !",
                "💼 Créer une entreprise en France ? C'est plus simple avec MBC !",
                "🌟 Transformez votre projet en succès entrepreneurial !",
                "📈 Besoin d'aide pour votre création d'entreprise ? Je suis là !",
                "💡 Votre rêve d'entrepreneur peut devenir réalité !",
                "🎯 Prêt à lancer votre business ? Commençons ensemble !",
                "💪 Créer une entreprise franco-maghrébine ? C'est notre spécialité !"
            ];

            let lastScrollTime = 0;
            let lastMessageTime = 0;
            let isChatbotVisible = false;
            let messageInterval;

            // Header scroll effect
            function handleScroll() {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                // Show chatbot periodically while scrolling
                const currentTime = Date.now();
                const scrollTime = currentTime - lastScrollTime;
                
                if (scrollTime > 2000 && !isChatbotVisible) { // 2 seconds between scrolls
                    const timeSinceLastMessage = currentTime - lastMessageTime;
                    if (timeSinceLastMessage > 30000) { // 30 seconds between messages
                        showRandomMessage();
                        lastMessageTime = currentTime;
                    }
                }
                
                lastScrollTime = currentTime;
            }

            // Show random business message
            function showRandomMessage() {
                const randomMessage = businessMessages[Math.floor(Math.random() * businessMessages.length)];
                messageText.textContent = randomMessage;
                chatbot.classList.add('active');
                isChatbotVisible = true;

                // Auto-hide after 8 seconds if not interacted with
                setTimeout(() => {
                    if (isChatbotVisible) {
                        hideChatbot();
                    }
                }, 8000);
            }

            // Hide chatbot
            function hideChatbot() {
                chatbot.classList.remove('active');
                isChatbotVisible = false;
            }

            // Close chatbot
            closeBtn.addEventListener('click', hideChatbot);

            // Discover button
            discoverBtn.addEventListener('click', function() {
                hideChatbot();
                // Redirect to services or contact
                window.location.href = '#services';
            });

            // Later button
            laterBtn.addEventListener('click', function() {
                hideChatbot();
            });

            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!chatbot.contains(e.target) && isChatbotVisible) {
                    hideChatbot();
                }
            });

            // Add scroll listener
            window.addEventListener('scroll', handleScroll);

            // Show first message after 5 seconds
            setTimeout(() => {
                if (!isChatbotVisible) {
                    showRandomMessage();
                }
            }, 5000);
        });

        // Modal Functions
        function openSimulatorsModal() {
            const modal = document.getElementById('simulatorsModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Initialize simulators
            initializeSimulators();
        }

        function closeSimulatorsModal() {
            const modal = document.getElementById('simulatorsModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('simulatorsModal');
            if (event.target === modal) {
                closeSimulatorsModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSimulatorsModal();
            }
        });

        // Initialize Simulators
        function initializeSimulators() {
            // Tab Navigation
            const tabs = document.querySelectorAll('.nav-tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding content
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });

            // TVA Calculator - Real-time calculation
            const tvaHtInput = document.getElementById('tva-ht');
            const tvaRateSelect = document.getElementById('tva-rate');
            const tvaAmountInput = document.getElementById('tva-amount');
            const tvaTtcInput = document.getElementById('tva-ttc');

            function calculateTVA() {
                const ht = parseFloat(tvaHtInput.value) || 0;
                const rate = parseFloat(tvaRateSelect.value) / 100;
                const tva = ht * rate;
                const ttc = ht + tva;
                
                tvaAmountInput.value = tva.toFixed(2) + ' €';
                tvaTtcInput.value = ttc.toFixed(2) + ' €';
            }

            if (tvaHtInput) {
                tvaHtInput.addEventListener('input', calculateTVA);
                tvaRateSelect.addEventListener('change', calculateTVA);
            }

            // Dividend Calculator
            const divBrutInput = document.getElementById('div-brut');
            const divOptionSelect = document.getElementById('div-option');
            const divSocialInput = document.getElementById('div-social');
            const divImpotInput = document.getElementById('div-impot');
            const divNetInput = document.getElementById('div-net');

            function calculateDividends() {
                const brut = parseFloat(divBrutInput.value) || 0;
                const option = divOptionSelect.value;
                
                let social, impot, net;
                if (option === 'flat') {
                    social = brut * 0.17; // 17% prélèvements sociaux
                    impot = brut * 0.13; // 13% impôt forfaitaire
                    net = brut - social - impot;
                } else {
                    social = brut * 0.17; // 17% prélèvements sociaux
                    impot = brut * 0.12; // 12% barème progressif
                    net = brut - social - impot;
                }
                
                divSocialInput.value = social.toFixed(2) + ' €';
                divImpotInput.value = impot.toFixed(2) + ' €';
                divNetInput.value = net.toFixed(2) + ' €';
            }

            if (divBrutInput) {
                divBrutInput.addEventListener('input', calculateDividends);
                divOptionSelect.addEventListener('change', calculateDividends);
            }

            // Social Charges Calculator
            const chargesBrutInput = document.getElementById('charges-brut');
            const chargesStatusSelect = document.getElementById('charges-status');
            const chargesTotalInput = document.getElementById('charges-total');
            const chargesNetInput = document.getElementById('charges-net');

            function calculateSocialCharges() {
                const brut = parseFloat(chargesBrutInput.value) || 0;
                const status = chargesStatusSelect.value;
                
                let charges, net;
                switch(status) {
                    case 'salarie':
                        charges = brut * 0.22; // 22% charges salariales
                        net = brut - charges;
                        break;
                    case 'micro':
                        charges = brut * 0.12; // 12% micro-entreprise
                        net = brut - charges;
                        break;
                    case 'auto':
                        charges = brut * 0.22; // 22% auto-entrepreneur
                        net = brut - charges;
                        break;
                    case 'sarl':
                        charges = brut * 0.45; // 45% SARL
                        net = brut - charges;
                        break;
                    case 'sas':
                        charges = brut * 0.50; // 50% SAS
                        net = brut - charges;
                        break;
                }
                
                chargesTotalInput.value = charges.toFixed(2) + ' €';
                chargesNetInput.value = net.toFixed(2) + ' €';
            }

            if (chargesBrutInput) {
                chargesBrutInput.addEventListener('input', calculateSocialCharges);
                chargesStatusSelect.addEventListener('change', calculateSocialCharges);
            }

            // PER Calculator
            const perAgeInput = document.getElementById('per-age');
            const perMontantInput = document.getElementById('per-montant');
            const perTypeSelect = document.getElementById('per-type');
            const perSituationSelect = document.getElementById('per-situation');
            const perImpotInput = document.getElementById('per-impot');
            const perNetInput = document.getElementById('per-net');

            function calculatePER() {
                const age = parseInt(perAgeInput.value) || 0;
                const montant = parseFloat(perMontantInput.value) || 0;
                const type = perTypeSelect.value;
                const situation = perSituationSelect.value;
                
                let impot, net;
                if (situation === 'retraite') {
                    impot = montant * 0.10; // 10% si retraité
                } else if (age >= 60) {
                    impot = montant * 0.15; // 15% si 60+ ans
                } else {
                    impot = montant * 0.30; // 30% si avant 60 ans
                }
                
                net = montant - impot;
                
                perImpotInput.value = impot.toFixed(2) + ' €';
                perNetInput.value = net.toFixed(2) + ' €';
            }

            if (perAgeInput) {
                perAgeInput.addEventListener('input', calculatePER);
                perMontantInput.addEventListener('input', calculatePER);
                perTypeSelect.addEventListener('change', calculatePER);
                perSituationSelect.addEventListener('change', calculatePER);
            }

            // Housing Aid Calculator
            const aideRevenusInput = document.getElementById('aide-revenus');
            const aideLoyerInput = document.getElementById('aide-loyer');
            const aideFamilleSelect = document.getElementById('aide-famille');
            const aideEnfantsSelect = document.getElementById('aide-enfants');
            const aideZoneSelect = document.getElementById('aide-zone');
            const aideAmountSpan = document.getElementById('aide-amount');

            function calculateHousingAid() {
                const revenus = parseFloat(aideRevenusInput.value) || 0;
                const loyer = parseFloat(aideLoyerInput.value) || 0;
                const famille = aideFamilleSelect.value;
                const enfants = parseInt(aideEnfantsSelect.value) || 0;
                const zone = parseInt(aideZoneSelect.value) || 1;
                
                // Simplified calculation for housing aid
                let aide = 0;
                if (revenus > 0 && loyer > 0) {
                    const revenusParPersonne = revenus / (1 + (famille === 'couple' ? 1 : 0) + enfants);
                    const loyerMax = 300 + (enfants * 50); // Simplified max rent
                    
                    if (loyer <= loyerMax && revenusParPersonne < 20000) {
                        aide = Math.min(loyer * 0.3, 200); // Max 30% of rent, capped at 200€
                    }
                }
                
                aideAmountSpan.textContent = aide.toFixed(0) + ' €';
            }

            if (aideRevenusInput) {
                aideRevenusInput.addEventListener('input', calculateHousingAid);
                aideLoyerInput.addEventListener('input', calculateHousingAid);
                aideFamilleSelect.addEventListener('change', calculateHousingAid);
                aideEnfantsSelect.addEventListener('change', calculateHousingAid);
                aideZoneSelect.addEventListener('change', calculateHousingAid);
            }
        }
    </script>

    <!-- Simulators Modal -->
    <div id="simulatorsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo __('modal.simulators.title'); ?></h2>
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
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
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
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script src="chatbot.js"></script>
</body>
</html>
