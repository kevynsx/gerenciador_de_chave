<?php
require_once('../config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nome = filter_input(INPUT_POST, 'nomecompleto');
    $cpf = filter_input(INPUT_POST, 'cpf');
    $cargo = filter_input(INPUT_POST, 'funcao');
    $senha_em_texto = $_POST['senha'];

    // Criando o hash da senha de forma segura
    $senha_hash = password_hash($senha_em_texto, PASSWORD_DEFAULT);

    // Consulta SQL corrigida para especificar as colunas
    $insertcargo = "INSERT INTO usuarios (nome, cpf, senha, cargo)
                    VALUES (:nome, :cpf, :senha, :cargo)";
    
    $req = $dbh->prepare($insertcargo);
    $req->bindValue(':nome', $nome);
    $req->bindValue(':cpf', $cpf);
    $req->bindValue(':senha', $senha_hash);
    $req->bindValue(':cargo', $cargo);

    if ($req->execute()) {
        header("Location: ../login.php?sucesso=0");
        exit();
    } else {
        header("Location: ../cadastro.php?sucesso=1");
        exit();
    }

} else {
    header("Location: ../cadastro.php");
    exit();
}
?>