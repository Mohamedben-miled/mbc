    </main>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-icon">
                        <i class="fas fa-building" aria-hidden="true"></i>
                    </div>
                    <h3>MBC Expert Comptable</h3>
                    <p>Votre expert-comptable de confiance pour accompagner votre entreprise dans sa croissance.</p>
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
                        <li><a href="#accueil">Accueil</a></li>
                        <li><a href="mbc.php">MBC</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="contact-form.php">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Nos services</h3>
                    <ul>
                        <li><a href="#expertise">Expertise Comptable</a></li>
                        <li><a href="#fiscalite">Fiscalité</a></li>
                        <li><a href="#social">Social &amp; Paie</a></li>
                        <li><a href="#conseil">Conseil</a></li>
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
                <p>© 2024 MBC Expert Comptable. Tous droits réservés.</p>
                <div>
                    <a href="#mentions">Mentions légales</a>
                    <a href="#confidentialite">Politique de confidentialité</a>
                    <a href="#cookies">CGV</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simulators Modal is included separately -->


    <!-- Scripts -->
    <script src="script.js"></script>

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

        // Modal functions are handled by modal.js

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
