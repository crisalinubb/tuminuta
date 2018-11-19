<div class="page-header">
  <h1>Editar Aporte por Insumo</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

     <div class="form-group">
      <div class="col-sm-10">
        <input type="hidden" id="codigo_insumo" name="codigo_insumo" class="form-control validate[required]" value="<?php echo $aportes_insumos->id_insumo; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_aporte" class="col-sm-2 control-label">Aporte Nutricional</label>
      <div class="col-sm-4">
        <select id="codigo_aporte" name="codigo_aporte" class="selectpicker" data-live-search="true" required>
           <option disabled>Seleccione</option>
           <?php if($aportes_nutricionales){ ?>
           <?php foreach($aportes_nutricionales as $aporte_nutricional){ ?>
              <option value="<?php echo $aporte_nutricional->id_aporte_nutricional; ?>"  <?php if($aportes_insumos->id_aporte == $aporte_nutricional->id_aporte_nutricional) echo "selected"; ?>><?php echo $aporte_nutricional->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

     <div class="form-group">
      <label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
      <div class="col-sm-10">
        <input type="text" id="cantidad" name="cantidad" class="form-control validate[required]" value="<?php echo $aportes_insumos->cantidad; ?>" required/>
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $aportes_insumos->id_aporteinsumo; ?>" />
      </div>
    </div>

     <div class="form-group">
      <label for="cantidad_aporte" class="col-sm-2 control-label">Cantidad Aporte</label>
      <div class="col-sm-10">
        <input type="number" id="cantidad_aporte" name="cantidad_aporte" class="form-control validate[required]" value="<?php echo $aportes_insumos->cantidadAporte; ?>" required/>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>