<?php  
define("DB_SERVIDOR", "localhost");
define("DB_USUARIO", "root");
define("DB_SENHA", "");
define("DB_NOME", "db_tcc");

class Entidade {
    private $conexao = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_SENHA, DB_NOME);

    public function query($sql) {
        $dados_consulta = mysqli_query($this->conexao, $sql);

        return $dados_consulta;
    }

    public function insertInto($table, $dados = [], $tipos_dados = []) {
        $sql_insert  = "";

        $mark_params = "";
        $columns_output   = "";
        $columns_formated = [];
        $columns_input    = array_values($dados);
        
        foreach ($columns_input as $column) {	
            array_push($columns_formated, substr($column, 1));
        }	     
        foreach ($columns_formated as $key => $column) {
            if ( $key != 0 && $key != count($columns_formated) ) {
                $columns_output .= ', ';
            }
            
            $columns_output .=  $column . '';
        }
        
        for ($m = 0; $m < count($columns_formated); $m++) {
            if ($m != 0 && $m != count($columns_formated)) {
                $mark_params .= ', ';
            }

            $mark_params .= '? ';
        }

        $sql_insert = "INSERT INTO tabela (". $columns_output .") VALUES (". $mark_params .")";
        $query = mysqli_prepare($this->conexao, $sql_insert);
        
        foreach ($columns_formated as $key => $value) {
            $query->bind_param($tipos_dados[$key], $value);
        }        

        return $query->execute();
    }

}
