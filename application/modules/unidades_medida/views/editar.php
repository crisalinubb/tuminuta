<div class="page-header">
  <h1>Editar Unidad de Medida</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="codigo" class="col-sm-2 control-label">Codigo</label>
      <div class="col-sm-10">
         <input type="text" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $unidad_medida->id_unidad_medidad; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $unidad_medida->nombre; ?>" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>