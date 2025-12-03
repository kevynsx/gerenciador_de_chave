<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/porteiro.css">
    <title>Porteiro - Sistema SENAC</title>
    <link rel="icon" href="css/Senac.png" type="image">
</head>
<body>
    
    <?php
        require_once('config.php'); 
        //date_default_timezone_set('America/Recife');
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

        session_start();
        $nome = $_SESSION['nome'];

        if(!isset($_SESSION['nome'])){
        header("Location: login.php");
        //verificando se existe sessão criada!
}

        
        $sqlTotal = "SELECT COUNT(*) as total FROM chaves WHERE disponivel = 1";
        $total = $dbh->query($sqlTotal)->fetch(PDO::FETCH_ASSOC)['total'];

        $sqlDisponiveis = "SELECT COUNT(*) as disponiveis FROM chaves WHERE situacao = 'Disponível' AND disponivel = 1";
        $disponiveis = $dbh->query($sqlDisponiveis)->fetch(PDO::FETCH_ASSOC)['disponiveis'];

        $sqlEmprestadas = "SELECT COUNT(*) as emprestadas FROM chaves WHERE situacao = 'Emprestada'";
        $emprestadas = $dbh->query($sqlEmprestadas)->fetch(PDO::FETCH_ASSOC)['emprestadas'];

        $sqlAtivos = "SELECT COUNT(*) as ativos,
                m.id_chave,
                m.id_usuario,
                u.id_usuario,
                c.situacao,
                m.tipo
                FROM
                    chaves c
                JOIN
                    movimentacoes m ON c.id_chave = m.id_chave
                JOIN
                    usuarios u ON m.id_usuario = u.id_usuario
                WHERE
                    c.situacao = 'Emprestada' AND m.tipo = 'retirada'
                AND
                    m.data_hora = (SELECT MAX(data_hora) FROM movimentacoes WHERE id_chave = c.id_chave)";
        $ativos = $dbh->query($sqlAtivos)->fetch(PDO::FETCH_ASSOC)['ativos'];


        $sqlEmprestimos = "SELECT
                    c.id_chave,
                    c.codigo_chave,
                    c.descricao,
                    m.data_hora,
                    m.solicitante,
                    m.observacao,
                    m.documento,
                    u.nome as porteiro_nome
                FROM
                    chaves c
                JOIN
                    movimentacoes m ON c.id_chave = m.id_chave
                JOIN
                    usuarios u ON m.id_usuario = u.id_usuario
                WHERE
                    c.situacao = 'Emprestada' AND m.tipo = 'retirada'
                AND
                    m.data_hora = (SELECT MAX(data_hora) FROM movimentacoes WHERE id_chave = c.id_chave)";

        $emprestimosAtivos = $dbh->query($sqlEmprestimos)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <header> <!-- Cabeçalho da página -->
        <div class="header">
            <div class="headeresq"> <!-- Cabeçalho esquerdo -->
                <img class="headeresqimg" src="imagens/senacmain.png" alt="Senac">
                <p class="headeresqtexto">Gerenciador de Chaves</p>
            </div>
            <div class="headerdir"> <!-- Cabeçalho direito -->
                <div class="headerdirtexto"> <!-- Área do texto -->
                <h2 class="headerdirtextonome"><?= htmlspecialchars($nome) ?></h2> <!-- Nome do usuário -->
                <p>Porteiro</p>
            </div> <!-- Função do usuário -->
                    <p alt="Configurações" onclick="abrirMenuModalUserLogado()" class="botaoconfiguracoes">☰</p> <!-- Engrenagem -->
            </div>
        </div>
    </header>
    <section class="secao1">
        <div class="secao1status">
            <div class="secao1status1">
                <p>Total de Chaves</p>
                <h2><?=$total?></h2>
            </div>
            <div class="secao1status2">
                <p>Disponíveis</p>
                <h2><?=$disponiveis?></h2>
            </div>
            <div class="secao1status3">
                <p>Emprestadas</p>
                <h2><?=$emprestadas?></h2>
            </div>
            <div class="secao1status4">
                <p>Relatório</p>
            </div>
        </div>
    </section>
    <div class="menuusuarioarea" id="menuusuariologado">
    <div class="menuusuario" > <!-- Painel -->
        <div class="areasair"><img src="./imagens/fechar.png" alt="Fechar" class="fechar" height="30" id="fechar"></div> <!-- Botão de fechar -->
        <a class="botaosair" href="src/sair.php">Sair</a> <!-- Sair/deslogar -->
    </div></div>
    <section class="secao2">
        <div class="secao2esq">
        <h2>Emprestar Chave</h2>

            <form action="src/emprestar_chave.php" method="POST" class="secao2esqitens">
            <div class="secao2esqinputs">
                <select id="selchave" required class="secao2esqinput" name='id_chave'>
                <option disabled selected>Selecione uma chave</option>
                <?php
                $sqlChavesDisp = "SELECT id_chave, codigo_chave, descricao, disponivel FROM chaves WHERE situacao = 'Disponível' AND disponivel = 1";
                $stmt = $dbh->query($sqlChavesDisp);
                $chavesDisp = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($chavesDisp as $ch) {
                    echo "<option name='id_chave' value='{$ch['id_chave']}'>{$ch['codigo_chave']} - {$ch['descricao']}</option>";
                }
                ?>
            </select>

            <input class="secao2esqinput" type="text" name="solicitante" placeholder="Nome completo do solicitante" required>
            <input class="secao2esqinput" type="text" name="documento" placeholder="Documento (opcional)">
            <input class="secao2esqinput" type="text" name="observacao" placeholder="Observações (opcional)"></div>

            <button type="submit" class="secao2esqbotao">Emprestar Chave</button>
            </form>
        </div>

        <div class="secao2dir">
            <h2>Empréstimos Ativos</h2>
            <div class="secao2dirobjarea">
                <?php
                    if (empty($emprestimosAtivos)) {
                        echo "<p>Nenhum empréstimo ativo no momento.</p>";
                    } else {
                        foreach ($emprestimosAtivos as $emprestimo) {
                            $data = date('d-m-Y', strtotime($emprestimo['data_hora']));
                            $hora = date('H:i:s', strtotime($emprestimo['data_hora']));
                ?>
                <div class="secao2dirobj">
                    <div class="secao2dirobjheader">
                        <h2><?= htmlspecialchars($emprestimo['codigo_chave']) ?></h2>
                        <div>
                            <p><b><?= $data ?></b>, <?= $hora ?></p>
                        </div>
                    </div>
                    <div class="secao2dirobjtexto">
                        <p><b>Solicitante:</b> <?= htmlspecialchars($emprestimo['solicitante']) ?></p>
                        <p><b>Porteiro:</b> <?= htmlspecialchars($emprestimo['porteiro_nome']) ?></p>
                        <p><b>Descrição:</b> <?= htmlspecialchars($emprestimo['descricao']) ?></p>
                        <p><b>Observações:</b> <?= htmlspecialchars($emprestimo['observacao']) ?></p>
                        <p><b>documento:</b> <?= htmlspecialchars($emprestimo['documento']) ?></p>
                        
                    </div>
                    
                    <form action="src/devolver_chave.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_chave" value="<?= htmlspecialchars($emprestimo['id_chave']) ?>">
                        <button type="submit" class="secao2dirobjheaderdevol">Devolver Chave</button>
                    </form>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </section>
    <script src="./js/master.js"></script>
</body>
</html>