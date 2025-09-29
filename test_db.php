<?php
session_start();
require_once __DIR__ . '/db.php';

// Apenas usuários logados podem usar o teste
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Acesso negado. Faça login para testar a conexão.";
    exit();
}

header('Content-Type: text/plain; charset=utf-8');

echo "Teste de conexão com o banco (PDO/MySQL)\n";
echo "PHP: " . PHP_VERSION . "\n";
echo "Extensões: PDO=" . (extension_loaded('pdo') ? 'OK' : 'NÃO') . ", pdo_mysql=" . (extension_loaded('pdo_mysql') ? 'OK' : 'NÃO') . "\n";

try {
    $t0 = microtime(true);
    $pdo = get_pdo();
    // Verificação simples
    $pdo->query('SELECT 1');
    $ms = number_format((microtime(true) - $t0) * 1000, 2);
    echo "Resultado: OK - Conexão bem-sucedida ({$ms} ms)\n";
} catch (Throwable $e) {
    http_response_code(500);
    echo "Resultado: ERRO - " . $e->getMessage() . "\n";
}
