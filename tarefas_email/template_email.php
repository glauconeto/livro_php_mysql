<h1>Tarefa: <?= $tarefa['nome'] ?></h1>

<p>
    <strong>Concluída:</strong>
    <?= traduz_concluida($tarefa['concluida']) ?>
</p>
<p>
    <strong>Descricao:</strong>
    <?= nl2br($tarefa['descricao']) ?>
</p>
<p>
    <strong>Prazo:</strong>
    <?= traduz_data($tarefa['prazo']) ?>
</p>
<p>
    <strong>Prioridade:</strong>
    <?= traduz_prioridade($tarefa['prioridade']) ?>
</p>

<?php if (count($anexos) > 0): ?>
    <p><strong>Atenção!</strong> Esta tarefa contém anexos!</p>
<?php endif ?>
<p>Tenha um bom dia!</p>