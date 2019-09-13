<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Desayunos</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Desayunos</h1>
    <div class="col-md-3" style="margin-top:24px;">
        
      <form class="form-inline" method="get" action="<?php echo base_url(); ?>desayuno/busqueda">
      <div class="input-group">
    
      <div class="col-sm-15">
        <select id="desayunos" name="desayunos" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($desayunos){ ?>
           <?php foreach($desayunos as $desayuno){ ?>
              <option value="<?php echo $desayuno->receta_nombre; ?>"><?php echo $desayuno->receta_nombre; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>desayuno/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar Receta</button>
      </div>
      <br>
      <!--
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>desayuno/agregar_detalle_codigo/'" type="button" class="btn btn-primary col-md-12">Agregar Detalle Codigo</button>
      </div>
      -->
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
        <th scope="col" style="width:20px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $desayuno): ?>
				<tr>
          <td><?php echo $desayuno->receta_nombre;?></td>
          <?php $regimen = $this->objRegimen->obtener(array('id_regimen' => $desayuno->regimen)); ?>
          <td><?php echo $regimen->nombre;?></td>
					<td class="editar">
            <!--
						<a href="<?php echo base_url(); ?>desayuno/editar/<?php echo $desayuno->id_desayuno ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>-->

            <a href="<?php echo base_url(); ?>desayuno/eliminar/<?php echo $desayuno->id_desayuno; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

            <?php if($desayuno->estado == 0){ ?>
							<button type="button" class="btn btn-primary btn-xs estado" rel="<?php echo $desayuno->id_desayuno .'-1'; ?>" >Activo</button>
						<?php } else{ ?>
							<button type="button" class="btn btn-warning btn-xs estado" rel="<?php echo $desayuno->id_desayuno .'-0'; ?>">Inactivo</button>
						<?php } ?>

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