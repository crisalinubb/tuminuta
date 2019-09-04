<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Menu de Productos Solicitados</li>
</ol>

 <h1 class="col-md-7">Menu de Productos Solicitados</h1>
 <br>
<div class="page-header">
  <div class="row">
    <div>
    	<div class="jumbotron">
        <form action="<?php echo base_url(); ?>index/Informe_Producto" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit">Resumen Productos Solicitados</button>
  		  </form>

  		  <p><a href="<?php echo base_url(); ?>usuarios_organizacion/">Administrador de Organizacion</a></p>
  		  <p><a href="<?php echo base_url(); ?>usuarios_nutricionista">Nutricionista</a></p>
      
        <p><a href="<?php echo base_url(); ?>usuarios_organizacion/">Administrador de Organizacion</a></p>
        <p><a href="<?php echo base_url(); ?>usuarios_nutricionista">Nutricionista</a></p>
		</div>
  </div>
</div>