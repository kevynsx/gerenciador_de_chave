<?php

require '../config.php';

// --- PEGAR ID DO FORM (POST) ---
if (!isset($_POST['id_usuario'])) {
    die("ID do usuário não informado.");
}

$id = intval($_POST['id_usuario']);
var_dump($id);

// --- BUSCAR DADOS DO USUÁRIO ---
$stmt = $dbh->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

// --- SE O FORM FOI ENVIADO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_completo = $_POST['nome_completo'];
    $cpf = $_POST['cpf'];
    $funcao = $_POST['funcao'];

    $sql = "UPDATE usuarios SET nome_completo = ?, cpf = ?, funcao = ? WHERE id_usuario = ?";
    $update = $dbh->prepare($sql);

    if ($update->execute([$nome_completo, $cpf, $funcao, $id])) {
        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='lista_users.php';</script>";
        exit;
    } else {
        echo "Erro ao atualizar usuário.";
    }
}
?>
