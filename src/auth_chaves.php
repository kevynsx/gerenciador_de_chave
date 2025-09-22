<?php 

require_once ('../config.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $codigo_chave = filter_input(INPUT_POST,'codigo_chave');
    $descricao = filter_input(INPUT_POST,'descricao');
    $localizacao  = filter_input(INPUT_POST, 'localizacao');

    $insertchave = "INSERT INTO chaves (codigo_chave, descricao, localizacao) VALUES (:codigo_chave, :descricao, :localizacao)";

    $req = $dbh->prepare($insertchave);
    $req->bindValue(":codigo_chave", $codigo_chave);
    $req->bindValue(":localizacao", $localizacao);
    $req->bindValue(":descricao", $descricao);
    if ($req->execute()) {
        header("Location: ../menu_master.php?sucesso=0 ");
    }
    else {
        echo 'Erro chave nao cadastrada!';
}
}