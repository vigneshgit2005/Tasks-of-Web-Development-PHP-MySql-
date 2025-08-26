<?php
// db.php
$host = '127.0.0.1';
$db   = 'blog_demo';
$user = 'root';        // ← change to your MySQL user
$pass = '';            // ← change to your MySQL password
$charset = 'utf8mb4';
$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // lets us bind ints to LIMIT/OFFSET safely
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    exit('Database connection failed.');
}
