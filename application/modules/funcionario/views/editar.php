<div class="page-header">
  <h1>Agregar Funcionarios</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" placeholder="123456789-k" value="<?php echo $funcionarios->rut; ?>"/>
        <input type="hidden" id="codigo" name="codigo" class="form-control" value="<?php echo $funcionarios->id_funcionario; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $funcionarios->nombre; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellido_pat" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellido_pat" name="apellido_pat" class="form-control validate[required]" value="<?php echo $funcionarios->apellido_pat;?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellido_mat" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellido_mat" name="apellido_mat" class="form-control validate[required]" value="<?php echo $funcionarios->apellido_mat;?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="hospitales" class="col-sm-2 control-label">Unidad</label>
      <div class="col-sm-4">
        <select id="hospitales" name="hospitales" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($hospitales){ ?>
           <?php foreach($hospitales as $hospital){ ?>
              <option value="<?php echo $hospital->id_hospital; ?>" <?php if($funcionarios->fk_unidad == $hospital->id_hospital) echo "selected"; ?>><?php echo $hospital->hos_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_servicio" class="col-sm-2 control-label">Servicio Clinico</label>
      <div class="col-sm-4">
        <select id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
              <?php if($servicios){ ?>
                <?php foreach($servicios as $serv){ ?>
                  <option value="<?php echo $serv->id_servicio; ?>" <?php if($funcionarios->fk_servicio == $serv->id_servicio) echo "selected"; ?>><?php echo $serv->nombre_servicio; ?></option>
                <?php } ?>
              <?php } ?> 
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="tipo_contrato" class="col-sm-2 control-label">Tipo Contrato</label>
      <div class="col-sm-4">
        <select id="tipo_contrato" name="tipo_contrato" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($tipo_contrato){ ?>
           <?php foreach($tipo_contrato as $t_c){ ?>
              <option value="<?php echo $funcionarios->fk_tipocontrato; ?>" <?php if($funcionarios->fk_tipocontrato == $t_c->id_tipocontrato) echo "selected"; ?>><?php echo $t_c->descripcion; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="observacion" class="col-sm-2 control-label">observacion</label>
      <div class="col-sm-10">
        <input type="text" id="observacion" name="observacion" class="form-control" value="<?php echo $funcionarios->observacion;?>"/>
      </div>
    </div>

    
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

<script type="text/javascript">   
            $(document).ready(function() {                       
                $("#hospitales").change(function() {
                    $("#hospitales option:selected").each(function() {
                        unidad = $('#hospitales').val();
                        $.post("<?php echo base_url(); ?>funcionario/buscarServicios", {
                            unidad : unidad
                        }, function(data) {
                            $("#codigo_servicio").html(data);
                        });
                    });
                });
            });

        </script>
