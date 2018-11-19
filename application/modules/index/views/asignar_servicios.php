 <h1 class="col-md-7"> Asignar Servicios Clinicos</h1>
 <br>
<div class="page-header">
  <div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Usuarios</th>
        <th scope="col" style="width:50px;">Institucion</th>
        <th scope="col" style="width:50px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $usuario): ?>
				<tr>
					<td><?php echo $usuario->nombre." ".$usuario->apellidoPaterno." ".$usuario->apellidoMaterno; ?></td>
					<?php $institucion = $this->objHospital->obtener(array('id_hospital' => $usuario->id_unidad)); ?>
          			<td><?php echo  $institucion->hos_nombre ;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>index/vista_asignar_servicios/<?php echo $usuario->id_usuario; ?>" >
							<button title="Asignar servicios" type="button" class="btn btn-success btn-sm"> Asignar Servicios</button>
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