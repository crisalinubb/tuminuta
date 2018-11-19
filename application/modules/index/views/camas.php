<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/mis_servicios">Servicios Clinicos</a></li>
  <li><a href="<?php echo base_url(); ?>index/ver_salas?servicio=<?php echo $codigo_serv; ?>">Salas</a></li>
  <li class="active">Camas</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Camas</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

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
          			<?php $validador = $this->objIndex->buscar_solicitud_dia_actual($datos[0]->codigo_paciente); ?>
          			<td class="editar">
						<a href="<?php echo base_url(); ?>index/dar_alta_paciente/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Dar alta" type="button" class="btn btn-success btn-sm"> Dar alta</button>
						</a>
						<!-- Validamos la condicion en caso de que tenga o no una solicitud enviada el dia actual (mostramos botones de accion segun condicion) -->

						<?php if(!$validador){ ?>
						<a href="<?php echo base_url(); ?>index/solicitud_clinica/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Solicitud Clinica" type="button" class="btn btn-success btn-sm"> Solicitud Clinica</button>
						</a>

						<?php }else{ ?>
						<a href="<?php echo base_url(); ?>index/editar_solicitud_clinica/<?php echo $datos[0]->id_paciente; ?>" >
							<button title="Editar Solicitud" type="button" class="btn btn-success btn-sm"> Editar Solicitud</button>
						</a>
						<?php } ?>
					</td>
					<?php }else{ ?>
						<td class="editar">
						<a href="<?php echo base_url(); ?>index/hospitalizar_paciente/<?php echo $cama->id_cama; ?>" >
							<button title="Hospitalizar" type="button" class="btn btn-success btn-sm">Hospitalizar Paciente</button>
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
