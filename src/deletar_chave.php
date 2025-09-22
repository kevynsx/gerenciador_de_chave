<?php



// O resto do seu cÃ³digo comeÃ§a aqui
require_once('../config.php');
// ...

// Inclui o arquivo de configuraÃ§Ã£o para a conexÃ£o com o banco de dados.
// O caminho '../' sobe um nÃ­vel na hierarquia de pastas.
require_once('../config.php');
session_start();

// 1. SEGURANÃ‡A: Verifica se o usuÃ¡rio estÃ¡ logado e se Ã© um Master.
// Acesso direto a este arquivo Ã© bloqueado para usuÃ¡rios nÃ£o autorizados.
if (!isset($_SESSION['nome']) || $_SESSION['tipo'] !== 'Master') {
    header("Location: ../login.php");
    exit;
}

// 2. VERIFICAÃ‡ÃƒO DE MÃ‰TODO: Garante que a requisiÃ§Ã£o veio de um formulÃ¡rio (POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3. VALIDAÃ‡ÃƒO DE DADOS: Verifica se o ID da chave foi enviado.
    if (isset($_POST['id_chave']) && !empty($_POST['id_chave'])) {
        $id_chave = $_POST['id_chave'];

        try {
            // 4. DELEÃ‡ÃƒO SEGURA: Usa uma consulta preparada para evitar SQL Injection.
            // A consulta SQL DELETE apaga a linha na tabela 'chaves' com o ID especificado.
            $sql = "DELETE FROM chaves WHERE id_chave = :id_chave";
            $stmt = $dbh->prepare($sql);
            
            // Associa o parÃ¢metro ':id_chave' com a variÃ¡vel $id_chave.
            $stmt->bindParam(':id_chave', $id_chave, PDO::PARAM_INT);
            $stmt->execute();

            // 5. FEEDBACK E REDIRECIONAMENTO: Redireciona para a pÃ¡gina principal com uma mensagem de sucesso.
            header("Location: ../menu_master.php?sucesso=Chave_deletada_com_sucesso");
            exit;

        } catch (PDOException $e) {
            // Em caso de erro do banco de dados, redireciona com uma mensagem de erro detalhada.
            header("Location: ../menu_master.php?erro=" . urlencode("Erro ao deletar a chave: " . $e->getMessage()));
            exit;
        }
    } else {
        // Se o ID da chave nÃ£o foi enviado, redireciona com um erro.
        header("Location: ../menu_master.php?erro=ID_da_chave_nÃ£o_especificado");
        exit;
    }
} else {
    // Se a requisiÃ§Ã£o nÃ£o for POST, redireciona para a pÃ¡gina principal.
    header("Location: ../menu_master.php");
    exit;
}
?>