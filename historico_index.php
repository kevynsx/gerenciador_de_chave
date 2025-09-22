<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico - Chaves, Reservas e Funcionários</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap.css">
    <link rel="stylesheet" href="../css/estilo_historico.css">
</head>

<body>
    <div class="retangulo-superior">
        <div class="keybox">
            <img src="../imagem/logo.png" alt="keybox">
        </div>
        <div class="imglogosenac">
            <img src="../imagem/logosenac.png" alt="logosenac" class="img_senac_logo">
        </div>
    </div>
    <nav class="breadcrumb">
        <a href="index_menu.php">Início</a> 
    </nav>
    <h1 class="titulo-principal">Histórico Completo</h1>
    <section class="secao-tabela">
    <?php
        require_once('../config/dbConnect.php');

        // Consulta SQL ajustada
        $sql = "SELECT 
                    chave.descricao AS chave_descricao,
                    -- Ajuste para determinar o status da chave
                    CASE 
                        WHEN registro.data_dev IS NULL THEN 'Emprestada'
                        WHEN registro.data_dev IS NOT NULL THEN 'Disponível'
                    END AS chave_status,
                    registro.data_emp AS data_emp,
                    COALESCE(DATE_FORMAT(registro.data_dev, '%Y-%m-%d %H:%i:%s'), 'Pendente') AS data_dev,
                    func.nome AS func_nome,
                    tipo_func.tip_func AS func_cargo
                FROM 
                    chave
                LEFT JOIN 
                    registro ON chave.id = registro.id_chave
                LEFT JOIN 
                    func ON registro.id_func = func.id
                LEFT JOIN 
                    tipo_funcionario tipo_func ON func.cod_tip_func = tipo_func.codigo
                WHERE data_emp IS NOT NULL
             "; // Exclui status indefinido

        $resultado = $dbh->query($sql);
        $dados = $resultado->fetchAll(PDO::FETCH_ASSOC);

        // Verificar se há registros a serem exibidos
        if (count($dados) > 0):
        ?>
            <table id="tabela" class="display nowrap tabela-principal"  style="width:100%">
                <thead>
                    <tr>
                        <th>Chave</th>
                        <th>Status</th>
                        <th>Empréstimo</th>
                        <th>Devolução</th>
                        <th>Funcionário</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dados as $linha):
                    ?>
                        <tr>
                            <td><?= $linha['chave_descricao'] ?></td>
                            <td><?= $linha['chave_status'] ?></td>
                            <td class="data-emp"><?= $linha['data_emp'] ?></td>
                            <td><?= $linha['data_dev'] ?></td>
                            <td><?= $linha['func_nome'] ?></td>
                            <td><?= $linha['func_cargo'] ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="imagem-vazia">
                <img src="../imagem/Vector.png" alt="Nenhum registro encontrado">
            </div>
        <?php endif; ?>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#tabela').DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    scrollCollapse: true,
                    scrollY: '50vh',
                    responsive: true
                });
            });
        </script>
</body>
</html>