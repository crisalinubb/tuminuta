<div class="page-header">
  <h1>Agregar Aportes por Regimen</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
     <div class="form-group">
      <label for="codigo_regimen" class="col-sm-2 control-label">Regimen</label>
      <div class="col-sm-4">
        <select id="codigo_regimen" name="codigo_regimen" class="selectpicker" data-live-search="true" required>
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
      <label for="tipo_aporte" class="col-sm-2 control-label">Tipo de Aporte</label>
      <div class="col-sm-4">
        <select id="tipo_aporte" name="tipo_aporte" class="selectpicker" data-live-search="true" required>
           <option disabled selected>Seleccione</option>
           <?php if($tipo_aporte){ ?>
           <?php foreach($tipo_aporte as $tipo_aport){ ?>
              <option value="<?php echo $tipo_aport->id_tipoaporte; ?>"><?php echo $tipo_aport->tipoaporte_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="kcal" class="col-sm-2 control-label">Kcal</label>
      <div class="col-sm-10">
        <input type="text" id="kcal" name="kcal" class="form-control" required/>
      </div>
    </div>

    <div class="form-group">
      <label for="prot" class="col-sm-2 control-label">Prot</label>
      <div class="col-sm-10">
        <input type="text" id="prot" name="prot" class="form-control" required/>
      </div>
    </div>

    <div class="form-group">
      <label for="lip" class="col-sm-2 control-label">Lip</label>
      <div class="col-sm-10">
        <input type="text" id="lip" name="lip" class="form-control" required/>
      </div>
    </div>

    <div class="form-group">
      <label for="cho" class="col-sm-2 control-label">Cho</label>
      <div class="col-sm-10">
        <input type="text" id="cho" name="cho" class="form-control" required/>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>