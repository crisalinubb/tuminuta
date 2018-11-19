<div class="page-header">
  <h1>Agregar Insumo por Receta</h1>
</div>
  
 <?php if($this->session->flashdata('error')){  ?>

        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>

    <?php }  ?>

<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <div class="col-sm-10">
        <input type="hidden" id="codigo_receta" name="codigo_receta" class="form-control validate[required]" value="<?php echo $receta; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_insumo" class="col-sm-2 control-label">Insumo</label>
      <div class="col-sm-4">
        <select id="codigo_insumo" name="codigo_insumo" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($insumos){ ?>
           <?php foreach($insumos as $insumo){ ?>
              <option value="<?php echo $insumo->id_insumo; ?>"><?php echo $insumo->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
      <div class="col-sm-10">
        <input type="number" id="cantidad" name="cantidad" class="form-control" required />
      </div>
    </div>
    
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
