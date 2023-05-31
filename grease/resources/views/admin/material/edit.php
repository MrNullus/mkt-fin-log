<?php
# ------ Configurações Básicas
require dirname(dirname(dirname(dirname(__DIR__)))) . '\config.php';

global $_ENV;   

$categoria_material = new CategoriaMaterial($mysqli);
$categorias = $categoria_material->buscarTodos();

# Receber os dados enviados via POST
$materialData = $_POST;
//print_r($materialData);

import_utils(['extend_styles', 'render_component']);

// Verifica se a variável de sessão 'ultimo_acesso' já existe
if(isset($_SESSION['ultimo_acesso'])) {
  $ultimo_acesso = $_SESSION['ultimo_acesso'];
  
  // Verifica se já passaram 5 minutos desde o último acesso
  if(time() - $ultimo_acesso > 100) {
    unset($_SESSION['fed_cadastro_usuario']);
  }
} 
?>


<?php
require $_ENV['PASTA_VIEWS'] . '/components/head.php';
?>
<title>
    Admin 🕺 Grease
</title>


<body>
    <?php
    require $_ENV['PASTA_VIEWS'] . '/components/header.php';
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
    
    <form 
        method="POST" 
        action="<?php echo $_ENV['URL_CONTROLLERS']; ?>/Material/UpdateController.php"
        enctype="multipart/form-data"
    >
        <input 
            type="hidden" 
            class="text" 
            name="material_id" 
            value="<?= $materialData['material_id']; ?>" />

        <input type="text" class="text" name="nome" placeholder="Corda de arame..." value="<?= $materialData['nome']; ?>">
        <label for="nome">Nome</label>
        <br>

        <label for="categoria">Categoria</label>
        <select name="categoria_id">
            <option value="">- Selecione a Categoria -</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo $categoria['categoria_id']; ?>" <?php echo ($materialData['categoria_id'] == $categoria['categoria_id']) ? 'selected' : ''; ?>>
                    <?php echo $categoria['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <input type="text" class="text" name="descricao" placeholder="Uma corda de arame preta..." value="<?= $materialData['descricao']; ?>">
        <label for="descricao">Descrição</label>
        <br>

        <input type="number" class="text" name="qtde_estimada" placeholder="5 unidades..." value="<?= $materialData['qtde_estimada']; ?>">
        <label for="qtde_estimada">Quantidade estimada</label>
        <br>

        <input type="text" class="text" name="valor_estimado" placeholder="R$10.00" value="<?= $materialData['valor_estimado']; ?>">
        <label for="valor_estimado">Valor estimado</label>
        <br>

        <input type="text" class="text" name="valor_gasto" placeholder="R$50.00" value="<?= $materialData['valor_gasto']; ?>">
        <label for="valor_gasto">Valor gasto</label>
        <br>

        <input type="text" class="text" name="unidade_medida" placeholder="10 metros" value="<?= $materialData['unidade_medida']; ?>">
        <label for="unidade_medida">Unidade de medida em Metros</label>
        <br>

        <input type="number" class="text" name="estoque_minimo" placeholder="5 unidades" value="<?= $materialData['estoque_minimo']; ?>">
        <label for="estoque_minimo">Estoque mínimo</label>
        <br>

        <input type="number" class="text" name="estoque_atual" placeholder="2 unidades" value="<?= $materialData['estoque_atual']; ?>">
        <label for="estoque_atual">Estoque atual</label>
        <br>

        <input type="text" class="text" name="valor_unitario" placeholder="R$15.00" value="<?= $materialData['valor_unitario']; ?>">
        <label for="valor_unitario">Valor unitário</label>
        <br>

        <input type="date" class="text" name="data_validade" placeholder="10/09/2024" value="<?= $materialData['data_validade']; ?>">
        <label for="data_validade">Data de validade</label>
        <br>

        <img 
          width="300px"
          src="<?= $_ENV['STORAGE'].  '/image/material/' .$materialData['foto_material']; ?>" 
          alt="<?= $materialData['nome']; ?>" />
        <input type="file" class="text" name="foto_material[]">
        <label for="foto_material">Foto do material</label>
        <br>

        <input type="text" class="text" name="status_material" placeholder="Status ok" value="<?= $materialData['status_material']; ?>">
        <label for="status_material">Status do material</label>
        <br>

        <button class="signin login">
            Cadastrar
        </button>
    </form>


    <?php
    require $_ENV['PASTA_VIEWS'] . '/components/footer.php';
    ?>
</body>