<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Entrega por servicio</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Entrega por servicio</h1>

    <div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="post" action="<?php echo base_url(); ?>control_casino/busqueda_funcionarios_por_servicio">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="servicios_clinicos" name="servicios_clinicos" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($servicios_clinicos){ ?>
           <?php foreach($servicios_clinicos as $servicio_clinico){ ?>
              <option value="<?php echo $servicio_clinico->id_servicio; ?>"><?php echo $servicio_clinico->nombre_servicio; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>
    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<?php if ($arreglo) { ?>
<?php $i=0; ?>
 <div><h3 style="color: red";>ERROR!!!!, POR FAVOR REVISAR LAS SIGUIENTES SOLICITUDES DE ESTOS FUNCIONARIOS:</h3>
  <ul class="list-group"> 
  <?php while ( $i < sizeof($arreglo)) { ?> 
    <li class="list-group-item list-group-item-danger" role="alert" style="color: red;"><strong><?php echo $arreglo[$i]."\r\n";?></strong></li>
    <?php $i++;?>
  <?php } ?>
</ul>
<?php } ?>

<?php if($datos){ ?>
  <form class="form-inline" method="post" action="<?php echo base_url(); ?>control_casino/transaccion_por_servicio">
<div>
<div class="form-group">
<input type="hidden" id="servicios_clinicos" name="servicios_clinicos" class="form-control" value="<?php echo $codigo_servicio; ?>" />
<label for="funcionarios_sol" class="col-sm-4 control-label">Funcionario:</label>
  <div class="col-sm-10">
    <select id="funcionarios_sol[]" name="funcionarios_sol[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
  
      <?php foreach($datos as $fun_sol){ ?>
      <?php $funcionario = $this->objFuncionario->obtener(array('id_funcionario' => $fun_sol->fk_funcionario));?>
        <option value="<?php echo $funcionario->id_funcionario; ?>" selected data-subtext="<?php echo $funcionario->rut; ?>"><?php echo $funcionario->nombre . " " . $funcionario->apellido_pat. " " . $funcionario->apellido_mat ?></option>
      <?php } ?>
      
  </select>
  </div>
</div>
</div>

<div class="text-box">
  <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
</div>
</form>
<?php } ?>



