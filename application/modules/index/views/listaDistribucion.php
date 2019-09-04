<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Listado de Distribucion</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Listado de Distribucion</h1>
    <div class="col-md-3" style="margin-top:24px;">
    
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>index/busquedaPorServicio">
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

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

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
        <th scope="col" style="width:50px;">Desayuno</th>
        <th scope="col" style="width:50px;">Almuerzo</th> 
        <th scope="col" style="width:50px;">Once</th> 
        <th scope="col" style="width:50px;">Cena</th>
        <th scope="col" style="width:50px;">Col_10</th> 
        <th scope="col" style="width:50px;">Col_20</th>
        <th scope="col" style="width:20px;">Acciones</th>  
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
          <?php $desayuno = $this->objRecetas->obtener(array("id_receta" => $sol->id_desayuno));?>
          <td><?php echo $desayuno->nombre; ?></td>
          <?php $almuerzo = $this->objRegimen->obtener(array("id_regimen" => $sol->id_almuerzo));?>
          <td><?php echo $almuerzo->nombre; ?></td>
          <?php $once = $this->objRecetas->obtener(array("id_receta" => $sol->id_once));?>
          <td><?php echo $once->nombre; ?></td>
          <?php $cena = $this->objRegimen->obtener(array("id_regimen" => $sol->id_cena));?>
          <td><?php echo $cena->nombre; ?></td>
          <?php $col_10 = $this->objRecetas->obtener(array("id_receta" => $sol->id_col10));?>
          <td><?php echo $col_10->nombre; ?></td>
          <?php $col_20 = $this->objRecetas->obtener(array("id_receta" => $sol->id_col20));?>
          <td><?php echo $col_20->nombre; ?></td>
          <td class="editar">
            <a href="<?php echo base_url(); ?>index/editar/<?php echo $sol->id_solicitud; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
            </a>

            <a href="<?php echo base_url(); ?>index/eliminar/<?php echo $sol->id_solicitud; ?>" onclick="return confirm('Esta seguro que desea eliminar esta solicitud?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
          </td>
				</tr>
			<?php endforeach;?>
		<?php } else{ ?>
			<tr>
				<td colspan="10" style="text-align:center;"><i>No hay registros</i></td>
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