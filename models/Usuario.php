<?php
/**
 * Usuario
 */
class Usuario 
{
    private $mysqli;
    private $tabela = "usuarios";


    /**
     * Método construtor da classe
     *
     * @param  mysqli $mysqli É a conexão com o banco de dados
     * @return void
     */
    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }


    /**
     * Método para verificar se determinado valor de um campo é único
     *
     * @param int $campo Nome do campo
     * @param int $valor É o valor do campo
     * @return bool|null
     */
    public function unico($campo, $valor)
    {
        $query = "
            SELECT 
                usuario_id 
            FROM 
                " . $this->tabela . " 
            WHERE {$campo} = ?
        ";
        $params = [$valor];

        $stmt = $this->mysqli->prepare($query);

        if (!$stmt) {
            error_log("Erro ao preparar a consulta: " . $this->mysqli->error);
            return false;
        }

        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Método para buscar um usuario por um ID 
     *
     * @param int $ID ID do usuario
     * @return mixed 
     */
    public function buscar($email)
    {
        $stmt = $this->mysqli->prepare("
            SELECT 
                * 
            FROM 
                " . $this->tabela . " 
            WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return null;
        }

        $usuario = $result->fetch_assoc();
        $stmt->close();

        return $usuario;
    }

    /**
     * Método para buscar um usuario por um ID 
     *
     * @param int $ID ID do usuario
     * @return mixed 
     */
    public function buscarPorID($id)
    {
      $stmt = $this->mysqli->prepare("
          SELECT 
              * 
          FROM 
              " . $this->tabela . " 
          WHERE usuario_id = ?
      ");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
          return null;
      }

      $usuario = $result->fetch_assoc();
      $stmt->close();

      return $usuario;
    }

     public function buscarTodos()
    {
        $stmt = $this->mysqli->query("
            SELECT 
                * 
            FROM 
                " . $this->tabela ."
            ORDER BY nome ASC"    
        );

        if ($stmt->num_rows === 0) {
            return null;
        }

        while ($linha = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
            $usuario[] = $linha;
        }

        return $usuario;
    }

    /**
     * Método para realizar o login do usuario
     *
     * @param  string $email É o email a ser usada no login
     * @param  string $senha É a senha a ser usada no login
     * @return bool|array
     */
    public function login($email, $senha)
    {
        $query = "
            SELECT 
                * 
            FROM 
                " . $this->tabela . " 
            WHERE email = ? LIMIT 0,1
        ";

        $stmt = $this->mysqli->prepare($query);

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($senha == $row['senha']) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Método para realizar o cadastro de um Úsuario
     *
     * @param  array $dados Dados a serem cadastrados
     * @return void
     */
    public function cadastrar($dados = [])
    {
        $stmt = $this->mysqli->prepare("
            INSERT INTO 
                " . $this->tabela . " 
            (
                tipo_usuario, 
                nome, 
                email, 
                senha, 
                celular, 
                idade, 
                genero, 
                cpf, 
                foto_perfil
            ) 
                VALUES 
            (
                ?, 
                ?, 
                ?, 
                ?, 
                ?, 
                ?, 
                ?, 
                ?, 
                ?
            )
        ");

         $stmt->bind_param(
            "sssssisss",
            $dados['tipo_usuario'],
            $dados['username'],
            $dados['email'],
            $dados['password'],
            $dados['cell'],
            $dados['age'],
            $dados['genrer'],
            $dados['cpf'],
            $dados['foto_perfil']
        );

        $stmt->execute();
        $stmt->close();
    }

    
    public function atualizar($dados = [])
    {
      $stmt = $this->mysqli->prepare("
        UPDATE 
            " . $this->tabela . " 
        SET 
            nome = ?,  
            email = ?,  
            cpf = ?,  
            senha = ?, 
            idade = ?, 
            genero = ?, 
            celular = ?
        WHERE 
            usuario_id = ? 
    ");

    $stmt->bind_param(
        "ssssissi", 
        $dados['nome'],
        $dados['email'],
        $dados['cpf'],
        $dados['senha'],
        $dados['idade'],
        $dados['genero'],
        $dados['celular'],
        $dados['usuario_id']
    );
      
      $stmt->execute();
      $stmt->close();
    }

    public function deletar($id)
    {
        $query = "
            DELETE FROM 
                " . $this->tabela . " 
            WHERE usuario_id = ?
        ";

        $stmt = $this->mysqli->prepare($query);

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

        $stmt->close();
    }

     // Verifica se o e-mail existe no banco de dados
    public function existeEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Salva um token no banco de dados
    public function salvarTokenNoBanco($email, $token, $expiration) {
        $query = "INSERT INTO ResetPasswordRequests (email, token, expiration) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("sss", $email, $token, $expiration);
        return $stmt->execute();
    }

     // Método para verificar se um token de redefinição de senha é válido
    public function verificarToken($token) {
        // Verifique se o token existe no banco de dados e não foi usado
        $query = "SELECT * FROM ResetPasswordRequests WHERE token = ? AND used = 0 AND expiration > NOW()";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows === 1) {
            return $row; // O token é válido
        } else {
            return false; // O token não é válido
        }
    }

    // Atualiza a senha de um usuário
    public function atualizarSenha($email, $novaSenha) {
        $query = "UPDATE usuarios SET senha = MD5(?) WHERE email = ?";
        $stmt = $this->mysqli->prepare($query);

        $stmt->bind_param("ss", $novaSenha, $email);
        return $stmt->execute();
    }

    // Invalida um token de redefinição de senha após o uso
    public function invalidarToken($token) {
        $query = "UPDATE ResetPasswordRequests SET used = 1 WHERE token = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $token);
        return $stmt->execute();
    }
}
