<?php
// Session configuration for security
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800, // 30 mins
    'domain' => 'localhost',
    'path' => '/',
    'secure' => false, // Set to true if using HTTPS
    'httponly' => true, // Prevent JavaScript access to session cookie
    'samesite' => 'Strict'
]);

session_start();

// Database connection configuration
$host = 'localhost';
$dbname = 'satitschool_db';
$username = 'root'; // Change if necessary
$password = '';     // Change if necessary
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // Important for security (use real prepared statements)
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // In production, log this error instead of displaying it.
    die("Database connection failed: " . $e->getMessage());
}
?>
