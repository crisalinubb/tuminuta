<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
</ol>

 <h1 class="col-md-7"> Asignar Servicios Clinicos</h1>
 <br>
 <h3><center><?php echo $nombre_usuario ;?></center></h3>
<div class="page-header">
  <div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Servicios Clinicos</th>
        <th scope="col" style="width:50px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $servicio): ?>
				<tr>
					<td><?php echo $servicio->nombre_servicio; ?></td>
					<?php $servicios_asociados = $this->objIndex->validar_servicios($codigo_usuario, $servicio->id_servicio); ?>
					<td>
					<?php if($servicios_asociados == 0){?>
						<button type="button" class="btn btn-primary btn-xs datos" rel="<?php echo $servicio->id_servicio .'-'. $codigo_usuario.'-1'; ?>" >Asignar Servicio</button>
					<?php } else{ ?>
						<button type="button" class="btn btn-warning btn-xs datos" rel="<?php echo $servicio->id_servicio .'-'. $codigo_usuario.'-2'; ?>">Desvincular Servicio</button>
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
    //evento que se ejecuta cuando se hace click en el estado de la tabla desayuno
  $(".datos").click(function() {  
        //se envio el valor del estado
        var datos = $(this).attr('rel'); 
        
        var r = confirm("¿Esta seguro que quiere realizar cambios de asignación?");
        if (r == true) {
  
          var request = $.ajax({
          url: "<?php echo base_url(); ?>index/vincular_desvincular_servicio",
          type: "POST",          
          dataType: "json",
          data: { datos: datos},
          
          success: function(json){
                     if(json.result){
                         noty({
                             text: json.msg,
                             layout: 'topCenter',
                             type: 'success',
                             timeout: 2000,
                             killer: true
                         });
  
                      //    setTimeout(function() {
                      //     window.location.replace('<?php echo base_url();?>desayuno/');
                      //        }, 1000)
                      setTimeout(function() {
                          window.location.href = window.location.pathname;
                      }, 1000);
                      
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
        }
        
  
    });
  });
</script>