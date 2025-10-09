<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("nav.contact") . " - MBC Expert Comptable";
$pageDescription = __("contact.meta_description");

// SEO Meta Tags
$seoKeywords = "contact expert comptable, devis gratuit, conseil entreprise, comptabilité, fiscalité";
$ogImage = "https://mbc-expertcomptable.fr/assets/contact-og.jpg";
$twitterImage = "https://mbc-expertcomptable.fr/assets/contact-twitter.jpg";
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
    <meta property="og:url" content="https://mbc-expertcomptable.fr/contact">
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mbc-expertcomptable.fr/contact">
    <meta property="twitter:title" content="<?php echo $pageTitle; ?>">
    <meta property="twitter:description" content="<?php echo $pageDescription; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://mbc-expertcomptable.fr/contact">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/mbc.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="contact-page">

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
                        <li><a href="simulators.php" class="nav-link"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php" class="nav-link"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact.php" class="nav-link active" aria-current="page"><?php echo __('nav.contact'); ?></a></li>
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

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo __('contact.page_title'); ?></h1>
                <p class="hero-subtitle"><?php echo __('contact.page_subtitle'); ?></p>
            </div>
        </div>
    </section>

    <!-- Contact Methods Section -->
    <section class="contact-methods">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('contact.choose_contact'); ?></h2>
                <p><?php echo __('contact.contact_subtitle'); ?></p>
            </div>
            
            <div class="contact-methods-grid">
                <!-- Direct Call -->
                <div class="contact-method-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3><?php echo __('contact.direct_call'); ?></h3>
                    <p><?php echo __('contact.direct_call_desc'); ?></p>
                    <a href="tel:+33123456789" class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        <?php echo __('contact.phone_number'); ?>
                    </a>
                </div>

                <!-- WhatsApp -->
                <div class="contact-method-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3><?php echo __('contact.whatsapp'); ?></h3>
                    <p><?php echo __('contact.whatsapp_desc'); ?></p>
                    <a href="https://wa.me/33123456789" target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i>
                        <?php echo __('contact.start_conversation'); ?>
                    </a>
                </div>

                <!-- Email -->
                <div class="contact-method-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3><?php echo __('contact.email'); ?></h3>
                    <p><?php echo __('contact.email_desc'); ?></p>
                    <a href="mailto:contact@mbc-expertcomptable.fr" class="btn btn-outline">
                        <i class="fas fa-envelope"></i>
                        <?php echo __('contact.email'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Information -->
    <section class="office-info">
        <div class="container">
            <div class="office-content">
                <div class="office-details" data-aos="fade-right">
                    <h2><?php echo __('contact.our_office'); ?></h2>
                    <div class="office-address">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <p><?php echo __('contact.office_address'); ?></p>
                            <p><?php echo __('contact.office_city'); ?></p>
                        </div>
                    </div>
                    
                    <div class="office-hours">
                        <h3><?php echo __('contact.opening_hours'); ?></h3>
                        <div class="hours-list">
                            <div class="hours-item">
                                <span><?php echo __('contact.weekdays'); ?></span>
                            </div>
                            <div class="hours-item">
                                <span><?php echo __('contact.saturday'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="support-info">
                        <h3><?php echo __('contact.customer_support'); ?></h3>
                        <p><?php echo __('contact.support_hours'); ?></p>
                    </div>
                </div>
                
                <div class="office-map" data-aos="fade-left">
                    <div class="map-placeholder">
                        <i class="fas fa-map"></i>
                        <p><?php echo __('contact.office_address'); ?></p>
                        <p><?php echo __('contact.office_city'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="contact-faq">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('contact.faq_title'); ?></h2>
                <p><?php echo __('contact.faq_subtitle'); ?></p>
            </div>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('contact.faq1_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('contact.faq1_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('contact.faq2_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('contact.faq2_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('contact.faq3_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('contact.faq3_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php echo __('contact.faq4_question'); ?></h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo __('contact.faq4_answer'); ?></p>
                    </div>
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
                    <p><?php echo __('contact.footer_description'); ?></p>
                    <div class="social-links">
                        <a href="#" aria-label="<?php echo __('social.facebook'); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.linkedin'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.twitter'); ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" aria-label="<?php echo __('social.instagram'); ?>"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3><?php echo __('contact.quick_links'); ?></h3>
                    <ul>
                        <li><a href="index.php"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="simulators.php"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact.php"><?php echo __('nav.contact'); ?></a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3><?php echo __('contact.our_services'); ?></h3>
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

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/main.js"></script>
    <script src="js/mobile-nav.js"></script>
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

        // FAQ Toggle
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                const answer = faqItem.querySelector('.faq-answer');
                const icon = question.querySelector('i');
                
                faqItem.classList.toggle('active');
                
                if (faqItem.classList.contains('active')) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    answer.style.maxHeight = '0';
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });

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
</body>
</html>
