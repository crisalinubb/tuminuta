<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Listado de Distribucion Formulas Lacteas</h1>
    <div class="col-md-3" style="margin-top:24px;">
    
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>index/busquedaPorServicio_Formulas_Lacteas">
      <div class="input-group">
        <?php if($fecha){ ?>
          <h3><input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>"/></h3>
        <?php  }else{?>
            <h3><input type="text" id="fecha" name="fecha" value="<?php echo date("d/m/Y"); ?>"/></h3>
        <?php } ?>

      <div class="input-group">
      <div class="col-sm-20">
        <select id="servicios" name="servicios" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($servicios){ ?>
           <?php foreach($servicios as $servicio_clinico){ ?>
              <option value="<?php echo $servicio_clinico->id_servicio; ?>"><?php echo $servicio_clinico->nombre_servicio; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>

      <div class="input-group">
        <div class="col-sm-20">
        <select id="salas" name="salas" class="form-control validate[required]">
           <option disabled selected>Seleccione</option> 
              <option value="0">Salas</option>
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

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <h3><?php echo $nombre_servicio.' '.$fecha; ?></h3>
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Sala</th>
        <th scope="col" style="width:30px;">Cama</th> 
        <th scope="col" style="width:90px;">Nombre</th>
        <th scope="col" style="width:50px;">Formula</th>
        <th scope="col" style="width:50px;">Comp 1</th> 
        <th scope="col" style="width:50px;">Comp 2</th> 
        <th scope="col" style="width:50px;">Comp 3</th>
        <th scope="col" style="width:50px;">Volumen</th> 
        <th scope="col" style="width:50px;">Frecuencia</th>
        <th scope="col" style="width:20px;">Bajada</th> 
        <th scope="col" style="width:50px;">Horarios</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $sol): ?>
				<tr>
          <?php $sala = $this->objSalas->obtener(array('id_sala' => $sol->id_sala)); ?>
          <td><?php echo $sala->NOMSALA; ?></td>
          <?php $cama = $this->objCamas->obtener(array('id_cama' => $sol->id_cama)); ?>
          <td><?php echo $cama->cama; ?></td>
          <?php $datos_pacientes = $this->objPacGeneral->obtener(array("id_paciente" => $sol->id_paciente)); ?>
					<td><?php echo $datos_pacientes->nombre." ".$datos_pacientes->apellido_paterno." ".$datos_pacientes->apellido_materno; ?></td>
          <?php $formula = $this->objRecetas->obtener(array("id_receta" => $sol->id_formula));?>
          <td><?php echo $formula->nombre; ?></td>
          <?php $comp1 = $this->objRecetas->obtener(array("id_receta" => $sol->id_complemento1));?>
          <td><?php echo $comp1->nombre; ?></td>
          <?php $comp2 = $this->objRecetas->obtener(array("id_receta" => $sol->id_complemento2));?>
          <td><?php echo $comp2->nombre; ?></td>
          <?php $comp3 = $this->objRecetas->obtener(array("id_receta" => $sol->id_complemento3));?>
          <td><?php echo $comp3->nombre; ?></td>
          <td><?php echo $sol->volumen; ?></td>
          <td><?php echo $sol->frecuencia; ?></td>
        
          <?php if($sol->bajada != '0'){ ?>
          <td><?php echo strtoupper($sol->bajada); ?></td>
          <?php }else{ ?>
          <td><?php echo ''; ?></td>
          <?php  }?>

          <?php $horarios = '';
                if($sol->h9){
                  $horarios = $horarios.'9:00 ';
                } 
                if($sol->h14){
                  $horarios = $horarios.'14:00 ';
                }
                if($sol->h18){
                  $horarios = $horarios.'18:00 ';
                }
                if($sol->h22){
                  $horarios = $horarios.'22:00 ';
                } 
           ?>
          <td><?php echo $horarios; ?></td>
				</tr>
			<?php endforeach;?>
		<?php } else{ ?>
			<tr>
				<td colspan="11" style="text-align:center;"><i>No hay registros</i></td>
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

$(document).ready(function() {                       
                $("#servicios").change(function() {
                    $("#servicios option:selected").each(function() {
                        idServicio = $('#servicios').val();
                        $.post("<?php echo base_url(); ?>paciente/buscarSalas", {
                            idServicio : idServicio
                        }, function(data) {
                            $("#salas").html(data);
                        });
                    });
                });
            });

$("#fecha").datepicker();
</script>