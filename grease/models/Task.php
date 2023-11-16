<?php


/**
 * Classe Task
 *
 * Esta classe representa uma tarefa e fornece métodos para interagir com as tarefas no sistema.
 *
 * @since 2023-10-30
 * @version 1.0
 * @author MrNullus <gustavojs417@gmail.com>
 */
class Task
{
    private $mysqli;
    private $tabela = 'tarefas';

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
   * Cadastra uma nova tarefa no sistema.
   *
   * Este método insere uma nova tarefa na tabela de tarefas do banco de dados.
   *
   * @param array $dados Um array associativo contendo os dados da tarefa.
   * - 'titulo': O título da tarefa.
   * - 'descricao': A descrição da tarefa.
   * - 'data_de_vencimento': A data de vencimento da tarefa no formato 'YYYY-MM-DD'.
   * - 'aluno_id': O ID do aluno associado à tarefa.
   * - 'sprint_id': O ID da sprint à qual a tarefa pertence.
   * - 'status_tarefa': O status da tarefa (ativa, concluída, etc.).
   *
   * @return void
   *
   * @throws Exception Se ocorrer um erro durante a execução da query.
   *
   * @since 2023-10-30
   *
   * @example
   * ```php
   * $task = new Task($mysqli);
   * $dados = [
   *     'titulo' => 'Tarefa 1',
   *     'descricao' => 'Descrição da tarefa 1',
   *     'data_de_vencimento' => '2023-11-30',
   *     'aluno_id' => '1',
   *     'sprint_id' => '2',
   *     'status_tarefa' => 'ativa'
   * ];
   * $task->cadastrar($dados);
   * ```
   */
    public function cadastrar($dados)
    {
        $query = "
            INSERT INTO 
                {$this->tabela} 
                    (titulo, descricao, data_de_vencimento, aluno_id, sprint_id, status_tarefa)
            VALUES 
                    (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param(
            "ssssss",
            $dados['titulo'],
            $dados['descricao'],
            $dados['data_de_vencimento'],
            $dados['aluno_id'],
            $dados['sprint_id'],
            $dados['status_tarefa']
        );

        if (!$stmt->execute()) {
            die("Erro ao criar tarefa: " . $stmt->error);
        }

        $stmt->close();
    }

    /**
   * Desativa uma tarefa no sistema.
   *
   * Este método atualiza o status de uma tarefa para 'desativada' na tabela de tarefas do banco de dados.
   *
   * @param int $id O ID da tarefa a ser desativada.
   *
   * @return bool Retorna true se a tarefa foi desativada com sucesso, false se a tarefa não foi encontrada.
   *
   * @throws Exception Se ocorrer um erro durante a execução da query.
   *
   * @since 2023-10-30
   *
   * @example
   * ```php
   * $task = new Task($mysqli);
   * $tarefaId = 1;
   * $resultado = $task->deletar($tarefaId);
   * if ($resultado) {
   *     echo "Tarefa desativada com sucesso.";
   * } else {
   *     echo "Tarefa não encontrada.";
   * }
   * ```
   */
    public function deletar($id)
    {
        $sql = "
            UPDATE 
                {$this->tabela}
            SET 
                status_tarefa = 'desativada'
            WHERE 
                id = ?
        ";
        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            die('Erro na execução da query: ' . $this->mysqli->error);
        }
    }

