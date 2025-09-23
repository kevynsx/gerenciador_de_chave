<?php
// src/devolver_chave.php
date_default_timezone_set('America/Recife');
require_once('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_chave'])) {
    $id_chave = $_POST['id_chave'];

    try {
        // Inicia uma transação para garantir que ambas as operações sejam bem-sucedidas
        $dbh->beginTransaction();

        // 1. Atualiza a situação da chave para 'Disponível'
        $sqlChave = "UPDATE chaves SET situacao = 'Disponível' WHERE id_chave = ?";
        $stmtChave = $dbh->prepare($sqlChave);
        $stmtChave->execute([$id_chave]);

        // 2. Registra a devolução na tabela de movimentações
        $tipo = "devolucao";
        $data_hora = date('Y-m-d H:i:s');
        $id_porteiro = 1; // Substitua por uma variável de sessão ou autenticação

        $sqlMov = "INSERT INTO movimentacoes (id_chave, tipo, data_hora, id_usuario) VALUES (?, ?, ?, ?)";
        $stmtMov = $dbh->prepare($sqlMov);
        $stmtMov->execute([$id_chave, $tipo, $data_hora, $id_porteiro]);

        // Finaliza a transação
        $dbh->commit();

        // Redireciona de volta para a página principal
        header("Location: ../menu_porteiro.php?status=devolvido");
        exit();

    } catch (PDOException $e) {
        // Em caso de erro, desfaz a transação
        $dbh->rollBack();
        echo "Erro ao devolver a chave: " . $e->getMessage();
    }
} else {
    echo "Requisição inválida.";
}
?>