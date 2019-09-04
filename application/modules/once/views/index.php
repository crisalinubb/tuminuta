<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Onces</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Onces</h1>
    <div class="col-md-3" style="margin-top:24px;">
        
      <form class="form-inline" method="get" action="<?php echo base_url(); ?>once/busqueda">
      <div class="input-group">
    
      <div class="col-sm-15">
        <select id="onces" name="onces" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($onces){ ?>
           <?php foreach($onces as $once){ ?>
              <option value="<?php echo $once->receta_nombre; ?>"><?php echo $once->receta_nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>once/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
			<?php foreach($datos as $onces): ?>
				<tr>
          <td><?php echo $onces->receta_nombre;?></td>
          <?php $regimen = $this->objRegimen->obtener(array('id_regimen' => $onces->regimen)); ?>
          <td><?php echo $regimen->nombre;?></td>
          <?php if($onces->estado == 0){ ?>
            <td><?php echo 'ACTIVO';?></td>
          <?php  }else{?>
            <td><?php echo 'INACTIVO';?></td>
          <?php  }?>
					<td class="editar">
            <!--
						<a href="<?php echo base_url(); ?>once/editar/<?php echo $onces->id_once ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>-->

            <a href="<?php echo base_url(); ?>once/eliminar/<?php echo $onces->id_once; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

            <?php if($onces->estado == 0){ ?>
           
               <a href="<?php echo base_url(); ?>once/desactivar/<?php echo $onces->id_once; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm">DESACTIVAR</button> 

            <?php  }else{?>

              <a href="<?php echo base_url(); ?>once/activar/<?php echo $onces->id_once; ?>">
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