<div class="page-header">
  <h1>Editar Regimen</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $regimenes->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $regimenes->id_regimen; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="tipo" class="col-sm-2 control-label">Tipo</label>
      <div class="col-sm-4">
        <select id="tipo" name="tipo" class="form-control" data-live-search="true">
           <option >Seleccione</option>
           <option value="0" <?php if($regimenes->tipo == 0) echo "selected"; ?>>No Planificable</option>
           <option value="1" <?php if($regimenes->tipo == 1) echo "selected"; ?>>Planificable</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="base" class="col-sm-2 control-label">Base</label>
      <div class="col-sm-4">
        <select id="base" name="base" class="form-control validate[required]" data-live-search="true">
           <option >Seleccione</option>
           <?php if($bases){ ?>
           <?php foreach($bases as $base){ ?>
              <option value="<?php echo $base->id_regimen; ?>"  <?php if($regimenes->base == $base->id_regimen) echo "selected"; ?>><?php echo $base->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="producto" class="col-sm-2 control-label">Producto</label>
      <div class="col-sm-4">
        <select id="producto" name="producto" class="form-control validate[required]" data-live-search="true">
           <option >Seleccione</option>
           <?php if($productos){ ?>
           <?php foreach($productos as $producto){ ?>
              <option value="<?php echo $producto->id_producto; ?>"  <?php if($regimenes->producto == $producto->id_producto) echo "selected"; ?>><?php echo $producto->nombre_producto; ?></option>
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