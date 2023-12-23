<?php
# ------ Dados Iniciais
require dirname(dirname(__DIR__)) . '/config.php';

global $mysqli;
import_utils(['navegate']);

# ------ Validar Envio de Dados
$campos_validos = (
    $_GET['id'] && is_numeric($_GET['id']) &&
    $_GET['acao'] && ($_GET['acao'] === 'ativar' || $_GET['acao'] === 'desativar')
);

if (!$campos_validos) {
    $_SESSION['fed_meta'] = [
        'title' => 'Erro!',
        'msg' => 'Campos Inválidos',
        'icon' => 'error'
    ];
    navegate($_ENV['ROUTE'] . 'admin.meta.index');
}

# ----- Atualizar Status
$meta_id = $_GET['id'];
$acao = $_GET['acao'];
$novoStatus = $acao == 'desativar'? 0 : 1;

$meta = new Meta($mysqli);

if ($meta->alterarStatus($meta_id, $novoStatus)) {
      $_SESSION['fed_meta'] = [
        'title' => 'Sucesso!',
        'msg' => 'Status da meta alterado com sucesso.',
        'icon' => 'success'
    ];
} else {
    $_SESSION['fed_meta'] = [
        'title' => 'Erro!',
        'msg' => 'Erro ao alterar o status da meta.',
        'icon' => 'error'
    ];
}

navegate($_ENV['ROUTE'] . 'admin.meta.index');

