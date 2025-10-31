-- Table pour stocker la configuration SMTP
CREATE TABLE IF NOT EXISTS smtp_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enabled TINYINT(1) DEFAULT 0,
    host VARCHAR(255) DEFAULT 'smtp.gmail.com',
    port INT DEFAULT 587,
    encryption ENUM('none', 'tls', 'ssl') DEFAULT 'tls',
    username VARCHAR(255) DEFAULT '',
    password VARCHAR(255) DEFAULT '',
    from_email VARCHAR(255) DEFAULT '',
    from_name VARCHAR(255) DEFAULT 'MBC Expert Comptable',
    notification_email VARCHAR(255) DEFAULT '',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer une configuration par défaut si elle n'existe pas
INSERT IGNORE INTO smtp_config (id, enabled, host, port, encryption, username, password, from_email, from_name, notification_email)
VALUES (1, 0, 'smtp.gmail.com', 587, 'tls', '', '', '', 'MBC Expert Comptable', '');

