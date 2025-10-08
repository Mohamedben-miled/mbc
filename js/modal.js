/**
 * Modal Handler
 * Handles simulator modal and other modal interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing modal handler...');
    
    // Simulator Modal Functions
    window.openSimulatorsModal = function() {
        console.log('Opening simulators modal...');
        const modal = document.getElementById('simulatorsModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            document.body.style.touchAction = 'none';
            
            // Add animation
            setTimeout(() => {
                modal.style.opacity = '1';
            }, 10);
            
            console.log('Simulators modal opened');
        } else {
            console.error('Simulators modal not found');
        }
    };
    
    window.closeModal = function() {
        console.log('Closing modal...');
        const modal = document.getElementById('simulatorsModal');
        if (modal) {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
                document.body.style.touchAction = '';
            }, 300);
            console.log('Modal closed');
        }
    };
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('simulatorsModal');
        if (modal && e.target === modal) {
            closeModal();
        }
    }, { passive: true });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('simulatorsModal');
            if (modal && modal.style.display === 'flex') {
                closeModal();
            }
        }
    });
    
    // Close modal with close button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-close') || e.target.closest('.modal-close')) {
            closeModal();
        }
    }, { passive: true });
    
    console.log('Modal handler initialized');
});
