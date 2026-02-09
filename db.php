<?php
// Database connection using SQLite for local storage
$db_file = __DIR__ . '/users.db';

try {
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        firstname TEXT NOT NULL,
        lastname TEXT NOT NULL,
        address TEXT NOT NULL,
        sex TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
