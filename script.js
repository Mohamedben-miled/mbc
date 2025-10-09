/**
 * MBC Expert Comptable - Clean JavaScript
 * Optimized and well-structured code
 */

// ========================================
// 1. SIMULATOR FUNCTIONS
// ========================================

/**
 * Open simulators modal
 */
function openSimulatorsModal() {
    // Prevent default link behavior
    event.preventDefault();
    
    const modal = document.getElementById('simulatorsModal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Initialize simulators
        initializeSimulators();
    } else {
        // If modal doesn't exist, redirect to index.html
        console.log('Modal not found, redirecting to index.html');
        window.location.href = 'index.html#simulators';
    }
    return false;
}

/**
 * Close simulators modal
 */
function closeSimulatorsModal() {
    const modal = document.getElementById('simulatorsModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

/**
 * Initialize simulators functionality
 */
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
            const targetContent = document.getElementById(targetTab);
            if (targetContent) {
                targetContent.classList.add('active');
            }
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
}

// ========================================
// 2. USER DROPDOWN FUNCTIONALITY
// ========================================
// Note: User dropdown functionality is handled in js/main.js
// This prevents duplicate event listeners

// ========================================
// 3. MODAL EVENT LISTENERS
// ========================================

// Initialize modal event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // User dropdown is handled in js/main.js
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('simulatorsModal');
        if (modal && event.target === modal) {
            closeSimulatorsModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSimulatorsModal();
        }
    });
});

// ========================================
// 3. UTILITY FUNCTIONS
// ========================================

/**
 * Debounce function to limit function calls
 * @param {Function} func - Function to debounce
 * @param {number} wait - Wait time in milliseconds
 * @returns {Function} Debounced function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function to limit function calls
 * @param {Function} func - Function to throttle
 * @param {number} limit - Time limit in milliseconds
 * @returns {Function} Throttled function
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * Check if element is in viewport
 * @param {Element} element - Element to check
 * @returns {boolean} True if element is in viewport
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// ========================================
// 2. HEADER SCROLL EFFECT
// ========================================

class HeaderScrollEffect {
    constructor() {
        this.header = null;
        this.init();
    }

    init() {
        this.header = document.querySelector('.header');
        if (!this.header) return;

        this.bindEvents();
    }

    bindEvents() {
        window.addEventListener('scroll', throttle(() => {
            this.handleScroll();
        }, 10));
    }

    handleScroll() {
        const scrollY = window.scrollY;
        
        if (scrollY > 50) {
            this.header.classList.add('scrolled');
        } else {
            this.header.classList.remove('scrolled');
        }
    }
}

// ========================================
// 3. MOBILE MENU FUNCTIONALITY
// ========================================
// Mobile menu functionality is handled by js/mobile-nav.js

// ========================================
// 3. SMOOTH SCROLLING
// ========================================

class SmoothScroll {
    constructor() {
        this.init();
    }

    init() {
        // Smooth scrolling for anchor links
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="#"]');
            if (!link) return;

            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                e.preventDefault();
                this.scrollToElement(targetElement);
            }
        });
    }

    scrollToElement(element) {
        const headerHeight = document.querySelector('.header').offsetHeight;
        const targetPosition = element.offsetTop - headerHeight - 20;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}

// ========================================
// 4. SCROLL ANIMATIONS
// ========================================

class ScrollAnimations {
    constructor() {
        this.animatedElements = new Set();
        this.init();
    }

    init() {
        // Use Intersection Observer for better performance
        if ('IntersectionObserver' in window) {
            this.setupIntersectionObserver();
        } else {
            // Fallback for older browsers
            this.setupScrollListener();
        }
    }

    setupIntersectionObserver() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe elements that should be animated
        const elementsToAnimate = document.querySelectorAll('.ecosystem-card, .service-card, .creation-card, .review-card, .resource-card');
        elementsToAnimate.forEach(el => observer.observe(el));
    }

    setupScrollListener() {
        const animateElements = () => {
            const elements = document.querySelectorAll('.ecosystem-card, .service-card, .creation-card, .review-card, .resource-card');
            elements.forEach(el => {
                if (isInViewport(el) && !this.animatedElements.has(el)) {
                    this.animateElement(el);
                }
            });
        };

        window.addEventListener('scroll', throttle(animateElements, 100));
    }

    animateElement(element) {
        this.animatedElements.add(element);
        element.classList.add('fade-in');
    }
}

// ========================================
// 5. SERVICE CARDS INTERACTIONS
// ========================================

class ServiceCards {
    constructor() {
        this.init();
    }

    init() {
        const serviceCards = document.querySelectorAll('.service-card');
        
        serviceCards.forEach(card => {
            this.addHoverEffects(card);
            this.addClickHandler(card);
        });
    }

    addHoverEffects(card) {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    }

    addClickHandler(card) {
        card.addEventListener('click', () => {
            // Add click functionality here if needed
            console.log('Service card clicked:', card.querySelector('h3').textContent);
        });
    }
}

// ========================================
// 6. FORM HANDLING
// ========================================

class FormHandler {
    constructor() {
        this.init();
    }

    init() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => this.setupForm(form));
    }

    setupForm(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit(form);
        });
    }

    handleSubmit(form) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Add form submission logic here
        console.log('Form submitted:', data);
        
        // Show success message
        this.showMessage('Message envoyé avec succès!', 'success');
    }

    showMessage(message, type) {
        // Create and show notification
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// ========================================
// 7. PERFORMANCE MONITORING
// ========================================

class PerformanceMonitor {
    constructor() {
        this.init();
    }

    init() {
        // Monitor page load performance
        window.addEventListener('load', () => {
            this.logPerformanceMetrics();
        });
    }

    logPerformanceMetrics() {
        if ('performance' in window) {
            const navigation = performance.getEntriesByType('navigation')[0];
            const loadTime = navigation.loadEventEnd - navigation.loadEventStart;
            
            console.log(`Page load time: ${loadTime}ms`);
        }
    }
}

// ========================================
// 8. SERVICE WORKER REGISTRATION
// ========================================

class ServiceWorkerManager {
    constructor() {
        this.init();
    }

    init() {
        if ('serviceWorker' in navigator) {
            this.registerServiceWorker();
        }
    }

    registerServiceWorker() {
        navigator.serviceWorker.register('sw.js')
            .then(registration => {
                console.log('ServiceWorker registered successfully');
            })
            .catch(error => {
                console.log('ServiceWorker registration failed:', error);
            });
    }
}

// ========================================
// 9. LAZY LOADING
// ========================================

class LazyLoader {
    constructor() {
        this.init();
    }

    init() {
        if ('IntersectionObserver' in window) {
            this.setupLazyLoading();
        } else {
            this.loadAllImages();
        }
    }

    setupLazyLoading() {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    this.loadImage(img);
                    imageObserver.unobserve(img);
                }
            });
        });

        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    }

    loadImage(img) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        img.classList.add('loaded');
    }

    loadAllImages() {
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => this.loadImage(img));
    }
}

// ========================================
// 10. INITIALIZATION
// ========================================

class App {
    constructor() {
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
        } else {
            this.initializeComponents();
        }
    }

    initializeComponents() {
        try {
            // Initialize all components
            new HeaderScrollEffect();
            // MobileMenu is handled by js/mobile-nav.js
            new SmoothScroll();
            new ScrollAnimations();
            new ServiceCards();
            new FormHandler();
            new PerformanceMonitor();
            new ServiceWorkerManager();
            new LazyLoader();

            console.log('MBC Expert Comptable website loaded successfully!');
        } catch (error) {
            console.error('Error initializing app:', error);
        }
    }
}

// Start the application
new App();