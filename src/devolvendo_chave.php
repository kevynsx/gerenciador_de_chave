<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_chave = $_POST['id_chave'];
    $observacao = $_POST['observacao'] ?? '';

    // 1. Verificar se a chave está disponível
    $sqlVerifica = "SELECT situacao FROM chaves WHERE id_chave = :id_chave";
    $stmt = $dbh->prepare($sqlVerifica);
    $stmt->bindValue(':id_chave', $id_chave);
    $stmt->execute();
    $chave = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($chave && $chave['situacao'] === 'Disponível') {
        // 2. Inserir movimentação de retirada
        $sqlInsert = "INSERT INTO movimentacoes (id_chave, id_usuario, tipo, observacao) 
                      VALUES (:id_chave, :id_usuario, 'retirada', :observacao)";
        $stmtInsert = $dbh->prepare($sqlInsert);
        $stmtInsert->bindValue(':id_chave', $id_chave);
        $stmtInsert->bindValue(':id_usuario', $id_usuario);
        $stmtInsert->bindValue(':observacao', $observacao);
        $stmtInsert->execute();

        // 3. Atualizar situação da chave
        $sqlUpdate = "UPDATE chaves SET situacao = 'Emprestada' WHERE id_chave = :id_chave";
        $stmtUpdate = $dbh->prepare($sqlUpdate);
        $stmtUpdate->bindValue(':id_chave', $id_chave);
        $stmtUpdate->execute();

        echo "Chave retirada com sucesso!";
    } else {
        echo "Chave não disponível para retirada!";
    }
}
?>
