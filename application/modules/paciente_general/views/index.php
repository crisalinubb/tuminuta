<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Pacientes</h1>
    <div class="col-md-3" style="margin-top:24px;">
        
       <form class="form-inline" method="get" action="<?php echo base_url(); ?>paciente_general/busqueda">
         <div class="input-group">
         <div class="col-sm-20">

      <select id="pacientes" name="pacientes" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($pacientes){ ?>
           <?php foreach($pacientes as $paciente){ ?>
           <option value="<?php echo $paciente->rut; ?>" data-subtext="<?php echo $paciente->rut; ?>"><?php echo $paciente->nombre . " " . $paciente->apellido_paterno." ". $paciente->apellido_materno?></option>
           <?php } ?>
           <?php } ?>
        </select>
        </div>
        <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span>
        </form>
    </div>

    <div class="col-md-6" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>paciente_general/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:90px;">Rut</th>
        <th scope="col" style="width:100px;">Nombre</th>
        <th scope="col" style="width:100px;">Fecha de Nacimiento</th>
        <th scope="col" style="width:100px;">Telefono</th>
        <th scope="col" style="width:100px;">Fecha de Registro</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $pacientes): ?>
				<tr>
					<td><?php echo number_format($pacientes->rut, 0, ".", ".") . "-" . $pacientes->dv; ?></td>
					<td><?php echo $pacientes->nombre." ".$pacientes->apellido_paterno." ".$pacientes->apellido_materno;?></td>
          <td><?php echo date('d/m/Y',strtotime($pacientes->fecha_nacimiento));?></td>
          <td><?php echo $pacientes->telefono;?></td>
          <td><?php echo date('d/m/Y H:i:s',strtotime($pacientes->fecha_registro));?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>paciente_general/editar/<?php echo $pacientes->id_paciente; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>paciente_general/eliminar/<?php echo $pacientes->id_paciente; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

            <?php if($pacientes->estado == 0){ ?>
            <a href="<?php echo base_url(); ?>paciente/agregar/<?php echo $pacientes->id_paciente; ?>">
              <button title="Hospitalizar" type="button" class="btn btn-success btn-sm">Hospitalizar</button>
            </a>
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

<!-- [PAGINACION] -->
<?php echo $pagination; ?>