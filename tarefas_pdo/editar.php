<?php

require 'config.php';
require 'banco.php';
require 'ajudantes.php';
require "classes/Tarefa.php";
require "classes/Anexo.php";
require "classes/RepositorioTarefas.php";

$repositorio_tarefas = new RepositorioTarefas($pdo);

try {
    $tarefa = $repositorio_tarefas->buscar($_GET['id']);
} catch (Exception $e) {
    http_response_code(404);
    echo 'Erro ao buscar tarefa: ' . $e->getMessage();
    die();
}

$exibir_tabela = false;
$tem_erros = false;
$erros_validacao = array();

if (tem_post()) {
    if (strlen($_POST['nome']) && strlen($_POST['nome']) > 0) {
        $tarefa->setNome($_POST['nome']);
    } else {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }

    if (isset($_POST['descricao'])) {
        $tarefa->setDescricao($_POST['descricao']);
    } else {
        $tarefa->setDescricao('');
    }

    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        if (validar_data($_POST['prazo'])) {
            $tarefa->setPrazo(traduz_data_para_banco($_POST['prazo']));
        } else {
            $tem_erros = true;
            $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        }
    } else {
        $tarefa->setPrazo(null);
    }

    $tarefa->setPrioridade($_POST['prioridade']);

    if (isset($_POST['concluida'])) {
        $tarefa->setConcluida(true);
    } else {
        $tarefa->setConcluida(false);
    }

    if (! $tem_erros) {
        $repositorio_tarefas->atualizar($tarefa);

        if (isset($_POST['lembrete']) && $_POST['lembrete'] == '1') {
            enviar_email($tarefa);
        }

        header('Location: tarefas.php');
        die();
    }
}

include 'template.php';