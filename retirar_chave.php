<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keybox - Retirar Chave</title>
    <link rel="stylesheet" href="../css/estilo-chave.css">
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
        <a href="index_menu.php">Início > Retirar</a>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2>Retirar Chave</h2>
            <form class="formulario" action="../src/controller/reservar_chave.php" method="POST">
                <div class="form-inputs">
                    <div class="quem-retirou">
                        <label for="funcionario" class="custom-label">Quem retirou:</label>
                        <select id="funcionario" name="funcionario">
                            <option value="#" disabled selected>Selecione o Funcionário</option>
                            <?php
                            require_once('../config/dbConnect.php');
                            $sqlFuncionarios = "SELECT id, nome FROM func";
                            $resultadoFuncionarios = $dbh->query($sqlFuncionarios);
                            $listaFuncionarios = $resultadoFuncionarios->fetchAll(PDO::FETCH_ASSOC);

                            if (count($listaFuncionarios) > 0):
                                foreach ($listaFuncionarios as $funcionario):
                            ?>
                                    <option value="<?= $funcionario['id'] ?>"> <?= $funcionario['nome'] ?> </option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                    <div class="chave">
                        <label for="chave" class="custom-label">Chave:</label>
                        <select id="chave" name="chave">
                            <option value="#" disabled selected>Selecione a Chave</option>
                            <?php
                            $sqlChaves = "SELECT id, descricao FROM chave";
                            $resultadoChaves = $dbh->query($sqlChaves);
                            $listaChaves = $resultadoChaves->fetchAll(PDO::FETCH_ASSOC);

                            if (count($listaChaves) > 0):
                                foreach ($listaChaves as $chave):
                            ?>
                                    <option value="<?= $chave['id'] ?>"> <?= $chave['descricao'] ?> </option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-botoes">
                    <button type="submit" class="butao">Salvar</button>
                    <button type="button" class="butao">
                            Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>