<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Pacientes Egresados</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Pacientes Egresados</h1>
    <div class="col-md-3" style="margin-top:24px;">
      
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>index/busqueda_pacientes_egresados">
      <div class="input-group">

      <div class="input-group">
      <div class="col-sm-20">
        <select id="pacientes" name="pacientes" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione Paciente</option>
           <?php if($pacientes){ ?>
           <?php foreach($pacientes as $pacientes_general){ ?>
           <option value="<?php echo $pacientes_general->id_paciente; ?>" data-subtext="<?php echo $pacientes_general->rut; ?>"><?php echo $pacientes_general->nombre . " " . $pacientes_general->apellido_paterno." ". $pacientes_general->apellido_materno?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>
    
    <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar Egresos</button>
        </span></div>
    </form>

    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:90px;">Nombre</th>
        <th scope="col" style="width:40px;">Rut</th> 
        <th scope="col" style="width:40px;">Fecha de Egreso</th>
        <th scope="col" style="width:50px;">Ubicacion Hospitalaria</th>
        <th scope="col" style="width:50px;">Responsable Alta</th>
        <th scope="col" style="width:50px;">Diagnostico</th>
        <th scope="col" style="width:50px;">Motivo Egreso</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $pacientes): ?>
				<tr>
          <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $pacientes->codigo_paciente)); ?>
					<td><?php echo $datos_pacientes->nombre." ".$datos_pacientes->apellido_paterno." ".$datos_pacientes->apellido_materno; ?></td>
					<td><?php echo number_format($datos_pacientes->rut, 0, ".", ".") . "-" . $datos_pacientes->dv;?></td>
          <td><?php echo date('d/m/Y H:i:s',strtotime($pacientes->egresado_fechaegreso));?></td>
          
          <?php 
            $ubicacion = '';
            $servicio = $this->objServicioClinico->obtener(array('id_servicio' => $pacientes->egresado_servicio));
            $sala = $this->objSalas->obtener(array('id_sala' => $pacientes->egresado_sala));
            $cama = $this->objCamas->obtener(array('id_cama' => $pacientes->egresado_cama));
            $ubicacion = $servicio->nombre_servicio." | ".$sala->NOMSALA." | ".$cama->cama;
           ?>
          <td><?php echo $ubicacion; ?></td>

          <?php $usuario_responsable = $this->objUsuario->obtener(array("id_usuario" => $pacientes->usuario_egreso)); ?>
          <td><?php echo $usuario_responsable->nombre.' '. $usuario_responsable->apellidoPaterno.' '.$usuario_responsable->apellidoMaterno; ?></td>

          <?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' =>$pacientes->egresado_diagnostico)); ?>
          <td><?php echo $diagnostico->diagnostico_descripcion; ?></td>
          <td><?php echo $pacientes->egresado_motivoegreso; ?></td>
				</tr>
			<?php endforeach;?>
		<?php } else{ ?>
			<tr>
				<td colspan="8" style="text-align:center;"><i>No hay registros</i></td>
			</tr>
		<?php } ?>
    </tbody>
  </table>
</div>

<script>

function myFunction() {
    var divToPrint=document.getElementById("multiselectForm");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>