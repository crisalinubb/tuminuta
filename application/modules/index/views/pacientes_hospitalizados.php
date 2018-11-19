<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Pacientes Hospitalizados</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Nombre del Paciente</th>
        <th scope="col" style="width:50px;">Ubicacion Hospitalaria</th>
        <th scope="col" style="width:50px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos->result() as $paciente): ?>
				<tr>
					<td><?php echo $paciente->nombre." ".$paciente->apellido; ?></td>
					<?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' =>$paciente->diagnostico)); ?>
          			<td><?php echo $diagnostico->diagnostico_descripcion; ?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>index/dar_alta_paciente/<?php echo $paciente->id_paciente; ?>" >
							<button title="Dar alta" type="button" class="btn btn-success btn-sm"> Dar alta</button>
						</a>
						<a href="<?php echo base_url(); ?>index/solicitud_clinica/<?php echo $paciente->id_paciente; ?>" >
							<button title="Solicitud Clinica" type="button" class="btn btn-success btn-sm"> Solicitud Clinica</button>
						</a>
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
