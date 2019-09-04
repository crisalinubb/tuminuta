<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Unidades de Medida</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Unidades de Medida</h1>

    <div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="get" action="<?php echo base_url(); ?>unidades_medida/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="unidades_medida" name="unidades_medida" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($unidades_medida){ ?>
           <?php foreach($unidades_medida as $unidad_medida){ ?>
              <option value="<?php echo $unidad_medida->nombre; ?>"><?php echo $unidad_medida->nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>unidades_medida/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:400px;">Nombre de la Unidad de Medida</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $unidades_medida): ?>
				<tr>
					<td><?php echo $unidades_medida->id_unidad_medidad; ?></td>
					<td><?php echo $unidades_medida->nombre;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>unidades_medida/editar/<?php echo $unidades_medida->id_unidad_medidad; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>unidades_medida/eliminar/<?php echo $unidades_medida->id_unidad_medidad; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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