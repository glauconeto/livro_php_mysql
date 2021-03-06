<?php

require 'config.php';
require 'banco.php';
require 'classes/RepositorioTarefas.php';

$repositorio_tarefas = new RepositorioTarefas($pdo);
$anexo = $repositorio_tarefas->buscar_anexo($_GET['id']);
$repositorio_tarefas->remover_anexo($anexo->getId());

unlink('anexos/' . $anexo['arquivo']);

header('Location: tarefa.php?id=' . $anexo->getTarefaId());