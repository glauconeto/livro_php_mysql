<h1>Tarefa: <?= $tarefa->getNome() ?></h1>

<p>
    <strong>Concluída:</strong>
    <?= traduz_concluida($tarefa->getConcluida()) ?>
</p>
<p>
    <strong>Descricao:</strong>
    <?= nl2br($tarefa->getDescricao()) ?>
</p>
<p>
    <strong>Prazo:</strong>
    <?= traduz_data($tarefa->getPrazo()) ?>
</p>
<p>
    <strong>Prioridade:</strong>
    <?= traduz_prioridade($tarefa->getPrioridade()) ?>
</p>

<?php if (count($tarefa->getAnexos()) > 0): ?>
    <p><strong>Atenção!</strong> Esta tarefa contém anexos!</p>
<?php endif ?>
<p>Tenha um bom dia!</p>