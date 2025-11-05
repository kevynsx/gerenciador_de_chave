<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Recife');

require_once('config.php');
session_start();
$nome = $_SESSION['nome'];
$cpf = $_SESSION['cpf'];
$cargo = $_SESSION['cargo'];


if(!isset($_SESSION['nome'])){
    header("Location: login.php");
    //verificando se existe sessão criada!
}

// Consultas para os contadores
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

// Consulta para listar as chaves para a seÃ§Ã£o "Gerenciar Chaves"
$sqlChaves = "SELECT id_chave, codigo_chave, descricao, situacao FROM chaves WHERE disponivel = 1 ORDER BY codigo_chave ASC";
$stmtChaves = $dbh->query($sqlChaves);
$chaves = $stmtChaves->fetchAll(PDO::FETCH_ASSOC);


$sqlHistorico = "SELECT 
                    c.codigo_chave,
                    c.descricao,
                    m1.solicitante,
                    m1.observacao,
                    u.nome AS porteiro_nome,
                    m1.data_hora AS data_emprestimo,
                    m2.data_hora AS data_devolucao
                FROM movimentacoes m1
                LEFT JOIN movimentacoes m2 ON m1.id_chave = m2.id_chave AND m2.tipo = 'devolucao' AND m2.data_hora > m1.data_hora
                LEFT JOIN usuarios u ON u.id_usuario = m1.id_usuario
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
                <img class="headeresqimg" src="imagens/senacmain.png" alt="Senac">
                <p class="headeresqtexto">Gerenciador de Chaves</p>
            </div>
            <div class="headerdir">
                <div class="headerdirtexto">
                    <h2><?= htmlspecialchars($nome) ?></h2>
                    <p>Master</p>
                </div>
                    <p alt="Configurações" onclick="abrirMenuModalUserLogado()" class="botaoconfiguracoes">☰</p>
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
                <p>Emprestimos Ativos</p>
                <h2><?= htmlspecialchars($ativos) ?></h2>
            </div>
            <div class="secao1status4">
                <p>Relatório</p>
            </div>
        </div>
    </section>
    <section class="secao2">
        <div class="secao2esq">
            <div class="secao2esqheader">
            <h2>Gerenciar Chaves</h2>
            
            <a class="secao2esqheaderbotaochaves" onclick="abrirMenuAddChave()"><b>Adicionar Chave</b></a>
        </div>
        
                            <div class="addchave" id="addchavemenu">
                                <div class="addchaveform">
                                    <div class="addchaveformheader">
                                        <h1 class="addchaveformtitulo">Adicionar nova chave</h1>
                                        <div class="areasairform"><img src="imagens/fechar.png" alt="Fechar" class="fechar" height="30" id="fechar"></div>
                                    </div>
                                    <form action="./src/auth_chaves.php" method="post">
                                        <div class="addchaveforminputs">
                                            <div class="addchaveformobj">
                                                <label for="codigo_chave">Número da chave</label>
                                                <input type="text" name="codigo_chave" placeholder="ex. 001, A-01, 15, etc" id="codigo_chave" required>
                                            </div>
                                            <div class="addchaveformobj">
                                                <label for="descricao">Descrição</label>
                                                <input type="text" name="descricao" placeholder="ex. Sala 101, Laboratório de Informática, Laboratório Maker" id="descricao" required>
                                            </div>
                                            <div class="addchaveformobj">
                                                <label for="localizacao">Localização</label>
                                                <input type="text" id="localizacao" name="localizacao" placeholder="ex. 1º andar, Bloco A, Corredor 2" required>
                                            </div>
                                        </div>
                                        <div class="addchaveformbotaoarea">
                                            <input type="submit" id="addchavebotao" value="Adicionar Chave" class="addchaveformbotao">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tabelausuarios" id="tabelausuarios">
        <div class="tabelausuariosarea">
            <div class="tabelausuariostituloheader">
            <h1 class="tabelausuariostitulo">Ver Usuários</h1>
            <div class="areasairform"><img src="imagens/fechar.png" alt="Fechar" class="fechar" height="30" id="fechar"></div></div>
            <div class="tabelausuarioareaitens">
            <table>
                <tr class="tabelausuariosheader">
                <th>Usuários</th>
                <th>CPF</th>
                <th>Função</th>
                <th>Ações</th>
            </tr>
            <tbody>
                <tr class="tabelausuariosdesc">
                    <td><?=$nome?></td>
                    <td><?=var_dump($cpf)?></td>
                    <td>Porteiro(a)</td>
                    <td><div class="tabelausuarioacoes">
                <button class="tabelaeditar" type="submit" id="editar" onclick="editarUser()"><img src="../imagens/edit.png" alt="Editar Chave" height="25px"></button>
                <button class="tabelaapagar" type="submit" id="apagar" onclick="confirmacaoApagarUser()"><img src="../imagens/lixo.png" alt="Editar Chave" height="25px" width="30px"></button>
            </div></td>
                </tr>
                
                <tr class="tabelausuariosdesc">
                    <td>Simão Lucas Dent</td>
                    <td>666.666.666-69</td>
                    <td>Master</td>
                    <td><div class="tabelausuarioacoes">
                <button class="tabelaeditar" type="submit" id="editar" onclick="editarUser()"><img src="../imagens/edit.png" alt="Editar Chave" height="25px"></button>
                <button class="tabelaapagar" type="submit" id="apagar" onclick="confirmacaoApagarUser()"><img src="../imagens/lixo.png" alt="Editar Chave" height="25px" width="30px"></button>
            </div></td>
                </tr>
                
                <tr class="tabelausuariosdesc">
                    <td>Nilo Wilson</td>
                    <td>777.777.777-77</td>
                    <td>Professor(a)</td>
                    <td><div class="tabelausuarioacoes">
                <button class="tabelaeditar" type="submit" id="editar" onclick="editarUser()"><img src="../imagens/edit.png" alt="Editar Chave" height="25px"></button>
                <button class="tabelaapagar" type="submit" id="apagar" onclick="confirmacaoApagarUser()"><img src="../imagens/lixo.png" alt="Editar Chave" height="25px" width="30px"></button>
            </div></td>
                </tr>
            </tbody>
            </table>
        </div></div>
    </div>
            <div class="secao2esqitens">
                <?php if (!empty($chaves)): ?>
                    <?php foreach ($chaves as $ch): ?>
                        <div class="secao2esqobj">
                            <div class="secao2esqitenstexto">
                                <h2><?= htmlspecialchars($ch['codigo_chave'] ?? '') ?></h2>
                                <p><?= htmlspecialchars($ch['descricao'] ?? '') ?></p>
                                <p class="secao2esqsituacao"><?= htmlspecialchars($ch['situacao'] ?? '') ?></p>
                            </div>
                            <div class="secao2esqbotoes">
                                <form action="src/editar_chave.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="id_chave" value="<?= htmlspecialchars($ch['id_chave'] ?? '') ?>">
                                    <button class="secao2esqeditar" type="submit">
                                        <img src="css/edit.png" alt="Editar Chave" height="35px">
                                    </button>
                                </form>
                                <form action="src/btn_deletar.php" method="GET" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja apagar esta chave?');" >
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
                <?php if (!empty($historico)): ?>
                    <?php foreach ($historico as $h): ?>
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
                                <p>Observações: <b><?= htmlspecialchars($h['observacao'] ?? '') ?></b></p>
                                <?php if ($h['data_devolucao']) : ?>
                                <p>Devolvida: <b><?= date('H:i:s', strtotime($h['data_devolucao'] ?? '')) ?></b></p>
                                
                            <?php else : ?>
                                <p>Ativa: <b><?= htmlspecialchars($h['ativa'] ?? '') ?></b></p>
                            <?php endif; ?>
                            </p>
                            </div>

                            <?php if ($h['data_devolucao']) : ?>
                                <p class="secao2dirobjheaderdevol">Devolvida</p>
                            <?php else : ?>
                                <p class="secao2dirobjheaderdevol">Ativa</p>
                            <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum empréstimo registrado ainda.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="menuusuario" id="menuusuariologado">
        <div class="menuusuarioparte1">
        <div class="areasair"><img src="imagens/fechar.png" alt="Fechar" class="fechar" height="30" id="fechar"></div>
        <a class="botaoverusuarios" onclick="abrirMenuVerUsuarios()"><b>Ver Usuários</b></a>
        <a class="botaocadastrarusuario" onclick="abrirMenuCadastroUsuario()"><b>Cadastrar Usuário</b></a></div>
        <a class="botaosair" href="src/sair.php"><b>Sair</b></a>

    </div>
    <form class="formulariocadastrouser" action="./src/auth_cadastro.php" id="cadastrousuario" method="POST">
        <div class="formularioheader">
            <h1 >Cadastro do Usuário</h1>
            <div class="areasairform"><img src="imagens/fechar.png" alt="Fechar" class="fechar" height="30" id="fechar"></div>
        </div>
        <div class="areacadastro">
        <input type="text" placeholder="Nome completo" id="nomecompleto" name="nomecompleto" required>
        <select name="funcao" id="funcao" required>
            <option disabled selected>Função</option>
            <option value="porteiro">Porteiro</option>
            <option value="master">Master</option>
        </select>
        <input type="text" maxlength="11" minlength="11" name="cpf" id="cpf" placeholder="CPF" required>
        <input type="text" minlength="8" name="senha" id="senha" placeholder="Senha" required>
    <p class="formulariotextosenha">a senha precisa ter no mínimo 8 caracteres, um número e um símbolo especial</p></div>
        <input class="botaocadastrar" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
    </form>
    </section>
    <script src="./js/master.js"></script>
</body>

</html>