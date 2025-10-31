/**
 * Advanced Site Search with Dropdown
 */

(function() {
    'use strict';

    let searchTimeout;
    const minSearchLength = 2;

    // Initialize search
    function initSearch() {
        const searchInput = document.getElementById('siteSearchInput');
        const dropdown = document.getElementById('searchResultsDropdown');

        if (!searchInput || !dropdown) return;

        // Handle input
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < minSearchLength) {
                dropdown.classList.remove('active');
                dropdown.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });

        // Handle focus
        searchInput.addEventListener('focus', function() {
            if (dropdown.innerHTML) {
                dropdown.classList.add('active');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Handle keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = dropdown.querySelectorAll('.search-result-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const active = dropdown.querySelector('.search-result-item.active');
                if (active) {
                    active.classList.remove('active');
                    const next = active.nextElementSibling;
                    if (next) {
                        next.classList.add('active');
                        next.scrollIntoView({ block: 'nearest' });
                    } else {
                        items[0]?.classList.add('active');
                    }
                } else {
                    items[0]?.classList.add('active');
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const active = dropdown.querySelector('.search-result-item.active');
                if (active) {
                    active.classList.remove('active');
                    const prev = active.previousElementSibling;
                    if (prev) {
                        prev.classList.add('active');
                        prev.scrollIntoView({ block: 'nearest' });
                    } else {
                        items[items.length - 1]?.classList.add('active');
                    }
                } else {
                    items[items.length - 1]?.classList.add('active');
                }
            } else if (e.key === 'Enter') {
                e.preventDefault();
                const active = dropdown.querySelector('.search-result-item.active');
                if (active) {
                    active.click();
                } else if (items.length > 0) {
                    items[0].click();
                }
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('active');
                searchInput.blur();
            }
        });
    }

    // Perform search
    function performSearch(query) {
        const dropdown = document.getElementById('searchResultsDropdown');
        
        // Show loading
        dropdown.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Recherche...</div>';
        dropdown.classList.add('active');

        fetch('includes/search-endpoint.php?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                displayResults(data.results, query);
            })
            .catch(error => {
                console.error('Search error:', error);
                dropdown.innerHTML = '<div class="search-error">Erreur lors de la recherche</div>';
            });
    }

    // Display search results
    function displayResults(results, query) {
        const dropdown = document.getElementById('searchResultsDropdown');
        
        if (!results || results.length === 0) {
            dropdown.innerHTML = '<div class="search-no-results">Aucun résultat trouvé</div>';
            return;
        }

        let html = '';
        results.forEach((result, index) => {
            const highlightedContent = highlightText(result.content, query);
            const icon = result.type === 'blog' ? 'fa-file-alt' : 'fa-file';
            
            html += `
                <a href="${result.url}" class="search-result-item ${index === 0 ? 'active' : ''}" data-url="${result.url}">
                    <div class="search-result-icon">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="search-result-content">
                        <div class="search-result-title">${result.title}</div>
                        <div class="search-result-section">${result.section} - ${result.page_title}</div>
                        <div class="search-result-snippet">${highlightedContent}</div>
                    </div>
                </a>
            `;
        });

        dropdown.innerHTML = html;

        // Add click handlers
        dropdown.querySelectorAll('.search-result-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url');
                navigateToResult(url);
            });
        });
    }

    // Highlight search term in text
    function highlightText(text, query) {
        if (!query) return text;
        const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    // Escape regex special characters
    function escapeRegex(str) {
        return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Navigate to search result
    function navigateToResult(url) {
        if (url.includes('#')) {
            const [page, anchor] = url.split('#');
            window.location.href = page + '#' + anchor;
        } else {
            window.location.href = url;
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        initSearch();
    }
})();

