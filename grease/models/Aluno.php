<?php
/**
 * Aluno
*/
class Aluno
{
    private $mysqli;
    private $tabela = 'alunos';
    private $tabela_secundaria = 'caixa';
    private $tabela_terciaria = 'usuarios';

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
   * @method public void cadastrar(array $dados)
   *
   * Cadastra um novo aluno no banco de dados.
   *
   * @param array $dados Dados do aluno a ser cadastrado.
   *
   * @throws Exception Se houver um erro ao cadastrar o aluno.
   *
   * @return void
   *
   * @since 2023-07-20
   * @author MrNullus <gustavojs417@gmail.com>
   *
   * @example
   *
   * // Cadastra um novo aluno
   * $aluno = new Aluno();
   * $aluno->cadastrar([
   *     "nome" => "João da Silva",
   * ]);
   */
    public function cadastrar($dados)
    {
        $query = "
            INSERT INTO 
                {$this->tabela} 
                    (nome)
            VALUES 
                    (?)
        ";

        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param(
            "s",
            $dados['nome']
        );

        if (!$stmt->execute()) {
            die("Erro ao criar aluno: " . $stmt->error);
        }

        $stmt->close();
    }

    /**
   * @method public bool cadastrarEmMassa(array $dados)
   *
   * Cadastra vários alunos no banco de dados.
   *
   * @param array $dados Dados dos alunos a serem cadastrados.
   *
   * @return bool True se o cadastro foi bem-sucedido, false caso contrário.
   *
   * @since 2023-07-20
   * @author MrNullus <gustavojs417@gmail.com>
   *
   * @example
   *
   * // Cadastra vários alunos
   * $alunos = [
   *     "João da Silva",
   *     "Maria da Silva",
   *     "José da Silva",
   * ];
   *
   * $aluno = new Aluno();
   * $aluno->cadastrarEmMassa([
   *     "nomes_alunos" => implode(";", $alunos),
   * ]);
   */
    public function cadastrarEmMassa($dados)
    {
        $textComNomeDosAlunos = $dados['nomes_alunos'];
        $listaDeNomesDosAlunos = explode(';', $textComNomeDosAlunos);

        $query = "INSERT INTO alunos (nome) VALUES ";
        $values = array();

        foreach ($listaDeNomesDosAlunos as $key => $value) {
            if (!empty($value) && isset($value)) {
                $values[] = "('$value')";
                //echo $value;
            }
        }

        $query .= implode(',', $values) . ';';

        // Execute a consulta SQL para inserir os alunos
        $stmt = $this->mysqli->query($query);

        print_r($query);

        if ($stmt) {
            return true; // Inserção bem-sucedida
        } else {
            return false; // Erro na inserção
        }
    }

    /**
     * @method public bool deletar(int $id)
     *
     * Exclui um aluno do banco de dados.
     *
     * @param int $id ID do aluno a ser deletado.
     *
     * @return bool True se o aluno foi deletado com sucesso, false caso contrário.
     *
     * @since 2023-07-20
     * @author MrNullus <gustavojs417@gmail.com>
     *
     * @example
     *
     * // Exclui um aluno
     * $aluno = new Aluno();
     * $aluno->deletar(1);
     */
    public function deletar($id)
    {
        // Verifica se há pagamentos associados a esse aluno
        $sqlPagamentos = "SELECT aluno_id FROM caixa WHERE aluno_id = ?";
        $stmtPagamentos = $this->mysqli->prepare($sqlPagamentos);
        $stmtPagamentos->bind_param('i', $id);
        $stmtPagamentos->execute();
        $resultPagamentos = $stmtPagamentos->get_result();

        if ($resultPagamentos->num_rows > 0) {
            // Aluno tem pagamentos, não pode ser deletado
            return false;
        }

        // Não há pagamentos, pode deletar o aluno
        $sql = "DELETE FROM " . $this->tabela . " WHERE aluno_id = ?";
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
   * @method public bool atualizar(array $dados)
   *
   * Atualiza os dados de um aluno no banco de dados.
   *
   * @param array $dados Dados do aluno a serem atualizados.
   *
   * @return bool True se a atualização foi bem-sucedida, false caso contrário.
   *
   * @since 2023-07-20
   * @author MrNullus <gustavojs417@gmail.com>
   *
   * @example
   *
   * // Atualiza os dados de um aluno
   * $aluno = new Aluno();
   * $aluno->atualizar([
   *     "id" => 1,
   *     "nome" => "João da Silva",
   * ]);
   */
    public function atualizar($dados)
    {
        $query = "
            UPDATE {$this->tabela}
            SET nome = ?
            WHERE aluno_id = ?
        ";
        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            die('Erro na preparação da query: ' . $this->mysqli->error);
        }

        $stmt->bind_param(
            'si',
            $dados['nome'],
            $dados['id']
        );

        if ($stmt->execute()) {
            return true;
        } else {
            die('Erro na execução da query: ' . $stmt->error);
        }
    }

