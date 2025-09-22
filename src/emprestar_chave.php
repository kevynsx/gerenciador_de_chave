<?php
// src/emprestar_chave.php

require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_chave'])) {
    $id_chave = $_POST['id_chave'];
    $solicitante = $_POST['solicitante'];
    $documento = $_POST['documento'];
    $observacoes = $_POST['observacao'];
    $tipo = "retirada";
    $data_hora = date('Y-m-d H:i:s');
    $id_porteiro = 1; // Substitua pelo ID do usuário logado

    try {
        // Inicia uma transação
        $dbh->beginTransaction();

        // 1. ATUALIZA A SITUAÇÃO DA CHAVE PARA 'Emprestada'
        $sqlChave = "UPDATE chaves SET situacao = 'Emprestada' WHERE id_chave = ?";
        $stmtChave = $dbh->prepare($sqlChave);
        $stmtChave->execute([$id_chave]);

        // 2. REGISTRA A MOVIMENTAÇÃO DE RETIRADA
        $sqlMov = "INSERT INTO movimentacoes (id_chave, tipo, data_hora, solicitante, documento, observacao, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtMov = $dbh->prepare($sqlMov);
        $stmtMov->execute([$id_chave, $tipo, $data_hora, $solicitante, $documento, $observacoes, $id_porteiro]);

        // Finaliza a transação
        $dbh->commit();

        // Redireciona de volta
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