<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
</ol>

<div class="container">
	<?php if ($mesagge) { ?>
		<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
	<?php } ?>
  <h2>Liberar Clinica</h2>
  <div>

    <a href="<?php echo base_url(); ?>index/liberar" onclick="return confirm('Esta seguro que desea liberar toda la clinica de la organizacion?');"><button title="Eliminar" type="button" class="btn btn-primary">Liberar Clinica</button></a>

  </div>
</div>