<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Aportes por Insumos</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
      <form class="form-inline" method="post" action='<?= base_url() ?>aporte_insumo/agregar?insumo=<?php echo $id_insumo; ?>'>
        <div class="text-center new">
        <button type="submit" class="btn btn-primary col-md-12">Agregar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div align="center">
  <?php $insumo = $this->objInsumo->obtener(array("id_insumo" => $id_insumo)); ?>
  <div><h2><strong><?php echo $insumo->nombre; ?></strong></h2></div>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:100px;">Aporte nutricional</th>
        <th scope="col" style="width:100px;">Cantidad</th>     
        <th scope="col" style="width:100px;">Cantidad de aporte</th>       
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $aporte_insumo): ?>
				<tr>
          <?php $aporte_nutricional = $this->objAportesNutricionales->obtener(array("id_aporte_nutricional" => $aporte_insumo->id_aporte)); ?>
					<td><?php echo $aporte_nutricional->nombre; ?></td>
          <td><?php echo $aporte_insumo->cantidad;?></td>
          <td><?php echo $aporte_insumo->cantidadAporte;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>aporte_insumo/editar/<?php echo $aporte_insumo->id_aporteinsumo; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>aporte_insumo/eliminar/<?php echo $aporte_insumo->id_aporteinsumo; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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

<!-- [PAGINACION] 
<?php echo $pagination; ?>-->