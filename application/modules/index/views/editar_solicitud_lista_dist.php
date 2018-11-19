<div class="page-header">
  <h1>Editar Solicitud</h1>
</div>
<form action="<?php echo base_url(); ?>index/editar_sol_list" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <div class="col-sm-10">
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $solicitud->id_solicitud; ?>" />
      </div>
    </div>

    <div>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut:</label>
      <div class="col-sm-4">
        <strong><?php echo number_format($paciente_general->rut, 0, ".", ".") . "-" . $paciente_general->dv;?></strong>
      </div>

      <label for="codigo_paciente" class="col-sm-2 control-label">Codigo del paciente:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_general->codigo_atencion;?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre Completo:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_general->nombre." ".$paciente_general->apellido_paterno." ".$paciente_general->apellido_materno;?></strong>
      </div>

     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_general->fecha_nacimiento; ?></strong>
      </div>
      </div>
  </div>

      <div class="form-group">
      <label for="codigo_desayuno" class="col-sm-2 control-label">Desayuno</label>
      <div class="col-sm-4">
        <select id="codigo_desayuno" name="codigo_desayuno" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($desayunos){ ?>
           <?php foreach($desayunos as $desayuno){ ?>
              <option value="<?php echo $desayuno->id_receta; ?>"  <?php if($solicitud->id_desayuno == $desayuno->id_receta) echo "selected"; ?>><?php echo $desayuno->receta_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_almuerzo" class="col-sm-2 control-label">Almuerzo</label>
      <div class="col-sm-4">
        <select id="codigo_almuerzo" name="codigo_almuerzo" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>"  <?php if($solicitud->id_almuerzo == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_once" class="col-sm-2 control-label">Once</label>
      <div class="col-sm-4">
        <select id="codigo_once" name="codigo_once" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($onces){ ?>
           <?php foreach($onces as $once){ ?>
              <option value="<?php echo $once->id_receta; ?>"  <?php if($solicitud->id_once == $once->id_receta) echo "selected"; ?>><?php echo $once->receta_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_cena" class="col-sm-2 control-label">Cena</label>
      <div class="col-sm-4">
        <select id="codigo_cena" name="codigo_cena" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>"  <?php if($solicitud->id_cena == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_col10" class="col-sm-2 control-label">Col-10</label>
      <div class="col-sm-4">
        <select id="codigo_col10" name="codigo_col10" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($colaciones){ ?>
           <?php foreach($colaciones as $colacion){ ?>
              <option value="<?php echo $colacion->id_receta; ?>"  <?php if($solicitud->id_col10 == $colacion->id_receta) echo "selected"; ?>><?php echo $colacion->receta_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_col20" class="col-sm-2 control-label">Col-20</label>
      <div class="col-sm-4">
        <select id="codigo_col20" name="codigo_col20" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($colaciones){ ?>
           <?php foreach($colaciones as $colacion){ ?>
              <option value="<?php echo $colacion->id_receta; ?>"  <?php if($solicitud->id_col20 == $colacion->id_receta) echo "selected"; ?>><?php echo $colacion->receta_nombre; ?></option>
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
