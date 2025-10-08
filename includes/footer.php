    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Company Info -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="assets/mbc.png" alt="MBC Expert Comptable" class="footer-logo-img">
                    </div>
                    <p class="footer-description">
                        Votre expert-comptable de confiance pour accompagner votre entreprise dans sa croissance.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.php#accueil">Accueil</a></li>
                        <li><a href="mbc.php">À propos</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="contact-form.php">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="footer-section">
                    <h3>Nos services</h3>
                    <ul>
                        <li><a href="services.php#expertise">Expertise Comptable</a></li>
                        <li><a href="services.php#fiscalite">Fiscalité</a></li>
                        <li><a href="services.php#social">Social & Paie</a></li>
                        <li><a href="services.php#conseil">Conseil</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3>Contact</h3>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Rue de la Comptabilité<br>75001 Paris, France</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:+33676570097">+33 6 76 57 00 97</a>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:contact@mbc-expertcomptable.fr">contact@mbc-expertcomptable.fr</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> MBC Expert Comptable. Tous droits réservés.</p>
                    <div class="footer-links">
                        <a href="#">Mentions légales</a>
                        <a href="#">Politique de confidentialité</a>
                        <a href="#">CGV</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simulators Modal -->
    <div id="simulatorsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Simulateurs en ligne</h2>
                <button class="modal-close" aria-label="Fermer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="simulators-grid">
                    <div class="simulator-card">
                        <div class="simulator-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3>Simulateur de Charges</h3>
                        <p>Calculez vos charges sociales et fiscales</p>
                        <button class="btn btn-primary">Utiliser</button>
                    </div>
                    <div class="simulator-card">
                        <div class="simulator-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Simulateur de TVA</h3>
                        <p>Estimez votre TVA à payer</p>
                        <button class="btn btn-primary">Utiliser</button>
                    </div>
                    <div class="simulator-card">
                        <div class="simulator-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Simulateur de Création</h3>
                        <p>Évaluez le coût de création d'entreprise</p>
                        <button class="btn btn-primary">Utiliser</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chatbot -->
    <div id="chatbot" class="chatbot">
        <div class="chatbot-toggle" id="chatbotToggle">
            <i class="fas fa-comments"></i>
            <span><?php echo __('chatbot.assistant'); ?></span>
        </div>
        <div class="chatbot-window" id="chatbotWindow">
            <div class="chatbot-header">
                <h3><?php echo __('chatbot.assistant'); ?></h3>
                <button class="chatbot-close" id="chatbotClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chatbot-messages" id="chatbotMessages">
                <div class="chatbot-message bot">
                    <p><?php echo __('chatbot.welcome_message'); ?></p>
                </div>
            </div>
            <div class="chatbot-input">
                <input type="text" id="chatbotInput" placeholder="<?php echo __('chatbot.placeholder'); ?>">
                <button id="chatbotSend">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="script.js"></script>
    <script src="chatbot.js"></script>

    <!-- Additional scripts if needed -->
    <?php if (isset($additionalScripts)): ?>
        <?php echo $additionalScripts; ?>
    <?php endif; ?>

    <script>
        // User dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const userDropdownToggle = document.querySelector('.user-dropdown-toggle');
            const userDropdownMenu = document.querySelector('.user-dropdown-menu');
            
            if (userDropdownToggle && userDropdownMenu) {
                userDropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    userDropdownMenu.style.display = isExpanded ? 'none' : 'block';
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                        userDropdownToggle.setAttribute('aria-expanded', 'false');
                        userDropdownMenu.style.display = 'none';
                    }
                });
            }
        });

        // Language change functionality
        function changeLanguage(lang) {
            // Create a form to submit the language change
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

        // Mobile navigation functionality is handled by js/mobile-nav.js
            
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
        });
    </script>
</body>
</html>
