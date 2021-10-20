<?php

try {
    $anexo = $repositorio_tarefas->buscar_anexo($_GET['id']);
} catch (Exception $e) {
    http_response_code(404);
    echo 'Erro ao buscar anexo: ' . $e->getMessage();
    die();
}

$anexo = $repositorio_tarefas->buscar_anexos($_GET['id']);
$repositorio_tarefas->remover_anexo($anexo->getId());
unlink(__DIR__ . '/../anexos/' . $anexo->getArquivo());

header('Location: index.php?rota=tarefa&id=' . $anexo->getTarefaId());