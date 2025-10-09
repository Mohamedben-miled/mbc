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
    <html lang="<?php echo getCurrentLanguage(); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo __('contact.meta_description'); ?>">
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
                <nav class="nav" role="navigation" aria-label="<?php echo __('nav.main_navigation'); ?>">
                    <ul class="nav-list">
                        <li><a href="index.php#accueil" class="nav-link"><?php echo __('nav.home'); ?></a></li>
                        <li><a href="mbc.php" class="nav-link"><?php echo __('nav.about'); ?></a></li>
                        <li><a href="services.php" class="nav-link"><?php echo __('nav.services'); ?></a></li>
                        <li><a href="#simulators" class="nav-link" onclick="openSimulatorsModal()"><?php echo __('nav.simulators'); ?></a></li>
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
                <li><a href="index.php" class="mobile-nav-link"><?php echo __('nav.home'); ?></a></li>
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

    <!-- Contact Methods -->
    <section class="contact-methods">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('contact.methods_title'); ?></h2>
                <p><?php echo __('contact.methods_subtitle'); ?></p>
            </div>

            <div class="methods-grid">
                <div class="method-card primary">
                    <div class="method-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3><?php echo __('contact.direct_call_title'); ?></h3>
                    <p><?php echo __('contact.direct_call_desc'); ?></p>
                    <a href="tel:+33123456789" class="method-btn">
                        <i class="fas fa-phone"></i>
                        +33 1 23 45 67 89
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3><?php echo __('contact.whatsapp_title'); ?></h3>
                    <p><?php echo __('contact.whatsapp_desc'); ?></p>
                    <a href="https://wa.me/33676570097" target="_blank" class="method-btn">
                        <i class="fab fa-whatsapp"></i>
                        <?php echo __('contact.start_conversation'); ?>
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3><?php echo __('contact.email_title'); ?></h3>
                    <p><?php echo __('contact.email_desc'); ?></p>
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
                            <option value=""><?php echo __('contact.select_subject'); ?></option>
                            <option value="expertise-comptable"><?php echo __('contact.subject_expertise'); ?></option>
                            <option value="fiscalite"><?php echo __('contact.subject_fiscalite'); ?></option>
                            <option value="social-paie"><?php echo __('contact.subject_social'); ?></option>
                            <option value="conseil"><?php echo __('contact.subject_conseil'); ?></option>
                            <option value="creation-entreprise"><?php echo __('contact.subject_creation'); ?></option>
                            <option value="devis"><?php echo __('contact.subject_devis'); ?></option>
                            <option value="autre"><?php echo __('contact.subject_autre'); ?></option>
                        </select>
                </div>
                    
                    <div class="form-group">
                        <label for="message"><?php echo __('contact.message'); ?> *</label>
                        <textarea id="message" name="message" rows="5" required placeholder="<?php echo __('contact.message_placeholder'); ?>"></textarea>
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
                    <h3><?php echo __('contact.our_office_title'); ?></h3>
                    <p><?php echo __('contact.office_address'); ?><br><?php echo __('contact.office_city'); ?></p>
                    </div>
                    
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3><?php echo __('contact.opening_hours_title'); ?></h3>
                            <p><?php echo __('contact.weekdays_hours'); ?><br><?php echo __('contact.saturday_hours'); ?></p>
                    </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3><?php echo __('contact.customer_support_title'); ?></h3>
                    <p><?php echo __('contact.customer_support_desc'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2><?php echo __('contact.faq_title'); ?></h2>
                <p><?php echo __('contact.faq_subtitle'); ?></p>
            </div>
            
            <div class="faq-grid">
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

    <?php include 'includes/footer.php'; ?>



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
                submitBtn.innerHTML = '<span><?php echo __("contact.sending"); ?></span><i class="fas fa-spinner fa-spin"></i>';
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
                    showNotification('error', '<?php echo __("contact.error_occurred"); ?>');
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

        <?php include 'includes/simulators-modal.php'; ?>

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
        });

        // Simulators link now uses onclick attribute

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
                closeModal();
            }
        });
            
            // Contact form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitBtn = this.querySelector('.submit-btn');
                    const originalText = submitBtn.innerHTML;
                    
                    // Show loading state
                    submitBtn.innerHTML = '<span><?php echo __("contact.sending"); ?></span><i class="fas fa-spinner fa-spin"></i>';
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
                        showNotification('error', '<?php echo __("contact.error_occurred"); ?>');
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