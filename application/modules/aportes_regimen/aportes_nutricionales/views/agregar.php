<div class="page-header">
  <h1>Agregar Aporte Nutricional</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
      </div>
    </div>
    
    <div class="form-group">
      <label for="tipo" class="col-sm-2 control-label">Unidad de medida</label>
      <div class="col-sm-4">
        <select id="unidades_medida" name="unidades_medida" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($unidades_medida){ ?>
           <?php foreach($unidades_medida as $unidad){ ?>
              <option value="<?php echo $unidad->id_unidad_medidad; ?>"><?php echo $unidad->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>
    
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