    /**
 * Atualiza os detalhes de uma tarefa no sistema.
 *
 * Este método atualiza os atributos de uma tarefa na tabela de tarefas do banco de dados.
 *
 * @param array $dados Um array associativo contendo os novos dados da tarefa. Deve incluir:
 *   - 'id': O ID da tarefa a ser atualizada.
 *   - 'titulo': O novo título da tarefa.
 *   - 'descricao': A nova descrição da tarefa.
 *   - 'data_de_vencimento': A nova data de vencimento da tarefa.
 *   - 'aluno_id': O novo ID do aluno associado à tarefa.
 *   - 'sprint_id': O novo ID da sprint associada à tarefa.
 *   - 'status_tarefa': O novo status da tarefa.
 *
 * @return bool Retorna true se a tarefa foi atualizada com sucesso, false em caso de falha.
 *
 * @throws Exception Se ocorrer um erro durante a execução da query.
 *
 * @since 2023-10-30
 *
 * @example
 * ```php
 * $task = new Task($mysqli);
 * $dadosTarefa = [
 *     'id' => 1,
 *     'titulo' => 'Nova Tarefa',
 *     'descricao' => 'Esta é a nova descrição da tarefa.',
 *     'data_de_vencimento' => '2023-11-30',
 *     'aluno_id' => 42,
 *     'sprint_id' => 3,
 *     'status_tarefa' => 'ativo'
 * ];
 * $resultado = $task->atualizar($dadosTarefa);
 * if ($resultado) {
 *     echo "Tarefa atualizada com sucesso.";
 * } else {
 *     echo "Falha ao atualizar a tarefa.";
 * }
 * ```
 */
    public function atualizar($dados)
    {
        $query = "
            UPDATE {$this->tabela}
            SET 
                titulo = ?,
                descricao = ?,
                data_de_vencimento = ?,
                aluno_id = ?,
                sprint_id = ?,
                status_tarefa = ?
            WHERE 
                id = ?
        ";
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param(
            'ssssssi',
            $dados['titulo'],
            $dados['descricao'],
            $dados['data_de_vencimento'],
            $dados['aluno_id'],
            $dados['sprint_id'],
            $dados['status_tarefa'],
            $dados['id']
        );

        if ($stmt->execute()) {
            return true;
        } else {
            die('Erro na execução da query: ' . $stmt->error);
        }
    }

  /**
 * Obtém todas as tarefas cadastradas no sistema.
 *
 * Este método recupera todas as tarefas existentes na tabela de tarefas do banco de dados.
 *
 * @return array|null Retorna um array contendo todas as tarefas encontradas ou null se não houver tarefas.
 *
 * @throws Exception Se ocorrer um erro durante a execução da query.
 *
 * @since 2023-10-30
 *
 * @example
 * ```php
 * $task = new Task($mysqli);
 * $todasAsTarefas = $task->buscarTodos();
 * if ($todasAsTarefas !== null) {
 *     foreach ($todasAsTarefas as $tarefa) {
 *         echo "ID: {$tarefa['id']}, Título: {$tarefa['titulo']}, Status: {$tarefa['status_tarefa']} <br>";
 *     }
 * } else {
 *     echo "Não há tarefas cadastradas.";
 * }
 * ```
 */
    public function buscarTodos()
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

