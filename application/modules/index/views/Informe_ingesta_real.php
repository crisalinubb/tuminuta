<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Informe Ingesta Real</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Ingesta Real</h1>
    <div class="col-md-3" style="margin-top:24px;">
      
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>index/busqueda_pacientes_ingesta_real">
      <div class="input-group">

      <div class="input-group">
      <div class="col-sm-20">
        <select id="hospitalizados" name="hospitalizados" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione Paciente</option>
           <?php if($hospitalizados){ ?>
           <?php foreach($hospitalizados as $hospitalizado){ ?>

           <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $hospitalizado->codigo_paciente)) ?>

           <option value="<?php echo $hospitalizado->codigo_paciente; ?>" data-subtext="<?php echo $datos_pacientes->rut; ?>"><?php echo $datos_pacientes->nombre . " " . $datos_pacientes->apellido_paterno." ". $datos_pacientes->apellido_materno?></option>
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

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:90px;">Nombre</th>
        <th scope="col" style="width:40px;">Rut</th> 
        <th scope="col" style="width:40px;">Fecha de Ingreso</th>
        <th scope="col" style="width:50px;">Ubicacion Hospitalaria</th>
        <th scope="col" style="width:100px;">Informacion Nutricional(KCAL | PROT | LIP | CHO) </th>
        <th scope="col" style="width:100px;">Ingesta Real(KCAL | PROT | LIP | CHO) </th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($pacientes){ ?>
				<tr>
          <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $pacientes->codigo_paciente)); ?>
					<td><?php echo $datos_pacientes->nombre." ".$datos_pacientes->apellido_paterno." ".$datos_pacientes->apellido_materno; ?></td>
					<td><?php echo number_format($datos_pacientes->rut, 0, ".", ".") . "-" . $datos_pacientes->dv;?></td>
          <td><?php echo date('d/m/Y H:i:s',strtotime($pacientes->fecha_ingreso));?></td>
          <?php 
            $ubicacion = '';
            $servicio = $this->objServicioClinico->obtener(array('id_servicio' => $pacientes->codigo_servicio));
            $sala = $this->objSalas->obtener(array('id_sala' => $pacientes->codigo_sala));
            $cama = $this->objCamas->obtener(array('id_cama' => $pacientes->codigo_cama));
            $ubicacion = $servicio->nombre_servicio." | ".$sala->NOMSALA." | ".$cama->cama;
           ?>
          <td><?php echo $ubicacion; ?></td>
          <td><?php echo $informacion_nutricional; ?></td>
          <td><?php echo $ingesta_real; ?></td>
				</tr>
		<?php } else{ ?>
			<tr>
				<td colspan="6" style="text-align:center;"><i>No hay registros</i></td>
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