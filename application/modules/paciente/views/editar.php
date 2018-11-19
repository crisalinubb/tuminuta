<div class="page-header">
  <h1>Editar Paciente Hospitalizado</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]"  value="<?php echo $paciente_general->rut; ?>" readonly/>
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $pacientes->id_paciente; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="dv" class="col-sm-2 control-label">Digito Verificador</label>
      <div class="col-sm-10">
        <input type="text" id="dv" name="dv" class="form-control validate[required]" value="<?php echo $paciente_general->dv; ?>" readonly/>
        <input type="hidden" id="codigo_paciente" name="codigo_paciente" class="form-control validate[required]" value="<?php echo $paciente_general->id_paciente; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $paciente_general->nombre; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidop" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidop" name="apellidop" class="form-control validate[required]" value="<?php echo $paciente_general->apellido_paterno; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidom" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidom" name="apellidom" class="form-control validate[required]" value="<?php echo $paciente_general->apellido_materno; ?>" readonly/>
      </div>
    </div>

    <div class="form-group">
     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha1" type="text" class="form-control" name="fecha1" value="<?php echo $paciente_general->fecha_nacimiento; ?>" readonly/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar" ></span> </span> </div>
      </div>
      </div>

      <div class="form-group">
      <label for="codigo_atencion" class="col-sm-2 control-label">Codigo de Atencion</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_atencion" name="codigo_atencion" class="form-control" value="<?php echo $pacientes->codigo_atencion; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="diagnostico" class="col-sm-2 control-label">Diagnostico</label>
      <div class="col-sm-4">
        <select id="diagnostico" name="diagnostico" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($diagnosticos){ ?>
           <?php foreach($diagnosticos as $diagnostico){ ?>
              <option value="<?php echo $diagnostico->id_diagnostico; ?>" <?php if($pacientes->diagnostico == $diagnostico->id_diagnostico) echo "selected"; ?> ><?php echo $diagnostico->diagnostico_descripcion; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="observacion" class="col-sm-2 control-label">Observacion Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="observacion" name="observacion" class="form-control" value="<?php echo $pacientes->observacion_diagnostico; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="medico" class="col-sm-2 control-label">Medico</label>
      <div class="col-sm-4">
        <select id="medico" name="medico" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
              <option value="<?php echo $medico->id_medico; ?>" <?php if($pacientes->medico_tratante == $medico->id_medico) echo "selected"; ?> ><?php echo $medico->medico_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label for="codigo_serv" class="col-sm-2 control-label">Servicio Clinico</label>
      <div class="col-sm-4">
        <select id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($servicios_clinicos){ ?>
           <?php foreach($servicios_clinicos as $servicio_clinico){ ?>
              <option value="<?php echo $servicio_clinico->id_servicio; ?>" <?php if($pacientes->codigo_servicio == $servicio_clinico->id_servicio) echo "selected"; ?>><?php echo $servicio_clinico->nombre_servicio; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_sala" class="col-sm-2 control-label">Sala</label>
      <div class="col-sm-4">
        <select id="codigo_sala" name="codigo_sala" class="form-control validate[required]">
           <option disabled selected>Seleccione</option> 
              <?php if($salas){ ?>
                <?php foreach($salas as $sala){ ?>
                  <option value="<?php echo $sala->id_sala; ?>" <?php if($pacientes->codigo_sala == $sala->id_sala) echo "selected"; ?>><?php echo $sala->NOMSALA; ?></option>
                <?php } ?>
              <?php } ?> 
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_cama" class="col-sm-2 control-label">Cama</label>
      <div class="col-sm-4">
        <select id="codigo_cama" name="codigo_cama" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
              <?php if($camas){ ?>
                <?php foreach($camas as $cama){ ?>
                  <option value="<?php echo $cama->id_cama; ?>" <?php if($pacientes->codigo_cama == $cama->id_cama) echo "selected"; ?>><?php echo $cama->cama; ?></option>
                <?php } ?>
              <?php } ?> 
        </select>
      </div>
    </div>

      <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">Estatura</label>
      <div class="col-sm-10">
        <input type="text" id="estatura" name="estatura" class="form-control" value="<?php echo $pacientes->estatura; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="peso" class="col-sm-2 control-label">Peso</label>
      <div class="col-sm-10">
        <input type="text" id="peso" name="peso" class="form-control" value="<?php echo $pacientes->peso; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="anamnesis" class="col-sm-2 control-label">Anamnesis</label>
      <div class="col-sm-10">
        <input type="text" name="anamnesis" id="anamnesis" class="form-control" value="<?php echo $pacientes->anamnesis; ?>">
      </div>
    </div>

    <div class="form-group">
      <label for="tratamiento" class="col-sm-2 control-label">Tratamiento</label>
      <div class="col-sm-10">
        <input type="text" name="tratamiento" id="tratamiento" class="form-control" value="<?php echo $pacientes->tratamiento; ?>">
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

<script type="text/javascript">   
            $(document).ready(function() {                       
                $("#codigo_servicio").change(function() {
                    $("#codigo_servicio option:selected").each(function() {
                        idServicio = $('#codigo_servicio').val();
                        $.post("<?php echo base_url(); ?>paciente/buscarSalas", {
                            idServicio : idServicio
                        }, function(data) {
                            $("#codigo_sala").html(data);
                        });
                    });
                });
            });

               $(document).ready(function() {                       
                $("#codigo_sala").change(function() {
                    $("#codigo_sala option:selected").each(function() {
                        idSala = $('#codigo_sala').val();
                        $.post("<?php echo base_url(); ?>paciente/buscarCamas", {
                            idSala : idSala
                        }, function(data) {
                            $("#codigo_cama").html(data);
                        });
                    });
                });
            });

        </script>
