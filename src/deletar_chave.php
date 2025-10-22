<?php

require_once('../config.php');
session_start();


if (!isset($_SESSION['nome']) || $_SESSION['tipo'] !== 'Master') {
    header("Location: ../login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['id_chave']) && !empty($_POST['id_chave'])) {
        $id_chave = $_POST['id_chave'];

        try {
            
            $sql = "DELETE FROM chaves WHERE id_chave = :id_chave";
            $stmt = $dbh->prepare($sql);
            
            
            $stmt->bindParam(':id_chave', $id_chave, PDO::PARAM_INT);
            $stmt->execute();

            
            header("Location: ../menu_master.php?sucesso=Chave_deletada_com_sucesso");
            exit;

        } catch (PDOException $e) {
            header("Location: ../menu_master.php?erro=" . urlencode("Erro ao deletar a chave: " . $e->getMessage()));
            exit;
        }
    } else {
        header("Location: ../menu_master.php?erro=ID_da_chave_nÃ£o_especificado");
        exit;
    }
} else {
    
    header("Location: ../menu_master.php");
    exit;
}
?>