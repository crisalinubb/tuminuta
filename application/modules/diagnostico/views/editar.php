<div class="page-header">
  <h1>Editar Diagnostico</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="codigo_diagnostico" class="col-sm-2 control-label">Codigo Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_diagnostico" name="codigo_diagnostico" class="form-control" value="<?php echo $diagnostico->diagnostico_codigo; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $diagnostico->diagnostico_descripcion; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $diagnostico->id_diagnostico; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="observacion" class="col-sm-2 control-label">Observacion</label>
      <div class="col-sm-10">
        <input type="text" id="observacion" name="observacion" class="form-control" value="<?php echo $diagnostico->diagnostico_observacion; ?>" />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>