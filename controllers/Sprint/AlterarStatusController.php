<?php
# ------ Dados Iniciais
require dirname(dirname(__DIR__)) . '/config.php';

global $mysqli;
import_utils(['navegate']);


if(isset($_SESSION['ultimo_acesso'])) {
  $ultimo_acesso = $_SESSION['ultimo_acesso'];
} else {
  $ultimo_acesso = null;
}

$_SESSION['ultimo_acesso'] = time();


# ------ Validar Envio de Dados
$campos_validos = (
    is_numeric($_GET['id']) && 
    ($_GET['action'] === 'ativar' || $_GET['action'] === 'desativar')
);

if (!$campos_validos) {
    $_SESSION['fed_sprint'] = [
        'title' => 'Erro!',
        'msg' => 'Campos Inválidos',
        'icon' => 'error'
    ];
    navegate($_ENV['ROUTE'] . 'admin.sprint.index');
}

# ----- Atualizar Status
$sprint_id = $_GET['id'];
$action = $_GET['action'];
$novoStatus = ($action == 'desativar')? 'inativa' : 'ativa';

$sprint = new Sprint($mysqli);

if ($sprint->alterarStatus($sprint_id, $novoStatus)) {
      $_SESSION['fed_sprint'] = [
        'title' => 'Sucesso!',
        'msg' => 'Status da sprint alterado com sucesso.',
        'icon' => 'success'
    ];
} else {
    $_SESSION['fed_sprint'] = [
        'title' => 'Erro!',
        'msg' => 'Erro ao alterar o status da sprint.',
        'icon' => 'error'
    ];
}

navegate($_ENV['ROUTE'] . 'admin.sprint.index');

