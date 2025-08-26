<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$file = 'dados_alunos.csv';

// Verificar se o arquivo existe e não está vazio
if (!file_exists($file) || filesize($file) == 0) {
    header('Location: index.php?error=nodata');
    exit();
}

// Configurar cabeçalhos para download do arquivo
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="relatorio_alunos_' . date('Y-m-d') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Transfer-Encoding: binary');

// Abrir o arquivo para leitura
$handle = fopen($file, 'r');
if ($handle === false) {
    die('Erro ao abrir o arquivo CSV');
}

// Ler e enviar o conteúdo do arquivo linha por linha
while (($data = fgetcsv($handle, 0, ';')) !== false) {
    // Converter cada linha para UTF-8 se necessário e exibir
    echo implode(';', array_map('utf8_encode', $data)) . "\r\n";
}

fclose($handle);
exit();
?>
