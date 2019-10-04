<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Funcionarios</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Funcionarios</h1>
    <div class="col-md-3" style="margin-top:24px;">
        
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>funcionario/busqueda">
      <div class="input-group">
    
      <div class="col-sm-15">
        <select id="servicios" name="servicios" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($servicios){ ?>
           <?php foreach($servicios as $servicio){ ?>
              <option value="<?php echo $servicio->id_servicio; ?>"><?php echo  $servicio->nombre_servicio; ?></option>
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
        <button onclick="javascript:location.href='<?php echo base_url(); ?>funcionario/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar Funcionario</button>
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
  <table  class="table table-bordered" border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Nombre Completo</th>
        <th scope="col" style="width:25px;">Rut</th>
        <th scope="col" style="width:20px;">Servicio</th>
        <th scope="col" style="width:20px;">Tipo Contrato</th> 
        <th scope="col" style="width:20px;">Unidad</th>
        <th scope="col" style="width:20px;">Observacion</th>   
        <th scope="col" style="width:20px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $fun): ?>
				<tr>
          <td><?php echo $fun->nombre." ".$fun->apellido_pat." ".$fun->apellido_mat; ?></td>
          <td><?php echo $fun->rut; ?></td>
          <?php $serv = $this->objServicioclinico->obtener(array("id_servicio" => $fun->fk_servicio )); ?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <?php $tip_cont = $this->objTipoContrato->obtener(array("id_tipocontrato" => $fun->fk_tipocontrato )); ?>
          <td><?php echo $tip_cont->descripcion; ?></td>
          <?php $unidad = $this->objHospital->obtener(array("id_hospital" => $fun->fk_unidad )); ?>
          <td><?php echo $unidad->hos_nombre; ?></td>
          <td><?php echo $fun->observacion; ?></td>
          <td class="editar">
            <a href="<?php echo base_url(); ?>funcionario/editar/<?php echo $fun->id_funcionario; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
            </a>

            <?php if($fun->activo == 0){ ?>
							<button type="button" class="btn btn-primary btn-xs estado" rel="<?php echo $fun->id_funcionario .'-1'; ?>" >Activo</button>
						<?php } else{ ?>
							<button type="button" class="btn btn-warning btn-xs estado" rel="<?php echo $fun->id_funcionario .'-0'; ?>">Inactivo</button>
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
