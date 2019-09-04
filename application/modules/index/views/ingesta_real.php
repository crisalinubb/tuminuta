<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Porcentaje de Ingesta Real</li>
</ol>

<div class="page-header">
  <h1>Solicitud Dia Actual</h1>
</div>
<form action="<?php echo base_url(); ?>index/agregar_ingesta_Real" method="post" class="form-horizontal">
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

    <input type="hidden" id="codigo_solicitud" name="codigo_solicitud" class="form-control validate[required]" value="<?php echo $codigo_solicitud; ?>" />

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

    <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">Estatura:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->estatura; ?></strong>
      </div>

      <label for="peso" class="col-sm-2 control-label">Peso:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->peso; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">IMC:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->imc; ?></strong>
      </div>

       <label for="ingreso" class="col-sm-2 control-label">Fecha de Ingreso:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->fecha_ingreso; ?></strong>
      </div>
    </div>

     <div class="form-group">
      <label for="diagnostico" class="col-sm-2 control-label">Diagnostico:</label>
      <div class="col-sm-4">
        <?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' => $paciente_hospitalizado->diagnostico)); ?>
        <strong><?php echo $diagnostico->diagnostico_descripcion; ?></strong>
      </div>

      <label for="obs" class="col-sm-2 control-label">Observacion del Diagnostico:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->observacion_diagnostico; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="anamnesis" class="col-sm-2 control-label">Anamnesis:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->anamnesis; ?></strong>
      </div>
      
      <label for="tratamiento" class="col-sm-2 control-label">Tratamiento:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->tratamiento; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="servicio" class="col-sm-2 control-label">Servicio Clinico:</label>
      <div class="col-sm-4">
        <?php $servicio = $this->objServicioClinico->obtener(array('id_servicio' => $paciente_hospitalizado->codigo_servicio)); ?>
        <strong><?php echo $servicio->nombre_servicio; ?></strong>
      </div>
      
      <label for="sala" class="col-sm-2 control-label">Sala:</label>
      <div class="col-sm-4">
        <?php $sala = $this->objSalas->obtener(array('id_sala' => $paciente_hospitalizado->codigo_sala)); ?>
        <strong><?php echo $sala->NOMSALA; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="cama" class="col-sm-2 control-label">Cama:</label>
      <div class="col-sm-4">
        <?php $cama = $this->objCamas->obtener(array('id_cama' => $paciente_hospitalizado->codigo_cama)); ?>
        <strong><?php echo $cama->cama; ?></strong>
      </div>
    </div>
  </div>

   <input type="hidden" id="id_paciente_general" name="id_paciente_general" class="form-control validate[required]" value="<?php echo $paciente_general->id_paciente; ?>"/>

   <input type="hidden" id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_servicio; ?>"/>

   <input type="hidden" id="codigo_sala" name="codigo_sala" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_sala; ?>"/>

   <input type="hidden" id="codigo_cama" name="codigo_cama" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_cama; ?>"/>

   <input type="hidden" id="diagnostico" name="diagnostico" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->diagnostico; ?>"/>

   <input type="hidden" id="id_paciente" name="id_paciente" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->id_paciente; ?>"/>

   <input type="hidden" id="codigo_desayuno" name="codigo_desayuno" class="form-control" value="<?php echo $codigos['desayuno_codigo']; ?>"/>

   <input type="hidden" id="codigo_almuerzo" name="codigo_almuerzo" class="form-control" value="<?php echo $codigos['almuerzo_codigo']; ?>"/>

   <input type="hidden" id="codigo_once" name="codigo_once" class="form-control" value="<?php echo $codigos['once_codigo']; ?>"/>

   <input type="hidden" id="codigo_cena" name="codigo_cena" class="form-control" value="<?php echo $codigos['cena_codigo']; ?>"/>

   <input type="hidden" id="codigo_col10" name="codigo_col10" class="form-control" value="<?php echo $codigos['col10_codigo']; ?>"/>

   <input type="hidden" id="codigo_col20" name="codigo_col20" class="form-control" value="<?php echo $codigos['col20_codigo']; ?>"/>

   <input type="hidden" id="formula" name="formula" class="form-control" value="<?php echo $codigos['formula_codigo']; ?>"/>

   <input type="hidden" id="compl1" name="compl1" class="form-control" value="<?php echo $codigos['c1_codigo']; ?>"/>

   <input type="hidden" id="compl2" name="compl2" class="form-control" value="<?php echo $codigos['c2_codigo']; ?>"/>

   <input type="hidden" id="compl3" name="compl3" class="form-control" value="<?php echo $codigos['c3_codigo']; ?>"/>


