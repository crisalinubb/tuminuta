<div class="page-header">
  <h1>Agregar Aporte por Insumo</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <div class="col-sm-10">
        <input type="hidden" id="insumo" name="insumo" class="form-control validate[required]" value="<?php echo $insumo; ?>"/>
      </div>
    </div>
    
    <div class="form-group">
      <label for="codigo_aporte" class="col-sm-2 control-label">Aporte Nutricional</label>
      <div class="col-sm-4">
        <select id="codigo_aporte" name="codigo_aporte" class="selectpicker" data-live-search="true" required>
           <option disabled selected>Seleccione</option>
           <?php if($aportes_nutricionales){ ?>
           <?php foreach($aportes_nutricionales as $aporte_nutricional){ ?>
              <option value="<?php echo $aporte_nutricional->id_aporte_nutricional; ?>"><?php echo $aporte_nutricional->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
      <div class="col-sm-10">
        <input type="text" id="cantidad" name="cantidad" class="form-control" required/>
      </div>
    </div>

    <div class="form-group">
      <label for="cantidad_aporte" class="col-sm-2 control-label">Cantidad Aporte</label>
      <div class="col-sm-10">
        <input type="number" id="cantidad_aporte" name="cantidad_aporte" class="form-control" required/>
      </div>
    </div>
    
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
