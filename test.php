<?php
/**
 * Test script to verify the setup
 */

echo "<h1>MBC Website - Test de configuration</h1>";

// Test PHP
echo "<h2>1. Test PHP</h2>";
echo "Version PHP: " . phpversion() . "<br>";
echo "Extensions chargées: " . implode(', ', get_loaded_extensions()) . "<br>";

// Test database connection
echo "<h2>2. Test de connexion à la base de données</h2>";
try {
    require_once __DIR__ . '/config/database.php';
    $db = Database::getInstance();
    echo "✅ Connexion à la base de données réussie<br>";
    
    // Test tables
    $tables = ['users', 'blog_posts', 'contact_submissions', 'blog_categories'];
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Table '$table' existe<br>";
        } else {
            echo "❌ Table '$table' manquante<br>";
        }
    }
    
    // Test admin user
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $result = $stmt->fetch();
    echo "✅ Utilisateurs admin: " . $result['count'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erreur de connexion: " . $e->getMessage() . "<br>";
}

// Test file permissions
echo "<h2>3. Test des permissions de fichiers</h2>";
$dirs = ['uploads', 'uploads/images', 'uploads/documents'];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "✅ Dossier '$dir' accessible en écriture<br>";
        } else {
            echo "❌ Dossier '$dir' non accessible en écriture<br>";
        }
    } else {
        echo "❌ Dossier '$dir' n'existe pas<br>";
    }
}

// Test Apache modules
echo "<h2>4. Test des modules Apache</h2>";
$modules = ['mod_rewrite', 'mod_headers'];
foreach ($modules as $module) {
    if (function_exists('apache_get_modules')) {
        if (in_array($module, apache_get_modules())) {
            echo "✅ Module '$module' activé<br>";
        } else {
            echo "❌ Module '$module' non activé<br>";
        }
    } else {
        echo "⚠️ Impossible de vérifier les modules Apache<br>";
    }
}

// Test includes
echo "<h2>5. Test des fichiers includes</h2>";
$includes = [
    'config/database.php',
    'includes/auth.php',
    'includes/blog.php',
    'includes/contact.php'
];

foreach ($includes as $include) {
    if (file_exists($include)) {
        echo "✅ Fichier '$include' existe<br>";
    } else {
        echo "❌ Fichier '$include' manquant<br>";
    }
}

echo "<h2>6. Liens de test</h2>";
echo "<a href='admin/login.php'>Page de connexion admin</a><br>";
echo "<a href='blog-dynamic.php'>Blog dynamique</a><br>";
echo "<a href='contact-form.php'>Formulaire de contact</a><br>";

echo "<h2>7. Informations système</h2>";
echo "Serveur: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Path: " . __DIR__ . "<br>";

echo "<p><strong>Test terminé!</strong></p>";
?>
