<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Aportes por Regimen</h1>
    
    <div class="col-md-3" style="margin-top:24px;">
      <!--
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>aportes_regimen/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="regimenes" name="regimenes" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $reg){ ?>
              <option value="<?php echo $reg->id_regimen; ?>">

                <?php echo $reg->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form>
    -->
    </div>

    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>aportes_regimen/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:50px;">Regimen</th>
        <th scope="col" style="width:50px;">Tipo de Aporte</th>
        <th scope="col" style="width:50px;">KCAL</th>
        <th scope="col" style="width:50px;">PROT</th>
        <th scope="col" style="width:50px;">LIP</th>
        <th scope="col" style="width:50px;">CHO</th>
        <th scope="col" style="width:30px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $aport_reg): ?>
				<tr>
          <?php $regimen = $this->objRegimen->obtener(array('id_regimen' => $aport_reg->id_regimen)); ?>
					<td><?php echo $regimen->nombre;?></td>
          <?php $tipo_aporte = $this->objTipoAport->obtener(array('id_tipoaporte' => $aport_reg->id_tipoaporte)); ?>
          <td><?php echo $tipo_aporte->tipoaporte_nombre;?></td>
          <td><?php echo $aport_reg->Kcal;?></td>
          <td><?php echo $aport_reg->Prot;?></td>
          <td><?php echo $aport_reg->Lip;?></td>
          <td><?php echo $aport_reg->Cho;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>aportes_regimen/editar/<?php echo $aport_reg->Id_Aporte_Nut; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>aportes_regimen/eliminar/<?php echo $aport_reg->Id_Aporte_Nut; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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