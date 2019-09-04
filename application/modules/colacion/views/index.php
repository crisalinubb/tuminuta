<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Colaciones</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Colaciones</h1>
    <div class="col-md-3" style="margin-top:24px;">

        <form class="form-inline" method="get" action="<?php echo base_url(); ?>colacion/busqueda">
      <div class="input-group">
    
      <div class="col-sm-15">
        <select id="colacion" name="colacion" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($colacion){ ?>
           <?php foreach($colacion as $col){ ?>
              <option value="<?php echo $col->receta_nombre; ?>"><?php echo $col->receta_nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>colacion/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:50px;">Receta</th>
        <th scope="col" style="width:50px;">Regimen</th>
        <th scope="col" style="width:20px;">Estado</th>      
        <th scope="col" style="width:20px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $col): ?>
				<tr>
					<td><?php echo $col->receta_nombre;?></td>
          <?php $regimen = $this->objRegimen->obtener(array('id_regimen' => $col->regimen)); ?>
          <td><?php echo $regimen->nombre;?></td>
          <?php if($col->estado == 0){ ?>
            <td><?php echo 'ACTIVO';?></td>
          <?php  }else{?>
            <td><?php echo 'INACTIVO';?></td>
          <?php  }?>
					<td class="editar">
            <!--
						<a href="<?php echo base_url(); ?>col_10/editar/<?php echo $col10->id_col10 ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>-->

            <a href="<?php echo base_url(); ?>colacion/eliminar/<?php echo $col->id_colacion; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

            <?php if($col->estado == 0){ ?>
           
               <a href="<?php echo base_url(); ?>colacion/desactivar/<?php echo $col->id_colacion; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm">DESACTIVAR</button> 

            <?php  }else{?>

              <a href="<?php echo base_url(); ?>colacion/activar/<?php echo $col->id_colacion; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm">ACTIVAR</button>

            <?php  }?>

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