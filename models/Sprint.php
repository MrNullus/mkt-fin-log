<?php

class Sprint
{
    private $mysqli;
    private $tabela = 'sprints';

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function cadastrar($dados)
    {
        $query = "
            INSERT INTO 
                {$this->tabela} 
                    (titulo, descricao, data_de_inicio, data_de_fim, status_sprint)
            VALUES 
                    (?, ?, ?, ?, ?)
        ";

        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param(
            "sssss",
            $dados['titulo'],
            $dados['descricao'],
            $dados['data_de_inicio'],
            $dados['data_de_fim'],
            $dados['status_sprint']
        );

        if (!$stmt->execute()) {
            die("Erro ao criar sprint: " . $stmt->error);
        }

        $stmt->close();
    }

    public function atualizar($dados)
    {
        $query = "
            UPDATE {$this->tabela}
            SET 
                titulo = ?,
                descricao = ?,
                data_de_inicio = ?,
                data_de_fim = ?,
                status_sprint = ?
            WHERE 
                id = ?
        ";
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param(
            'sssssi',
            $dados['titulo'],
            $dados['descricao'],
            $dados['data_de_inicio'],
            $dados['data_de_fim'],
            $dados['status_sprint'],
            $dados['id']
        );

        if ($stmt->execute()) {
            return true;
        } else {
            die('Erro na execução da query: ' . $stmt->error);
        }
    }

    public function buscar($id)
    {
        $sql = $this->mysqli->query("
            SELECT 
                * 
            FROM 
                {$this->tabela} 
            WHERE 
                id = '" . $id . "' 
        ");

        if ($sql->num_rows === 0) {
            return null;
        }

        $sprint = $sql->fetch_assoc();

        return $sprint;
    }

    public function desativarSprint($sprintId)
    {
        $query = "
            UPDATE {$this->tabela}
            SET 
                status_sprint = 'desativada'
            WHERE 
                id = ?
        ";
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param('i', $sprintId);

        if ($stmt->execute()) {
            return true;
        } else {
            die('Erro na execução da query: ' . $stmt->error);
        }
    }

    public function listarSprints()
    {
        $query = "
            SELECT 
                * 
            FROM 
                {$this->tabela}     
        ";
        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $sprints = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $sprints[] = $linha;
        }

        return $sprints;
    }

    public function concluirSprint($sprintId)
    {
        $query = "
          DELETE FROM 
            " . $this->tabela . "
          WHERE 
            id = ?
        ";
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param('i', $sprintId);

        if ($stmt->execute()) {
            return true;
        } else {
            die('Erro na execução da query: ' . $stmt->error);
        }
    }

    public function listarSprintsAtivas()
    {
        $query = "
            SELECT * 
            FROM {$this->tabela} 
            WHERE status_sprint = 'ativa'
        ";
        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $sprintsAtivas = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $sprintsAtivas[] = $linha;
        }

        return $sprintsAtivas;
    }

  
    public function listarSprintsInativas()
    {
        $query = "
            SELECT * 
            FROM {$this->tabela} 
            WHERE status_sprint = 'inativa'
        ";
        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $sprintsAtivas = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $sprintsAtivas[] = $linha;
        }

        return $sprintsAtivas;
    }
    
    public function alterarStatus($id, $novoStatus)
  {
      // Verifica se o novo status é um valor válido
      if ($novoStatus === 'inativa' || $novoStatus === 'criada' || $novoStatus === 'ativa') {
          // Se o novo status for ativa, desativar todas as outras entradas primeiro
          if ($novoStatus == 'ativa') {
              $query = "
                  UPDATE " . $this->tabela . "
                  SET status_sprint = 'inativa'
              ";

              $result = $this->mysqli->query($query);
              if ($result === false) {
                  die('Erro ao desativar todas as outras entradas: ' . $this->mysqli->error);
              }
          }

          // Atualiza o status da entrada desejada para o novo status
          $query = "
              UPDATE " . $this->tabela . "
              SET status_sprint = ?
              WHERE id = ?
          ";

          $stmt = $this->mysqli->prepare($query);
          if (!$stmt) {
              die('Erro na preparação da query: ' . $this->mysqli->error);
          }

          $stmt->bind_param('si', $novoStatus, $id);

          if ($stmt->execute()) {
              return true;
          } else {
              die('Erro na execução da query: ' . $this->mysqli->error);
          }

          $stmt->close();
      }

      return false;
  }

}