<?php   
define("URL_BASE", "http://localhost:8080/grease");

$conn = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_SENHA, DB_NOME);

$sql = "
INSERT INTO 
    `usuarios` 
    ( 
        `nome`
    ) 

    VALUES 
    (
        'Tetes'
    )
";

echo "----------";
print_r(mysqli_query($conn, $sql));
