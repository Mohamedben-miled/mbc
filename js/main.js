/**
 * Main JavaScript Handler
 * Handles user dropdown, language changes, and other interactions
 */

document.addEventListener('DOMContentLoaded', function() {
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
    
    // Language change function
    window.changeLanguage = function(lang) {
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
    };
    
    // Simulators modal function
    window.openSimulatorsModal = function() {
        const modal = document.getElementById('simulatorsModal');
        if (modal) {
            modal.style.display = 'block';
        }
    };
    
    // Close modal function
    window.closeModal = function() {
        const modal = document.getElementById('simulatorsModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('simulatorsModal');
        if (modal && e.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('simulatorsModal');
            if (modal && modal.style.display === 'block') {
                modal.style.display = 'none';
            }
        }
    });
});
