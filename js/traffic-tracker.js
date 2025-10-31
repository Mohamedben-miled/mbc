/**
 * Traffic Tracking JavaScript
 * Tracks page visits and sends data to server
 */

(function() {
    'use strict';

    // Track page visit
    function trackPageVisit() {
        const data = {
            page_url: window.location.pathname + window.location.search,
            page_title: document.title,
            referrer: document.referrer || '',
            user_agent: navigator.userAgent,
            session_id: getSessionId()
        };

        // Send to tracking endpoint
        fetch('includes/track-visit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        }).catch(err => {
            console.error('Traffic tracking error:', err);
        });

        // Track page view duration
        let startTime = Date.now();
        window.addEventListener('beforeunload', function() {
            const duration = Math.round((Date.now() - startTime) / 1000);
            navigator.sendBeacon(
                'includes/track-visit.php?duration=' + duration,
                JSON.stringify(data)
            );
        });
    }

    // Get or create session ID
    function getSessionId() {
        let sessionId = sessionStorage.getItem('traffic_session_id');
        if (!sessionId) {
            sessionId = 'sess_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            sessionStorage.setItem('traffic_session_id', sessionId);
        }
        return sessionId;
    }

    // Initialize tracking when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', trackPageVisit);
    } else {
        trackPageVisit();
    }
})();

