<div class="page-header">
  <h1>Editar Servicio Clinico</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Codigo</label>
      <div class="col-sm-10">
         <input type="text" id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]" value="<?php echo $servicio_clinico->codigo_servicio; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $servicio_clinico->id_servicio; ?>" />
      </div>
    </div>

     <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $servicio_clinico->nombre_servicio; ?>" />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>