<div class="page-header">
  <h1>Editar Recetas</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $recetas->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $recetas->id_receta; ?>" />
      </div>
    </div>

      <div class="form-group">
      <label for="codigo_regimen" class="col-sm-2 control-label">Regimen</label>
      <div class="col-sm-4">
        <select id="codigo_regimen" name="codigo_regimen" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>"  <?php if($recetas->id_regimen == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

     <div class="form-group">
      <label for="codigo_tiporeceta" class="col-sm-2 control-label">Tipo de Receta</label>
      <div class="col-sm-4">
        <select id="codigo_tiporeceta" name="codigo_tiporeceta" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($tipo_recetas){ ?>
           <?php foreach($tipo_recetas as $tipo_receta){ ?>
              <option value="<?php echo $tipo_receta->id_tipo_receta; ?>"  <?php if($recetas->id_tipo_receta == $tipo_receta->id_tipo_receta) echo "selected"; ?>><?php echo $tipo_receta->nombre; ?></option>
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
           <option value="<?php echo $recetas->formula; ?>" <?php if($recetas->formula == 0) echo "selected"; ?>>No</option>
           <option value="<?php echo $recetas->formula; ?>" <?php if($recetas->formula == 1) echo "selected"; ?>>Si</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="complemento" class="col-sm-2 control-label">Complemento</label>
      <div class="col-sm-4">
        <select id="complemento" name="complemento" class="selectpicker" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="<?php echo $recetas->complemento; ?>" <?php if($recetas->complemento == 0) echo "selected"; ?>>No</option>
           <option value="<?php echo $recetas->complemento; ?>" <?php if($recetas->complemento == 1) echo "selected"; ?>>Si</option>
        </select>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>