    <?php
        require_once('config.php');
        session_start();
        $nome = $_SESSION['nome'];
    ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Cadastro - Sistema SENAC</title>
    <link rel="icon" href="css/Senac.png" type="image/x-icon">
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
                <h2><?=$nome?></h2>
                <p>Master</p></div>
                <div class="headerdirimg">
                    <img src="imagens/User.jpg" alt="Foto do usuário" height="60">
                </div>
            </div>
        </div>
    </header>
    <form class="formulario" action="src/auth_cadastro.php" method="post">
        <h1 class="formularioheader">Cadastro do Usuário</h1>
        <div class="areacadastro">
        <input type="text" placeholder="Nome completo" id="nomecompleto" name="nomecompleto" required>
        <select name="funcao" id="funcao" required>
            <option disabled selected>Função</option>
            <option value="master">Master</option>
            <option value="porteiro">Porteiro</option>
        </select>
        <input type="text" maxlength="11" minlength="11" name="cpf" id="cpf" placeholder="CPF" required>
        <input type="password" minlength="8" name="senha" id="senha" placeholder="Senha" required>
    <p class="formulariotextosenha">a senha precisa ter no mínimo 8 caracteres, um número e um símbolo especial</p></div>
        <input class="botaocadastrar" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
    </form>
</body>
</html>