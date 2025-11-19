<?php


require_once('../config.php');
session_start();

date_default_timezone_set('America/Recife');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_chave'])) {
    $id_chave = $_POST['id_chave'];
    $solicitante = $_POST['solicitante'];
    $documento = $_POST['documento'];
    $observacoes = $_POST['observacao'];
    $tipo = "retirada";
    $data_hora = date('Y-m-d H:i:s');
    $id_porteiro = $_SESSION['id_usuario'];

    try {
        
        $dbh->beginTransaction();

        
        $sqlChave = "UPDATE chaves SET situacao = 'Emprestada' WHERE id_chave = ?";
        $stmtChave = $dbh->prepare($sqlChave);
        $stmtChave->execute([$id_chave]);

        
        $sqlMov = "INSERT INTO movimentacoes (id_chave, tipo, data_hora, solicitante, documento, observacao, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtMov = $dbh->prepare($sqlMov);
        $stmtMov->execute([$id_chave, $tipo, $data_hora, $solicitante, $documento, $observacoes, $id_porteiro]);

        $dbh->commit();
        header("Location: ../menu_porteiro.php?sucesso=1");
        exit();

    } catch (PDOException $e) {
        $dbh->rollBack();
        echo "Erro ao emprestar a chave: " . $e->getMessage();
    }
} else {
    echo "Requisição inválida.";
}
?>