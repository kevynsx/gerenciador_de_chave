<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/loginstyle.css">
    <title>Pagina inicial</title>
    <link rel="icon" href="css/Senac.png" type="image">
</head>
<body class="corpo">
    
    <form action="src/auth_login.php" method="post">
    <section class="login">
        <div class="loginsecao">
            <div class="loginheader">
                <div class="logintitulo">
            <img src="imagens/senacmain.png" height="40">
            <h1 class="logintitulotexto">Gerenciador de Chaves</h1>
        </div>
    </div>
        
        <div class="loginarea">

            <div class="logindigitar">
                <input type="text" name="cpf" id="cpf" placeholder="CPF" required maxlength="11" minlength="11" >
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
            <div class="esqueceuasenhasecao">
                <a href="" class="esqueceuasenha">Esqueceu a senha?</a></div>
            </div>
        </div>
        <button type="submit" class="loginbotao">Entrar</button>
    </section>
    </form>
</body>
</html>