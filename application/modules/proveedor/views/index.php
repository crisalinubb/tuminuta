<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Proveedores</h1>

    <div class="col-md-3" style="margin-top:24px;">
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>proveedor/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="proveedores" name="proveedores" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($proveedores){ ?>
           <?php foreach($proveedores as $proveedor){ ?>
              <option value="<?php echo $proveedor->nombre_proveedor; ?>"><?php echo $proveedor->nombre_proveedor; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>proveedor/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:200px;">Nombre del Proveedor</th>
        <th scope="col" style="width:100px;">Direccion</th>
        <th scope="col" style="width:90px;">Numero telefonico</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $proveedores): ?>
				<tr>
					<td><?php echo $proveedores->nombre_proveedor;?></td>
          <td><?php echo $proveedores->direccion;?></td>
          <td><?php echo $proveedores->telefono;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>proveedor/editar/<?php echo $proveedores->id_proveedor; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>proveedor/eliminar/<?php echo $proveedores->id_proveedor; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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