<?php
require_once __DIR__ . '/../../app/config/database.php'; // Adjusted path

use App\Config\Database;

// Get database connection
$db = Database::connect();

// TAKE OUT IN PRODUCTION
$db->exec("DROP TABLE IF EXISTS migrations");

// Ensure `migrations` table exists
$db->exec("CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;");

echo "✅ migrations table checked.\n";

// Get applied migrations
$executedMigrations = [];
$query = $db->query("SELECT migration FROM migrations");
if ($query) {
    $executedMigrations = $query->fetchAll(PDO::FETCH_COLUMN);
}

// Scan the migrations directory
$migrationFiles = glob(__DIR__ . '/migrations/*.php');

// Run pending migrations
foreach ($migrationFiles as $file) {
    $migrationName = basename($file);

    if (!in_array($migrationName, $executedMigrations)) {
        echo "⚡ Running migration: $migrationName\n";

        // Include migration file and execute
        $migration = require $file;
        $migration($db);

        // Record migration in database
        $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $migrationName]);

        echo "✅ Migration completed: $migrationName\n";
    } else {
        echo "🔄 Already applied: $migrationName\n";
    }
}

echo "🚀 All migrations executed successfully.\n";
