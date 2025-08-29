<?php
session_start();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $login_error = 'Usuário ou senha inválidos';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Lista de atividades
$atividades = [
    "Aplicar modelo MVC como padrão de desenvolvimento de software",
    "Configurar acesso da rede sem fio por endereço de MAC",
    "Configurar redes sem fio",
    "Cria banners",
    "Criar algoritmos através de divisão modular",
    "Criar algoritmos através de refinamentos sucessivos",
    "Criar animações com Scratch",
    "Criar animações multimídia",
    "Criar aplicações em linguagem de programação compatíveis com o paradigma de orientação a objetos",
    "Criar aplicações para atualização de dados",
    "Criar aplicações para consulta de dados",
    "Criar aplicações para exclusão de dados",
    "Criar aplicações para inserção de dados",
    "Criar aplicações para leitura de dados",
    "Criar aplicativos Web baseados em dispositivos móveis",
    "Criar artes gráficas",
    "Criar atributos",
    "Criar diagrama do modelo relacional",
    "Criar diagramas UML básicos",
    "Criar diretórios",
    "Criar entidades",
    "Criar estrutura dos elementos de estilização do formulário",
    "Criar folders",
    "Criar folha de estilo em CSS",
    "Criar formulários para página Web",
    "Criar formulários para Web",
    "Criar formulas condicionais",
    "Criar gráficos",
    "Criar instruções SQL DDL",
    "Criar instruções SQL DML",
    "Criar jogos educativos com Scratch",
    "Criar jogos multiplataformas",
    "Criar layout de páginas usando CSS – Cascading Style Sheets",
    "Criar material publicitário",
    "Criar modelagem conceitual do banco de dados",
    "Criar Modelagem de Entidade-Relacionamento para o DER",
    "Criar modelagem lógica de banco de dados",
    "Criar normalização de tabelas do banco de dados",
    "Criar páginas para upload de arquivos",
    "Criar partições para o sistema de arquivo",
    "Criar planilhas eletrônicas",
    "Criar programas em linguagem de programação",
    "Criar programas usando conceitos básicos de programação",
    "Criar proteção para planilha",
    "Criar relacionamentos",
    "Criar scripts em linguagem de programação usando os fundamentos de estruturas lógicas",
    "Criar scripts para manipular serviços de rede de comunicação",
    "Criar sequência de passos de processos",
    "Criar sistemas integrando o banco de dados com aplicação",
    "Criar sistemas nas camadas propostas pelo padrão MVC",
    "Criar tabelas",
    "Criar um CRUD em linguagem de programação",
    "Criar Websites dinâmicos",
    "Desenvolver apresentações eletrônicas",
    "Desenvolver layout",
    "Editar imagens no CorelDRAW",
    "Editar planilhas eletrônicas",
    "Emitir laudos técnicos de computadores",
    "Emitir laudos técnicos de periféricos",
    "Estabelecer comunicação entre computadores",
    "Exportar imagens no CorelDRAW",
    "Importar imagens no CorelDRAW",
    "Inserir paginação",
    "Instalar sistemas Dual Boot",
    "Instalar softwares essenciais",
    "Manipular imagens no CorelDRAW",
    "Realizar a instalação dos drivers",
    "Realizar aplicação de folhas de estilo para formatação de páginas",
    "Realizar aplicação de permissões em arquivos",
    "Realizar aplicação de permissões em diretórios",
    "Realizar apresentações digitais",
    "Realizar ativação dos softwares essenciais",
    "Realizar backup de arquivos",
    "Realizar compartilhamento de arquivos",
    "Realizar compartilhamento de impressoras",
    "Realizar configuração de bordas",
    "Realizar configuração de computador em rede",
    "Realizar configuração de gerenciador de e-mails",
    "Realizar configuração de margens",
    "Realizar configuração de rede",
    "Realizar correção de erros de sintaxe de linguagem de programação",
    "Realizar correção de erros em diagramas propostos",
    "Realizar crimpagem dos conectores em cabo UTP",
    "Realizar desfragmentação de arquivos no disco",
    "Realizar desmontagem de computadores",
    "Realizar edição de textos",
    "Realizar encaixe de elementos na estrutura do código em linguagem de programação",
    "Realizar encaixe de elementos na estrutura dos algoritmos",
    "Realizar encaixe de elementos na estrutura dos programas",
    "Realizar encaixe de periféricos",
    "Realizar encaixe de tags na estrutura HTML",
    "Realizar escolha da estrutura de dados",
    "Realizar escolha de estilos de formatação de página Web",
    "Realizar escolha de normas de validação de páginas",
    "Realizar escolha de sistema operacional de acordo com arquitetura computacional",
    "Realizar formatação de textos",
    "Realizar formatação para o disco/partição",
    "Realizar gerenciamento de dispositivos",
    "Realizar gerenciamento de sistemas de banco de dados",
    "Realizar gerenciamento do Sistema Operacional",
    "Realizar identificação de requisitos para sistema proposto",
    "Realizar instalação de impressoras",
    "Realizar instalação de Sistema Operacional",
    "Realizar instalação de softwares anti-malware",
    "Realizar instalação de softwares antivírus",
    "Realizar integração entre classes e pacotes",
    "Realizar integração entre e o SGBD",
    "Realizar interligação de sistemas de banco de dados com aplicações",
    "Realizar interpretação de algoritmos",
    "Realizar interpretação de diagramas UML básicos",
    "Realizar interpretação de símbolos",
    "Realizar leitura de algoritmos",
    "Realizar leitura de símbolos",
    "Realizar levantamento de requisitos",
    "Realizar limpeza interna no gabinete",
    "Realizar manipulação de arquivos",
    "Realizar manipulação de diretórios",
    "Realizar manipulação de pastas",
    "Realizar manuseio de alicate",
    "Realizar manuseio de alicates de crimpagem e punch down",
    "Realizar manuseio de chaves de fenda",
    "Realizar manuseio de chaves Philips",
    "Realizar manuseio de testador de cabo",
    "Realizar manutenção corretiva em microcomputadores",
    "Realizar manutenção preventiva em microcomputadores",
    "Realizar mapeamento de classes necessárias a um software",
    "Realizar mapeamento de entidades",
    "Realizar minicursos de informática básica",
    "Realizar modificações a partir de um programa já implementado",
    "Realizar montagem de computadores",
    "Realizar operação de S.O. (Sistema Operacional)",
    "Realizar operação de um S.O. (Sistema Operacional) em modo texto",
    "Realizar operações com arquivos no servidor Web",
    "Realizar operações com diretórios no servidor Web",
    "Realizar planejamento de rede",
    "Realizar testes de comunicação com rede de computadores",
    "Realizar testes em produtos de software",
    "Realizar tratamento de imagens no Photoshop",
    "Realizar verificação de compatibilidade de hardware",
    "Salvar imagens no CorelDRAW",
    "Utilizar algoritmos",
    "Utilizar CD/DVD",
    "Utilizar comandos e funções no MS-DOS",
    "Utilizar discos removíveis",
    "Utilizar efeitos nas apresentações",
    "Utilizar função PROCH",
    "Utilizar função PROCV",
    "Utilizar funções básicas do Scratch",
    "Utilizar gerenciadores no Linux",
    "Utilizar gerenciadores no Windows",
    "Utilizar linguagem HTML na criação de páginas Web",
    "Utilizar mala direta",
    "Utilizar operadores de comparação",
    "Utilizar operadores matemáticos",
    "Utilizar pacote de escritório",
    "Utilizar plataforma Android",
    "Utilizar plataforma Android SDK",
    "Utilizar plataforma Android Studio",
    "Utilizar programação em bloco com auxílio do Scratch",
    "Utilizar softwares anti-malware",
    "Utilizar Unity como Gamer Engine",
    "Vetorizar imagens"
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Escolar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro Escolar</h1>
        <form id="studentForm" action="process.php" method="POST">
            <div class="form-group">
                <label for="escola">Nome da Escola:</label>
                <input type="text" id="escola" name="escola" required>
            </div>
            
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" required>
            </div>
            
            <div class="form-group">
                <label for="curso">Curso:</label>
                <input type="text" id="curso" name="curso" required>
            </div>
            
            <div class="form-group">
                <label for="disciplina">Disciplina:</label>
                <input type="text" id="disciplina" name="disciplina" required>
            </div>
            
            <div class="survey">
                <h3>Atividades Realizadas</h3>
                <?php foreach ($atividades as $i => $atividade): ?>
                    <div class="question">
                        <p><?= ($i+1) ?>. <?= htmlspecialchars($atividade) ?></p>
                        <label><input type="radio" name="atividade_<?= $i ?>" value="Observou"> Observou</label>
                        <label><input type="radio" name="atividade_<?= $i ?>" value="Realizou Com Auxílio"> Realizou com Auxílio</label>
                        <label><input type="radio" name="atividade_<?= $i ?>" value="Realizou Sem Auxílio"> Realizou sem Auxílio</label>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="form-group">
                <label for="observacoes">Observações <span id="observacoes_counter">*300 caracteres restantes.</span></label>
                <textarea id="observacoes" name="observacoes" maxlength="300" rows="4" oninput="updateCounter('observacoes', 300)"></textarea>
            </div>
            
            <div class="form-group">
                <label for="intervencoes">Intervenções <span id="intervencoes_counter">300 caracteres restantes.</span></label>
                <textarea id="intervencoes" name="intervencoes" maxlength="300" rows="4" oninput="updateCounter('intervencoes', 300)"></textarea>
            </div>
            
            <button type="submit">Enviar</button>
            
            <script>
            function updateCounter(fieldId, maxLength) {
                const textarea = document.getElementById(fieldId);
                const counter = document.getElementById(fieldId + '_counter');
                const remaining = maxLength - textarea.value.length;
                counter.textContent = remaining + ' caracteres restantes.';
                if (remaining < 50) {
                    counter.style.color = 'red';
                } else {
                    counter.style.color = '';
                }
            }
            </script>
        </form>
        
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <div class="actions">
            <a href="generate_csv.php" class="btn">Gerar Relatório CSV</a>
            <a href="?logout=1" class="btn btn-logout">Sair</a>
        </div>
    <?php else: ?>
        <div class="login-form">
            <h3>Acesso Restrito</h3>
            <?php if (isset($login_error)): ?>
                <div class="error"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Usuário:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn">Entrar</button>
            </form>
        </div>
    <?php endif; ?>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
