<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Tarjeta</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Tarjeta</h1>
    <div class="col-md-3" style="margin-top:24px;">
        
      <form class="form-inline" method="post" action="<?php echo base_url(); ?>funcionario/busqueda">
      <div class="input-group">
    
      <!-- <div class="col-sm-15">
        <select id="servicios" name="servicios" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <//?php if($servicios){ ?>
           <//?php foreach($servicios as $servicio){ ?>
              <option value="<//?php echo $servicio->id_servicio; ?>"><//?php echo  $servicio->nombre_servicio; ?></option>
           <//?php } ?>
           <//?php } ?>
        </select>
      </div>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Buscar</button>
        </span></div>
    </form> -->

    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>tarjeta/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar tarjeta</button>
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
        <th scope="col" style="width:20px;">Numero Tarjeta</th>
        <th scope="col" style="width:50px;">Vigencia</th>
        <th scope="col" style="width:20px;">Tipo Comida</th> 
        <th scope="col" style="width:20px;">Tipo Tarjeta</th>
        <th scope="col" style="width:50px;">Funcionario</th>
        <th scope="col" style="width:20px;">Unidad</th>   
        <th scope="col" style="width:20px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $tarjeta): ?>
				<tr>
          <td><?php echo $tarjeta->numero_tarjeta; ?></td>
          <?php 
          $fecha_desde = date("Y-m-d", strtotime(str_replace("/", "-", $tarjeta->vigencia_desde)));
          $fecha_hasta = date("Y-m-d", strtotime(str_replace("/", "-", $tarjeta->vigencia_hasta))); 
          ?>
          <td><?php echo $fecha_desde." / ".$fecha_hasta; ?></td>
          <?php $tipo_comida = $this->objTipoComida->obtener(array("id_tipocomida" => $tarjeta->fk_tipocomida )); ?>
          <td><?php echo $tipo_comida->nombre; ?></td>
          <?php $tip_tarj = $this->objTipoTarjeta->obtener(array("id_tipotarjeta" => $tarjeta->fk_tipotarjeta )); ?>
          <td><?php echo $tip_tarj->descripcion; ?></td>
          <?php $funcionario = $this->objFuncionario->obtener(array("id_funcionario" => $tarjeta->fk_funcionario )); ?>
          <td><?php echo $funcionario->nombre." ".$funcionario->apellido_pat." ".$funcionario->apellido_mat; ?></td>
          <?php $unidad = $this->objHospital->obtener(array("id_hospital" => $tarjeta->id_unidad )); ?>
          <td><?php echo $unidad->hos_nombre; ?></td>
          <td class="editar">
            <a href="<?php echo base_url(); ?>tarjeta/editar/<?php echo $tarjeta->numero_tarjeta; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
            </a>
            <?php if($tarjeta->activo == 0){ ?>
							<button type="button" class="btn btn-primary btn-xs activo" rel="<?php echo $tarjeta->numero_tarjeta .'-1'; ?>" >Activo</button>
						<?php } else{ ?>
							<button type="button" class="btn btn-warning btn-xs activo" rel="<?php echo $tarjeta->numero_tarjeta .'-0'; ?>">Inactivo</button>
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

<script>
$(document).ready(function() {
  //evento que se ejecuta cuando se hace click en el activo de la tabla tarjeta
$(".activo").click(function() {  
      //se envio el valor del activo
      var codigo = $(this).attr('rel'); 
      var r = confirm("¿Esta seguro de cambiar el estado de esta tarjeta?");
      if (r == true) {

        var request = $.ajax({
        url: "<?php echo base_url(); ?>tarjeta/cambio_activo_desactivo",
        type: "POST",          
        dataType: "json",
        data: { datos_tarjeta: codigo},
        
        success: function(json){
                   if(json.result){
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'success',
                           timeout: 2000,
                           killer: true
                       });

                       setTimeout(function() {
                        window.location.replace('<?php echo base_url();?>tarjeta/');
                           }, 1000)

                    
  
                   }
                   else
                   {
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'error',
                           timeout: 2000,
                           killer: true
                       });

                   }
        }
      });

        // request.done(function(data) {


        //   window.location.replace('<?php echo base_url();?>tarjeta/');
                
        // });

        // request.fail(function(jqXHR, textStatus) {
        //   alert( "Peticion Fallida: " + textStatus );
        // }); 
      }
      

  });
});
</script>