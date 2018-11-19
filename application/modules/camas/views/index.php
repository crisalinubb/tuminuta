<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Camas</h1>

    <div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="get" action="<?php echo base_url(); ?>camas/busqueda">
      <div class="input-group">

      <div class="input-group">
      <div class="col-sm-20">
        <select id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($servicios_clinicos){ ?>
           <?php foreach($servicios_clinicos as $servicio_clinico){ ?>
              <option value="<?php echo $servicio_clinico->id_servicio; ?>"><?php echo $servicio_clinico->nombre_servicio; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>

      <div class="input-group">
        <div class="col-sm-20">
        <select id="codigo_sala" name="codigo_sala" class="form-control validate[required]">
           <option disabled selected>Seleccione</option> 
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-20">
        <select id="codigo_cama" name="codigo_cama" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
        </select>
      </div>
    </div>

      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>
    </div>

    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>camas/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
      </div>
    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:100px;">Servicio Clinico</th> 
        <th scope="col" style="width:100px;">Sala</th>   
        <th scope="col" style="width:100px;">Cama</th>
        <th scope="col" style="width:50px;">Unidad/Institucion</th>      
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $camas): ?>
				<tr>
           <?php $servicio = $this->objServicioclinico->obtener(array("id_servicio" => $camas->codigo_servicio)); ?>
          <td><?php echo $servicio->nombre_servicio;?></td>
          <?php $sala = $this->objSalas->obtener(array("CODSALA" => $camas->codigo_sala)); ?>
          <td><?php echo $sala->NOMSALA;?></td>
					<td><?php echo $camas->cama;?></td>
          <?php $institucion = $this->objHospital->obtener(array('id_hospital' => $camas->id_unidad)); ?>
          <td><?php echo  $institucion->hos_nombre ;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>camas/editar/<?php echo $camas->id_cama; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>camas/eliminar/<?php echo $camas->id_cama; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
					</td>
				</tr>
			<?php endforeach;?>
		<?php } else{ ?>
			<tr>
				<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
			</tr>
		<?php } ?>
    </tbody>
  </table>
</div>

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

<!-- [PAGINACION] -->
<?php echo $pagination; ?>