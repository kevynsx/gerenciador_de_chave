<?php
require_once('../config.php'); 

$id_chave = $_GET['id_chave'];
$id_chave = intval($id_chave);

// Situacão da chave.
$sqlDisponivel = "UPDATE chaves SET disponivel = 0 WHERE id_chave = $id_chave;";

$stmt = $dbh->query($sqlDisponivel);

if($stmt){
        header("Location: ../login.php?sucesso=1");
        exit();
}else {
        header("Location: menu_master?sucesso=0");
        exit();
}

?>
