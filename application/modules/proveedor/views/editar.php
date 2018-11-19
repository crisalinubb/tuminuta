<div class="page-header">
  <h1>Editar Rubro</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $proveedor->nombre_proveedor; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $proveedor->id_proveedor; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="direccion" class="col-sm-2 control-label">Direccion</label>
      <div class="col-sm-10">
        <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $proveedor->direccion; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="telefono" class="col-sm-2 control-label">Telefono</label>
      <div class="col-sm-10">
        <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $proveedor->telefono; ?>" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>