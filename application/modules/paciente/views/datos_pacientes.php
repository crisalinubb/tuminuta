<div class="page-header">
  <h1>Datos Paciente</h1>
</div>
  <div style="background-color:#F8F5F5">
    <div class="form-group row">
      <label for="rut" class="col-sm-2 control-label">Rut:</label>
      <div class="col-sm-4">
        <strong><?php echo number_format($pacientes_general->rut, 0, ".", ".") . "-" . $pacientes_general->dv;?></strong>
      </div>

      <label for="codigo_paciente" class="col-sm-2 control-label">Codigo del paciente:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->codigo_atencion;?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="nombre" class="col-sm-2 control-label">Nombre Completo:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_general->nombre." ".$pacientes_general->apellido_paterno." ".$pacientes_general->apellido_materno;?></strong>
      </div>

     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_general->fecha_nacimiento; ?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="estatura" class="col-sm-2 control-label">Estatura:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->estatura; ?></strong>
      </div>

      <label for="peso" class="col-sm-2 control-label">Peso:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->peso; ?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="estatura" class="col-sm-2 control-label">IMC:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->imc; ?></strong>
      </div>

       <label for="ingreso" class="col-sm-2 control-label">Fecha de Ingreso:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->fecha_ingreso; ?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="diagnostico" class="col-sm-2 control-label">Diagnostico:</label>
      <div class="col-sm-4">
        <?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' => $pacientes_hospitalizados->diagnostico)); ?>
        <strong><?php echo $diagnostico->diagnostico_descripcion; ?></strong>
      </div>

      <label for="obs" class="col-sm-2 control-label">Observacion del Diagnostico:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->observacion_diagnostico; ?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="anamnesis" class="col-sm-2 control-label">Anamnesis:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->anamnesis; ?></strong>
      </div>
      
      <label for="tratamiento" class="col-sm-2 control-label">Tratamiento:</label>
      <div class="col-sm-4">
        <strong><?php echo $pacientes_hospitalizados->tratamiento; ?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="servicio" class="col-sm-2 control-label">Servicio Clinico:</label>
      <div class="col-sm-4">
        <?php $servicio = $this->objServicioclinico->obtener(array('id_servicio' => $pacientes_hospitalizados->codigo_servicio)); ?>
        <strong><?php echo $servicio->nombre_servicio; ?></strong>
      </div>
      
      <label for="sala" class="col-sm-2 control-label">Sala:</label>
      <div class="col-sm-4">
        <?php $sala = $this->objSalas->obtener(array('id_sala' => $pacientes_hospitalizados->codigo_sala)); ?>
        <strong><?php echo $sala->NOMSALA; ?></strong>
      </div>
    </div>

    <div class="form-group row">
      <label for="cama" class="col-sm-2 control-label">Cama:</label>
      <div class="col-sm-4">
        <?php $cama = $this->objCamas->obtener(array('id_cama' => $pacientes_hospitalizados->codigo_cama)); ?>
        <strong><?php echo $cama->cama; ?></strong>
      </div>
    </div>

</div>