 <h1 class="col-md-7">Servicios Clinicos</h1>
 <br>
<div class="page-header">
  <div class="row">
    <div>
    	<div class="jumbotron">
    		<?php if($datos){ ?>
			<?php foreach($datos->result() as $servicios): ?>
		  <p><a href="<?php echo base_url(); ?>index/ver_salas?servicio=<?php echo $servicios->id_servicio; ?>"><?php $serv = $this->objServicioClinico->obtener(array('id_servicio' => $servicios->id_servicio)); ?><?php echo $serv->nombre_servicio; ?></a></p>
		  	<?php endforeach;?>
		<?php } else{ ?>
			<div>
				<p> No hay Servicios Clinicos para este usuario</p>
			</div>
		<?php } ?>
		</div>
  </div>
</div>