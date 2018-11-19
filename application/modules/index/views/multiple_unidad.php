<h1 class="col-md-7">Seleccionar Unidad/Organizacion</h1>
 <br>
<div class="page-header">
  <div class="row">
    <div>
    	<div class="jumbotron">
    		<?php if($unidades){ ?>
			<?php foreach($unidades->result() as $unidad): ?>
		  <p><a href="<?php echo base_url(); ?>index/ingresar_unidad_usuario/<?php echo $unidad->id_unidad; ?>"><?php $hospital = $this->objHospital->obtener(array('id_hospital' => $unidad->id_unidad)); ?>  <?php echo $hospital->hos_nombre; ?></a></p>
		  	<?php endforeach;?>
		<?php } ?>
		</div>
  </div>
</div>