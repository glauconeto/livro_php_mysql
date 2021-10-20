<?php

session_start();

require 'banco.php';
require 'ajudantes.php';

if (array_key_exists('nome', $_GET) && $_GET['nome'] != '') {
    $tarefa = [
        'nome' => $_GET['nome'],
        'descricao' => '',
        'prazo' => '',
        'prioridade' => $_GET['prioridade'],
        'concluida' => 0
    ];

    $tarefa['nome'] = $_GET['nome'];

    if (array_key_exists('descricao', $_GET)) {
        $tarefa['descricao'] = $_GET['descricao'];
    }

    if (array_key_exists('prazo', $_GET)) {
        $tarefa['prazo'] = traduz_data_para_banco($_GET['prazo']);
    }

    $tarefa['prioridade'] = $_GET['prioridade'];

    if (array_key_exists('concluida', $_GET)) {
        $tarefa['concluida'] = $_GET['concluida'];
    }

    gravar_tarefas($conexao, $tarefa);
}

$lista_tarefas = buscar_tarefas($conexao);

require 'template.php';
