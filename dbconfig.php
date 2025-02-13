<?php
// Autoload dependencies installed by Composer
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Connect to MySQL without specifying a database
    ORM::configure(array(
        'connection_string' => 'mysql:host=localhost;dbname=crud',
        'username' => 'root',
        'password' => 'admin'
    ));

    // Check if the 'crud' database exists
    $dbExists = ORM::for_table('information_schema.schemata')
        ->where('schema_name', 'crud')
        ->find_one();

    if (!$dbExists) {
        // Create the 'crud' database
        ORM::get_db()->exec("CREATE DATABASE crud");
        // echo "Database 'crud' created successfully.<br>";
    }

    // Check if the 'users' table exists
    $tableExists = ORM::for_table('information_schema.tables')
        ->where('table_schema', 'crud')
        ->where('table_name', 'users')
        ->find_one();

    if (!$tableExists) {
        // Create the 'users' table
        ORM::get_db()->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            phone VARCHAR(20) NOT NULL
        )");
        // echo "Table 'users' created successfully.<br>";
    } else {
        // echo "Table 'users' already exists.<br>";
    }
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
