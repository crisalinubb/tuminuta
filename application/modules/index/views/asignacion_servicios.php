 <h1 class="col-md-7"> Asignar Servicios Clinicos</h1>
 <br>
<div class="page-header">
  <div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Usuarios</th>
        <th scope="col" style="width:50px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $servicio): ?>
				<tr>
					<td><?php echo $servicio->nombre_servicio; ?></td>
					<?php $servicios_asociados = $this->objIndex->validar_servicios($codigo_usuario, $servicio->id_servicio); ?>
					<?php if ($servicios_asociados == 0){?>

					<td class="editar">
						<a href="<?php echo base_url(); ?>index/ingresar_servicioasociado/<?php echo $servicio->id_servicio; ?>/<?php echo $codigo_usuario; ?>">
							<button title="Asignar servicio" type="button" class="btn btn-success btn-sm"> Asignar Servicio</button>
						</a>
					</td>
					<?php }else{ ?>
					<td class="editar">
						<a href="<?php echo base_url(); ?>index/desvincular_servicioasociado/<?php echo $servicio->id_servicio; ?>/<?php echo $codigo_usuario; ?>">
							<button title="Desvincular Servicio" type="button" class="btn btn-success btn-sm"> Desvincular Servicio</button>
						</a>
					</td>
					<?php } ?>
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