<?php  
define("DB_SERVIDOR", "localhost");
define("DB_USUARIO", "root");
define("DB_SENHA", "");
define("DB_NOME", "db_tcc");

class Entidade {
    private $conexao;

    public static function query($sql) {
        $conn = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_SENHA, DB_NOME);
        $dados_consulta = mysqli_query($this->conexao, $sql);

        return $dados_consulta;
    }

    public static function insertInto($table, $dados = [], $tipos_dados = []) {
        $sql_insert  = "";

        $columns_output = "";
        $columns_input = array_values($dados);
        
        foreach ($columns_input as $key => $column) {
            if ( $key !== 0 && $key !== count($columns_input) ) {
                $columns_output .= ', ';
            }
            
            $columns_output .=  $column . '';
        }
        
        $sql_insert = "INSERT INTO tabela (". $columns_output .")";

        $query = mysqli_prepare($this->conn, $sql);
        return mysqli_stmt_execute($query);
    }

}