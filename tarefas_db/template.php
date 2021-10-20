<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gerenciador de Tarefas</h1>
    <form>
        <fieldset>
            <legend>Nova tarefa</legend>
            <label>
                Tarefa:
                <input type="text" name="nome">
            </label>
        </fieldset>
        
        <label>
            Descrição (Opcional):
            <textarea name="descricao" cols="30" rows="10"></textarea>
        </label>
        <label>
            Prazo (Opcional):
            <input type="text" name="prazo">
        </label>
        <fieldset>
            <legend>Prioridade:</legend>
            <label>
                <input type="radio" name="prioridade" value="1" checked>Baixa
                <input type="radio" name="prioridade" value="2">Media
                <input type="radio" name="prioridade" value="3">Alta
            </label>
        </fieldset>
        <label>
            Tarefa Concluída:
            <input type="checkbox" name="concluida" value="1">
        </label>
        <input type="submit" value="Cadastrar">
    </form>
    <table>
        <tr>
            <th>Tarefas</th>
            <th>Descrição</th>
            <th>Prazo</th>
            <th>Prioridade</th>
            <th>Concluida</th>
        </tr>
        <?php foreach ($lista_tarefas as $tarefa): ?>
            <tr>
                <td><?= $tarefa['nome'] ?></td>
                <td><?= $tarefa['descricao'] ?></td>
                <td><?= traduz_data($tarefa['prazo']) ?></td>
                <td><?= traduz_prioridade($tarefa['prioridade']) ?></td>
                <td><?= traduz_concluida($tarefa['concluida']) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</body>
</html>