<?php
# ------ Configurações Básicas
require dirname(dirname(dirname(dirname(__DIR__)))) . '/config.php';
global $_ENV;

import_utils(['Auth']);

Auth::check('adm');

import_utils([
    'extend_styles',
    'use_js_scripts',
    'render_component',
    'Money',
    'Mascara'
]);

include $_ENV['PASTA_CONTROLLER'] . '/Fornecedor/ConsultaController.php';

//ChamaSamu::debugPanel($fornecedores);

if (isset($_SESSION['ultimo_acesso'])) {
    $ultimo_acesso = $_SESSION['ultimo_acesso'];

    if (time() - $ultimo_acesso > 5) {
        unset($_SESSION['fed_sala']);
    }
}
?>


<!------- HEAD --------->
<?php
render_component('head');
//extend_styles(['css.admin.financas']);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>


<title>
    Relatorio Finanças 🕺 Grease
</title>
<!-------/ HEAD --------->


<!------- BODY --------->
<style type="text/css">
	body {
		font-family: monospace;
		font-weight: 600;
	}
</style>
<body style="padding: 2rem;margin: 1rem 0;">
  <?php if (isset($_SESSION['fed_sala']) && !empty($_SESSION['fed_sala'])): ?>
  <script>
  Swal.fire({
      title: '<?= $_SESSION['fed_sala']['title']; ?>',
      text: '<?= $_SESSION['fed_sala']['msg']; ?>',
      icon: '<?= $_SESSION['fed_sala']['icon']; ?>',
      confirmButtonText: 'OK'
  })
  </script>
  <?php endif; ?>


  <div>
  	<button 
  		style="padding: 0.68rem;border-radius: 0.25rem;width: 70px;color: #000;border-color: 2px solid #555;background: #ff0000a6;cursor: pointer;" 
  		onclick="exportToPDF()"
  	>
  		PDF
  	</button>
  	<button 
  		style="padding: 0.68rem;border-radius: 0.25rem;width: 70px;color: #000;border-color: 2px solid #555;background: #28f898;cursor: pointer;" 
  		onclick="exportToExcel()"
  	>
  		Excel
  	</button>
  </div>
  <br><br>


	<?php if (isset($fornecedores) && !empty($fornecedores)) { ?>
    <table id="myTable" class="display" style="width: 100%!important; border-collapse: collapse; border: 1px solid whitesmoke; border-radius: 3rem;" cellpadding="12" cellspacing="15" border="2">
        <thead>
            <tr>
                <th colspan="20" style="background: #333; color: whitesmoke; border: 1px solid whitesmoke;">
                    <h1 style="margin-bottom: 1.2rem;">RELATÓRIO DOS FORNECEDORES</h1>
                     <h3><?= date('d-m-Y'); ?></h3>
                </th>
            </tr>
            <tr>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">Nome</th>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">CNPJ</th>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">Email</th>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">Celular</th>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">Ender</th>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">Descrição</th>
                <th style="font-size: 1.12rem; font-weight: 700; background: #333; color: whitesmoke; border: 1px solid whitesmoke;">Status</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($fornecedores as $fornecedor): ?>
            <tr>
                <td style="background: #f9f9f9; border: 1px solid #fff; text-align: center;">
                    <?= ucfirst($fornecedor['nome_fornecedor']); ?>
                </td>
                <td style="background: #f9f9f9; border: 1px solid #fff; text-align: center;">
                    <?= ($fornecedor['cnpj'])? Mascara::mascararCPF($fornecedor['cnpj']) : 'N/A'; ?>
                </td>
                <td style="background: #f9f9f9; border: 1px solid #fff; text-align: center;">
                    <?= ($fornecedor['email'])? $fornecedor['email'] : 'N/A'; ?>
                </td>
                <td style="background: #f9f9f9; border: 1px solid #fff; text-align: center;">
                    <?= ($fornecedor['celular_fornecedor'])? Mascara::mascararCPF($fornecedor['celular_fornecedor']) : 'N/A'; ?>
                </td>
                <td style="background: #f9f9f9; border: 1px solid #fff; text-align: center;">
                    <?= ucfirst($fornecedor['ender_fornecedor'])? $fornecedor['ender_fornecedor'] : 'N/A'; ?>
                </td>
                <td style="background: #f9f9f9; border: 1px solid #fff; text-align: center;">
                    <?= (isset($fornecedor['descricao']) || !empty($fornecedor['descricao'])? $fornecedor['descricao'] : 'N/A'); ?>
                </td>
                <th style="
                    background: #f9f9f9; 
                    border: 1px solid #fff; 
                    text-align: center;
                    color: <?= ($fornecedor['status_fornecedor'] == 'ativo')? 'green' : 'red' ?>;
                ">
                    <?= ucfirst($fornecedor['status_fornecedor']); ?>
                </th>
            </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="30" style="background: #333; color: whitesmoke; border: 1px solid whitesmoke; text-align: right;">
                    <strong>
                        Etec de Francisco Morato - 3º Informática Tarde | 2023
                    </strong>
                </td>
            </tr>
        </tfoot>
    </table>
  <?php } else { ?>
      <br>
      <h3>Sem dados</h3>
  <?php } ?>


  <?php
    use_js_scripts([ 
      'js.lib.xlsx',
      'js.lib.jspdf',
      'js.services.jspdf_plugin_autotable',
      'js.services.ExportTabelaCaixa'
    ]);
  ?>
</body>