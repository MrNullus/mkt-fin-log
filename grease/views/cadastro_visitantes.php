<?php
require('../config.php');
?>


<h1> Cadastro Visitantes </h1>

<form method="POST" action="<?php url_controllers('cadastroUsuario'); ?>">
    <input name="tipo_usuario" type="hidden" value="visitante" />

    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="idade">Idade:</label>
        <input type="text" class="form-control" id="autor">
    </div>
    <div class="form-group">
        <label for="genero">Gênero:</label>
        <select name="genero" id="genero">
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outro</option>
        </select>
    </div>
    <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" pattern="\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>