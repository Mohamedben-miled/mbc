-- Table pour le tracking du trafic sur le site
CREATE TABLE IF NOT EXISTS site_traffic (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_url VARCHAR(500) NOT NULL,
    page_title VARCHAR(255),
    referrer VARCHAR(500),
    user_agent TEXT,
    ip_address VARCHAR(45),
    session_id VARCHAR(100),
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    visit_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    duration_seconds INT DEFAULT 0,
    INDEX idx_visit_date (visit_date),
    INDEX idx_page_url (page_url(255)),
    INDEX idx_session_id (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les pages les plus visitées (cache pour performance)
CREATE TABLE IF NOT EXISTS page_views_stats (
    page_url VARCHAR(500) NOT NULL PRIMARY KEY,
    page_title VARCHAR(255),
    total_views INT DEFAULT 0,
    unique_visitors INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_total_views (total_views)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

