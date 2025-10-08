<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/encoding.php';
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/translations.php';

$auth = new Auth();

$pageTitle = __("nav.contact") . " - MBC Expert Comptable";
$pageDescription = __("contact.subtitle");

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
    <meta name="description" content="Contactez MBC Expert Comptable pour vos besoins en expertise comptable, fiscalité, social & paie. Devis gratuit et conseil personnalisé.">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="contact-page">
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
                <nav class="nav" role="navigation" aria-label="Navigation principale">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#" class="nav-link simulators-link"><?php echo __('nav.simulators'); ?></a></li>
                        <li><a href="blog-dynamic.php" class="nav-link"><?php echo __('nav.blog'); ?></a></li>
                        <li><a href="contact-form.php" class="nav-link active" aria-current="page"><?php echo __('nav.contact'); ?></a></li>
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


    <!-- Contact Methods -->
    <section class="contact-methods">
        <div class="container">
            <div class="section-header">
                <h2>Choisissez votre mode de contact</h2>
                <p>Nous adaptons notre approche à vos préférences</p>
            </div>

            <div class="methods-grid">
                <div class="method-card primary">
                    <div class="method-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Appel direct</h3>
                    <p>Parlez directement avec un expert</p>
                    <a href="tel:+33123456789" class="method-btn">
                        <i class="fas fa-phone"></i>
                        +33 1 23 45 67 89
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3>WhatsApp</h3>
                    <p>Échangez en temps réel</p>
                    <a href="https://wa.me/33676570097" target="_blank" class="method-btn">
                        <i class="fab fa-whatsapp"></i>
                        Démarrer la conversation
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>Détaillez votre projet par écrit</p>
                    <a href="mailto:contact@mbc-expertcomptable.fr" class="method-btn">
                        <i class="fas fa-envelope"></i>
                        contact@mbc-expertcomptable.fr
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2><?php echo __('contact.form.title'); ?></h2>
                    <p><?php echo __('contact.form.subtitle'); ?></p>
                </div>
                
                <form id="contactForm" class="modern-form" action="contact-handler.php" method="POST">
                        <div class="form-row">
                        <div class="form-group">
                            <label for="firstName"><?php echo __('contact.firstname'); ?> *</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName"><?php echo __('contact.lastname'); ?> *</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>
                    
                        <div class="form-row">
                        <div class="form-group">
                            <label for="email"><?php echo __('contact.email'); ?> *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><?php echo __('contact.phone'); ?></label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="company"><?php echo __('contact.company'); ?></label>
                        <input type="text" id="company" name="company">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject"><?php echo __('contact.subject'); ?> *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Sélectionnez un sujet</option>
                            <option value="expertise-comptable">Expertise Comptable</option>
                            <option value="fiscalite">Fiscalité</option>
                            <option value="social-paie">Social & Paie</option>
                            <option value="conseil">Conseil</option>
                            <option value="creation-entreprise">Création d'entreprise</option>
                            <option value="devis">Demande de devis</option>
                            <option value="autre">Autre</option>
                        </select>
                </div>
                    
                    <div class="form-group">
                        <label for="message"><?php echo __('contact.message'); ?> *</label>
                        <textarea id="message" name="message" rows="5" required placeholder="Décrivez votre projet ou votre question..."></textarea>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="privacy" name="privacy" required>
                        <label for="privacy"><?php echo __('contact.privacy'); ?> *</label>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <span><?php echo __('contact.submit'); ?></span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
                        </div>
    </section>

    <!-- Contact Info -->
    <section class="contact-info-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Notre bureau</h3>
                    <p>123 Avenue des Champs-Élysées<br>75008 Paris, France</p>
                    </div>
                    
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Horaires d'ouverture</h3>
                            <p>Lundi - Vendredi : 9h00 - 18h00<br>Samedi : 9h00 - 12h00</p>
                    </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Support client</h3>
                    <p>Disponible du lundi au vendredi<br>de 9h00 à 18h00</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2>Questions fréquentes</h2>
                <p>Retrouvez les réponses aux questions les plus courantes</p>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Comment puis-je obtenir un devis ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Vous pouvez demander un devis gratuit en remplissant notre formulaire de contact ou en nous appelant directement. Nous vous répondrons dans les 24h.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Quels sont vos tarifs ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Nos tarifs varient selon la taille de votre entreprise et les services requis. Contactez-nous pour un devis personnalisé adapté à vos besoins.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Travaillez-vous à distance ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Oui, nous proposons des services à distance avec des rendez-vous en visioconférence et un espace client sécurisé pour l'échange de documents.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Quels documents dois-je fournir ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Cela dépend de vos besoins. Nous vous fournirons une liste personnalisée lors de notre premier échange, adaptée à votre situation.</p>
                    </div>
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
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
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
                        <li><a href="services.php#expertise">Expertise Comptable</a></li>
                        <li><a href="services.php#fiscalite">Fiscalité</a></li>
                        <li><a href="services.php#social">Social & Paie</a></li>
                        <li><a href="services.php#conseil">Conseil</a></li>
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



    <script>
        // FAQ Accordion
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Close all other items
                    faqItems.forEach(otherItem => {
                        otherItem.classList.remove('active');
                    });
                    
                    // Toggle current item
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });
        });

        // Contact form submission
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('.submit-btn');
                const originalText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.innerHTML = '<span>Envoi en cours...</span><i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
                
                try {
                    const formData = new FormData(this);
                    
                    const response = await fetch('contact-handler.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        // Show success message
                        showNotification('success', result.message);
                        this.reset();
                    } else {
                        // Show error message
                        showNotification('error', result.message);
                        if (result.errors) {
                            displayFormErrors(result.errors);
                        }
                    }
                } catch (error) {
                    showNotification('error', 'Une erreur est survenue. Veuillez réessayer.');
                } finally {
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
        }
        
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()">&times;</button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
        
        function displayFormErrors(errors) {
            // Clear previous errors
            document.querySelectorAll('.form-error').forEach(error => error.remove());
            
            // Display new errors
            Object.keys(errors).forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'form-error';
                    errorDiv.textContent = errors[fieldName];
                    field.parentElement.appendChild(errorDiv);
                }
            });
        }
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
            
            // Contact form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitBtn = this.querySelector('.submit-btn');
                    const originalText = submitBtn.innerHTML;
                    
                    // Show loading state
                    submitBtn.innerHTML = '<span>Envoi en cours...</span><i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                    
                    try {
                        const formData = new FormData(this);
                        
                        const response = await fetch('contact-handler.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            // Show success message
                            showNotification('success', '<?php echo __('contact.success'); ?>');
                            this.reset();
                        } else {
                            // Show error message
                            showNotification('error', result.message || '<?php echo __('contact.error'); ?>');
                            if (result.errors) {
                                displayFormErrors(result.errors);
                            }
                        }
                    } catch (error) {
                        showNotification('error', 'Une erreur est survenue. Veuillez réessayer.');
                    } finally {
                        // Reset button
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }
        });
        
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()">&times;</button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
        
        function displayFormErrors(errors) {
            // Clear previous errors
            document.querySelectorAll('.form-error').forEach(error => error.remove());
            
            // Display new errors
            Object.keys(errors).forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'form-error';
                    errorDiv.textContent = errors[fieldName];
                    field.parentElement.appendChild(errorDiv);
                }
            });
        }
        
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
        
        // Enhanced mobile checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing checkbox enhancements...');
            
            // Function to enhance checkbox interactions
            function enhanceCheckboxes() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                console.log('Found checkboxes:', checkboxes.length);
                
                checkboxes.forEach((checkbox, index) => {
                    console.log(`Processing checkbox ${index + 1}:`, checkbox.id);
                    
                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                    const container = checkbox.closest('.checkbox, .checkbox-group');
                    
                    if (container && label) {
                        console.log('Enhancing checkbox container:', container);
                        
                        // Remove any existing event listeners to prevent duplicates
                        container.removeEventListener('click', handleContainerClick);
                        container.removeEventListener('touchstart', handleTouchStart);
                        container.removeEventListener('touchend', handleTouchEnd);
                        checkbox.removeEventListener('change', handleCheckboxChange);
                        
                        // Make the entire container clickable
                        function handleContainerClick(e) {
                            console.log('Container clicked');
                            if (e.target !== checkbox && e.target !== label) {
                                e.preventDefault();
                                e.stopPropagation();
                                checkbox.checked = !checkbox.checked;
                                checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        }
                        
                        // Add visual feedback
                        function handleTouchStart(e) {
                            this.style.transform = 'scale(0.98)';
                            this.style.transition = 'transform 0.1s ease';
                        }
                        
                        function handleTouchEnd(e) {
                            this.style.transform = '';
                        }
                        
                        // Handle checkbox state changes
                        function handleCheckboxChange(e) {
                            console.log('Checkbox changed:', this.checked);
                            if (this.checked) {
                                container.style.background = '#e9ecef';
                                container.style.borderColor = '#296871';
                            } else {
                                container.style.background = '#f8f9fa';
                                container.style.borderColor = 'transparent';
                            }
                        }
                        
                        // Add event listeners
                        container.addEventListener('click', handleContainerClick, { passive: false });
                        container.addEventListener('touchstart', handleTouchStart, { passive: true });
                        container.addEventListener('touchend', handleTouchEnd, { passive: true });
                        checkbox.addEventListener('change', handleCheckboxChange, { passive: true });
                        
                        // Also make the label clickable
                        label.addEventListener('click', function(e) {
                            e.preventDefault();
                            checkbox.checked = !checkbox.checked;
                            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                        }, { passive: false });
                        
                        console.log('Checkbox enhanced successfully');
                    } else {
                        console.log('No container or label found for checkbox');
                    }
                });
            }
            
            // Initialize immediately
            enhanceCheckboxes();
            
            // Re-initialize after a short delay to catch any dynamically loaded content
            setTimeout(enhanceCheckboxes, 100);
            
            // Also initialize when the page is fully loaded
            window.addEventListener('load', enhanceCheckboxes);
        });
    </script>
    <script src="chatbot.js"></script>
</body>
</html>