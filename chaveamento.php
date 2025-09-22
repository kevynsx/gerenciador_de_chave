<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="../css/fucionario_chaveamento.css">
    <title>Chave</title>
</head>

<body>
    <div class="retangulo-superior">
        <div class="keybox">
            <img src="../imagem/logo.png" alt="keybox">
        </div>
        <div class="imglogosenac">
            <img src="../imagem/logosenac.png" alt="logosenac" class="img_senac_logo">
        </div>
    </div>
    <nav class="navegacao">
        <div class="naveg-esq">
            <a href="index_menu.php" class="nav-link">Início</a>
        </div>
        <div class="naveg-dir">
            <a  class="link-add" href="adicionar_chave.php">Adicionar Chave</a>
            <a href="../src/controller/sair.php" class="link-sair">Sair</a>
        </div>      
    </nav>
    <h1 class="titulo-principal"> Chaves </h1>
    <section class="secao-tabela">
            <?php
            require_once('../src/controller/quant_chaveamento.php');
            if (count($chaves) > 0): ?>
                <table id="tabela" class="display tabela-principal">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chaves as $chave): ?>
                            <tr>
                                <td class="num-chave"><?php echo htmlspecialchars($chave['numero']); ?></td>
                                <td><?php echo htmlspecialchars($chave['descricao']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="mensagem-vazia">Nenhuma chave cadastrada.</p>
            <?php endif; ?>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#tabela').DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    }
                });
            });
        </script>
</body>

</html>