-- MBC Website Database Schema
-- Created for dynamic website with PHP backend

USE mbc_website;

-- Users table (admin only, no signup)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    cover_image VARCHAR(255),
    content_file VARCHAR(255), -- For uploaded files
    read_time INT NOT NULL, -- Reading time in minutes
    author_id INT NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Contact form submissions table
CREATE TABLE contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Newsletter subscriptions table
CREATE TABLE newsletter_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    status ENUM('active', 'unsubscribed') DEFAULT 'active',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog categories table
CREATE TABLE blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog post categories relationship table
CREATE TABLE blog_post_categories (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password_hash, full_name, role) VALUES 
('admin', 'admin@mbc-expertcomptable.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Majdi Besbes', 'admin');

-- Insert default blog categories
INSERT INTO blog_categories (name, slug, description) VALUES 
('Création d\'entreprise', 'creation-entreprise', 'Articles sur la création d\'entreprise'),
('Fiscalité', 'fiscalite', 'Articles sur la fiscalité et les impôts'),
('Expertise Comptable', 'expertise-comptable', 'Articles sur l\'expertise comptable'),
('Social & Paie', 'social-paie', 'Articles sur les charges sociales et la paie'),
('Conseil', 'conseil', 'Articles de conseil en gestion');

-- Insert sample blog posts
INSERT INTO blog_posts (title, content, excerpt, cover_image, read_time, author_id, status) VALUES 
('Comment créer une SARL en France : Guide complet 2024', 
'<p>Découvrez toutes les étapes pour créer une SARL en France, de la rédaction des statuts à l\'immatriculation au RCS. Guide pratique avec conseils d\'expert.</p><p>La SARL (Société à Responsabilité Limitée) est l\'une des formes juridiques les plus populaires pour créer une entreprise en France. Elle offre de nombreux avantages...</p>', 
'Découvrez toutes les étapes pour créer une SARL en France, de la rédaction des statuts à l\'immatriculation au RCS. Guide pratique avec conseils d\'expert.', 
'assets/hero.jpg', 
5, 
1, 
'published'),
('TVA 2024 : Nouveaux taux et obligations', 
'<p>Les changements de la TVA en 2024 et leurs impacts sur votre entreprise.</p><p>La TVA (Taxe sur la Valeur Ajoutée) connaît chaque année des évolutions importantes...</p>', 
'Les changements de la TVA en 2024 et leurs impacts sur votre entreprise.', 
'assets/fiscalité.jpg', 
3, 
1, 
'published'),
('Optimiser sa comptabilité : 10 conseils pratiques', 
'<p>Découvrez nos conseils pour optimiser votre gestion comptable et réduire vos coûts.</p><p>Une comptabilité bien organisée est la clé du succès de votre entreprise...</p>', 
'Découvrez nos conseils pour optimiser votre gestion comptable et réduire vos coûts.', 
'assets/conseille.png', 
4, 
1, 
'published');

-- Link blog posts to categories
INSERT INTO blog_post_categories (post_id, category_id) VALUES 
(1, 1), -- SARL article -> Création d'entreprise
(2, 2), -- TVA article -> Fiscalité
(3, 3); -- Comptabilité article -> Expertise Comptable
