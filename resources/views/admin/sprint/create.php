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


//var_dump($_SESSION['fed_sprint']);

// Verifica se a variável de sessão 'ultimo_acesso' já existe
if(isset($_SESSION['ultimo_acesso'])) {
  $ultimo_acesso = $_SESSION['ultimo_acesso'];
  
  // Verifica se já passaram 5 minutos desde o último acesso
  if(time() - $ultimo_acesso > 4) {
    unset($_SESSION['fed_sprint']);
  }
} 
?>


<!------- HEAD --------->
<?php
render_component('head');
extend_styles([ 'css.admin.financas' ]);
?>
<title>
  Sprint 🕺 Admin
</title>
<!------- /HEAD --------->


<body>
  <?php
  render_component('sidebar');
  ?>

  <?php if (isset($_SESSION['fed_sprint']) && !empty($_SESSION['fed_sprint'])): ?>
  <script>
    Swal.fire({
      title: '<?php echo $_SESSION['fed_sprint']['title']; ?>',
      text: '<?php echo $_SESSION['fed_sprint']['msg']; ?>',
      icon: '<?php echo $_SESSION['fed_sprint']['icon']; ?>',
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
            <span class="text">Cadastro Sprint</span>
          </div>
          * Campos Obrigatorios
          <br><br>

          <form 
      			method="POST" 
      			action="<?= $_ENV['URL_CONTROLLERS']; ?>/Sprint/CadastroController.php"
    		  >
            <input type="hidden" name="status_sprint" value="criada" />

      			<label for="titulo">* Titulo:</label>
      			<input type="text" name="titulo" placeholder="Sprint 1" required />
      			<br>
      			<br>

            <label for="data_de_inicio">
            * Data de Inicio:
            </label>
            <input type="date" name="data_de_inicio" class="data_de_inicio" />
            <br><br>

            <label for="data_de_fim">
            *  Data de Fim:
            </label>
            <input type="date" name="data_de_fim" class="data_de_fim" />
            <br><br>

            <label for="descricao">* Descrição:</label><br>
            <textarea name="descricao" required id="" cols="30" rows="3"
                placeholder="Sprint de...">
            </textarea>
            <br><br>
    				
    			 <input type="submit" value="salvar">
    		</form>
      </div>
    </div>
  </section>


  <?php
  use_js_scripts([ 'js.lib.maskMoney', 'js.admin.financas', 'js.masksForInputs' ]);
  ?> 
</body>