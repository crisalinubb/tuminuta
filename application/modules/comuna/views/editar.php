<div class="page-header">
  <h1>Editar Comuna</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Comuna</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $comuna->comuna_nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $comuna->id_comuna; ?>" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>