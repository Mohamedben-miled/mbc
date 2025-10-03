<?php
/**
 * Deployment Configuration Script
 * This script helps configure the website for production deployment
 */

// Check if we're in production mode
$isProduction = isset($_GET['production']) && $_GET['production'] === 'true';

if ($isProduction) {
    // Production configuration
    $configFile = 'config/database.production.php';
    $htaccessFile = '.htaccess.production';
    $targetHtaccess = '.htaccess';
    
    echo "<h1>MBC Website - Production Configuration</h1>";
    echo "<h2>Configuration Steps:</h2>";
    
    echo "<h3>1. Database Configuration</h3>";
    if (file_exists($configFile)) {
        echo "✅ Production database config found: $configFile<br>";
        echo "📝 Update config/database.php to include production settings<br>";
    } else {
        echo "❌ Production database config not found<br>";
    }
    
    echo "<h3>2. .htaccess Configuration</h3>";
    if (file_exists($htaccessFile)) {
        echo "✅ Production .htaccess found: $htaccessFile<br>";
        echo "📝 Rename to .htaccess on production server<br>";
    } else {
        echo "❌ Production .htaccess not found<br>";
    }
    
    echo "<h3>3. File Permissions</h3>";
    echo "📝 Set proper permissions on production server:<br>";
    echo "   - Directories: 755<br>";
    echo "   - PHP files: 644<br>";
    echo "   - media/ directory: 777<br>";
    
    echo "<h3>4. Database Setup</h3>";
    echo "📝 Import database_schema.sql to create tables<br>";
    echo "📝 Create admin user in database<br>";
    
    echo "<h3>5. Domain Configuration</h3>";
    echo "📝 Update APP_URL in config/database.production.php<br>";
    echo "📝 Configure SSL certificate<br>";
    
} else {
    // Local configuration
    echo "<h1>MBC Website - Local Development</h1>";
    echo "<h2>Current Configuration:</h2>";
    
    echo "<h3>Database Configuration</h3>";
    if (file_exists('config/database.php')) {
        echo "✅ Local database config: config/database.php<br>";
    } else {
        echo "❌ Local database config not found<br>";
    }
    
    echo "<h3>Production Configuration</h3>";
    if (file_exists('config/database.production.php')) {
        echo "✅ Production database config: config/database.production.php<br>";
    } else {
        echo "❌ Production database config not found<br>";
    }
    
    echo "<h3>Deployment Files</h3>";
    if (file_exists('.htaccess.production')) {
        echo "✅ Production .htaccess: .htaccess.production<br>";
    } else {
        echo "❌ Production .htaccess not found<br>";
    }
    
    echo "<hr>";
    echo "<h2>Deployment Instructions:</h2>";
    echo "<ol>";
    echo "<li>Upload all files to production server via FTP</li>";
    echo "<li>Rename .htaccess.production to .htaccess</li>";
    echo "<li>Update config/database.php with production settings</li>";
    echo "<li>Import database_schema.sql to create tables</li>";
    echo "<li>Set proper file permissions</li>";
    echo "<li>Configure domain and SSL</li>";
    echo "</ol>";
    
    echo "<p><a href='?production=true'>View Production Configuration</a></p>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f5f5f5;
}
h1, h2, h3 {
    color: #333;
}
h1 {
    border-bottom: 3px solid #667eea;
    padding-bottom: 10px;
}
h2 {
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}
h3 {
    color: #667eea;
}
ol {
    background: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
a {
    color: #667eea;
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    text-decoration: underline;
}
</style>
