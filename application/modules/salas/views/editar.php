<div class="page-header">
  <h1>Editar Sala</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="servicio_clinico" class="col-sm-2 control-label">Servicio Clinico</label>
      <div class="col-sm-4">
        <select id="servicio_clinico" name="servicio_clinico" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($servicio_clinicos){ ?>
           <?php foreach($servicio_clinicos as $servicio_clinico){ ?>
              <option value="<?php echo $servicio_clinico->id_servicio; ?>"  <?php if($salas->CODSERV == $servicio_clinico->id_servicio) echo "selected"; ?>><?php echo $servicio_clinico->nombre_servicio; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_sala" class="col-sm-2 control-label">Codigo</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_sala" name="codigo_sala" class="form-control validate[required]" value="<?php echo $salas->CODSALA; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $salas->id_sala; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $salas->NOMSALA; ?>" />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>