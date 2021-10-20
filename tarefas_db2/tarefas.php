<?php

ini_set('display_errors', true);

session_start();

require 'banco.php';
require 'ajudantes.php';

$exibir_tabela = false;

if (array_key_exists('nome', $_POST) && $_POST['nome'] != '') {
    $tarefa = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'descricao' => '',
        'prazo' => '',
        'prioridade' => $_POST['prioridade'],
        'concluida' => 0
    ];

    if (strlen($tarefa['nome']) == 0) {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }

    $tarefa['nome'] = $_POST['nome'];

    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_POST['descricao'];
    }

    if (array_key_exists('prazo', $_POST)) {
        $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
    }

    $tarefa['prioridade'] = $_POST['prioridade'];

    if (array_key_exists('concluida', $_POST)) {
        $tarefa['concluida'] = $_POST['concluida'];
    }

    gravar_tarefas($conexao, $tarefa);
}

$lista_tarefas = buscar_tarefas($conexao);

$tarefa = array(
    'id'         => 0,
    'nome'       => '',
    'descricao'  => '',
    'prazo'      => '',
    'prioridade' => 1,
    'concluida'  => ''
);

require 'template.php';