<?php
session_start();
require_once __DIR__ . '/db.php';

// Proteger a página: somente logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$pdo = get_pdo();

// Função helper para escapar
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Ver se estamos mostrando detalhes de uma submissão específica
$submission_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Respostas dos Alunos</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
    .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    .table th { background: #f7f7f7; text-align: left; }
    .actionsbar { display:flex; gap:8px; margin: 16px 0; }
    .btn { display:inline-block; padding:8px 12px; background:#1976d2; color:#fff; text-decoration:none; border-radius:4px; }
    .btn-secondary { background:#555; }
    .meta { margin: 8px 0 16px; color:#444; }
    .section { margin-top: 20px; }
    .muted { color:#666; }
  </style>
</head>
<body>
<div class="container">
  <h1>Respostas dos Alunos</h1>
  <div class="actionsbar">
    <a href="index.php" class="btn btn-secondary">Voltar ao Formulário</a>
    <a href="?" class="btn btn-secondary">Lista de Submissões</a>
    <a href="generate_csv.php" class="btn">Gerar Relatório CSV</a>
    <a href="test_db.php" class="btn">Testar Conexão</a>
    <a href="?logout=1" class="btn btn-secondary" onclick="event.preventDefault(); window.location='index.php?logout=1'">Sair</a>
  </div>

<?php
if ($submission_id > 0) {
    // Detalhes da submissão
    $stmt = $pdo->prepare('SELECT * FROM submissions WHERE id = ?');
    $stmt->execute([$submission_id]);
    $submission = $stmt->fetch();

    if (!$submission) {
        echo '<p class="muted">Submissão não encontrada.</p>';
    } else {
        echo '<div class="meta">';
        echo '<strong>Escola:</strong> ' . e($submission['escola']) . ' | ';
        echo '<strong>Aluno:</strong> ' . e($submission['nome']) . ' | ';
        echo '<strong>Telefone:</strong> ' . e($submission['telefone']) . ' | ';
        echo '<strong>Curso:</strong> ' . e($submission['curso']) . ' | ';
        echo '<strong>Disciplina:</strong> ' . e($submission['disciplina']) . ' | ';
        echo '<strong>Enviado em:</strong> ' . e($submission['created_at']);
        echo '</div>';

        echo '<div class="section">';
        echo '<h3>Observações</h3>';
        echo '<p>' . (trim($submission['observacoes']) !== '' ? nl2br(e($submission['observacoes'])) : '<span class="muted">(vazio)</span>') . '</p>';
        echo '</div>';

        echo '<div class="section">';
        echo '<h3>Intervenções</h3>';
        echo '<p>' . (trim($submission['intervencoes']) !== '' ? nl2br(e($submission['intervencoes'])) : '<span class="muted">(vazio)</span>') . '</p>';
        echo '</div>';

        // Respostas das atividades
        $sql = 'SELECT a.titulo, r.resposta
                FROM submission_activity_responses r
                INNER JOIN activities a ON a.id = r.activity_id
                WHERE r.submission_id = ?
                ORDER BY a.titulo ASC';
        $st = $pdo->prepare($sql);
        $st->execute([$submission_id]);
        $answers = $st->fetchAll();

        echo '<div class="section">';
        echo '<h3>Atividades Respondidas</h3>';
        if (!$answers) {
            echo '<p class="muted">Nenhuma atividade marcada.</p>';
        } else {
            echo '<table class="table">';
            echo '<thead><tr><th>Atividade</th><th>Resposta</th></tr></thead><tbody>';
            foreach ($answers as $row) {
                echo '<tr>';
                echo '<td>' . e($row['titulo']) . '</td>';
                echo '<td>' . e($row['resposta']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        echo '</div>';
    }
} else {
    // Lista de submissões
    $q = isset($_GET['q']) ? trim($_GET['q']) : '';

    $sql = 'SELECT id, escola, nome, telefone, curso, disciplina, created_at
            FROM submissions';
    $params = [];
    if ($q !== '') {
        $sql .= ' WHERE escola LIKE :q OR nome LIKE :q OR curso LIKE :q OR disciplina LIKE :q';
        $params[':q'] = '%' . $q . '%';
    }
    $sql .= ' ORDER BY created_at DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    echo '<form method="get">';
    echo '<input type="text" name="q" placeholder="Buscar por escola, aluno, curso, disciplina" value="' . e($q) . '" /> ';
    echo '<button type="submit" class="btn">Buscar</button>';
    echo '</form>';

    if (!$rows) {
        echo '<p class="muted">Nenhuma submissão encontrada.</p>';
    } else {
        echo '<table class="table">';
        echo '<thead><tr>';
        echo '<th>Data</th><th>Escola</th><th>Aluno</th><th>Curso</th><th>Disciplina</th><th>Ações</th>';
        echo '</tr></thead><tbody>';
        foreach ($rows as $r) {
            echo '<tr>';
            echo '<td>' . e($r['created_at']) . '</td>';
            echo '<td>' . e($r['escola']) . '</td>';
            echo '<td>' . e($r['nome']) . '</td>';
            echo '<td>' . e($r['curso']) . '</td>';
            echo '<td>' . e($r['disciplina']) . '</td>';
            echo '<td><a class="btn" href="responses.php?id=' . intval($r['id']) . '">Ver detalhes</a></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
}
?>
</div>
</body>
</html>
