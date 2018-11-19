<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Rubros</h1>

    <div class="col-md-3" style="margin-top:24px;">
       <form class="form-inline" method="get" action="<?php echo base_url(); ?>rubros/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="rubros" name="rubros" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($rubros){ ?>
           <?php foreach($rubros as $rubro){ ?>
              <option value="<?php echo $rubro->nombre; ?>"><?php echo $rubro->nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>rubros/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:200px;">Nombre del rubro</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $rubros): ?>
				<tr>
					<td><?php echo $rubros->nombre;?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>rubros/editar/<?php echo $rubros->id_rubro; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>rubros/eliminar/<?php echo $rubros->id_rubro; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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