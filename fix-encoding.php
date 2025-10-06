<?php
/**
 * Fix Database Encoding Script
 * This script ensures all database tables use UTF-8 encoding
 */

require_once 'config/database.php';
require_once 'includes/encoding.php';

echo "🔧 Fixing database encoding...\n";

try {
    $db = Database::getInstance();
    $connection = $db->getConnection();
    
    // Ensure UTF-8 encoding for the connection
    ensureUtf8Encoding($connection);
    
    // Get all tables
    $tables = $connection->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📋 Found " . count($tables) . " tables to check:\n";
    
    foreach ($tables as $table) {
        echo "  - Converting table: $table\n";
        
        try {
            // Convert table to UTF-8
            $connection->exec("ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "    ✅ Table $table converted to UTF-8\n";
        } catch (Exception $e) {
            echo "    ⚠️  Could not convert table $table: " . $e->getMessage() . "\n";
        }
    }
    
    // Set database default charset
    echo "\n🔧 Setting database default charset...\n";
    $connection->exec("ALTER DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "\n✅ Database encoding fix completed!\n";
    echo "All tables and columns now use UTF-8 encoding.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
