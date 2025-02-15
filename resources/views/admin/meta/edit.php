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
  'Money'
]);

# Receber os dados enviados via POST
$dados = $_POST;

print_r($_POST);

// Verifica se a variável de sessão 'ultimo_acesso' já existe
if(isset($_SESSION['ultimo_acesso'])) {
  $ultimo_acesso = $_SESSION['ultimo_acesso'];
  
  // Verifica se já passaram 5 minutos desde o último acesso
  if(time() - $ultimo_acesso > 2) {
    unset($_SESSION['fed_meta']);
  }
} 
?>


<!------- HEAD --------->
<?php
render_component('head');
extend_styles([ 'css.admin.financas' ]);
?>
<title>
  Finanças Admin 🕺 Grease
</title>
<!------- /HEAD --------->


<body>
  <?php
  render_component('sidebar');
  ?>

  <?php if (isset($_SESSION['fed_categoria_material']) && !empty($_SESSION['fed_categoria_material'])): ?>
  <script>
    Swal.fire({
      title: '<?php echo $_SESSION['fed_categoria_material']['title']; ?>',
      text: '<?php echo $_SESSION['fed_categoria_material']['msg']; ?>',
      icon: '<?php echo $_SESSION['fed_categoria_material']['icon']; ?>',
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
            <span class="text">Editar Categoria</span>
          </div>

           <form method="POST" id="frm-entrada" action="<?php echo $_ENV['URL_CONTROLLERS']; ?>/Meta/UpdateController.php">
          <input type="hidden" name="id" value="<?php echo isset($dados['id']) ? $dados['id'] : ''; ?>">

          <label for="nome">Nome:</label>
          <input type="text" name="nome" placeholder="Corda de arame..." value="<?php echo isset($dados['nome']) ? $dados['nome'] : ''; ?>">
          <br>
          <br>

          <!-- Preencha os outros campos com os valores correspondentes do array $dados -->
          <label for="descricao">Descrição:</label>
          <input type="text" name="descricao" placeholder="Descrição..." value="<?php echo isset($dados['descricao']) ? $dados['descricao'] : ''; ?>">
          <br>
          <br>

          <label for="data_inicio">Data de Início:</label>
          <input type="date" name="data_inicio" value="<?php echo isset($dados['data_inicio']) ? $dados['data_inicio'] : ''; ?>">
          <br>
          <br>

          <label for="data_fim">Data de Fim:</label>
          <input type="date" name="data_fim" value="<?php echo isset($dados['data_fim']) ? $dados['data_fim'] : ''; ?>">
          <div class="error-msg" id="lblErroDataInicio"></div>
          <br>
          <br>

          <label for="total_necessario">Total Necessário:</label>
          <input type="text" name="total_necessario" class="money" value="<?php echo isset($dados['total_necessario']) ? $dados['total_necessario'] : ''; ?>">
          <br>
          <br>

          <input type="hidden" name="status" value="<?php echo $dados['status'] == 1? 1 : 0; ?>">

          <input type="submit" value="Salvar">
        </form>
      </div>
    </div>
  </section>


  <?php
  use_js_scripts([ 'js.lib.maskMoney'  ]);
  use_js_scripts([ 'js.admin.financas' ]);
  ?> 
 <script>
    $(document).ready(() => {
      $('.money').maskMoney({
        prefix: 'R$ ',
        allowNegative: false,
        thousands: '.', decimal: ',',
        affixesStay: true
      });
      
      $('#frm-entrada').submit(function(event) {
        $('.money').each(function() {
          $(this).val($(this).maskMoney('unmasked')[0]);
        });
      });

       // Verificar se a data de início é menor que a data de fim
      $('input[name=data_inicio]').blur(({ currentTarget }) => { 
        let erro = '';
        const dataInicio = new Date(currentTarget.value);
        const dataFim = new Date($('input[name=data_fim]').val());

        if (dataInicio >= dataFim) {
          $('#btn-register').prop('disabled', true);
          erro = '* A data de início deve ser menor que a data de fim';
        } else {
          $('#btn-register').prop('disabled', false);
          erro = '';
        }

        $('#lblErroDataInicio').text(erro);
      });
    });
  </script>
</body>