    /**
   * @method public array buscarTodos()
   *
   * Retrieves all students from the database.
   *
   * @return array An array of student data.
   *
   * @since 2023-07-20
   * @author MrNullus <gustavojs417@gmail.com>
   *
   * @example
   *
   * // Retrieve all students
   * $alunos = [];
   * $aluno = new Aluno();
   * $alunos = $aluno->buscarTodos();
   *
   * // Display the names of all students
   * foreach ($alunos as $aluno) {
   *     echo $aluno['nome'] . "<br>";
   * }
   */
    public function buscarTodos()
    {
        $query = "SELECT * FROM {$this->tabela}";

        $result = $this->mysqli->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $alunos = [];
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $alunos[] = $linha;
        }

        return $alunos;
    }

    /**
   * @method public array buscar(int $id)
   *
   * Retrieves a student from the database by their ID.
   *
   * @param int $id The ID of the student to be retrieved.
   *
   * @return array An array of student data.
   *
   * @since 2023-07-20
   * @author MrNullus <gustavojs417@gmail.com>
   *
   * @example
   *
   * // Retrieve a student
   * $aluno = new Aluno();
   * $aluno = $aluno->buscar(1);
   *
   * // Display the student's name
   * echo $aluno['nome'] . "<br>";
   *
   * // Display the student's total payment
   * echo $aluno['total_pago'] . "<br>";
   */
    public function buscar($id)
    {
        $aluno = [];

        // -- pegar os dados do usuario
        $sql = $this->mysqli->query("
            SELECT 
                a.nome AS nome_aluno, 
                a.*,
                SUM(c.valor) AS total_pago
            FROM 
                {$this->tabela} AS a
            JOIN 
                {$this->tabela_secundaria} AS c 
            ON 
                c.aluno_id = a.aluno_id
            WHERE 
                c.aluno_id = '".$id."'
        ");


        if ($sql->num_rows === 0) {
            return null;
        }

        $aluno = $sql->fetch_assoc();

        // -- pegar as movimentações
        $result = $this->mysqli->query("
            SELECT 
                c.caixa_id,
                c.`categoria`,
                c.`descricao`,
                c.`data_movimentacao`,
                c.`valor`,
                c.`tipo_movimentacao`,
                c.`forma_pagamento`,
                c.`obs`,
                u.nome as nome_usuario
            FROM 
                alunos AS a
            JOIN 
                caixa AS c 
            ON 
                c.aluno_id = a.aluno_id
            JOIN 
                usuarios AS u
            ON 
                u.usuario_id = c.usuario_id
            WHERE 
                c.aluno_id = '".$id."'
        ");

        if ($sql->num_rows === 0) {
            return null;
        }

        $aluno['movimentacoes'] = $result->fetch_all(MYSQLI_ASSOC);

        return $aluno;
    }
}
 
