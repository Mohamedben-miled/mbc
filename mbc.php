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
    <link rel="icon" type="image/png" href="assets/mbc.png">
</head>
<body class="mbc-page">
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
                        <li><a href="#simulators" class="nav-link" onclick="openSimulatorsModal()"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php" class="nav-link"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact-form.php" class="nav-link"><?php echo __('nav.contact'); ?></a></li>
                    </ul>
                </nav>

                <!-- Header Utils -->
                <div class="header-utils">
                    <select class="language-selector" aria-label="<?php echo __('nav.select_language'); ?>" onchange="changeLanguage(this.value)">
                        <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>FR</option>
                        <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>EN</option>
                        <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>中文</option>
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
                <li><a href="#simulators" class="mobile-nav-link" onclick="openSimulatorsModal()"><?php echo __('nav.simulators'); ?></a></li>
                <li><a href="blog-dynamic.php" class="mobile-nav-link"><?php echo __('nav.blog'); ?></a></li>
                <li><a href="contact-form.php" class="mobile-nav-link"><?php echo __('nav.contact'); ?></a></li>
            </ul>
            
            <!-- Mobile Auth Section -->
            <div class="mobile-auth">
                <!-- Mobile Language Selector -->
                <div class="mobile-language-section">
                    <select class="language-selector mobile-language-selector" aria-label="<?php echo __('nav.select_language'); ?>" onchange="changeLanguage(this.value)">
                        <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>FR</option>
                        <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>EN</option>
                        <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>中文</option>
                    </select>
                </div>
                
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

    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="js/mobile-nav.js"></script>
    <script src="js/main.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/chatbot-multilingual-db.js"></script>
    <script>
        // Business Suggestion Chatbot
        document.addEventListener('DOMContentLoaded', function() {
            const chatbot = document.getElementById('businessChatbot');
            const closeBtn = document.querySelector('.chatbot-close');
            const discoverBtn = document.querySelector('.btn-primary');
            const laterBtn = document.querySelector('.btn-secondary');
            const messageText = document.querySelector('.message-text');
            const header = document.querySelector('.header');

            // Business suggestion messages based on language
            const businessMessages = {
                fr: {
                    title: "Découvrez nos services comptables",
                    message: "Besoin d'un expert-comptable ? Découvrez nos services personnalisés pour entrepreneurs franco-maghrébins.",
                    discover: "Découvrir nos services",
                    later: "Plus tard"
                },
                en: {
                    title: "Discover our accounting services",
                    message: "Need an accountant? Discover our personalized services for Franco-Maghrebi entrepreneurs.",
                    discover: "Discover our services",
                    later: "Later"
                },
                zh: {
                    title: "发现我们的会计服务",
                    message: "需要会计师吗？发现我们为法马企业家提供的个性化服务。",
                    discover: "发现我们的服务",
                    later: "稍后"
                }
            };

            // Show chatbot after 3 seconds
            setTimeout(() => {
                if (chatbot && !sessionStorage.getItem('chatbotShown')) {
                    chatbot.style.display = 'block';
                    sessionStorage.setItem('chatbotShown', 'true');
                }
            }, 3000);

            // Close chatbot
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    chatbot.style.display = 'none';
                });
            }

            // Handle button clicks
            if (discoverBtn) {
                discoverBtn.addEventListener('click', () => {
                    window.location.href = 'services.php';
                });
            }

            if (laterBtn) {
                laterBtn.addEventListener('click', () => {
                    chatbot.style.display = 'none';
                });
            }

            // Update content based on language
            function updateChatbotContent(language) {
                const messages = businessMessages[language] || businessMessages.fr;
                if (messageText) {
                    messageText.innerHTML = `
                        <h3>${messages.title}</h3>
                        <p>${messages.message}</p>
                    `;
                }
                if (discoverBtn) discoverBtn.textContent = messages.discover;
                if (laterBtn) laterBtn.textContent = messages.later;
            }

            // Initialize with current language
            const currentLang = document.documentElement.lang || 'fr';
            updateChatbotContent(currentLang);
        });

        // TVA Calculator
        function calculateTVA() {
            const ht = parseFloat(document.getElementById('tva-ht').value) || 0;
            const rate = parseFloat(document.getElementById('tva-rate').value) || 0;
            const tva = (ht * rate) / 100;
            const ttc = ht + tva;
            
            document.getElementById('tva-amount').value = tva.toFixed(2);
            document.getElementById('tva-ttc').value = ttc.toFixed(2);
        }

        // Modal Functions
        function openSimulatorsModal() {
            const modal = document.getElementById('simulatorsModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
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

        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked tab and corresponding content
                    tab.classList.add('active');
                    const tabId = tab.getAttribute('data-tab');
                    const targetContent = document.getElementById(tabId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });

        // Housing Aid Calculator
        function calculateHousingAid() {
            const loyer = parseFloat(document.getElementById('aide-loyer').value) || 0;
            const revenus = parseFloat(document.getElementById('aide-revenus').value) || 0;
            const famille = parseInt(document.getElementById('aide-famille').value) || 1;
            const enfants = parseInt(document.getElementById('aide-enfants').value) || 0;
            const zone = parseInt(document.getElementById('aide-zone').value) || 1;

            // Simplified calculation (this is just an example)
            let aide = 0;
            if (revenus < 2000 && loyer > 0) {
                aide = Math.min(loyer * 0.3, 200);
            }

            document.getElementById('aide-montant').value = aide.toFixed(2);
        }

        // Initialize calculators when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // TVA Calculator
            const tvaHtInput = document.getElementById('tva-ht');
            const tvaRateSelect = document.getElementById('tva-rate');
            
            if (tvaHtInput && tvaRateSelect) {
                tvaHtInput.addEventListener('input', calculateTVA);
                tvaRateSelect.addEventListener('change', calculateTVA);
                calculateTVA(); // Initial calculation
            }

            // Housing Aid Calculator
            const aideLoyerInput = document.getElementById('aide-loyer');
            const aideRevenusInput = document.getElementById('aide-revenus');
            const aideFamilleSelect = document.getElementById('aide-famille');
            const aideEnfantsInput = document.getElementById('aide-enfants');
            const aideZoneSelect = document.getElementById('aide-zone');
            
            if (aideLoyerInput && aideRevenusInput && aideFamilleSelect && aideEnfantsInput && aideZoneSelect) {
                aideLoyerInput.addEventListener('input', calculateHousingAid);
                aideRevenusInput.addEventListener('input', calculateHousingAid);
                aideFamilleSelect.addEventListener('change', calculateHousingAid);
                aideEnfantsInput.addEventListener('change', calculateHousingAid);
                aideZoneSelect.addEventListener('change', calculateHousingAid);
            }
        }

        // Initialize chatbot
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the multilingual chatbot
            if (typeof window.multilingualChatbotDB !== 'undefined') {
                window.multilingualChatbotDB.init();
            }
        });
    </script>

    <?php include 'includes/simulators-modal.php'; ?>

    <!-- Chatbot -->
    <div id="mbc-chatbot" class="mbc-chatbot" style="display: block !important; visibility: visible !important; opacity: 1 !important; position: fixed !important; bottom: 15px !important; right: 15px !important; z-index: 9999 !important;">
        <div class="chatbot-toggle" onclick="window.multilingualChatbotDB.toggleChatbot()" style="display: flex !important; visibility: visible !important; opacity: 1 !important; background: rgba(255, 255, 255, 0.95) !important; border: 2px solid #296871 !important; color: #296871 !important; padding: 8px 12px !important; border-radius: 50px !important; cursor: pointer !important;">
            <i class="fas fa-comments"></i>
            <span><?php echo __('chatbot.assistant'); ?></span>
        </div>
        <div class="chatbot-window" id="chatbotWindow">
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <i class="fas fa-robot"></i>
                    <span><?php echo __('chatbot.assistant'); ?></span>
                </div>
                <div class="chatbot-language-selector">
                    <select id="chatbotLanguage" onchange="window.multilingualChatbotDB.changeLanguage(this.value)">
                        <option value="fr" <?php echo getCurrentLanguage() === 'fr' ? 'selected' : ''; ?>>FR</option>
                        <option value="en" <?php echo getCurrentLanguage() === 'en' ? 'selected' : ''; ?>>EN</option>
                        <option value="zh" <?php echo getCurrentLanguage() === 'zh' ? 'selected' : ''; ?>>中文</option>
                    </select>
                </div>
                <button class="chatbot-close" onclick="window.multilingualChatbotDB.toggleChatbot()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chatbot-messages" id="chatbotMessages">
                <div class="message bot-message">
                    <div class="message-content">
                        <?php echo __('chatbot.welcome_message'); ?>
                    </div>
                </div>
            </div>
            <div class="chatbot-input">
                <input type="text" id="chatbotInput" placeholder="<?php echo __('chatbot.placeholder'); ?>" onkeypress="window.multilingualChatbotDB.handleKeypress(event)">
                <button onclick="window.multilingualChatbotDB.sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
