<?php
// Database connection helper using PDO (MySQL)
// Configure via environment variables where possible:
//   DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
// Provide safe defaults for local development.

function get_pdo(): PDO {
    $host = getenv('DB_HOST') !== false ? getenv('DB_HOST') : '127.0.0.1';
    $port = getenv('DB_PORT') !== false ? getenv('DB_PORT') : '3306';
    $db   = getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'formulario_aluno';
    $user = getenv('DB_USER') !== false ? getenv('DB_USER') : 'root';
    $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    return new PDO($dsn, $user, $pass, $options);
}

?>
