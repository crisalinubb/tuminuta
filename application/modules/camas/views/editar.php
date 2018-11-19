<div class="page-header">
  <h1>Editar Cama</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="codigo_serv" class="col-sm-2 control-label">Servicio Clinico</label>
      <div class="col-sm-4">
        <select id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($servicios_clinicos){ ?>
           <?php foreach($servicios_clinicos as $servicio_clinico){ ?>
              <option value="<?php echo $servicio_clinico->id_servicio; ?>" <?php if($camas->codigo_servicio == $servicio_clinico->id_servicio) echo "selected"; ?>><?php echo $servicio_clinico->nombre_servicio; ?></option>
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
              <option value="<?php echo $sala->CODSALA; ?>" <?php if($camas->codigo_sala == $sala->CODSALA) echo "selected"; ?>><?php echo $sala->NOMSALA; ?></option>
           <?php } ?>
           <?php } ?> 
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="cama" class="col-sm-2 control-label">Cama</label>
      <div class="col-sm-10">
        <input type="text" id="cama" name="cama" class="form-control validate[required]" value="<?php echo $camas->cama; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $camas->id_cama; ?>" />
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
                        $.post("<?php echo base_url(); ?>camas/buscarSalas", {
                            idServicio : idServicio
                        }, function(data) {
                            $("#codigo_sala").html(data);
                        });
                    });
                });
            });

        </script>