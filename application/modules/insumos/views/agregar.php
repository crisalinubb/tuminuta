<div class="page-header">
  <h1>Agregar Insumos</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>

      <div class="form-group">
      <label for="codigo" class="col-sm-2 control-label">Codigo</label>
      <div class="col-sm-10">
        <input type="text" id="codigo" name="codigo" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
      </div>
    </div>
    
    <div class="form-group">
      <label for="codigo_rubro" class="col-sm-2 control-label">Rubros</label>
      <div class="col-sm-4">
        <select id="codigo_rubro" name="codigo_rubro" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($rubros){ ?>
           <?php foreach($rubros as $rubro){ ?>
              <option value="<?php echo $rubro->id_rubro; ?>"><?php echo $rubro->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

     <div class="form-group">
      <label for="codigo_unidadmedida" class="col-sm-2 control-label">Unidad de Medida</label>
      <div class="col-sm-4">
        <select id="codigo_unidadmedida" name="codigo_unidadmedida" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($unidades_medidas){ ?>
           <?php foreach($unidades_medidas as $unidades_medida){ ?>
              <option value="<?php echo $unidades_medida->id_unidad_medidad; ?>"><?php echo $unidades_medida->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="perecible" class="col-sm-2 control-label">Perecible</label>
      <div class="col-sm-4">
        <select id="perecible" name="perecible" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="1" selected>Perecible</option>
           <option value="0">No Perecible</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="factor_pedido" class="col-sm-2 control-label">Factor Pedido</label>
      <div class="col-sm-10">
        <input type="text" id="factor_pedido" name="factor_pedido" class="form-control validate[required]" />
      </div>
    </div>
    
    <div class="form-group">
      <label for="costo" class="col-sm-2 control-label">Costo</label>
      <div class="col-sm-10">
        <input type="text" id="costo" name="costo" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_proveedor" class="col-sm-2 control-label">Proveedor</label>
      <div class="col-sm-4">
        <select id="codigo_proveedor" name="codigo_proveedor" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($proveedores){ ?>
           <?php foreach($proveedores as $proveedor){ ?>
              <option value="<?php echo $proveedor->id_proveedor; ?>"><?php echo $proveedor->nombre_proveedor; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="factor_costo" class="col-sm-2 control-label">Factor costo</label>
      <div class="col-sm-10">
        <input type="text" id="factor_costo" name="factor_costo" class="form-control validate[required]" />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
