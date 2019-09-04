<style>
h1.ex1 {
  width:800px;
  height:80px;
  margin: auto;
  background: #0C1555;
  font-family: Lucida Calligraphy, Mistral, fantasy;
  color: white;
}

div.ex2 {
  height:180px;
  width:1200px;
  margin: auto;
  text-align:center;
  background-color:#4355CB;
}
p.parrafo1{
  color: red;
  font: oblique bold 200% cursive;
}

div.datos{
  color: white;
  text-align: center;
  font-weight: bold;
}

.button2 {
  background-color: white; 
  color: black; 
  border: 2px solid #008CBA;
}

.button2:hover {
  background-color: #008CBA;
  color: white;
}

</style>

<div class="ex2">
<h1 class="ex1" align="center">Gestión para Nutricionistas</h1>
 <img src="<?php echo base_url() ?>/imagenes/sitio/miminuta.png" width="200" height="100" align="left"/>
    <div class="datos">
      <?php echo "Nombre Usuario: ".$this->session->userdata("usuario")->nombre." ".$this->session->userdata("usuario")->apellidoPaterno." ".$this->session->userdata("usuario")->apellidoMaterno; ?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php $hospital = $this->objHospital->obtener(array('id_hospital' => $this->session->userdata("usuario")->id_unidad)); ?>
      <?php echo "Institucion: ".$hospital->hos_nombre; ?>
    </div>
</div>

<div class="page-header">
  <div class="row">
    <div>
      <div class="jumbotron">
        <p id="clock" style="text-align: right;">
  <?php echo strftime("%A, %d de %B de %Y, %H:%M:%S", strtotime(date("Y-m-d H:i:s"))); ?>
</p>

	<body>

  <div class="btn-group btn-group-lg" role="group">
    <button class="button button2"><a href="<?php echo base_url(); ?>index/mis_servicios"><i class="icon-h-sign" style="font-size:60px;color:black;"> Clinica</i></a></button> 

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <button class="button button2"><a href="<?php echo base_url(); ?>paciente_general/"><i class="fa fa-users" style="font-size:60px;color:black;"> Pacientes</i></a></button> 

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <button class="button button2"><a href="<?php echo base_url(); ?>paciente/"><i class="icon-user-md" style="font-size:60px;color:black;"> Hospitalizados</i></a></button>
  </div>
  
	</body>

	</div>
  </div>
</div>
</div>