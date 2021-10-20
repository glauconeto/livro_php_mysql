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
                <a href="index.php?rota=tarefa&id=<?= $tarefa->getId() ?>">
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
                <a href="index.php?rota=editar&id=<?= $tarefa->getId() ?>">
                    Editar
                </a>
                <a href="index.php?rota=remover&id=<?= $tarefa->getId() ?>">
                    Remover
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>