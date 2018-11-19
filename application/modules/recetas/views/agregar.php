<div class="page-header">
  <h1>Agregar Receta</h1>
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
      <label for="codigo_regimen" class="col-sm-2 control-label">Regimen</label>
      <div class="col-sm-4">
        <select id="codigo_regimen" name="codigo_regimen" class="selectpicker validate[required]" data-live-search="true" >
           <option disabled selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>"><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

     <div class="form-group">
      <label for="codigo_tiporeceta" class="col-sm-2 control-label">Tipo de receta</label>
      <div class="col-sm-4">
        <select id="codigo_tiporeceta" name="codigo_tiporeceta" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($tipo_recetas){ ?>
           <?php foreach($tipo_recetas as $tipo_receta){ ?>
              <option value="<?php echo $tipo_receta->id_tipo_receta; ?>"><?php echo $tipo_receta->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

     <div class="form-group">
      <label for="formula" class="col-sm-2 control-label">Formula</label>
      <div class="col-sm-4">
        <select id="formula" name="formula" class="selectpicker" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>No</option>
           <option value="1">Si</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="complemento" class="col-sm-2 control-label">Complemento</label>
      <div class="col-sm-4">
        <select id="complemento" name="complemento" class="selectpicker" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>No</option>
           <option value="1">Si</option>
        </select>
      </div>
    </div>
    
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
