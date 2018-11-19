<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Aportes Nutricionales</h1>

    <div class="col-md-3" style="margin-top:24px;">
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>aportes_nutricionales/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="aportes_nutricionales" name="aportes_nutricionales" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($aportes_nutricionales){ ?>
           <?php foreach($aportes_nutricionales as $aporte_nutricional){ ?>
              <option value="<?php echo $aporte_nutricional->nombre; ?>"><?php echo $aporte_nutricional->nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>aportes_nutricionales/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:100px;">Nombre del Aporte nutricional</th>
        <th scope="col" style="width:100px;">Unidad de medida</th>       
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $aportes): ?>
				<tr>
					<td><?php echo $aportes->nombre;?></td>
          <?php $unidad_medida = $this->objUnidadesMed->obtener(array("id_unidad_medidad" => $aportes->id_unidad_medida)); ?>
          <td><?php echo $unidad_medida->nombre;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>aportes_nutricionales/editar/<?php echo $aportes->id_aporte_nutricional ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>aportes_nutricionales/eliminar/<?php echo $aportes->id_aporte_nutricional; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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