<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Recetas</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Recetas</h1>

    <div class="col-md-3" style="margin-top:24px;">
      
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>recetas/busqueda">
      <div class="input-group">

      <div class="input-group">
      <div class="col-sm-25">
        <select id="regimenes" name="regimenes" class="selectpicker" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
           <?php $reg = $this->objRegimen->obtener(array('id_regimen' => $regimen->base)); ?>
              <option value="<?php echo $reg->id_regimen; ?>"><?php echo $reg->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>

      <div class="input-group">
        <div class="col-sm-35">
        <select id="recetas" name="recetas" class="js-example-responsive" style="width: 150%">
           <option disabled selected>Seleccione</option> 
        </select>
      </div>
    </div>

      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>
    </div>

    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>recetas/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
      </div>
    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>recetas/InformeRecetas">
  <div class="form-group" align="right">
      <button type="submit" class="btn btn-default"><i class="icon-check">Reporte de Recetas</i></button>
  </div>
  </form>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:100px;">Nombre de la Receta</th>
        <th scope="col" style="width:100px;">Regimen</th>       
        <th scope="col" style="width:100px;">Tipo de receta</th>
        <th scope="col" style="width:50px;">Estado</th>  
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $recetas): ?>
				<tr>
					<td><?php echo $recetas->nombre;?></td>
          <?php $regimen = $this->objRegimen->obtener(array("id_regimen" => $recetas->id_regimen)); ?>
          <td><?php echo $regimen->nombre;?></td>
          <?php $tipo_receta = $this->objTiporeceta->obtener(array("id_tipo_receta" => $recetas->id_tipo_receta)); ?>
          <td><?php echo $tipo_receta->nombre;?></td>
          
          <?php if($recetas->estado == 0){ ?>
            <td><?php echo 'ACTIVO'; ?></td>
          <?php  }else{?>
            <td><?php echo 'DESACTIVO'; ?></td>
          <?php  }?>

					<td class="editar">
						<a href="<?php echo base_url(); ?>recetas/editar/<?php echo $recetas->id_receta; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <?php if($recetas->estado == 0){ ?>
              <a href="<?php echo base_url(); ?>recetas/eliminar/<?php echo $recetas->id_receta; ?>" onclick="return confirm('Esta seguro que desea desactivar este registro?');"><button title="DESACTIVAR" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
            <?php }else{ ?>
              <a href="<?php echo base_url(); ?>recetas/activar/<?php echo $recetas->id_receta; ?>" onclick="return confirm('Esta seguro que desea activar este registro?');"><button title="ACTIVAR" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></button></a>
            <?php } ?>

            

            <a href="<?php echo base_url(); ?>insumo_receta/index/<?php echo $recetas->id_receta; ?>">
              <button title="Ver Insumos" type="button" class="btn btn-success btn-sm">Ver Insumos</button>
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

<script type="text/javascript">   

            $(document).ready(function() {                       
                $("#regimenes").change(function() {
                    $("#regimenes option:selected").each(function() {
                        idRegimen = $('#regimenes').val();
                        $.post("<?php echo base_url(); ?>recetas/buscarRecetas", {
                            idRegimen : idRegimen
                        }, function(data) {
                            $("#recetas").html(data);
                        });
                    });
                });
            });

$(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});

</script>


<!-- [PAGINACION] -->
<?php echo $pagination; ?>