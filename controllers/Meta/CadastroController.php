<?php 		
# ------ Dados Iniciais
require dirname(dirname(__DIR__)) . '/config.php';


global $mysqli;

import_utils([ 'Auth' ]);
Auth::check('adm');

import_utils([ 'valida_campo', 'navegate' ]);



# ------ Validar Envio de Dados
$campos_validos = valida_campo($_POST['nome']);
if (!$campos_validos) 
{
  $_SESSION['fed_categoria_material'] = [ 
      'title' => 'Erro!', 'msg' => 'Campos Invalidos' 
  ];
  navegate($_ENV['ROUTE'] . 'admin.meta.create');
} 


# ----- Cadastro 
$meta = new Meta($mysqli);
 
$dados = [
  'nome' => $_POST['nome'],
  'descricao' => $_POST['descricao'],
  'data_inicio' => $_POST['data_inicio'],
  'data_fim' => $_POST['data_fim'],
  'total_necessario' => $_POST['total_necessario'],
  'status' => $_POST['status']
];

try {
  $meta->cadastrar($dados);
} catch (Exception $e) {
  $_SESSION['fed_categoria_material'] = [ 
      'title' => 'Erro!', 'msg' => 'Campos Invalidos' 
  ];
  navegate($_ENV['ROUTE'] . 'admin.meta.create');
}

//print_r($_POST);

navegate($_ENV['ROUTE'] . 'admin.meta.index');
