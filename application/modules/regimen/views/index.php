<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Regimenes</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Regimenes</h1>

    <div class="col-md-3" style="margin-top:24px;">
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>regimen/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="regimenes" name="regimenes" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->nombre; ?>"><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>
    </div>

    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>regimen/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:100px;">Nombre del Regimen</th>
        <th scope="col" style="width:100px;">Tipo</th>      
        <th scope="col" style="width:100px;">Base</th> 
        <th scope="col" style="width:100px;">Producto</th>  
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $regimenes): ?>
				<tr>
					<td><?php echo $regimenes->nombre;?></td>
          <?php if($regimenes->tipo == 1){ ?>
            <td><?php echo 'Planificable';?></td>
          <?php }else if($regimenes->tipo == 0){?>
            <td><?php echo 'No Planificable';?></td>
          <?php } ?>
          <?php $base = $this->objRegimen->obtener(array('id_regimen' => $regimenes->base)); ?>
          <td><?php echo $base->nombre;?></td>
          <?php $producto = $this->objProducto->obtener(array('id_producto' => $regimenes->producto)); ?>
          <td><?php echo $producto->nombre_producto;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>regimen/editar/<?php echo $regimenes->id_regimen; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>regimen/eliminar/<?php echo $regimenes->id_regimen; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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