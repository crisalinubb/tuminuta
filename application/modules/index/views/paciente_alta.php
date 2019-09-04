<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
</ol>

<div class="page-header">
  <h1>Dar Alta Paciente Hospitalizado</h1>
</div>
<form action="<?php echo base_url(); ?>index/registrar_alta" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]"  value="<?php echo $paciente->rut; ?>" readonly/>

         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $paciente->id_paciente; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="dv" class="col-sm-2 control-label">Digito Verificador</label>
      <div class="col-sm-10">
        <input type="text" id="dv" name="dv" class="form-control validate[required]" value="<?php echo $paciente->dv; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $paciente->nombre; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidop" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidop" name="apellidop" class="form-control validate[required]" value="<?php echo $paciente->apellido_paterno; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidom" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidom" name="apellidom" class="form-control validate[required]" value="<?php echo $paciente->apellido_materno; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha1" type="text" class="form-control" name="fecha1" value="<?php echo $paciente->fecha_nacimiento; ?>" readonly/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar" ></span> </span> </div>
      </div>
      </div>

      <div class="form-group">
      <label for="codigo_atencion" class="col-sm-2 control-label">Codigo de Atencion</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_atencion" name="codigo_atencion" class="form-control" value="<?php echo $paciente_hospitalizado->codigo_atencion; ?>" readonly/>
      </div>
    </div>

     <div class="form-group">
      <label for="diagnostico_nombre" class="col-sm-2 control-label">Diagnostico</label>
      <div class="col-sm-10">
        <?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' =>$paciente_hospitalizado->diagnostico)); ?>
        <input type="text" id="diagnostico_nombre" name="diagnostico_nombre" class="form-control"  value="<?php echo $diagnostico->diagnostico_descripcion; ?>" readonly/>

        <input type="hidden" id="diagnostico" name="diagnostico" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->diagnostico; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="observacion" class="col-sm-2 control-label">Observacion Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="observacion" name="observacion" class="form-control" value="<?php echo $paciente_hospitalizado->observacion_diagnostico; ?>" readonly/>
      </div>
    </div>

      <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">Estatura</label>
      <div class="col-sm-10">
        <input type="text" id="estatura" name="estatura" class="form-control" value="<?php echo $paciente_hospitalizado->estatura; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="peso" class="col-sm-2 control-label">Peso</label>
      <div class="col-sm-10">
        <input type="text" id="peso" name="peso" class="form-control" value="<?php echo $paciente_hospitalizado->peso; ?>"  readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="imc" class="col-sm-2 control-label">IMC</label>
      <div class="col-sm-10">
        <input type="text" id="imc" name="imc" class="form-control" value="<?php echo $paciente_hospitalizado->imc; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="anamnesis" class="col-sm-2 control-label">Anamnesis</label>
      <div class="col-sm-10">
        <input type="text" name="anamnesis" id="anamnesis" class="form-control" value="<?php echo $paciente_hospitalizado->anamnesis; ?>" readonly>
      </div>
    </div>

    <div class="form-group">
      <label for="tratamiento" class="col-sm-2 control-label">Tratamiento</label>
      <div class="col-sm-10">
        <input type="text" name="tratamiento" id="tratamiento" class="form-control" value="<?php echo $paciente_hospitalizado->tratamiento; ?>" readonly>
      </div>
    </div>

    <div class="form-group">
      <label for="alta_medica" class="col-sm-2 control-label">Motivo del Alta Medica</label>
      <div class="col-sm-10">
        <textarea name="alta_medica" id="alta_medica" class="form-control"></textarea>
      </div>
    </div>

    <input type="hidden" id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_servicio; ?>" />

    <input type="hidden" id="codigo_sala" name="codigo_sala" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_sala; ?>" />
    
    <input type="hidden" id="codigo_cama" name="codigo_cama" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_cama; ?>" />

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>