/**
 * Search Modal Functionality
 */

let searchTimeout;

function openSearchModal() {
    const modal = document.getElementById('searchModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Focus on input after animation
        setTimeout(() => {
            const input = document.getElementById('siteSearchInput');
            if (input) input.focus();
        }, 300);
    }
}

function closeSearchModal() {
    const modal = document.getElementById('searchModal');
    if (modal) {
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }, 300);
    }
}

function performSiteSearch() {
    const input = document.getElementById('siteSearchInput');
    if (!input) return;
    
    const query = input.value.trim();
    if (query.length < 2) {
        showSearchPlaceholder();
        return;
    }
    
    searchSite(query);
}

// Initialize search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('siteSearchInput');
    const resultsContainer = document.getElementById('searchModalResults');
    
    if (!searchInput || !resultsContainer) return;
    
    // Handle input with debounce
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            showSearchPlaceholder();
            return;
        }
        
        searchTimeout = setTimeout(() => {
            searchSite(query);
        }, 300);
    });
    
    // Handle Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSiteSearch();
        }
    });
    
    // Close modal with Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSearchModal();
        }
    });
    
    // Close modal when clicking outside
    const modal = document.getElementById('searchModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeSearchModal();
            }
        });
    }
});

function showSearchPlaceholder() {
    const resultsContainer = document.getElementById('searchModalResults');
    if (resultsContainer) {
        resultsContainer.innerHTML = `
            <div class="search-placeholder">
                <i class="fas fa-search"></i>
                <p>Tapez un mot-clé pour rechercher dans tout le site</p>
            </div>
        `;
    }
}

function searchSite(query) {
    const resultsContainer = document.getElementById('searchModalResults');
    
    if (!resultsContainer) return;
    
    // Show loading
    resultsContainer.innerHTML = `
        <div class="search-loading">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Recherche en cours...</p>
        </div>
    `;
    
    fetch('includes/search-endpoint.php?q=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            displaySearchResults(data.results, query);
        })
        .catch(error => {
            console.error('Search error:', error);
            resultsContainer.innerHTML = `
                <div class="search-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Erreur lors de la recherche</p>
                </div>
            `;
        });
}

function displaySearchResults(results, query) {
    const resultsContainer = document.getElementById('searchModalResults');
    
    if (!resultsContainer) return;
    
    if (!results || results.length === 0) {
        resultsContainer.innerHTML = `
            <div class="search-no-results">
                <i class="fas fa-search"></i>
                <p>Aucun résultat trouvé pour "<strong>${escapeHtml(query)}</strong>"</p>
            </div>
        `;
        return;
    }
    
    let html = '<div class="search-results-list">';
    results.forEach(result => {
        const highlightedContent = highlightText(result.content, query);
        const icon = result.type === 'blog' ? 'fa-file-alt' : 'fa-file';
        
        html += `
            <a href="${result.url}" class="search-result-item" onclick="closeSearchModal(); return true;">
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
    html += '</div>';
    
    resultsContainer.innerHTML = html;
}

function highlightText(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
}

function escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

