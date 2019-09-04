<div class="page-header">
  <h1>Cambiar Clave</h1>
</div>
<form action="<?php echo base_url(); ?>usuarios/cambiar_password" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
         <input type="hidden" id="id_usuario" name="id_usuario" class="form-control validate[required]" value="<?php echo $codigo_usuario; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" id="password" name="password" class="form-control validate[required]" />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>