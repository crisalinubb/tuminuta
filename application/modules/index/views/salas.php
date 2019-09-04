<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>index/mis_servicios">Servicios Clinicos</a></li>
  <li class="active">Salas</li>
</ol>

<div align="center">
	<h3><?php echo $nombre_servicio->nombre_servicio; ?></h3>
</div>

<h1 class="col-md-7">Salas</h1>
<br>
<div class="page-header">
  <div class="row">
    <div>
    	<div class="jumbotron">
    		<?php if($datos){ ?>
			<?php foreach($datos->result() as $salas): ?>
		  <p><a href="<?php echo base_url(); ?>index/ver_camas/<?php echo $salas->id_sala; ?>" ><?php echo " ".$salas->NOMSALA; ?></a></p>
		  	<?php endforeach;?>
		<?php } else{ ?>
			<div>
				<p> No hay Salas en esta sesion</p>
			</div>
		<?php } ?>
		</div>
  </div>
</div>