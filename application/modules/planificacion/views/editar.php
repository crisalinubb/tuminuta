<div class="page-header">
  <h1>Editar Receta</h1>
</div>
<form action="<?php echo base_url(); ?>planificacion/editar_receta_planificacion" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Receta</label>
      <div class="col-sm-10">
       <?php $recetas = $this->objRecetas->obtener(array('id_receta' => $receta_planificacion->id_receta)); ?> 
        <input type="text" id="receta" name="receta" class="form-control validate[required]" value="<?php echo $recetas->nombre; ?>" readonly/>
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $receta_planificacion->id_planificacion; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="volumen" class="col-sm-2 control-label">Volumen</label>
      <div class="col-sm-10">
        <input type="text" id="volumen" name="volumen" class="form-control validate[required]" value="<?php echo $receta_planificacion->volumen_produccion; ?>" required/>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>