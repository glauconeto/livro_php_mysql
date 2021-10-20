<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="assets/tarefas.css">
</head>
<body>
    <h1>Gerenciador de Tarefas</h1>

    <?php require 'formulario.php';

    if ($exibir_tabela) : ?>
        <?php require 'tabela.php' ?>
    <?php endif ?>
</body>
</html>