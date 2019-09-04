<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Pacientes Hospitalizados</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Pacientes Hospitalizados</h1>
    <div class="col-md-3" style="margin-top:24px;">
      
      <form class="form-inline" method="get" action="<?php echo base_url(); ?>paciente/busqueda">
      <div class="input-group">

      <div class="input-group">
      <div class="col-sm-20">
        <select id="hospitalizados" name="hospitalizados" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione Paciente</option>
           <?php if($hospitalizados){ ?>
           <?php foreach($hospitalizados as $hospitalizado){ ?>

           <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $hospitalizado->codigo_paciente)) ?>

           <option value="<?php echo $hospitalizado->id_paciente; ?>" data-subtext="<?php echo $datos_pacientes->rut; ?>"><?php echo $datos_pacientes->nombre . " " . $datos_pacientes->apellido_paterno." ". $datos_pacientes->apellido_materno?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>
    
    <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>

    <br>
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>paciente/busquedaPorSalas">
      <div class="input-group">

      <div class="input-group">
      <div class="col-sm-20">
        <select id="servicios" name="servicios" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione Servicio</option>
           <?php if($servicios){ ?>
           <?php foreach($servicios as $servicio){ ?>
           <option value="<?php echo $servicio->id_servicio; ?>"><?php echo $servicio->nombre_servicio;?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>
    
    <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>

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
        <th scope="col" style="width:90px;">Nombre</th>
        <th scope="col" style="width:80px;">Rut</th> 
        <th scope="col" style="width:100px;">Fecha de Ingreso</th>
        <th scope="col" style="width:100px;">Ubicacion Hospitalaria</th>       
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $pacientes): ?>
				<tr>
          <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $pacientes->codigo_paciente)); ?>
					<td><?php echo $datos_pacientes->nombre." ".$datos_pacientes->apellido_paterno." ".$datos_pacientes->apellido_materno; ?></td>
					<td><?php echo number_format($datos_pacientes->rut, 0, ".", ".") . "-" . $datos_pacientes->dv;?></td>
          <td><?php echo date('d/m/Y H:i:s',strtotime($pacientes->fecha_ingreso));?></td>
          <?php 
            $ubicacion = '';
            $servicio = $this->objServicioclinico->obtener(array('id_servicio' => $pacientes->codigo_servicio));
            $sala = $this->objSalas->obtener(array('id_sala' => $pacientes->codigo_sala));
            $cama = $this->objCamas->obtener(array('id_cama' => $pacientes->codigo_cama));
            $ubicacion = $servicio->nombre_servicio." | ".$sala->NOMSALA." | ".$cama->cama;
           ?>
          <td><?php echo $ubicacion; ?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>paciente/editar/<?php echo $pacientes->id_paciente; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>paciente/eliminar/<?php echo $pacientes->id_paciente; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

            <a href="<?php echo base_url(); ?>paciente/ver_datos_paciente/<?php echo $pacientes->codigo_paciente; ?>/<?php echo $pacientes->id_paciente; ?>"><button title="Ver Detalle Pacientes" type="button" class="btn btn-success btn-sm">Ver Detalle Pacientes</button></a>

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