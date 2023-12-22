<?php
# ------ Configurações Básicas
require dirname(dirname(dirname(dirname(__DIR__)))) . '/config.php';
global $_ENV;

import_utils(['Auth']);

Auth::check('adm');

require $_ENV['PASTA_CONTROLLER'] . '/Fornecedor/ConsultaController.php';
 
import_utils([
  'extend_styles', 
  'use_js_scripts', 
  'render_component',
  'Money'
]);


// Verifica se a variável de sessão 'ultimo_acesso' já existe
if(isset($_SESSION['ultimo_acesso'])) {
  $ultimo_acesso = $_SESSION['ultimo_acesso'];
  // Verifica se já passaram 5 minutos desde o último acesso
  if(time() - $ultimo_acesso >= 2) {
    unset($_SESSION['fed_conta']);
  }
}
?>


<!------- HEAD --------->
<?php
render_component('head');
extend_styles([ 'css.admin.financas' ]);
?>
<title>
  Contas Admin 🕺 Grease
</title>
<!------- /HEAD --------->


<body>
  <?php
  render_component('sidebar');
  ?>

  <?php if (isset($_SESSION['fed_conta']) && !empty($_SESSION['fed_conta'])): ?>
  <script>
    Swal.fire({
      title: '<?php echo $_SESSION['fed_conta']['title']; ?>',
      text: '<?php echo $_SESSION['fed_conta']['msg']; ?>',
      icon: '<?php echo $_SESSION['fed_conta']['icon']; ?>',
      confirmButtonText: 'OK'
    })
  </script>
  <?php endif; ?>




   <section class="dashboard">

    <div class="top">
      <i class="uil uil-bars sidebar-toggle"></i>
    </div>
    <div class="dash-content">
        <div class="overview">
          <div class="title">
            <span class="text">Cadastro Conta</span>
          </div>

          <form 
            id="frm-conta"
      			method="POST" 
      			action="<?= $_ENV['URL_CONTROLLERS']; ?>/Conta/CadastroController.php"
    		  >
            <input type="hidden" name="status_conta" value="0" />
            <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario']['usuario_id'] ?>" />
            <input type="hidden" name="data_insercao" value="<?= date('Y/m/d'); ?>" />
            

      			<label for="fornecedor_id">Fornecedor:</label>
      			<select name="fornecedor_id" require>
                <option value="">
                    - Selecione -
                </option>
                
                <?php if (!empty($fornecedores)): ?>
                  <?php foreach ($fornecedores as $fornecedor): ?>
                    <option 
                      value="<?= $fornecedor['fornecedor_id']; ?>" 
                    >
                        <?php echo $fornecedor['nome']; ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <br><br>

            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" class="" placeholder="Compra dos Paletes" />
            <br>
            <br>

            <label for="email">Descrição:</label>
            <textarea name="descricao" id="" cols="30" rows="10"></textarea>
            <br>
            <br>

            <label for="ender">Valor:</label>
            <input type="text" name="valor" class="money" placeholder="R$ 90,00" />
            <br>
            <br>

            <label for="celular">Data Vencimento:</label>
            <input type="date" class=""  name="data_validade" placeholder="" />
            <br>
            <br>
    				
    			 <input type="submit" value="salvar">
    		</form>
      </div>
    </div>
  </section>


  <?php
    use_js_scripts([ 'js.lib.maskMoney', 'js.admin.financas', 'js.masksForInputs' ]);
  ?> 
  <script type="text/javascript">
    $('.money').maskMoney({
      prefix: 'R$ ',
      allowNegative: false,
      thousands: '.',
      decimal: ',',
      affixesStay: true
    });

    $('#frm-conta').submit(function(event) {
      $('.money').each(function() {
        $(this).val($(this).maskMoney('unmasked')[0]);
      });
    });
  </script>
</body>