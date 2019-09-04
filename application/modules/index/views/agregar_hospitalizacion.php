<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
</ol>

<div class="page-header">
  <h1>Agregar Paciente Hospitalizado</h1>
</div>

<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]"  value="<?php echo $pacientes->rut; ?>" readonly/>
        <input type="hidden" id="codigo" name="codigo" class="form-control" value="<?php echo $paciente_codigo; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="dv" class="col-sm-2 control-label">Digito Verificador</label>
      <div class="col-sm-10">
        <input type="text" id="dv" name="dv" class="form-control validate[required]" value="<?php echo $pacientes->dv; ?>" readonly/>
        <input type="hidden" id="codigo_paciente" name="codigo_paciente" class="form-control validate[required]" value="<?php echo $paciente_general->id_paciente; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $pacientes->nombre; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidop" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidop" name="apellidop" class="form-control validate[required]" value="<?php echo $pacientes->apellido_paterno; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidom" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidom" name="apellidom" class="form-control validate[required]" value="<?php echo $pacientes->apellido_materno; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha1" type="text" class="form-control" name="fecha1" value="<?php echo $pacientes->fecha_nacimiento; ?>" readonly/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar" ></span> </span> </div>
      </div>
      </div>

      <div class="form-group">
      <label for="codigo_atencion" class="col-sm-2 control-label">Codigo de Atencion</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_atencion" name="codigo_atencion" class="form-control" value="<?php echo $datos->codigo_atencion; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="diagnostico" class="col-sm-2 control-label">Diagnostico</label>
      <div class="col-sm-4">
        <select id="diagnostico" name="diagnostico" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($diagnosticos){ ?>
           <?php foreach($diagnosticos as $diagnostico){ ?>
              <option value="<?php echo $diagnostico->id_diagnostico; ?>"><?php echo $diagnostico->diagnostico_descripcion.' | '.$diagnostico->diagnostico_codigo; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="observacion" class="col-sm-2 control-label">Observacion Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="observacion" name="observacion" class="form-control"/>
      </div>
    </div>

    <div class="form-group">
      <label for="medico" class="col-sm-2 control-label">Medico Tratante</label>
      <div class="col-sm-4">
        <select id="medico" name="medico" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
              <option value="<?php echo $medico->id_medico; ?>"><?php echo $medico->medico_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

        <input type="hidden" id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]" value="<?php echo $camas->codigo_servicio; ?>" readonly/>
      
        <input type="hidden" id="codigo_sala" name="codigo_sala" class="form-control validate[required]" value="<?php echo $sala->id_sala; ?>" readonly/>

        <input type="hidden" id="codigo_cama" name="codigo_cama" class="form-control validate[required]" value="<?php echo $camas->id_cama; ?>" readonly/>

      <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">Estatura</label>
      <div class="col-sm-10">
        <input type="text" id="estatura" name="estatura" class="form-control" placeholder="Ejemplo: 167" />
      </div>
    </div>

    <div class="form-group">
      <label for="peso" class="col-sm-2 control-label">Peso</label>
      <div class="col-sm-10">
        <input type="text" id="peso" name="peso" class="form-control" placeholder="Ejemplo: 55" />
      </div>
    </div>
<!--
    <div class="form-group">
      <label for="imc" class="col-sm-2 control-label">IMC</label>
      <div class="col-sm-10">
        <input type="text" id="imc" name="imc" class="form-control" placeholder="Ejemplo: 24"/>
      </div>
    </div>
-->
    <div class="form-group">
      <label for="anamnesis" class="col-sm-2 control-label">Anamnesis</label>
      <div class="col-sm-10">
        <textarea name="anamnesis" id="anamnesis" class="form-control"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label for="tratamiento" class="col-sm-2 control-label">Tratamiento</label>
      <div class="col-sm-10">
        <textarea name="tratamiento" id="tratamiento" class="form-control"></textarea>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
