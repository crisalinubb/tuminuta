<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>index/mis_servicios">Servicios Clinicos</a></li>
  <li><a href="<?php echo base_url(); ?>index/ver_salas/<?php echo $codigo_serv; ?>">Salas</a></li>
  <li class="active">Camas</li>
</ol>

<div align="center">
	<?php
		$servicio = $this->objServicioClinico->obtener(array('id_servicio' => $datos_salas->CODSERV));


	?>
	<h3><?php echo $servicio->nombre_servicio; ?></h3>
	<h3><?php echo $datos_salas->NOMSALA; ?></h3>
</div>


<div class="container" align="center">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Buscar Paciente</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Buscador Pacientes</h4>
        </div>
        <div class="modal-body">
          <form class="form-inline">
		      <div class="input-group">

		      <div class="input-group">
		        <select id="codigo_paciente" name="codigo_paciente" class="js-example-responsive" style="width: 150%">
		           <option disabled selected>Seleccione Paciente</option>
		           <?php if($hospitalizados){ ?>
		           <?php foreach($hospitalizados as $hospitalizado){ ?>

		           <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $hospitalizado->codigo_paciente)) ?>

		           <option value="<?php echo $hospitalizado->id_paciente; ?>" data-subtext="<?php echo $datos_pacientes->rut; ?>"><?php echo $datos_pacientes->nombre . " " . $datos_pacientes->apellido_paterno." ". $datos_pacientes->apellido_materno?></option>
		           <?php } ?>
		           <?php } ?>
		        </select>
		  
		      </div>
		    
		    <span class="input-group-btn">
		        <button type="button" id="busqueda_paciente" class="btn btn-default">Buscar</button>
		        </span></div>
		    </form>
        </div>
        <div id="mostrar_paciente" >
        	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Camas</h1>
    <div class="col-md-3" style="margin-top:24px;">
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
        <th scope="col" style="width:50px;">Cama</th>
        <th scope="col" style="width:50px;">Paciente Hospitalizado</th>
        <th scope="col" style="width:50px;">Diagnostico</th>
        <th scope="col" style="width:30px;">Acciones</th>
        <th scope="col" style="width:10px;">Solicitud Diaria</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos->result() as $cama): ?>
				<tr>
					<td><?php echo $cama->cama; ?></td>
					<?php $datos = $this->objIndex->buscar_paciente_hospitalizado($cama->id_cama); ?>
					<?php $datos_paciente = $this->objPacGeneral->obtener(array('id_paciente' => $datos[0]->codigo_paciente)); ?>
					<td><?php echo $datos_paciente->nombre." ".$datos_paciente->apellido_paterno." ".$datos_paciente->apellido_materno; ?></td>
					<?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' =>$datos[0]->diagnostico)); ?>
          			<td><?php echo $diagnostico->diagnostico_descripcion; ?></td>
          			
          			<!-- Preguntamos si existe un hospitalizacion en esa sala -->
          			<?php if($datos){ ?>
          			<!-- Buscamos si ya envio el dia actual una solicitud -->
          			<?php $validador = $this->objIndex->buscar_solicitud_dia_actual($datos[0]->codigo_paciente, $this->session->userdata("usuario")->id_unidad); ?>
          			
          			<td class="editar">
						<a href="<?php echo base_url(); ?>index/dar_alta_paciente/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Dar alta" type="button" class="btn btn-success btn-sm"> Dar alta</button>
						</a>

						<a href="<?php echo base_url(); ?>index/formula_extra/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Formula Extra" type="button" class="btn btn-primary btn-sm"> Formula Extra</button>
						</a>

						<!-- Validamos la condicion en caso de que tenga o no una solicitud enviada el dia actual (mostramos botones de accion segun condicion) -->

						<?php if(!$validador){ ?>
						<a href="<?php echo base_url(); ?>index/solicitud_clinica/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Solicitud Clinica" type="button" class="btn btn-info btn-sm"> Solicitud Clinica</button>
						</a>

						<?php }else{ ?>
						<a href="<?php echo base_url(); ?>index/editar_solicitud_clinica/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Editar Solicitud" type="button" class="btn btn-warning btn-sm"> Editar Solicitud</button>
						</a>

						<a href="<?php echo base_url(); ?>index/ingesta_real/<?php echo $datos[0]->id_paciente; ?>" >
							<button title=" % Ingesta Real" type="button" class="btn btn-info btn-sm"> % Ingesta Real</button>
						</a>
						<?php } ?>
					</td>
					<?php }else{ ?>
						<td class="editar">
						<a href="<?php echo base_url(); ?>index/hospitalizar_paciente/<?php echo $cama->id_cama; ?>" >
							<button title="Hospitalizar" type="button" class="btn btn-danger btn-sm">Hospitalizar Paciente</button>
						</a>
						</td>
					<?php } ?>
					<td>
						<?php if(!$validador && $datos){ ?>
						<button type="button" class="btn btn-danger btn-sm">
          					<span class="glyphicon glyphicon-remove"></span>
        				</button>
        				<?php }else if($validador && $datos){ ?>
        				<button type="button" class="btn btn-primary btn-sm">
          					<span class="glyphicon glyphicon-check"></span>
        				</button>
        				<?php }else if((!$validador && !$datos) || ($validador && !$datos)){ ?>
        				<button type="button" class="btn btn-info btn-sm">
          					<span class="glyphicon glyphicon-minus"></span>
        				</button>
        				<?php } ?>
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

$(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});


$( "#busqueda_paciente" ).click(function() {
 	codigo_paciente = $('#codigo_paciente').val();
    $.post("<?php echo base_url(); ?>index/buscar_paciente_cama", {
        codigo_paciente : codigo_paciente
    }, function(data) {
        $("#mostrar_paciente").html(data);
    });
});

</script>