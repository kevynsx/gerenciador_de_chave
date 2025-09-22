<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendentes - Chaves</title>
    <link rel="stylesheet" href="../css/estilo_pendentes.css">
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

    <div class="container">
        <div class="titulo">Chaves Pendentes</div>

        <h3>Lista de Chaves Pendentes de Devolução</h3>
        <table>
            <thead>
                <tr>
                    <th>Descrição da Chave</th>
                    <th>Data de Empréstimo</th>
                    <th>Nome do Funcionário</th>
                    <th>Cargo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('../config/dbConnect.php');

                // Consulta SQL para exibir apenas chaves com devolução pendente (data_dev é NULL)
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
                            registro.data_dev IS NULL"; // Filtra as chaves com devolução pendente

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
                        <td colspan="4">Nenhuma chave pendente de devolução</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Exibe a imagem caso não haja chaves pendentes -->
    <?php if (count($dados) == 0): ?>
        <div class="block">
            <img src="../imagem/Vector.png" alt="Nenhuma chave pendente de devolução">
        </div>
    <?php endif; ?>

</body>

</html>