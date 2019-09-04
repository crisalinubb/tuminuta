<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Usuarios</li>
</ol>

 <h1 class="col-md-7">Usuarios</h1>
 <br>
<div class="page-header">
  <div class="row">
    <div>
    	<div class="jumbotron">
      <?php  if($this->session->userdata("usuario")->id_perfil == 1){?>
  		  <p><a href="<?php echo base_url(); ?>usuarios/">Administrador</a></p>
  		  <p><a href="<?php echo base_url(); ?>usuarios_organizacion/">Administrador de Organizacion</a></p>
  		  <p><a href="<?php echo base_url(); ?>usuarios_nutricionista">Nutricionista</a></p>
      <?php }else if ($this->session->userdata("usuario")->id_perfil == 2) {?>
        <p><a href="<?php echo base_url(); ?>usuarios_organizacion/">Administrador de Organizacion</a></p>
        <p><a href="<?php echo base_url(); ?>usuarios_nutricionista">Nutricionista</a></p>
      <?php  }?>
		</div>
  </div>
</div>