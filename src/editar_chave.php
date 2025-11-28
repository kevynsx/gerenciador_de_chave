<?php
require_once ('../config.php');

// validar o id vindo da URL
$id = filter_input(INPUT_GET, 'id_chave', FILTER_VALIDATE_INT);
//var_dump($id);
//exit();
if ($id === false || $id === null) {
    die("ID inválido");
}
$stmt = $dbh->prepare("SELECT * FROM chaves WHERE id_chave = :id_chave");
$stmt->execute([':id_chave' => $id]);
$chave = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$chave) {
    die("chave não encontrada");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $codigo_chave = ($_GET['numerodachave']);
    $descricao = ($_GET['descricao']);
    $localizacao = ($_GET['localizacao']);


    // atualizar no banco
    $stmt = $dbh->prepare('UPDATE chaves SET codigo_chave = :codigo_chave, descricao = :descricao , localizacao = :localizacao WHERE id_chave = :id_chave');
    $stmt->execute([
        ':id_chave'=>$id,
        ':codigo_chave'=>$codigo_chave,
        ':descricao' => $descricao,
        ':localizacao'=> $localizacao
    ]);

    
    header("location: ../menu_master.php?sucesso=0");
}