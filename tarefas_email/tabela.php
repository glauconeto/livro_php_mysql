<table>
    <tr>
        <th>Tarefa</th>
        <th>Descricao</th>
        <th>Prazo</th>
        <th>Prioridade</th>
        <th>Concluída</th>
        <th>Opções</th>
    </tr>
    <?php foreach ($lista_tarefas as $tarefa) : ?>
        <tr>
            <td>
                <a href="tarefa.php?id=<?= $tarefa['id'] ?>">
                    <?= $tarefa['nome']; ?>
                </a>
            </td>
            <td>
                <?= $tarefa['descricao']; ?>
            </td>
            <td>
                <? traduz_data_para_exibir($tarefa['prazo']); ?>
            </td>
            <td>
                <? traduz_prioridade($tarefa['prioridade']); ?>
            </td>
            <td>
                <? traduz_concluida($tarefa['concluida']); ?>
            </td>
            <td>
                <a href="editar.php?id=<? $tarefa['id']; ?>">
                    Editar
                </a>
                <a href="remover.php?id=<? $tarefa['id']; ?>">
                    Remover
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>