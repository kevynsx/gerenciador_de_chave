<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservadas - Chaves</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap.css">
    <link rel="stylesheet" href="../css/estilo_reservadas.css">
</head>

<body>
    <div class="retangulo-superior">
        <div class="keybox">
            <img src="../imagem/logo.png" alt="keybox">
        </div>
        <div class="imglogosenac">
            <img src="../imagem/image 7.png" alt="logosenac" class="img_senac_logo">
        </div>
    </div>
    <nav class="breadcrumb">
        <a href="index_menu.php">Início</a>
        <a href="../src/controller/sair.php" class="link-sair">Sair</a>
    </nav>

        <h1 class="titulo-principal">Lista de Chaves Emprestadas</h1>
        <section class="secao-tabela">
        <table id="tabela" class="display nowrap tabela-principal" style="width:100%">
            <thead>
                <tr>
                    <th>Chave</th>
                    <th>Data de Empréstimo</th>
                    <th>Funcionário</th>
                    <th>Cargo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('../config/dbConnect.php');

                // Consulta SQL para exibir apenas chaves emprestadas
                $sql = "SELECT 
                            chave.descricao AS chave_descricao,
                            registro.data_emp AS data_emp,
                            func.nome AS func_nome,
                            tipo_func.tip_func AS func_cargo
                        FROM 
                            chave
                        JOIN 
                            registro ON chave.id = registro.id_chave
                        JOIN 
                            func ON registro.id_func = func.id
                        JOIN 
                            tipo_funcionario tipo_func ON func.cod_tip_func = tipo_func.codigo
                        WHERE 
                            registro.data_dev IS NULL -- Somente chaves que não têm data de devolução
                            AND chave.descricao IS NOT NULL -- Ignorar chaves sem descrição"; 

                $resultado = $dbh->query($sql);
                $dados = $resultado->fetchAll(PDO::FETCH_ASSOC);

                if (count($dados) > 0):
                    foreach ($dados as $linha):
                ?>
                        <tr>
                            <td><?= $linha['chave_descricao'] ?></td>
                            <td><?= $linha['data_emp'] ?></td>
                            <td><?= $linha['func_nome'] ?></td>
                            <td><?= $linha['func_cargo'] ?></td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="4">Nenhuma chave emprestada encontrada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </section>

    <!-- Exibe a imagem caso nenhuma chave esteja emprestada -->
    <?php if (count($dados) == 0): ?>
        <div class="block">
            <img src="../imagem/Vector.png" alt="Nenhuma chave emprestada">
        </div>
    <?php endif; ?>
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