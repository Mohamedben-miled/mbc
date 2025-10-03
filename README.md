# MBC Expert Comptable - Dynamic Website

Ce projet est une transformation complète du site statique MBC Expert Comptable en un site web dynamique avec backend PHP et base de données MySQL.

## 🚀 Fonctionnalités

### Backend PHP
- **Système d'authentification sécurisé** (admin uniquement, pas d'inscription)
- **Gestion des articles de blog** avec CRUD complet
- **Système de contact** avec gestion des formulaires
- **Upload de fichiers** sécurisé (images et documents)
- **Dashboard administrateur** complet

### Base de données MySQL
- **Table users** : Gestion des utilisateurs administrateurs
- **Table blog_posts** : Articles de blog avec métadonnées
- **Table contact_submissions** : Messages de contact
- **Table blog_categories** : Catégories d'articles
- **Table newsletter_subscriptions** : Abonnements newsletter

### Fonctionnalités du blog
- **Articles dynamiques** avec pagination
- **Recherche et filtrage** par catégorie
- **Temps de lecture estimé** automatique
- **Images de couverture** et fichiers attachés
- **Extraits automatiques** générés

### Système de contact
- **Formulaire de contact** avec validation
- **Newsletter** avec abonnement/désabonnement
- **Notifications email** automatiques
- **Gestion des statuts** (nouveau, lu, répondu)

## 📋 Prérequis

- **PHP 8.1+** avec extensions :
  - php-mysql
  - php-curl
  - php-gd
  - php-mbstring
  - php-xml
  - php-zip
  - php-intl
- **MySQL 8.0+**
- **Apache 2.4+** avec modules :
  - mod_rewrite
  - mod_headers

## 🛠️ Installation

### 1. Cloner le projet
```bash
git clone https://github.com/Mohamedben-miled/mbc.git
cd mbc
```

### 2. Configuration de la base de données
```bash
# Créer la base de données
mysql -u root -p
CREATE DATABASE mbc_website;
CREATE USER 'mbc_user'@'localhost' IDENTIFIED BY 'mbc_password123';
GRANT ALL PRIVILEGES ON mbc_website.* TO 'mbc_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Importer le schéma
mysql -u mbc_user -pmbc_password123 mbc_website < database_schema.sql
```

### 3. Configuration Apache
```bash
# Copier la configuration
sudo cp mbc.conf /etc/apache2/sites-available/

# Activer le site
sudo a2ensite mbc
sudo a2enmod rewrite headers

# Redémarrer Apache
sudo systemctl restart apache2
```

### 4. Permissions
```bash
# Permissions pour les uploads
sudo chown -R www-data:www-data /home/malek/MBC
sudo chmod -R 755 /home/malek/MBC
sudo chmod 755 /home/malek
```

## 🔐 Accès administrateur

### Compte par défaut
- **URL** : `http://localhost/admin/login.php`
- **Nom d'utilisateur** : `admin`
- **Mot de passe** : `admin123`

### Création d'utilisateurs
1. Connectez-vous avec le compte admin
2. Allez dans "Utilisateurs" dans le menu
3. Créez de nouveaux utilisateurs administrateurs

## 📁 Structure du projet

```
mbc/
├── admin/                 # Interface d'administration
│   ├── login.php         # Page de connexion
│   ├── dashboard.php     # Tableau de bord
│   ├── blog.php          # Gestion des articles
│   ├── blog-create.php   # Création d'articles
│   ├── contact.php       # Messages de contact
│   ├── users.php         # Gestion des utilisateurs
│   └── profile.php       # Profil utilisateur
├── config/               # Configuration
│   └── database.php      # Configuration base de données
├── includes/             # Classes PHP
│   ├── auth.php          # Système d'authentification
│   ├── blog.php          # Gestion des articles
│   └── contact.php       # Gestion des contacts
├── uploads/              # Fichiers uploadés
│   ├── images/           # Images des articles
│   └── documents/        # Documents attachés
├── assets/               # Ressources statiques
├── blog-dynamic.php      # Blog dynamique
├── contact-form.php      # Formulaire de contact
├── database_schema.sql   # Schéma de base de données
└── test.php             # Script de test
```

## 🔧 Configuration

### Base de données
Modifiez `config/database.php` pour ajuster les paramètres :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mbc_website');
define('DB_USER', 'mbc_user');
define('DB_PASS', 'mbc_password123');
```

### Upload de fichiers
Paramètres dans `config/database.php` :
```php
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'txt']);
```

## 📝 Utilisation

### Création d'articles
1. Connectez-vous à l'administration
2. Allez dans "Nouvel article"
3. Remplissez les champs :
   - Titre (obligatoire)
   - Contenu (obligatoire, HTML autorisé)
   - Extrait (optionnel, généré automatiquement)
   - Image de couverture (optionnel)
   - Fichier attaché (optionnel)
   - Temps de lecture (estimé automatiquement)
   - Statut (brouillon/publié)

### Gestion des contacts
1. Les messages arrivent automatiquement
2. Marquez-les comme "lu" ou "répondu"
3. Répondez directement par email
4. Supprimez les messages traités

### Gestion des utilisateurs
1. Créez de nouveaux administrateurs
2. Modifiez les profils
3. Supprimez les comptes inactifs

## 🛡️ Sécurité

- **Validation des entrées** : Toutes les données sont validées
- **Protection XSS** : `htmlspecialchars()` sur toutes les sorties
- **Protection SQL injection** : Requêtes préparées
- **Hachage des mots de passe** : `password_hash()`
- **Sessions sécurisées** : Timeout automatique
- **Upload sécurisé** : Validation des types et tailles

## 🧪 Tests

### Test de configuration
Visitez `http://localhost/test.php` pour vérifier :
- Connexion à la base de données
- Permissions des dossiers
- Modules Apache
- Fichiers includes

### Test des fonctionnalités
1. **Connexion admin** : `http://localhost/admin/login.php`
2. **Blog dynamique** : `http://localhost/blog-dynamic.php`
3. **Formulaire de contact** : `http://localhost/contact-form.php`

## 🔄 Maintenance

### Sauvegarde de la base de données
```bash
mysqldump -u mbc_user -pmbc_password123 mbc_website > backup.sql
```

### Logs
- **Apache** : `/var/log/apache2/mbc_error.log`
- **PHP** : `/var/log/php8.1/error.log`

### Mise à jour
```bash
git pull origin main
# Redémarrer Apache si nécessaire
sudo systemctl restart apache2
```

## 🐛 Dépannage

### Erreur 403 Forbidden
```bash
sudo chmod 755 /home/malek
sudo chown -R www-data:www-data /home/malek/MBC
```

### Erreur de base de données
Vérifiez les paramètres dans `config/database.php`

### Problème d'upload
Vérifiez les permissions du dossier `uploads/`

## 📞 Support

Pour toute question ou problème :
- **Email** : contact@mbc-expertcomptable.fr
- **Téléphone** : +33 1 23 45 67 89

## 📄 Licence

© 2024 MBC Expert Comptable. Tous droits réservés.

---

**Développé avec ❤️ pour MBC Expert Comptable**