/**
 * Mobile Navigation Handler - Optimized
 * Handles mobile menu toggle, close button, and overlay interactions
 */

(function() {
    'use strict';
    
    let isMenuOpen = false;
    let mobileMenuToggle, mobileNav, mobileNavClose;
    let mobileNavLinks = [];
    
    // Optimized functions
    function openMobileMenu() {
        if (isMenuOpen) return;
        
        isMenuOpen = true;
        mobileNav.classList.add('active');
        mobileMenuToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        document.body.style.touchAction = 'none';
        
        // Add smooth transition
        requestAnimationFrame(() => {
            mobileNav.style.transform = 'translateX(0)';
        });
    }
    
    function closeMobileMenu() {
        if (!isMenuOpen) return;
        
        isMenuOpen = false;
        mobileNav.classList.remove('active');
        mobileMenuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        document.body.style.touchAction = '';
        
        // Add smooth transition
        requestAnimationFrame(() => {
            mobileNav.style.transform = 'translateX(-100%)';
        });
    }
    
    // Event handlers
    function handleMenuToggle(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Menu toggle clicked, current state:', isMenuOpen);
        
        if (isMenuOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }
    
    function handleCloseButton(e) {
        e.preventDefault();
        e.stopPropagation();
        closeMobileMenu();
    }
    
    function handleOutsideClick(e) {
        if (isMenuOpen && !mobileNav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
            closeMobileMenu();
        }
    }
    
    function handleOverlayClick(e) {
        if (e.target === mobileNav) {
            closeMobileMenu();
        }
    }
    
    function handleLinkClick() {
        closeMobileMenu();
    }
    
    function handleEscapeKey(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMobileMenu();
        }
    }
    
    function handleResize() {
        if (window.innerWidth > 768 && isMenuOpen) {
            closeMobileMenu();
        }
    }
    
    // Initialize
    function init() {
        mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        mobileNav = document.querySelector('.mobile-nav');
        mobileNavClose = document.querySelector('.mobile-nav-close');
        
        console.log('Mobile nav elements found:', {
            toggle: !!mobileMenuToggle,
            nav: !!mobileNav,
            close: !!mobileNavClose
        });
        
        if (!mobileMenuToggle || !mobileNav) {
            console.warn('Mobile navigation elements not found');
            return;
        }
        
        // Get navigation links
        mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        
        // Add event listeners with optimized options
        mobileMenuToggle.addEventListener('click', handleMenuToggle, { passive: false });
        
        // Add fallback event listener with different approach
        mobileMenuToggle.addEventListener('touchstart', function(e) {
            e.preventDefault();
            handleMenuToggle(e);
        }, { passive: false });
        
        // Add mousedown as backup
        mobileMenuToggle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            handleMenuToggle(e);
        }, { passive: false });
        
        if (mobileNavClose) {
            mobileNavClose.addEventListener('click', handleCloseButton, { passive: false });
        }
        
        // Use event delegation for better performance
        document.addEventListener('click', handleOutsideClick, { passive: true });
        mobileNav.addEventListener('click', handleOverlayClick, { passive: true });
        document.addEventListener('keydown', handleEscapeKey, { passive: true });
        window.addEventListener('resize', handleResize, { passive: true });
        
        // Add event listeners to navigation links
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', handleLinkClick, { passive: true });
        });
        
        console.log('Mobile navigation initialized');
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // Expose functions globally for debugging
    window.mobileNav = {
        open: openMobileMenu,
        close: closeMobileMenu,
        isOpen: () => isMenuOpen
    };
})();

