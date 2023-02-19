<?php
    

class TarefaService {
    private $conexao;
    private $tarefa;

    public function __construct(Conexao $conexao, Tarefa $tarefa){
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    /// Create
    public function inserir() {
        $query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $stmt->execute();
    }

    /// Read
    public function recuperar() {
        $query = '
            SELECT 
                t.id, t.tarefa, s.status
            FROM 
                tb_tarefas as t LEFT JOIN tb_status as s ON(t.id_status = s.id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /// Update
    public function atualizar() {
        
        /// pontos de marcação ?
        
        $query = '
            UPDATE
                tb_tarefas
            SET
                tarefa = ? 
            WHERE
                id = ? 
        ';
        $stmt = $this->conexao->prepare($query);
        /// indice de ocorrência do valor do ponto
        $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
        $stmt->bindValue(2, $this->tarefa->__get('id'));
        return $stmt->execute();
        
    }

    /// Delete
    public function remover() {
        $query = 'DELETE FROM tb_tarefas WHERE id = ?';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->tarefa->__get('id'));
        return $stmt->execute();
    }
    
    public function marcarRealizada() {
        $query = '
            UPDATE
                tb_tarefas
            SET
                id_status = ? 
            WHERE
                id = ? 
        ';
        $stmt = $this->conexao->prepare($query);
        /// indice de ocorrência do valor do ponto
        $stmt->bindValue(1, $this->tarefa->__get('id_status'));
        $stmt->bindValue(2, $this->tarefa->__get('id'));
        return $stmt->execute();
    }

    public function recuperarPendentes() {
        $query = '
            SELECT 
                t.id, t.tarefa, s.status
            FROM 
                tb_tarefas as t LEFT JOIN tb_status as s ON(t.id_status = s.id)
            WHERE
                id_status = 1
            ';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

?>