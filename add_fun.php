<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Funcionário</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilofun.css">
</head>
<body>
    <header class="header">
        <div class="retangulo-superior">
            <div class="keybox">
             <img src="../imagem/logo.png" alt="keybox">
            </div>
            <div class="imglogosenac">
             <img src="../imagem/logosenac.png" alt="logosenac" class="img_senac_logo">
         </div>
         </div>
    </header>
    
    <nav class="breadcrumb">
        <div class="breadcrumb-esq">
            <a href="index_menu.php" class="links-nav">Início > </a>
            <a href="fucionario.php" class="links-nav">Voltar</a>
        </div>
        <div class="breadcrumb-dir">
            <a class="link-add" href="tipo_func.php">Cadastrar cargo</a>
        </div>
        
        

    </nav>
    
    <main class="main-content">
        <div class="form-container">
            <h2>Adicionar Novo Funcionário</h2>
            <form action="../src/controller/add_funcionario_cadastro.php" method="POST" >
                <div class="input-group">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" placeholder="Ana Luiza Pereira dos Santos" name="nome">
                </div>
                
                <div class="input-group">
                    <label for="cargo">Cargo:</label>
                    <select id="cargo" class="input-group-select" name="cargo">
                        <option value="#"  disabled selected>Selecione</option>
                        <?php 
                            require_once('../config/dbConnect.php');
                            $sqlCargos = "SELECT codigo, tip_func FROM tipo_funcionario";
                            $resultado = $dbh->query($sqlCargos);
                            $listaCargos = $resultado->fetchAll(PDO::FETCH_ASSOC);

                            if(count($listaCargos) > 0):
                                foreach($listaCargos as $cargos):
                        ?>

                            <option value="<?= $cargos['codigo'] ?>"> <?= $cargos['tip_func'] ?> </option>
                        <?php
                            endforeach;
                        endif;
                    ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="contato">Contato:</label>
                    <input type="tel" id="contato" placeholder="(87) 96734-8403" name="telefone">
                </div>
                <div class="input-group">
                    <label for="Email">Email:</label>
                    <input type="email" id="email" placeholder="funcionario@pe.senac.br" name="email">
                </div>
                
                <button type="submit" class="submit-button">Adicionar Funcionário</button>
                
            </form>
        </div>
    </main>
</body>
</html>
