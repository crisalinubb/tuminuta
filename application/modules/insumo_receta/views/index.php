<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Insumos por Receta</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
      <form class="form-inline" method="post" action='<?= base_url() ?>insumo_receta/agregar/<?php echo $id_receta; ?>'>
        <div class="text-center new">
        <button type="submit" class="btn btn-primary col-md-12">Agregar Insumos</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div align="center">
   <?php $receta = $this->objRecetas->obtener(array("id_receta" => $id_receta)); ?>
  <div><h2><strong><?php echo $receta->nombre; ?></strong></h2></div>
</div>

<div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="post" action="<?php echo base_url(); ?>insumo_receta/busquedaPorRubro">
      <div class="input-group">
        <input type="hidden" id="receta" name="receta" class="form-control validate[required]" value="<?php echo $id_receta; ?>" />
      <div class="col-sm-20">
        <select id="rubros" name="rubros" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione Rubro</option>
           <?php if($rubros){ ?>
           <?php foreach($rubros as $rubro){ ?>
              <option value="<?php echo $rubro->id_rubro; ?>"><?php echo $rubro->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:100px;">Insumo</th> 
        <th scope="col" style="width:100px;">Cantidad</th>
        <th scope="col" style="width:30px;">Unidad de Medida</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $insumos_recetas): ?>
				<tr>
          <?php $insumo = $this->objInsumo->obtener(array("id_insumo" => $insumos_recetas->id_insumo)); ?>
          <td><?php echo $insumo->nombre;?></td>
          <td><?php echo $insumos_recetas->cantidad; ?></td>
          <td><?php echo $insumos_recetas->id_unidad_medida; ?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>insumo_receta/editar/<?php echo $insumos_recetas->id_insumo_receta; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>insumo_receta/eliminar/<?php echo $insumos_recetas->id_insumo_receta; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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
<br/>
<br/>
<br/>

<div >
  <p align="center" color="blue"><strong>Costo de la Receta: </strong>$ <?php echo number_format($costo_receta->SubTotal, 2, ',', '');?></p>
</div>

<h3><center>Aportes Nutricionales</center></h3>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Aporte</th> 
        <th scope="col" style="width:20px;">Total</th>
        <th scope="col" style="width:10px;">Um</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($insumos_aporte){ ?>
      <?php foreach($insumos_aporte->result() as $insumos_aportes): ?>
        <tr>
          <td><?php echo $insumos_aportes->nombre;?></td>
          <td><?php echo number_format($insumos_aportes->Total, 2, ',', '');?></td>
          <td><?php echo $insumos_aportes->id_unidad_medida;?></td>
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