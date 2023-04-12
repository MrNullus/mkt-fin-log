<?php
if (!isset($_POST) && empty($_POST)) {
  return;
}

require('../config.php');
import_models("Usuario");

$tipo_usuario = $_POST["tipo_usuario"];
switch ($tipo_usuario) {
  case 'visitante':
    
    break;
  
  default:
    throw new Exception("Error Processing Request", 1);
}
