<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Solicitud por servicio</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitud por servicio</h1>

    <div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="post" action="<?php echo base_url(); ?>control_casino/busqueda_funcionarios">
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

<?php if($funcionarios){ ?>

<form class="form-inline" method="post" action="<?php echo base_url(); ?>control_casino/agregar_solicitud">

<div class="form-group">
  <label for="servicio_clinico" class="col-sm-7 control-label">Servicio Clinico:</label>
    <div class="col-sm-8">
      <input type="text" id="nombre_servicio" name="nombre_servicio" class="form-control validate[required]" value="<?php echo $nombre_servicio; ?>" readonly/>
      <input type="hidden" id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]" value="<?php echo $codigo_servicio; ?>" />
    </div>
</div>

<div class="form-group">
<label for="funcionarios" class="col-sm-4 control-label">Funcionario:</label>
  <div class="col-sm-10">
    <select id="funcionarios" name="funcionarios[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
      <?php if($funcionarios){ ?>
      <?php foreach($funcionarios as $funcionario){ ?>
        <option value="<?php echo $funcionario->id_funcionario; ?>" selected data-subtext="<?php echo $funcionario->rut; ?>"><?php echo $funcionario->nombre . " " . $funcionario->apellido_pat. " " . $funcionario->apellido_mat ?></option>
      <?php } ?>
      <?php } ?>
  </select>
  </div>
</div>

<div class="form-group">
<label for="tipos_comida" class="col-sm-7 control-label">Tipo de Comida:</label>
  <div class="col-sm-8">
    <select id="tipos_comida" name="tipos_comida" class="selectpicker validate[required]">
      <?php if($tipos_comida){ ?>
      <?php foreach($tipos_comida as $tipo_comida){ ?>
        <option value="<?php echo $tipo_comida->id_tipocomida; ?>"><?php echo $tipo_comida->nombre?></option>
      <?php } ?>
      <?php } ?>
  </select>
  </div>
</div>

<div class="form-group">
  <label for="fecha_solicitud" class="col-sm-7 control-label">Fecha Solicitud</label>
    <div class="col-sm-8">
      <div class="input-group date">
        <input id="fecha_solicitud" type="text" class="form-control" name="fecha_solicitud" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
</div>

<div class="text-box">
  <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
</div>

</form>
<?php } ?>

<script>
  $("#fecha_solicitud").datepicker();
</script>