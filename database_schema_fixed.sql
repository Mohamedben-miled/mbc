-- Fixed Database Schema for MBC Website
-- This schema matches the code expectations

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS mbc_website;
USE mbc_website;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog categories table
CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog posts table (without category_id column)
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    excerpt TEXT,
    cover_image VARCHAR(255),
    content_file VARCHAR(255),
    read_time INT DEFAULT 5,
    author_id INT NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Blog post categories junction table (many-to-many)
CREATE TABLE IF NOT EXISTS blog_post_categories (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE CASCADE
);

-- Contact submissions table
CREATE TABLE IF NOT EXISTS contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    company VARCHAR(255),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Newsletter subscriptions table
CREATE TABLE IF NOT EXISTS newsletter_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    status ENUM('active', 'unsubscribed') DEFAULT 'active',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL
);

-- Insert default admin user
INSERT INTO users (username, email, password_hash, full_name, role) VALUES 
('admin', 'admin@mbc-expertcomptable.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin')
ON DUPLICATE KEY UPDATE username = username;

-- Insert default blog categories
INSERT INTO blog_categories (name, slug, description) VALUES 
('Création d\'entreprise', 'creation-entreprise', 'Articles sur la création d\'entreprise'),
('Fiscalité', 'fiscalite', 'Articles sur la fiscalité et les impôts'),
('Expertise Comptable', 'expertise-comptable', 'Articles sur l\'expertise comptable'),
('Social & Paie', 'social-paie', 'Articles sur les charges sociales et la paie'),
('Conseil', 'conseil', 'Articles de conseil en gestion')
ON DUPLICATE KEY UPDATE name = name;

-- Insert sample blog posts
INSERT INTO blog_posts (title, content, excerpt, author_id, status, read_time) VALUES 
('Guide complet pour créer votre entreprise', 'Contenu détaillé sur la création d\'entreprise...', 'Découvrez les étapes essentielles pour créer votre entreprise en France.', 1, 'published', 10),
('Optimisation fiscale pour PME', 'Stratégies d\'optimisation fiscale pour les petites et moyennes entreprises...', 'Maximisez vos économies fiscales avec nos conseils d\'experts.', 1, 'published', 8),
('Nouvelle réforme comptable 2024', 'Les changements importants de la réforme comptable...', 'Tout ce qu\'il faut savoir sur la nouvelle réforme comptable.', 1, 'published', 12)
ON DUPLICATE KEY UPDATE title = title;

-- Link blog posts to categories
INSERT INTO blog_post_categories (post_id, category_id) VALUES 
(1, 1), -- Guide création -> Création d'entreprise
(2, 2), -- Optimisation fiscale -> Fiscalité
(3, 3)  -- Réforme comptable -> Expertise Comptable
ON DUPLICATE KEY UPDATE post_id = post_id;
