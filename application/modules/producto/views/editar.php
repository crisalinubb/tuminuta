<div class="page-header">
  <h1>Editar Hospital</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="producto" class="col-sm-2 control-label">Producto</label>
      <div class="col-sm-10">
        <input type="text" id="producto" name="producto" class="form-control validate[required]" value="<?php echo $producto->nombre_producto; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $producto->id_producto; ?>" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>