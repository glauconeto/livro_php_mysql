<?php

session_start();

require 'config.php';
require 'banco.php';
require 'ajudantes.php';

$exibir_tabela = false;

$tem_erros = false;
$erros_validacao = [];

if (tem_post()) {
    $tarefa = [];

    if (strlen($tarefa['nome']) == 0) {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }

    if (!$tem_erros) {
        gravar_tarefas($conexao, $tarefa);

        if (array_key_exists($conexao, $tarefa) && $_POST['lembrete'] == '1') {
            enviar_email($tarefa);
        }

        header('Location: tarefas.php');
        die();
    }

    $tarefa['nome'] = $_POST['nome'];

    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_POST['descricao'];
    }

    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        if (validar_data($_POST['prazo']) > 0) {
            $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
        } else {
            $tem_erros = true;
            $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        }
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
    'nome'       => $_POST['nome'] ?? '',
    'descricao'  => $_POST['descricao'] ?? '',
    'prazo'      => (isset($_POST['prazo'])) ? traduz_data_para_banco($POST['prazo']) : '',
    'prioridade' => $_POST['prioridade'] ?? 1,
    'concluida'  => ''
);

require 'template.php';