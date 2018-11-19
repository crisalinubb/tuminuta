 <h1 class="col-md-7">Menu Principal</h1>
 <br>
<div class="page-header">
  <div class="row">
  	<div>
  		<?php echo "Nombre Usuario: ".$this->session->userdata("usuario")->nombre." ".$this->session->userdata("usuario")->apellidoPaterno." ".$this->session->userdata("usuario")->apellidoMaterno; ?>
  		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  		<?php $hospital = $this->objHospital->obtener(array('id_hospital' => $this->session->userdata("usuario")->id_unidad)); ?>
  		<?php echo "Unidad/Organizacion: ".$hospital->hos_nombre; ?>
  	</div>
    <div>
    	<div class="jumbotron">
    		<p id="clock" style="text-align: right;">
  <?php echo strftime("%A, %d de %B de %Y, %H:%M:%S", strtotime(date("Y-m-d H:i:s"))); ?>
</p>

	<body>
	<a href="<?php echo base_url(); ?>index/mis_servicios">
	<button type="button" aria-haspopup="true" aria-expanded="false" style="height:150px;width:250px">
	    Clinica
	</button></a>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<a href="<?php echo base_url(); ?>paciente_general/">
	<button type="button" aria-haspopup="true" aria-expanded="false" style="height:150px;width:250px">
	   Pacientes
	</button></a>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<a href="<?php echo base_url(); ?>paciente/">
	<button type="button" aria-haspopup="true" aria-expanded="false" style="height:150px;width:250px">
	    Hospitalizados
	</button></a>
	</body>

	</div>
  </div>
</div>
</div>