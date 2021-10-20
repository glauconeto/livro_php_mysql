<?php

require 'Anexo.php';

class RepositorioTarefas
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->conexao = $pdo;
    }

    public function salvar(Tarefa $tarefa)
    {
        $prazo = $tarefa->getPrazo();

        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        // Definindo SQL com Prepared Statement
        $sqlGravar = "
            INSERT INTO tarefas (nome, descricao, prioridade, prazo, concluida)
            VALUES (:nome, :descricao, :prioridade, :prazo, :concluida)";

        // Preparando a query
        $query = $this->pdo->prepare($sqlGravar);

        // Executando a query com os parâmetros nomeados
        $query->execute([
            'nome' => strip_tags($tarefa->getNome()),
            'descricao' => strip_tags($tarefa->getDescricao()),
            'prioridade' => $tarefa->getPrioridade(),
            'prazo' => $prazo,
            'concluida' => ($tarefa->getConcluida()) ? 1 : 0
        ]);
    }

    public function atualizar(Tarefa $tarefa)
    {
        $prazo = $tarefa->getPrazo();

        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        // Lembre-se de que no update precisamos do WHERE
        $sqlEditar = "UPDATE tarefas SET
            nome = :nome,
            descricao = :descricao,
            prioridae = :prioridade,
            prazo = :prazo,
            concluida = :concluida
        WHERE id = :id";

        $query = $this->pdo->prepare($sqlEditar);
        
        // O parâmetro do WHERE também é incluido na execução
        $query->execute([
            'nome' => strip_tags($tarefa->getNome()),
            'descricao' => strip_tags($tarefa->getDescricao()),
            'prioridade' => $tarefa->getPrioridade(),
            'prazo' => $prazo,
            'concluida' => ($tarefa->getConcluida()) ? 1 : 0,
            'id' => $tarefa->getId()
        ]);
    }

    public function buscar(int $tarefa_id = 0): Tarefa|array
    {
        if ($tarefa_id > 0) {
            return $this->buscar_tarefa($tarefa_id);
        } else {
            return $this->buscar_tarefas();
        }
    }

    public function remover(int $id)
    {
        // Na remoção é muito importante usar o WHERE
        $sqlRemover = "DELETE FROM tarefas WHERE id = :id";

        $query = $this->pdo->prepare($sqlRemover);
        $query->execute(['id' => $id]);

        $this->conexao->query($sqlRemover);
    }

    private function buscar_tarefa(int $id): Tarefa
    {
        $sqlBusca = 'SELECT * FROM tarefas WHERE id = :id';
        $query = $this->pdo->prepare($sqlBusca);
        $query->execute([
            'id' => $id
        ]);

        $tarefa = $query->fetch_object('Tarefa');

        if (! is_object($tarefa)) {
            throw new Exception('A tarefa com o id {$id} não existe');
        }

        // Delegamos a busca dos anexos
        // para o método buscar_anexos()

        $tarefa->setAnexos($this->buscar_anexos($tarefa->getId()));

        return $tarefa;
    }

    private function buscar_tarefas(): array
    {
        $sqlBusca = 'SELECT * FROM tarefas';
        $resultado = $this->pdo->query(
            $sqlBusca,
            PDO::FETCH_CLASS,
            'Tarefa'
        );

        $tarefas = [];

        foreach ($resultado as $tarefa) {
            $tarefa->setAnexos($this->buscar_anexos($tarefa->getId()));
            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    public function buscar_anexos(int $tarefa_id)
    {
        $sqlBusca = "SELECT * FROM anexos WHERE tarefa_id = :tarefa_id";
        $query = $this->pdo->prepare($sqlBusca);
        $query->execute(['tarefa_id' => $tarefa_id]);

        $anexos = array();

        while ($anexo = $query->fetchObject('Anexo')) {
            $anexos[] = $anexo;
        }

        return $anexos;
    }

    public function buscar_anexo(int $anexo_id): Anexo
    {
        $sqlBusca = "SELECT * FROM anexos WHERE id = :id";
        $query = $this->pdo->prepare($sqlBusca);
        $query->execute(['id' => $anexo_id]);

        $anexo = $query->fetch_object('Anexo');

        if (! is_object($anexo)) {
            throw new Exception('O anexo com o id {$id} não existe');
        }

        return $anexo;
    }

    public function salvar_anexo(Anexo $anexo)
    {
        $sqlGravar = "INSERT INTO anexos (tarefa_id, nome, arquivo)
            VALUES (:anexo, :nome, :arquivo')";
        $query = $this->pdo->prepare($sqlGravar);
        $query->execute([
            'tarefa_id' => $anexo->getTarefaId(),
            'nome' => strip_tags($anexo->getNome()),
            'arquivo' => strip_tags($anexo->getArquivo())
        ]);
    }

    public function remover_anexo(int $id)
    {
        $sqlRemover = "DELETE FROM anexos WHERE id = :id";
        $query = $this->pdo->prepare($sqlRemover);
        $query->execute(['id' => $id]);
    }
}