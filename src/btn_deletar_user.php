<?php
require_once('../config.php'); 

$id_usuario = $_GET['id_usuario'];
$id_usuario = intval($id_usuario);

// Situacão da chave.
$sqlDisponiveluser = "UPDATE usuarios SET disponivel = 0 WHERE id_usuario = $id_usuario;";

$stmt = $dbh->query($sqlDisponiveluser);

if($stmt){
        header("Location: ../menu_master.php?sucesso=1");
        exit();
}else {
        header("Location: ../menu_master.php?sucesso=0");
        exit();
}

?>