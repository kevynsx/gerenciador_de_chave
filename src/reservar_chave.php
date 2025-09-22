<?php
require_once('../../config/dbConnect.php');

date_default_timezone_set('America/Recife');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Captura os dados do formulário
    $id = filter_input(INPUT_POST, 'funcionario');
    $sala = filter_input(INPUT_POST, 'chave');
    $data_hora_atual = date("Y-m-d H:i:s");
 
    try {
        // Insere o registro com `data_dev` como NULL
        $sqlRegistro = "INSERT INTO registro (data_emp, data_dev, id_chave, id_func) VALUES (:data_emp, NULL, :id_chave, :id_func)";
        $stmtRegistro = $dbh->prepare($sqlRegistro);

        $stmtRegistro->bindValue(':data_emp', $data_hora_atual);
        $stmtRegistro->bindValue(':id_chave', $sala); // Substitua por uma consulta real para obter o ID correto da chave
        $stmtRegistro->bindValue(':id_func', $id); // Substitua por uma consulta real para obter o ID correto do funcionário

        if ($stmtRegistro->execute()) {
            header("Location: ../../views/retirar_chave.php?sucesso=1");
        } else {
            header("Location: ../../views/retirar_chave.php?erro=0");
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: ../../views/retirar_chave.php");
}