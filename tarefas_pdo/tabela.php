<table>
    <tr>
        <th>Tarefa</th>
        <th>Descricao</th>
        <th>Prazo</th>
        <th>Prioridade</th>
        <th>Concluída</th>
        <th>Opções</th>
    </tr>
    <?php foreach ($tarefas as $tarefa) : ?>
        <tr>
            <td>
                <a href="tarefa.php?id=<?= $tarefa->getId() ?>">
                    <?= htmlentities($tarefa->getNome()) ?>
                </a>
            </td>
            <td>
                <?= htmlentities($tarefa->getDescricao()) ?>
            </td>
            <td>
                <?= traduz_data($tarefa->getPrazo()) ?>
            </td>
            <td>
                <?= traduz_prioridade($tarefa->getPrioridade()) ?>
            </td>
            <td>
                <?= traduz_concluida($tarefa->getConcluida()) ?>
            </td>
            <td>
                <a href="editar.php?id=<?= $tarefa->getId() ?>">
                    Editar
                </a>
                <a href="remover.php?id=<?= $tarefa->getId() ?>">
                    Remover
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>