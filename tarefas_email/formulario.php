<form method="post">
    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
    <fieldset>
        <legend>Nova tarefa</legend>
            <label>
                Tarefa:
                <?php if ($tem_erros && array_key_exists('nome', $erros_validacao)): ?>
                    <span class="erro">
                        <?= $erros_validacao['nome'] ?>
                    </span>
                <?php endif; ?>
                <input type="text" name="nome" value="<?= $tarefa['nome'] ?>">
            </label>
    </fieldset>
    <label>
        Descrição (Opcional):
        <textarea name="descricao"><?= $tarefa['descricao'] ?></textarea>
    </label>
    <label>
        Prazo (Opcional):
        <?php if ($tem_erros && array_key_exists('prazo', $erros_validacao)): ?>
            <span class="erro">
                <?= $erros_validacao['prazo'] ?> 
            </span>
        <?php endif; ?>
        <input type="text" name="prazo" value="<?= traduz_data($tarefa['prazo']) ?>">
    </label>
    <fieldset>
        <legend>Prioridade:</legend>
        <label>
            <input type="radio" name="prioridade" value="1" <?= ($tarefa['prioridade'] == 1) ? 'checked' : ''; ?> /> Baixa
            <input type="radio" name="prioridade" value="2" <?= ($tarefa['prioridade'] == 2) ? 'checked' : ''; ?> /> Média
            <input type="radio" name="prioridade" value="3" <?= ($tarefa['prioridade'] == 3) ? 'checked' : ''; ?> /> Alta
        </label>
    </fieldset>
    <label>
        Tarefa Concluída:
        <input type="checkbox" name="concluida" value="1" <?= ($tarefa['concluida'] == 1) ? 'checked' : ''; ?> />
    </label>
        <input type="submit" value="<?= ($tarefa['id'] > 0) ? 'Atualizar' : 'Cadastrar'; ?>" />
    <label>
        Lembrete por e-mail:
        <input type="checkbox" name="lembrete" id="1">
    </label>
</form>