<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:40px;">Recetas</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($codigos){ ?>
        <tr>
          <td><p><strong>Desayuno:</strong></p></td>
          <?php $des = $this->objRecetas->obtener(array('id_receta' => $codigos['desayuno_codigo'])); ?>
          <td><?php echo $des->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Almuerzo:</strong></p></td>
          <?php $alm = $this->objRegimen->obtener(array('id_regimen' => $codigos['almuerzo_codigo'])); ?>
          <td><?php echo $alm->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Once:</strong></p></td>
          <?php $once = $this->objRecetas->obtener(array('id_receta' => $codigos['once_codigo'])); ?>
          <td><?php echo $once->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Cena:</strong></p></td>
          <?php $cena = $this->objRegimen->obtener(array('id_regimen' => $codigos['cena_codigo'])); ?>
          <td><?php echo $cena->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Col-10:</strong></p></td>
          <?php $col10 = $this->objRecetas->obtener(array('id_receta' => $codigos['col10_codigo'])); ?>
          <td><?php echo $col10->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Col-20:</strong></p></td>
          <?php $col20 = $this->objRecetas->obtener(array('id_receta' => $codigos['col20_codigo'])); ?>
          <td><?php echo $col20->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Formula:</strong></p></td>
          <?php $formula = $this->objRecetas->obtener(array('id_receta' => $codigos['formula_codigo'])); ?>
          <td><?php echo $formula->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Complemento 1:</strong></p></td>
          <?php $comp1 = $this->objRecetas->obtener(array('id_receta' => $codigos['c1_codigo'])); ?>
          <td><?php echo $comp1->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Complemento 2:</strong></p></td>
          <?php $comp2 = $this->objRecetas->obtener(array('id_receta' => $codigos['c2_codigo'])); ?>
          <td><?php echo $comp2->nombre; ?></td>
        </tr>
        <tr>
          <td><p><strong>Complemento 3:</strong></p></td>
          <?php $comp3 = $this->objRecetas->obtener(array('id_receta' => $codigos['c3_codigo'])); ?>
          <td><?php echo $comp3->nombre; ?></td>
        </tr>
    <?php } else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<div>
      <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
        <thead>
          <tr>
            <th scope="col" style="width:20px;"></th>
            <th scope="col" style="width:30px;">Kcal</th> 
            <th scope="col" style="width:30px;">Prot</th>
            <th scope="col" style="width:30px;">Lip</th>
            <th scope="col" style="width:30px;">Cho</th>
          </tr>
        </thead>
        <tbody class="table-hover">
          <tr>
              <td><strong>Total:</strong></td>
              <td><label id="total_kcal_sum"></label></td>
              <td><label id="total_prot_sum"></label></td>
              <td><label id="total_lip_sum"></label></td>
              <td><label id="total_cho_sum"></label></td>
          </tr>
        </tbody>
      </table>
    </div>

    <br>

     <div class="form-group">
      <h3>% Ingesta Real :</h3>
      <div class="col-sm-2">
        <input type="text" id="porcentaje_ingesta" name="porcentaje_ingesta" class="form-control" required placeholder="Ejemplo: 75 => 75%" />
      </div>
    </div>
   
    <div class="text-box">
      <input type="submit" name="boton1" class="btn btn-success btn-lg" value="Enviar">
    </div>
</form>

<script>
  window.onload = function() {
    
    desayuno = $('#codigo_desayuno').val();
    once = $('#codigo_once').val();
    col10 = $('#codigo_col10').val();
    col20 = $('#codigo_col20').val();
    almuerzo = $('#codigo_almuerzo').val();
    cena = $('#codigo_cena').val(); 
  formula = $('#formula').val();
    comp1 = $('#compl1').val();
    comp2 = $('#compl2').val();
  comp3 = $('#compl3').val();
    $("#total_kcal_sum").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal_sum", {
      desayuno : desayuno,
            once : once,
            col10 : col10,
            col20 : col20,
            almuerzo : almuerzo,
            cena : cena,
            formula : formula,
            comp1 : comp1,
            comp2 : comp2,
            comp3 : comp3
        }, function(data) {
          $("#total_kcal_sum").html(data);
        });
    });
  
  $("#total_prot_sum").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot_sum", {
            desayuno : desayuno,
            once : once,
            col10 : col10,
            col20 : col20,
            almuerzo : almuerzo,
            cena : cena,
            formula : formula,
            comp1 : comp1,
            comp2 : comp2,
            comp3 : comp3
        }, function(data) {
          $("#total_prot_sum").html(data);
        });
    });
  
  $("#total_lip_sum").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip_sum", {
            desayuno : desayuno,
            once : once,
            col10 : col10,
            col20 : col20,
            almuerzo : almuerzo,
            cena : cena,
            formula : formula,
            comp1 : comp1,
            comp2 : comp2,
            comp3 : comp3
        }, function(data) {
          $("#total_lip_sum").html(data);
        });
    });
  
  $("#total_cho_sum").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho_sum", {
            desayuno : desayuno,
            once : once,
            col10 : col10,
            col20 : col20,
            almuerzo : almuerzo,
            cena : cena,
            formula : formula,
            comp1 : comp1,
            comp2 : comp2,
            comp3 : comp3
        }, function(data) {
          $("#total_cho_sum").html(data);
        });
    });

  }
</script>