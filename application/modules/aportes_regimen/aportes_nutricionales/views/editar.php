<div class="page-header">
  <h1>Editar Aporte Nutricional</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $aportes_nutricionales->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $aportes_nutricionales->id_aporte_nutricional; ?>" />
      </div>
    </div>

      <div class="form-group">
      <label for="unidades_medida" class="col-sm-2 control-label">Tipo Funcionario</label>
      <div class="col-sm-4">
        <select id="unidades_medida" name="unidades_medida" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($unidades_medida){ ?>
           <?php foreach($unidades_medida as $unidad){ ?>
              <option value="<?php echo $unidad->id_unidad_medidad; ?>"  <?php if($aportes_nutricionales->id_unidad_medida == $unidad->id_unidad_medidad) echo "selected"; ?>><?php echo $unidad->nombre; ?></option>
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