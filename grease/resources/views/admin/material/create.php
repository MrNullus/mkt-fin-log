<?php
# ------ Configurações Básicas
require dirname(dirname(dirname(dirname(__DIR__)))) . '\config.php';

global $_ENV;   

import_utils(['auth']);

Auth::check('adm');
 
import_utils([
  'extend_styles', 
  'use_js_scripts', 
  'render_component',
  'Money'
]);

$categoria_material = new CategoriaMaterial($mysqli);
$categorias = $categoria_material->buscarTodos();

// Verifica se a variável de sessão 'ultimo_acesso' já existe
if(isset($_SESSION['ultimo_acesso'])) {
  $ultimo_acesso = $_SESSION['ultimo_acesso'];
  
  // Verifica se já passaram 5 minutos desde o último acesso
  if(time() - $ultimo_acesso > 100) {
    unset($_SESSION['fed_material']);
  }
} 
?>


<?php
render_component('head');
extend_styles([ 'css.admin.financas' ]);
?>
<title>
    Admin 🕺 Grease
</title>
<style type="text/css">
    /* Estilização do input do tipo "file" */
.input-file {
  position: relative;
  display: inline-block;
  cursor: pointer;
  font-size: 16px;
  color: #fff;
  background-color: #4CAF50;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
}

/* Estilização do texto do botão */
.input-file span {
  font-weight: bold;
}

/* Estilização do input real, escondido */
.input-file input[type="file"] {
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
}

/* Efeito de hover no botão */
.input-file:hover {
  background-color: #45a049;
}

/* Efeito de focus no botão */
.input-file:focus {
  outline: none;
  box-shadow: 0 0 5px #4CAF50;
}

</style>



<body>
  <?php
  render_component('sidebar');
  ?>

    <?php if (isset($_SESSION['fed_material']) && !empty($_SESSION['fed_material'])): ?>
        <script>
            Swal.fire({
                title: '<?php echo $_SESSION['fed_material']['title']; ?>',
                text: '<?php echo $_SESSION['fed_material']['msg']; ?>',
                icon: 'error',
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
            <span class="text">Cadastro Material</span>
          </div>

          <form 
            method="POST" 
            action="<?php echo $_ENV['URL_CONTROLLERS']; ?>/Material/CadastroController.php"
            enctype="multipart/form-data"
          >
            <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario']['usuario_id'] ?>" />

            
            <label for="nome">Nome</label>
            <input type="text" class="text" name="nome" placeholder="Corda de arame...">
            <br><br>

            <label for="categoria">Categoria</label>
            <select name="categoria_id">
                <option value="">
                    - Selecione a Categoria -
                </option>
                
                <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo $categoria['categoria_id']; ?>">
                    <?php echo $categoria['nome']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <br><br>
     
            <label for="descricao">Descrição</label>
            <input type="text" class="text" name="descricao" placeholder="Uma corda de arame preta...">
            <br><br>

            
            <label for="qtde_estimada">Quantidade estimada</label>
            <input type="number" class="text" name="qtde_estimada" placeholder="5 unidades...">
            <br><br>

            <label for="valor_estimado">Valor estimado</label>
            <input type="text" class="text" name="valor_estimado" placeholder="R$10.00">
            <br>
            <br>

            <label for="valor_gasto">Valor gasto</label>
            <input type="text" class="text" name="valor_gasto" placeholder="R$50.00">
            <br><br>

            <label for="unidade_medida">Unidade de medida em Metros</label>
            <input type="text" class="text" name="unidade_medida" placeholder="10 metros">
            <br><br>

            <label for="estoque_minimo">Estoque mínimo</label>
            <input type="number" class="text" name="estoque_minimo" placeholder="5 unidades">
            <br><br>

            <label for="estoque_atual">Estoque atual</label>
            <input type="number" class="text" name="estoque_atual" placeholder="2 unidades">
            <br><br>

            <label for="valor_unitario">Valor unitário</label>
            <input type="text" class="text" name="valor_unitario" placeholder="R$15.00">
            <br><br>

            <label for="data_validade">Data de validade</label>
            <input type="date" class="text" name="data_validade" placeholder="10/09/2024">
            <br><br>

            <label for="foto_material">Foto do material</label>
            <input type="file" class="text input-file" name="foto_material[]">
            <br><br>
            
            <label for="status_material">Status do material</label>
            <input type="text" class="text" name="status_material" placeholder="Ok">
            <br><br>

            <input type="submit" value="salvar">
        </form>
      </div>
    </div>
  </section>

    
  <?php
  use_js_scripts([ 'js.admin.financas' ]);
  ?>
  <script>
    $(document).ready(() => {
      $('#money').maskMoney({
        prefix: 'R$ ',
        allowNegative: false,
        thousands: '.', decimal: ',',
        affixesStay: true
      });

      $('#frm-entrada').submit(function(event) {
        $('input[name=valor]').val($('input[name=valor]').maskMoney('unmasked')[0]);
      });
    });
  </script>
</body>