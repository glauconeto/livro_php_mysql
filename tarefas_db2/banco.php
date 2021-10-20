<?php

$bdServidor = 'localhost';
$bdUsuario = 'neto';
$bdSenha = 'netozica';
$bdBanco = 'tarefas_livros';

$conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

if (mysqli_connect_error($conexao)) {
    echo "Problemas para conectar no banco. Erro: ";
    echo mysqli_connect_error();
    die();
}

function buscar_tarefas($conexao, $id)
{
    $sqlBusca = 'SELECT * FROM tarefas WHERE id = ' . $id;
    $resultado = mysqli_query($conexao, $sqlBusca);
    $tarefas = [];

    return mysqli_fetch_assoc($resultado);
}

function gravar_tarefas($conexao, $tarefa) 
{
    if ($tarefa['prazo'] == '') {
        $prazo = 'NULL';
    } else {
        $prazo = "'{$tarefa['prazo']}'";
    }

    $sqlGravar = "
        INSERT INTO tarefas
        (nome, descricao, prioridade, prazo, concluida)
        VALUES
        (
            '{$tarefa['nome']}',
            '{$tarefa['descricao']}',
            {$tarefa['prioridade']},
            {$prazo},
            {$tarefa['concluida']}
        )";

    mysqli_query($conexao, $sqlGravar);
}

function editar_tarefa($conexao, $tarefa)
{
    if ($tarefa['prazo'] == '') {
        $prazo = 'NULL';
    } else {
        $prazo = "'{$tarefa['prazo']}";
    }

    $sqlEditar = "
        UPDATE tarefas SET
            nome = '{$tarefa['nome']}',
            descricao = '{$tarefa['descricao']}',
            prioridade = {$tarefa['prioridade']},
            prazo = {$prazo},
            concluida = {$tarefa['concluida']}
        WHERE id = {$tarefa['id']}
    ";

    mysqli_query($conexao, $sqlEditar);
}

function remover_tarefa($conexao, $id)
{
    $sqlRemover = "DELETE FROM tarefas WHERE id = {$id}";

    mysqli_query($conexao, $sqlRemover);
}