<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Nutricionistas</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Nutricionistas</h1>
    <div class="col-md-3" style="margin-top:24px;">
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>usuarios_nutricionista/busqueda">
      <div class="input-group">
    
      <div class="col-sm-20">
        <select id="usuarios" name="usuarios" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($usuarios){ ?>
           <?php foreach($usuarios as $usuario){ ?>
              <option value="<?php echo $usuario->rut; ?>"><?php echo $usuario->nombre." ".$usuario->apellidoPaterno." ".$usuario->apellidoMaterno; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>usuarios_nutricionista/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
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
        <th scope="col" style="width:90px;">Rut</th>
        <th scope="col" style="width:80px;">Nombre Completo</th>
        <th scope="col" style="width:100px;">Login</th>
        <th scope="col" style="width:80px;">Organizacion/Hospital</th>            
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $usuarios): ?>
				<tr>
					<td><?php echo number_format($usuarios->rut, 0, ".", ".") . "-" . $usuarios->dv;?></td>
          <td><?php echo $usuarios->nombre." ".$usuarios->apellidoPaterno." ".$usuarios->apellidoMaterno; ?></td>
          <td><?php echo $usuarios->login; ?></td>
          <?php $hospital = $this->objHospital->obtener(array('id_hospital' => $usuarios->id_unidad)); ?>
          <td><?php echo $hospital->hos_nombre; ?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>usuarios_nutricionista/editar/<?php echo $usuarios->id_usuario; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>

            <a href="<?php echo base_url(); ?>usuarios_nutricionista/eliminar/<?php echo $usuarios->id_usuario; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
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