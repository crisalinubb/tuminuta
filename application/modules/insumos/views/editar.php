<div class="page-header">
  <h1>Editar Insumo</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Codigo</label>
      <div class="col-sm-10">
         <input type="text" id="codigo_insumo" name="codigo_insumo" class="form-control validate[required]" value="<?php echo $insumos->codigo; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $insumos->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $insumos->id_insumo; ?>" />
      </div>
    </div>

      <div class="form-group">
      <label for="codigo_rubro" class="col-sm-2 control-label">Rubros</label>
      <div class="col-sm-4">
        <select id="codigo_rubro" name="codigo_rubro" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($rubros){ ?>
           <?php foreach($rubros as $rubro){ ?>
              <option value="<?php echo $rubro->id_rubro; ?>"  <?php if($insumos->id_rubro == $rubro->id_rubro) echo "selected"; ?>><?php echo $rubro->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_unidadmedida" class="col-sm-2 control-label">Unidad de Medida</label>
      <div class="col-sm-4">
        <select id="codigo_unidadmedida" name="codigo_unidadmedida" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($unidades_medidas){ ?>
           <?php foreach($unidades_medidas as $unidades_medida){ ?>
              <option value="<?php echo $unidades_medida->id_unidad_medidad; ?>"  <?php if($insumos->id_unidad_medida == $unidades_medida->id_unidad_medidad) echo "selected"; ?>><?php echo $unidades_medida->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="perecible" class="col-sm-2 control-label">Estado</label>
      <div class="col-sm-4">
        <select id="perecible" name="perecible" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="1" <?php if($insumos->perecible) echo "selected"; ?>>Perecible</option>
           <option value="0" <?php if(!$insumos->perecible) echo "selected"; ?>>No Perecible</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="factor_pedido" class="col-sm-2 control-label">Factor Pedido</label>
      <div class="col-sm-10">
        <input type="text" id="factor_pedido" name="factor_pedido" class="form-control validate[required]" value="<?php echo $insumos->factor_pedido; ?>"/>
      </div>
    </div>
    
    <div class="form-group">
      <label for="costo" class="col-sm-2 control-label">Costo</label>
      <div class="col-sm-10">
        <input type="text" id="costo" name="costo" class="form-control validate[required]" value="<?php echo $insumos->costo; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_proveedor" class="col-sm-2 control-label">Proveedor</label>
      <div class="col-sm-4">
        <select id="codigo_proveedor" name="codigo_proveedor" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($proveedores){ ?>
           <?php foreach($proveedores as $proveedor){ ?>
              <option value="<?php echo $proveedor->id_proveedor; ?>"  <?php if($insumos->id_proveedor == $proveedor->id_proveedor) echo "selected"; ?>><?php echo $proveedor->nombre_proveedor; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>    

    <div class="form-group">
      <label for="factor_costo" class="col-sm-2 control-label">Factor costo</label>
      <div class="col-sm-10">
        <input type="text" id="factor_costo" name="factor_costo" class="form-control validate[required]" value="<?php echo $insumos->factor_costo; ?>"/>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>