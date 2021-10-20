<?php

use PHPMailer\PHPMailer\PHPMailer;

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

    if (count($dados) != 3) {
        return $data;
    }

    $data_mysql = "{$dados[2]}-{$dados[1]}-{$dados[0]}";

    return $data_mysql;
}

function traduz_data_br_para_objeto($data)
{
    if ($data == "") {
        return "";
    }

    $dados = explode("/", $data);

    if (count($dados) != 3) {
        return $data;
    }

    return  DateTime::createFromFormat('d/m/Y', $data);
}

function traduz_data($data)
{
    if ($data == "" OR $data == "0000-00-00") {
        return "";
    }
    
    $partes = explode("-", $data);

    if (count($partes) != 3) {
        return $data;
    }
    
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

function tem_post()
{
    if (count($_POST) > 0) {
        return true;
    }

    return false;
}

function validar_data($data)
{
    $padrao = '/^[0-9]{1,2}\/[0,9]{1,2}\/[0-9]{4}$/';
    $resultado = preg_match($padrao, $data);

    if (! $resultado) {
        return false;
    }

    $dados = explode('/', $data);

    $dia = $dados[0];
    $mes = $dados[1];
    $ano = $dados[2];

    return checkdate($mes, $dia, $ano);
}

function tratar_anexo($anexo)
{
    $padrao = '/^.+(\.pdf|\.zip)$/';
    $resultado = preg_match($padrao, $anexo['name']);

    if (! $resultado) {
        return false;
    }

    move_uploaded_file($anexo['tmp_name'], __DIR__ . "/../anexos/{$anexo['name']}");

    return true;
}

function enviar_email($tarefa, $anexos = [])
{
    // Acessar a aplicação de e-mails
    $corpo = preparar_corpo_email($tarefa, $anexos);
    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPAuth = true;
    $email->SMTPSecure = 'tls';
    
    // Fazer a autenticação com usuário e senha
    $email->Username = 'meuemail@gmail.com';
    $email->Password = 'minhasenha';
    
    // Usar a opção para escrever um e-mail
    $email->Host = 'smtp.gmail.com';
    $email->Port = 587;
    
    // Digitar o e-mail de destinatário
    $email->setFrom('meuemail@gmail.com', 'Avisador de Tarefas');
    
    // Digitar o assunto do e-mail
    $email->Subject = "Aviso de tarefa: {$tarefa->getNome()}";
    
    // Escrever o corpo do e-mail
    $email->msgHTML($corpo);
    
    // Adicionar os anexos, quando necessário
    $email->addAddress(EMAIL_NOTIFICACAO);
    
    foreach ($tarefa->getAnexos() as $anexo) {
        $email->addAttachment("/../anexos/{$anexo->getArquivo()}");
    }
    // Usar a opção de enviar o e-mail.
    $email->send();
}

function gravar_log($mensagem)
{
    $dataHora = date("Y-m-d H:i:s");
    $mensagem = "${$dataHora} {$mensagem}\n";

    file_put_contents("mensagens.log", $mensagem, FILE_APPEND);
}

function preparar_corpo_email($tarefa)
{
    // Aqui vamos pegar o conteúdo processado
    // do arquivo template_email.php
    
    // Falar para o PHP que não é para enviar
    // o resultado do processamento para o navegador:
    ob_start();
    include __DIR__ . '/../views/template_email.php';

    // Guardar o conteúdo do arquivo em uma variável;
    $corpo = ob_get_contents();

    // Falar para o PHP que ele pode voltar
    // a mandar conteúdos para o navegador.
    ob_end_clean();

    return $corpo;
}