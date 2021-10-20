<?php

require 'Anexo.php';

class RepositorioTarefas
{
    private $conexao;

    public function __construct(mysqli $conexao)
    {
        $this->conexao = $conexao;
    }

    public function salvar(Tarefa $tarefa)
    {
        $nome = strip_tags($this->conexao->escape_string(
            $tarefa->getNome()
        ));
        $descricao = strip_tags($this->conexao->escape_string(
            $tarefa->getDescricao()
        ));
        $prioridade = $tarefa->getPrioridade();
        $prazo = $tarefa->getPrazo();
        $concluida = ($tarefa->getConcluida()) ? 1 : 0;

        if (is_object($prazo)) {
            $prazo = "'{$prazo->format('Y-m-d')}'";
        } elseif ($prazo == '') {
            $prazo = 'NULL';
        } else {
            $prazo = "'{$prazo}'";
        }

        $sqlGravar = "
            INSERT INTO tarefas (nome, descricao, prioridade, prazo, concluida)
            VALUES ('{$nome}', '{$descricao}', '{$prioridade}', {$prazo}, '{$concluida}')";

        $this->conexao->query($sqlGravar);
    }

    public function atualizar(Tarefa $tarefa)
    {
        $id = $tarefa->getId();
        $nome = strip_tags($this->conexao->escape_string(
            $tarefa->getNome()
        ));
        $descricao = strip_tags($this->conexao->escape_string(
            $tarefa->getDescricao()
        ));
        $prioridade = $tarefa->getPrioridade();
        $prazo = $tarefa->getPrazo();
        $concluida = ($tarefa->getConcluida()) ? 1 : 0;

        if (is_object($prazo)) {
            $prazo = "'{$prazo->format('Y-m-d')}'";
        } elseif ($prazo == '') {
            $prazo = 'NULL';
        } else {
            $prazo = "'{$prazo}'";
        }

        $sqlEditar = "UPDATE tarefas SET
            nome = '{$nome}',
            descricao = '{$descricao}',
            prioridae = '{$prioridade}',
            prazo = '{$prazo}'
            concluida = '{$concluida}'
        WHERE id = {$id}";

        $this->conexao->query($sqlEditar);
    }

    public function buscar(int $tarefa_id = 0): Tarefa|array
    {
        if ($tarefa_id > 0) {
            return $this->buscar_tarefa($tarefa_id);
        } else {
            return $this->buscar_tarefas();
        }
    }

    public function buscar_tarefas(): array
    {
        $sqlBusca = "SELECT * FROM tarefas";
        $resultado = $this->conexao->query($sqlBusca);

        $tarefas = [];

        while ($tarefa = $resultado->fetch_object('Tarefa')) {
            $tarefa->setAnexos($this->buscar_anexos($tarefa->getId()));

            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    public function buscar_tarefa($id)
    {
        $sqlBusca = 'SELECT * FROM tarefas WHERE id = ' . $id;
        $resultado = $this->conexao->query($sqlBusca);

        $tarefa = $resultado->fetch_object('Tarefa');
        $tarefa->setAnexos(
            $this->buscar_anexos($tarefa->getId())
        );

        return $tarefa;
    }

    public function remover(int $tarefa_id)
    {
        $sqlRemover = "DELETE FROM tarefas WHERE id = {$tarefa_id}";

        $this->conexao->query($sqlRemover);
    }

    public function buscar_anexos(int $tarefa_id): array
    {
        $sqlBusca = "SELECT * FROM anexos WHERE tarefa_id = {$tarefa_id}";
        $resultado = $this->conexao->query($sqlBusca);

        $anexos = array();

        while ($anexo = $resultado->fetch_object('Anexo')) {
            $anexos[] = $anexo;
        }

        return $anexos;
    }

    public function buscar_anexo(int $anexo_id): Anexo
    {
        $sqlBusca = "SELECT * FROM anexos WHERE id = {$anexo_id}";
        $resultado = $this->conexao->query($sqlBusca);

        return $resultado->fetch_object('Anexo');
    }

    public function salvar_anexo(Anexo $anexo)
    {
        $nome = strip_tags($this->conexao->escape_string(
            $anexo->getNome()
        ));
        $arquivo = strip_tags($this->conexao->escape_string(
            $anexo->getArquivo()
        ));

        $sqlGravar = "INSERT INTO anexos (tarefa_id, nome, arquivo)
            VALUES (
                {$anexo->getTarefaId()},
                '{$nome}',
                '{$arquivo}'
            )";

        $this->conexao->query($sqlGravar);
    }

    public function remover_anexo(int $id)
    {
        $sqlRemover = "DELETE FROM anexos WHERE id = {$id}";

        $this->db->query($sqlRemover);
    }
}