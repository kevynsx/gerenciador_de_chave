<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Recife');

require_once('config.php');
session_start();
$nome = $_SESSION['nome'];
// Verifica se o usuÃ¡rio estÃ¡ logado, se nÃ£o, redireciona para a pÃ¡gina de login.
if (!isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit;
}
    
// Consultas para os contadores
$sqlTotal = "SELECT COUNT(*) as total FROM chaves";
$total = $dbh->query($sqlTotal)->fetch(PDO::FETCH_ASSOC)['total'];

$sqlDisponiveis = "SELECT COUNT(*) as disponiveis FROM chaves WHERE situacao = 'Disponível'";
$disponiveis = $dbh->query($sqlDisponiveis)->fetch(PDO::FETCH_ASSOC)['disponiveis'];

$sqlEmprestadas = "SELECT COUNT(*) as emprestadas FROM chaves WHERE situacao = 'Emprestada'";
$emprestadas = $dbh->query($sqlEmprestadas)->fetch(PDO::FETCH_ASSOC)['emprestadas'];

$sqlAtivos = "SELECT COUNT(*) as ativos,
                m.id_chave,
                m.id_usuario,
                u.id_usuarios,
                c.situacao,
                m.tipo
                FROM
                    chaves c
                JOIN
                    movimentacoes m ON c.id_chave = m.id_chave
                JOIN
                    usuarios u ON m.id_usuario = u.id_usuarios
                WHERE
                    c.situacao = 'Emprestada' AND m.tipo = 'retirada'
                AND
                    m.data_hora = (SELECT MAX(data_hora) FROM movimentacoes WHERE id_chave = c.id_chave)";
$ativos = $dbh->query($sqlAtivos)->fetch(PDO::FETCH_ASSOC)['ativos'];

// Consulta para listar as chaves para a seÃ§Ã£o "Gerenciar Chaves"
$sqlChaves = "SELECT id_chave, codigo_chave, descricao, situacao FROM chaves ORDER BY codigo_chave ASC";
$stmtChaves = $dbh->query($sqlChaves);
$chaves = $stmtChaves->fetchAll(PDO::FETCH_ASSOC);

// Consulta para o histÃ³rico de emprÃ©stimos
$sqlHistorico = "SELECT 
                    c.codigo_chave,
                    c.descricao,
                    m1.solicitante,
                    u.nome AS porteiro_nome,
                    m1.data_hora AS data_emprestimo,
                    m2.data_hora AS data_devolucao
                FROM movimentacoes m1
                LEFT JOIN movimentacoes m2 ON m1.id_chave = m2.id_chave AND m2.tipo = 'devolucao' AND m2.data_hora > m1.data_hora
                LEFT JOIN usuarios u ON u.id_usuarios = m1.id_usuario
                LEFT JOIN chaves c ON c.id_chave = m1.id_chave
                WHERE m1.tipo = 'retirada'
                ORDER BY m1.data_hora DESC";
$stmtHistorico = $dbh->query($sqlHistorico);
$historico = $stmtHistorico->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/master.css">
    <title>Master - Sistema SENAC</title>
    <link rel="icon" href="css/Senac.png" type="image">
</head>
<body>
    <header>
        <div class="header">
            <div class="headeresq">
                <h2>Sistema SENAC</h2>
                <p>Gerenciador de Chaves</p>
            </div>
            <div class="headerdir">
                <div class="headerdirtexto">
                <h2><?= htmlspecialchars($nome) ?></h2>
                <p>Master</p></div>
                <div class="headerdirimg">
                    <img src="css/User.jpg" alt="Foto do usuÃ¡rio" height="60">
                </div>
            </div>
        </div>
    </header>
    <section class="secao1">
        <div class="secao1status">
            <div class="secao1status1">
                <p>Total de Chaves</p>
                <h2><?= htmlspecialchars($total) ?></h2>
            </div>
            <div class="secao1status2">
                <p>Disponíveis</p>
                <h2><?= htmlspecialchars($disponiveis) ?></h2>
            </div>
            <div class="secao1status3">
                <p>Emprestadas</p>
                <h2><?= htmlspecialchars($emprestadas) ?></h2>
            </div>
            <div class="secao1status4">
                <p>Empréstimos Ativos</p>
                <h2><?= htmlspecialchars($ativos) ?></h2>
            </div>
        </div>
    </section>
    <section class="secao2">
        <div class="secao2esq">
            <div class="secao2esqheader">
                <h2>Gerenciar Chaves</h2>
                <a href="adicionar_chave.php" class="secao2esqheaderbotao"><b>+ Adicionar Chave</b></a>
            </div>
            <div class="secao2esqitens">
                <?php if(!empty($chaves)): ?>
                    <?php foreach($chaves as $ch): ?>
                        <div class="secao2esqobj">
                            <div class="secao2esqitenstexto">
                                <h2><?= htmlspecialchars($ch['codigo_chave'] ?? '') ?></h2>
                                <p><?= htmlspecialchars($ch['descricao'] ?? '') ?></p>
                                <p class="secao2esqsituacao"><?= htmlspecialchars($ch['situacao'] ?? '') ?></p>
                            </div>
                            <div class="secao2esqbotoes">
                                <form action="editar_chave.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="id_chave" value="<?= htmlspecialchars($ch['id_chave'] ?? '') ?>">
                                    <button class="secao2esqeditar" type="submit">
                                        <img src="css/edit.png" alt="Editar Chave" height="35px">
                                    </button>
                                </form>
                                <form action="src/deletar_chave.php" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja apagar esta chave?');">
                                    <input type="hidden" name="id_chave" value="<?= htmlspecialchars($ch['id_chave'] ?? '') ?>">
                                    <button class="secao2esqapagar" type="submit">
                                        <img src="css/lixo.png" alt="Apagar Chave" height="35px" width="30px">
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma chave cadastrada.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="secao2dir">
            <h2>Últimos Empréstimos</h2>
            <div class="secao2dirobjarea">
                <?php if(!empty($historico)): ?>
                    <?php foreach($historico as $h): ?>
                        <div class="secao2dirobj">
                            <div class="secao2dirobjheader">
                                <h2><?= htmlspecialchars($h['codigo_chave'] ?? '') ?></h2>
                                <div>
                                    <p><b><?= date('d-m-Y', strtotime($h['data_emprestimo'] ?? '')) ?></b>, <?= date('H:i:s', strtotime($h['data_emprestimo'] ?? '')) ?></p>
                                </div>
                            </div>
                            <div class="secao2dirobjtexto">
                                <p>Solicitante: <b><?= htmlspecialchars($h['solicitante'] ?? '') ?></b></p>
                                <p>Porteiro: <b><?= htmlspecialchars($h['porteiro_nome'] ?? '') ?></b></p>
                                <p>Descrição: <b><?= htmlspecialchars($h['descricao'] ?? '') ?></b></p>
                            </div>
                            <p class="secao2dirobjheaderdevol">
                                <?php if ($h['data_devolucao']) : ?>
                                    Devolvida
                                <?php else : ?>
                                    Ativa
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum empréstimo registrado ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>