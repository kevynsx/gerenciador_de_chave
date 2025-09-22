<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaves Reservadas</title>
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
            <img src="../imagem/logosenac.png" alt="logosenac" class="img_senac_logo">
        </div>
    </div>
    <nav class="breadcrumb">
        <a href="index_menu.php">Início</a>
    </nav>
    <h1 class="titulo-principal">Lista de Chaves Disponíveis</h1>
    <section class="secao-tabela">
        <?php
        require_once('../config/dbConnect.php');

        // Consulta para listar apenas as chaves reservadas (numero = 2)
        $sql = "SELECT 
                    chave.numero AS chave_numero,
                    chave.descricao AS chave_descricao,
                    CASE
                        WHEN MAX(registro.data_emp) IS NULL THEN 'Disponível'  -- Se não houver registro de empréstimo, está disponível
                        WHEN MAX(registro.data_dev) IS NULL THEN 'Indisponível'  -- Se houver empréstimo mas sem devolução, está indisponível
                        ELSE 'Disponível'  -- Se houve devolução, está disponível
                    END AS chave_status,
                    MAX(registro.data_emp) AS ultima_data_emp, -- Última data de empréstimo
                    MAX(DATE_FORMAT(registro.data_dev, '%Y-%m-%d %H:%i:%s')) AS ultima_data_dev -- Última data de devolução
                FROM 
                    chave
                LEFT JOIN 
                    registro ON chave.id = registro.id_chave
                WHERE 
                    chave.descricao IS NOT NULL -- Ignorar chaves sem descrição
                GROUP BY 
                    chave.descricao, chave.numero"; 

        $resultado = $dbh->query($sql);
        $chavesReservadas = $resultado->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($chavesReservadas);
       // exit();

        // Verificar se há chaves reservadas
        if (count($chavesReservadas) > 0):
        ?>
            <table id="tabela" class="display nowrap tabela-principal" style="width:100%">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Chave</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($chavesReservadas as $chave): 
                        if($chave["chave_status"] == 'Disponível'):
                    ?>
                        <tr>
                            <td class="chaves-disponiveis"><?= $chave['chave_numero'] ?></td>
                            <td class="chaves-disponiveis"><?= $chave['chave_descricao'] ?></td>
                        </tr>
                    <?php
                    endif;
                    endforeach;
                    ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="imagem-vazia">
                <img src="../imagem/Vector.png" alt="Nenhuma chave reservada">
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