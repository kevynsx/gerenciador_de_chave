
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Adicionar Chave</title>
    <link rel="stylesheet" href="css/chave.css">
    <link rel="icon" href="../imagens/Senac.png" type="image/x-icon">
</head>
<body>
    <div class="addchave">
        <div class="addchaveform">
            <h1 class="addchaveformtitulo">Adicionar nova chave</h1>
            <form action="src/auth_chaves.php" method="post">
                <div class="addchaveforminputs">
                    <div class="addchaveformobj">
                    <label for="numerodachave">Número da chave</label>
                <input type="text" name="codigo_chave" id="codigo_chave" placeholder="ex. 001, A-01, 15, etc"required></div>
                <div class="addchaveformobj">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" placeholder="ex. Sala 101, Laboratório de Informática, Laboratório Maker" id="descricao">
                </div>
                <div class="addchaveformobj">
                <label for="localizacao">Localização</label>
                <input type="text" id="localizacao" name="localizacao" placeholder="ex. 1º andar, Bloco A, Corredor 2"></div></div>
                <div class="addchaveformbotaoarea">
                <input type="submit" value="Adicionar Chave" class="addchaveformbotao"></div>
            </form>
        </div>
    </div>
</body>
</html>

