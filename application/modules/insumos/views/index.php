<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Insumos</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Insumos</h1>

    <div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="get" action="<?php echo base_url(); ?>insumos/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="insumos" name="insumos" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($insumos){ ?>
           <?php foreach($insumos as $insumo){ ?>
              <option value="<?php echo $insumo->nombre; ?>"><?php echo $insumo->nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>insumos/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:90px;">Código</th>
        <th scope="col" style="width:150px;">Nombre del Insumo</th>
        <th scope="col" style="width:100px;">Rubro</th>
        <th scope="col" style="width:90px;">Unidad de medida</th>
        <th scope="col" style="width:90px;">Unidad de Compra</th>
        <th scope="col" style="width:90px;">Perecible</th>
        <th scope="col" style="width:90px;">Factor de Pedido</th>
        <th scope="col" style="width:90px;">Costo</th>
        <th scope="col" style="width:90px;">Proveedor</th>
        <th scope="col" style="width:90px;">Factor Costo</th>
        <th scope="col" style="width:50px;">Estado</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $insumos): ?>
				<tr>
					<td><?php echo $insumos->codigo; ?></td>
					<td><?php echo $insumos->nombre;?></td>
          <?php $rubro = $this->objRubro->obtener(array("id_rubro" => $insumos->id_rubro)); ?>
          <td><?php echo $rubro->nombre;?></td>
          <?php $unidad_medida = $this->objUnidadesMed->obtener(array("id_unidad_medidad" => $insumos->id_unidad_medida)); ?>
          <td><?php echo $unidad_medida->nombre;?></td>
          <?php $unidad_compra = $this->objUnidadesMed->obtener(array("id_unidad_medidad" => $insumos->unidad_compra)); ?>
          <td><?php echo $unidad_compra->nombre;?></td>
          <?php $proveedor = $this->objProveedor->obtener(array("id_proveedor" => $insumos->id_proveedor)); ?>

          <?php if($insumos->perecible == 1){ ?>
          <td><?php echo "Perecible";?></td>
          <?php  }else{?>
          <td><?php echo "No Perecible";?></td>
          <?php } ?>  

          <td><?php echo $insumos->factor_pedido;?></td>
          <td><?php echo $insumos->costo;?></td>
          <td><?php echo $proveedor->nombre_proveedor;?></td>
          <td><?php echo $insumos->factor_costo;?></td>
          <?php if($insumos->estado == 0){ ?>
            <td><?php echo 'ACTIVO'; ?></td>
          <?php  }else{?>
            <td><?php echo 'DESACTIVO'; ?></td>
          <?php  }?>
					<td class="editar">
            <?php if($this->session->userdata("usuario")->id_perfil == 1){ ?>
						<a href="<?php echo base_url(); ?>insumos/editar/<?php echo $insumos->id_insumo; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>
            <?php if($insumos->estado == 0){ ?>
              <a href="<?php echo base_url(); ?>insumos/eliminar/<?php echo $insumos->id_insumo; ?>" onclick="return confirm('Esta seguro que desea desactivar este registro?');"><button title="Desactivar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
            <?php }else{ ?>
              <a href="<?php echo base_url(); ?>insumos/activar/<?php echo $insumos->id_insumo; ?>" onclick="return confirm('Esta seguro que desea activar este registro?');"><button title="Activar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></button></a>
            <?php } ?>
            <?php } ?>
            <a href="<?php echo base_url(); ?>aporte_insumo/index/<?php echo $insumos->id_insumo; ?>">
              <button title="Ver Aporte Nutricionales" type="button" class="btn btn-success btn-sm">Ver Aportes</button>
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

<!-- [PAGINACION] -->
<?php echo $pagination; ?>