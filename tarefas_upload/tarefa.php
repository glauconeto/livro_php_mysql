<?php

include 'banco.php';
include 'ajudantes.php';

$tarefa = buscar_tarefa($conexao, $_GET['id']);

if (! is_array($tarefa)) {
    http_response_code(404);
    echo 'Tarefa não encontrada';
    die();
}

$tem_erros = false;
$erros_validacao = [];

if (tem_post()) {
    // upload dos anexos
    $tarefa_id = $_POST['id'];

    if (! array_key_exists('anexo', $_FILES)) {
        $tem_erros = true;
        $erros_validacao['anexo'] = 'Você deve selecionar um arquivo para anexar';
    } else {
        if (tratar_anexos($_FILES['anexo'])) {
            $nome = $_FILES['anexo']['nome'];
            $anexo = [
                'tarefa_id' => $tarefa_id,
                'nome' => substr($nome, 0, -4),
                'arquivo' => $nome
            ];
        } else {
            $tem_erros = true;
            $erros_validacao['anexo'] = 'Envie anexos nos formatos zip ou pdf';
        }
    }

    if (! $tem_erros) {
        gravar_anexo($conexao, $anexo);
    }
}

$tarefa = buscar_tarefa($conexao, $_GET['id']);
$anexos = buscar_tarefa($conexao, $_GET['id']);

include 'template_tarefa.php';