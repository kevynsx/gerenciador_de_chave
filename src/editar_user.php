<?php
require '../config.php';

// --- PEGAR ID DO FORM (POST) ---
if (!isset($_POST['id_usuario'])) {
    die("ID do usuário não informado.");
}

$id = intval($_POST['id_usuario']);

// --- BUSCAR DADOS DO USUÁRIO ---
$stmt = $dbh->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

// --- SE O FORM FOI ENVIADO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegando dados do formulário
    $nome = $_POST['nome'];      // name do input do formulário
    $cpf = $_POST['cpf'];
    $cargo = $_POST['funcao'];   // name="funcao" → coluna no banco é cargo

    // Atualizando no banco
    $sql = "UPDATE usuarios SET nome = ?, cpf = ?, cargo = ? WHERE id_usuario = ?";
    $update = $dbh->prepare($sql);

    if ($update->execute([$nome, $cpf, $cargo, $id])) {
        header("Location: ../menu_master.php?sucesso=1");
        exit;
    } else {
        echo "Erro ao atualizar usuário.";
    }
}
?>

