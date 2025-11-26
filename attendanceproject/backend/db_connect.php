<?php
// db_connect.php
$config = require __DIR__ . '/config.php';

function getPDO() {
    global $config;
    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("DB Connection error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
}
