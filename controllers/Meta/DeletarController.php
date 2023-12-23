<?php
# ------ Dados Iniciais
require dirname(dirname(__DIR__)) . '/config.php';


global $mysqli;

import_utils([ 'Auth' ]);
Auth::check('adm');

import_utils([ 'valida_campo', 'navegate' ]);


# ------ Validar Envio de Dados
$campos_validos = (
    $_GET['id'] ? true : false
);	
if (!$campos_validos)
{ 
  navegate($_ENV['ROUTE'] . 'admin.categoria_material.index');
} 


# ----- Deletar Material
try {
  $meta = new Meta($mysqli);
  $meta->deletar($_GET['id']);
} catch (Exception $e) {
  $_SESSION['fed_categoria_material'] = [ 
    'title' => 'OK!', 'msg' => 'Não é possível excluir essa meta', 'icon' => 'error'
  ];
}

navegate($_ENV['ROUTE'] . 'admin.categoria_material.index');
