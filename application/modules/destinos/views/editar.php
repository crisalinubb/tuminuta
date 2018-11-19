<div class="page-header">
  <h1>Editar Destino</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="destino" class="col-sm-2 control-label">Destino</label>
      <div class="col-sm-10">
        <input type="text" id="destino" name="destino" class="form-control validate[required]" value="<?php echo $destinos->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $destinos->id_destino; ?>" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>