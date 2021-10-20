<?php

session_start();

require 'config.php';
require 'banco.php';
require 'ajudantes.php';

$exibir_tabela = false;
$tem_erros = false;
$erros_validacao = [];

if (tem_post()) {
    $tarefa = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'descricao' => '',
        'prioridade' => $_POST['prioridade'],
        'concluida' => 0,
    ];

    $tarefa['id'] = $_POST['id'];
    
    if (strlen($tarefa['nome'])) {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    } else {
        $tarefa['nome'] = $_POST['nome'];
    }

    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_POST['descricao'];
    } else {
        $tarefa['descricao'] = '';
    }

    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        if (validar_data($_POST['prazo'])) {
            $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
        } else {
            $tem_erros = true;
            $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        }
    }

    if (array_key_exists('concluida', $_POST)) {
        $tarefa['concluida'] = $_POST['concluida'];
    } else {
        $tarefa['concluida'] = 0;
    }

    if (! $tem_erros) {
        editar_tarefa($conexao, $tarefa);

        if (array_key_exists('lembrete', '$_POST') && $_POST['lembrete'] == '1') {
            $anexos = buscar_anexos($conexao, $tarefa['id']);
            enviar_email($tarefa, $anexos);
        }

        header('Location: tarefas.php');
        die();
    }
}

$tarefa = buscar_tarefas($conexao, $_POST['id']);

$tarefa['nome'] = (array_key_exists('nome', $_POST) ? $_POST['nome'] : $tarefa['nome']);
$tarefa['descricao'] = (array_key_exists('descricao', $_POST) ? $_POST['descricao'] : $tarefa['descricao']);
$tarefa['prazo'] = (array_key_exists('prazo', $_POST) ? $_POST['prazo'] : $tarefa['prazo']);
$tarefa['prioridade'] = (array_key_exists('prioridade', $_POST) ? $_POST['prioridade'] : $tarefa['prioridade']);
$tarefa['concluida'] = (array_key_exists('concluida', $_POST) ? $_POST['concluida'] : $tarefa['concluida']);

include 'template.php';