<?php

function traduz_prioridade($codigo)
{
    $prioridade = '';

    switch ($codigo) {
        case 1:
            $prioridade = 'baixa';
            break;
        case 2:
            $prioridade = 'média';
            break;
        case 3:
            $prioridade = 'alta';
            break;
    }

    return $prioridade;
}

function traduz_data_para_banco($data)
{
    if ($data == "") {
        return "";
    }

    $dados = explode("/", $data);
    // $dados = DateTime::createFromFormat('d/m/Y', $data);

    $data_mysql = "{$dados[2]}-{$dados[1]}-{$dados[0]}";

    return $data_mysql;
}

function traduz_data($data)
{
    if ($data == "" OR $data == "0000-00-00") {
        return "";
    }
    
    # $dados = explode("-", $data);
    $objeto_data = DateTime::createFromFormat('Y-m-d', $data);
    
    return $objeto_data->format('d/m/Y');
}

function traduz_concluida($concluida)
{
    if ($concluida == 1) {
        return 'Sim';
    }
    
    return 'Não';
}