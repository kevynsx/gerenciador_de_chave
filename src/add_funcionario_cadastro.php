<?php 
//Lógica de inserção na tabela professor
require_once ('../../config/dbConnect.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $nome = filter_input(INPUT_POST, 'nome');
    $telefone = filter_input(INPUT_POST, 'telefone');
    $cargo = filter_input(INPUT_POST, 'cargo');
    $email = filter_input(INPUT_POST, 'email');

    $insertProf = "INSERT INTO func (nome, contato, cod_tip_func, email) VALUES (:nome, :contato, :cod_tip_func, :email)";
    $req = $dbh->prepare($insertProf);
    $req->bindValue(':nome', $nome);
    $req->bindValue(':contato', $telefone);
    $req->bindValue(':cod_tip_func', $cargo);
    $req->bindValue(':email', $email);
    if($req->execute()){
        header("Location: ../../views/add_fun.php?sucesso=1");

    }else{
        header("Location: ../../views/add_fun.php?sucesso=0");
    }

}else{
    header("Location: ../../views/add_fun.php");
}
?>