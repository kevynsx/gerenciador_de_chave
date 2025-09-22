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

    
    
        // Adicione esta linha para definir a variável $nome
        $nome = "Nome do Porteiro"; 

        // O restante do seu código vem aqui

        
        // As suas consultas para o status (total, disponíveis, etc.)
        $sqlTotal = "SELECT COUNT(*) as total FROM chaves";
        $total = $dbh->query($sqlTotal)->fetch(PDO::FETCH_ASSOC)['total'];

        $sqlDisponiveis = "SELECT COUNT(*) as disponiveis FROM chaves WHERE situacao = 'Disponível'";
        $disponiveis = $dbh->query($sqlDisponiveis)->fetch(PDO::FETCH_ASSOC)['disponiveis'];

        $sqlEmprestadas = "SELECT COUNT(*) as emprestadas FROM chaves WHERE situacao = 'Emprestada'";
        $emprestadas = $dbh->query($sqlEmprestadas)->fetch(PDO::FETCH_ASSOC)['emprestadas'];

        $sqlAtivos = "SELECT COUNT(*) as ativos FROM movimentacoes m1
                    LEFT JOIN movimentacoes m2 ON m1.id_chave = m2.id_chave AND m2.tipo = 'devolucao' AND m2.data_hora > m1.data_hora
                    WHERE m1.tipo = 'retirada' AND m2.id_mov IS NULL";
        $ativos = $dbh->query($sqlAtivos)->fetch(PDO::FETCH_ASSOC)['ativos'];

        // Consulta para buscar todos os empréstimos ativos
        // Consulta para buscar todos os empréstimos ativos
        // Consulta para buscar todos os empréstimos ativos com a movimentação mais recente de retirada
        $sqlEmprestimos = "SELECT
                    c.id_chave,
                    c.codigo_chave,
                    c.descricao,
                    m.data_hora,
                    m.solicitante,
                    u.nome as porteiro_nome
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

        $emprestimosAtivos = $dbh->query($sqlEmprestimos)->fetchAll(PDO::FETCH_ASSOC);
    ?> 
    <header>
        <div class="headerporteiro">
            <div class="headerporteiroesq">
                <h2>Sistema SENAC</h2>
                <p>Gerenciador de Chaves</p>
            </div>
            <div class="headerporteirodir">
                <div class="headerporteirodirtexto">
                <h2><?= $nome ?></h2>
                <p>Porteiro</p></div>
                <div class="headerporteirodirimg">
                    <img src="User.jpg" alt="Foto do usuário" height="60">
                </div>
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
                <p>Empréstimos Ativos</p>
                <h2><?=$ativos?></h2>
            </div>
        </div>
    </section>
    <section class="secao2">
        <div class="secao2esq">
        <h2>Emprestar Chave</h2>

            <form action="src/emprestar_chave.php" method="POST" class="secao2esqitens">
            <select name="id_chave" required>
                <option disabled selected>Selecione uma chave</option>
                <?php
                $sqlChavesDisp = "SELECT id_chave, codigo_chave, descricao FROM chaves WHERE situacao = 'Disponível'";
                $stmt = $dbh->query($sqlChavesDisp);
                $chavesDisp = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($chavesDisp as $ch) {
                    echo "<option value='{$ch['id_chave']}'>{$ch['codigo_chave']} - {$ch['descricao']}</option>";
                }
                ?>
            </select>

            <input type="text" name="solicitante" placeholder="Nome completo do solicitante" required>
            <input type="text" name="documento" placeholder="Documento (opcional)">
            <input type="text" name="observacoes" placeholder="Observações (opcional)">

            <button type="submit" class="secao2esqbotao">Emprestar Chave</button>
            </form>
        </div>

        <div class="secao2dir">
            <h2>Empréstimos Ativos</h2>
            <div class="secao2dirobjarea">
                <?php
                    // AQUI está o loop dinâmico que exibe os empréstimos ativos
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
</body>
</html>