        $tarefas = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $tarefas[] = $linha;
        }

        return $tarefas;
    }

    /**
 * Busca uma tarefa ativa pelo ID.
 *
 * Este método retorna os detalhes de uma tarefa ativa com base no ID fornecido.
 *
 * @param int $id O ID da tarefa a ser buscada.
 *
 * @return array|null Retorna um array contendo os detalhes da tarefa ou null se a tarefa não for encontrada ou estiver inativa.
 *
 * @since 2023-10-30
 *
 * @example
 * ```php
 * $task = new Task($mysqli);
 * $tarefaId = 123; // Substitua pelo ID da tarefa a ser buscada
 * $detalhesTarefa = $task->buscar($tarefaId);
 * if ($detalhesTarefa !== null) {
 *     echo "ID: {$detalhesTarefa['id']}, Título: {$detalhesTarefa['titulo']}, Status: {$detalhesTarefa['status_tarefa']} <br>";
 * } else {
 *     echo "Tarefa não encontrada ou inativa.";
 * }
 * ```
 */
    public function buscar($id)
    {
        $tarefa = [];

        $sql = $this->mysqli->query("
            SELECT 
                *
            FROM 
                {$this->tabela}
            WHERE 
                id = '{$id}'
                    AND
                status_tarefa = 'ativa'
        ");

        if ($sql->num_rows === 0) {
            return null;
        }

        $tarefa = $sql->fetch_assoc();

        return $tarefa;
    }

    /**
 * Lista todas as tarefas associadas a um aluno.
 *
 * Este método retorna todas as tarefas associadas a um aluno com base no ID do aluno fornecido.
 *
 * @param int $alunoId O ID do aluno para o qual as tarefas serão listadas.
 *
 * @return array|null Retorna um array contendo todas as tarefas associadas ao aluno ou null se nenhuma tarefa for encontrada.
 *
 * @since 2023-10-30
 *
 * @example
 * ```php
 * $task = new Task($mysqli);
 * $alunoId = 456; // Substitua pelo ID do aluno para o qual você deseja listar as tarefas
 * $tarefasDoAluno = $task->listarTarefasPorAluno($alunoId);
 * if ($tarefasDoAluno !== null) {
 *     foreach ($tarefasDoAluno as $tarefa) {
 *         echo "ID: {$tarefa['id']}, Título: {$tarefa['titulo']}, Descrição: {$tarefa['descricao']} <br>";
 *     }
 * } else {
 *     echo "Nenhuma tarefa encontrada para este aluno.";
 * }
 * ```
 */
    public function listarTarefasPorAluno($alunoId)
    {
        $query = "
            SELECT 
                *
            FROM 
                {$this->tabela}
            WHERE 
                aluno_id = '{$alunoId}'
        ";

        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $tarefas = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $tarefas[] = $linha;
        }

        return $tarefas;
    }


    /**
   * Conta o número total de tarefas ativas associadas a uma sprint específica.
   *
   * Este método retorna o número total de tarefas ativas associadas a uma sprint com base no ID da sprint fornecido.
   *
   * @param int $sprintId O ID da sprint para a qual as tarefas serão contadas.
   *
   * @return int O número total de tarefas ativas associadas à sprint ou 0 se nenhuma tarefa for encontrada.
   *
   * @since 2023-10-30
   *
   * @example
   * ```php
   * $task = new Task($mysqli);
   * $sprintId = 123; // Substitua pelo ID da sprint para a qual você deseja contar as tarefas
   * $totalTarefas = $task->contarTarefasPorSprint($sprintId);
   * echo "Total de tarefas ativas na sprint: {$totalTarefas}";
   * ```
   */
    public function contarTarefasPorSprint($sprintId)
    {
        $query = "
            SELECT 
                COUNT(*) as total
            FROM 
                {$this->tabela}
            WHERE 
                sprint_id = '{$sprintId}'
                    AND
                status_tarefa = 'ativa'
        ";

        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return 0;
        }

        $row = $result->fetch_assoc();
        return $row['total'];
    }


    /**
   * Obtém todas as tarefas que estão com vencimento anterior à data atual.
   *
   * Este método retorna um array de todas as tarefas que têm a data de vencimento anterior à data atual.
   *
   * @return array|null Um array de tarefas atrasadas ou null se nenhuma tarefa estiver atrasada.
   *
   * @since 2023-10-30
   *
   * @example
   * ```php
   * $task = new Task($mysqli);
   * $tarefasAtrasadas = $task->obterTarefasAtrasadas();
   *
   * if ($tarefasAtrasadas !== null) {
   *     foreach ($tarefasAtrasadas as $tarefa) {
   *         echo "Tarefa atrasada: {$tarefa['titulo']} (Vencimento: {$tarefa['data_de_vencimento']})";
   *     }
   * } else {
   *     echo "Não há tarefas atrasadas no momento.";
   * }
   * ```
   */
    public function obterTarefasAtrasadas()
    {
        $dataAtual = date('Y-m-d');
        $query = "
            SELECT 
                *
            FROM 
                {$this->tabela}
            WHERE 
                data_de_vencimento < '{$dataAtual}'
        ";

        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $tarefasAtrasadas = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $tarefasAtrasadas[] = $linha;
        }

        return $tarefasAtrasadas;
    }

    /**
   * Marca uma tarefa como concluída.
   *
   * Este método atualiza o status de uma tarefa para 'concluída'.
   *
   * @param int $tarefaId O ID da tarefa a ser concluída.
   * @return bool Retorna true se a tarefa foi marcada como concluída com sucesso, false em caso de falha.
   *
   * @since 2023-10-30
   *
   * @example
   * ```php
   * $task = new Task($mysqli);
   * $tarefaId = 1; // Substitua pelo ID real da tarefa que deseja concluir
   *
   * if ($task->concluirTarefa($tarefaId)) {
   *     echo "Tarefa concluída com sucesso!";
   * } else {
   *     echo "Falha ao concluir a tarefa. Verifique o ID da tarefa.";
   * }
   * ```
   */
    public function concluirTarefa($tarefaId)
    {
        $query = "
            UPDATE {$this->tabela}
            SET 
                status_tarefa = 'concluida'
            WHERE 
                id = ?
        ";
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param('i', $tarefaId);

        if ($stmt->execute()) {
            return true;
        } else {
            die('Erro na execução da query: ' . $stmt->error);
        }
    }

}
