<?php
require_once('../config.php');
session_start();

$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

$verificaUsuario = "SELECT id_usuario, nome, senha, cargo FROM usuarios WHERE cpf = :cpf LIMIT 1";
$req = $dbh->prepare($verificaUsuario);
$req->bindValue(':cpf', $cpf);
$req->execute();
$dadosUsuario = $req->fetch(PDO::FETCH_ASSOC);

if($dadosUsuario){
    if (password_verify($senha, $dadosUsuario["senha"])) {
        
        $_SESSION['id_usuario'] = $dadosUsuario['id_usuario'];
        $_SESSION['nome'] = $dadosUsuario['nome'];
        $_SESSION['cargo'] = $dadosUsuario['cargo'];

        if(strtolower($dadosUsuario["cargo"]) === "master"){
            header('Location: ../menu_master.php');
            exit();
        }
        elseif(strtolower($dadosUsuario["cargo"]) === "porteiro"){
            header('Location: ../menu_porteiro.php');
            exit();
        }
        else{
            header('Location: ../login.php?sucesso=2');
            exit();
        }
    }
    else{
        header('Location: ../login.php?erro=senha');
        exit();
    }
} else {
    header('Location: ../login.php?erro=usuario');
    exit();
}
?>