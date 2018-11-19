<div class="page-header">
  <h1>Editar Insumo Receta</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $insumos_recetas->id_insumo_receta; ?>" />
    </div>

    <div class="form-group">
         <input type="hidden" id="codigo_receta" name="codigo_receta" class="form-control validate[required]" value="<?php echo $insumos_recetas->id_receta; ?>" />
    </div>

    <div class="form-group">
      <label for="codigo_insumo" class="col-sm-2 control-label">Insumo</label>
      <div class="col-sm-4">
        <select id="codigo_insumo" name="codigo_insumo" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($insumos){ ?>
           <?php foreach($insumos as $insumo){ ?>
              <option value="<?php echo $insumo->id_insumo; ?>"  <?php if($insumos_recetas->id_insumo == $insumo->id_insumo) echo "selected"; ?>><?php echo $insumo->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
      <div class="col-sm-10">
        <input type="number" id="cantidad" name="cantidad" class="form-control" value="<?php echo $insumos_recetas->cantidad; ?>" required/>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>