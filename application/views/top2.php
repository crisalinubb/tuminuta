<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php if(isset($home_indicador)){ ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="navbar-header"> 
	  <span class="navbar-brand">
	  </span> 
  </div>
</nav>
<?php }else{ ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    
    <div class="collapse navbar-collapse navbar-ex1-collapse" id="menu">
        <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $this->session->userdata("usuario")->login; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>usuarios/perfil"><i class="icon-user"></i> Perfil</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>logout/"><i class="icon-power-off"></i> Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav side-nav">
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Pacientes <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>paciente_general/"><span class="fa fa-stethoscope" aria-hidden="true"></span>&nbsp;&nbsp;Pacientes</a></li>
                    <li><a href="<?php echo base_url(); ?>paciente/"><span class="fa fa-wheelchair" aria-hidden="true"></span>&nbsp;&nbsp;Pacientes Hospitalizados</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Clinica <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>index/mis_servicios"><span class="fa fa-cogs" aria-hidden="true"></span>&nbsp;&nbsp;Mis Servicios</a></li>
                    <li><a href="<?php echo base_url(); ?>index/mostrar_usuarios"><span class="fa fa-cogs" aria-hidden="true"></span>&nbsp;&nbsp;Asignar Servicios</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Distribucion <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>index/solicitud_desayuno"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de desayuno</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_almuerzo"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de almuerzo</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_once"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de once</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_cena"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de cena</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_col10"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de col_10</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_col20"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de col_20</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_formulas_lacteas"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes Formulas<br> Lacteas</a></li>
                    <li><a href="<?php echo base_url(); ?>index/solicitud_formulas_enterales"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Solicitudes de Formulas<br> Enterales</a></li>
                    <li><a href="<?php echo base_url(); ?>index/listaDistribucion"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Lista de Distribucion</a></li>
                    <li><a href="<?php echo base_url(); ?>index/listaDistribucion_Formulas_Lacteas"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Lista de Distribucion <br> Formulas Lacteas</a></li>
                    <li><a href="<?php echo base_url(); ?>index/listaDistribucion_Formulas_Enterales"><span class="fa fa-line-chart" aria-hidden="true"></span>&nbsp;&nbsp;Lista de Distribucion <br> Formulas Enterales</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Armar Menu <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>desayuno/"><span class="fa fa-coffee" aria-hidden="true"></span>&nbsp;&nbsp;Desayuno</a></li>
                    <!--
                    <li><a href="<?php echo base_url(); ?>almuerzo/"><span class="fa fa-cutlery" aria-hidden="true"></span>&nbsp;&nbsp;Almuerzo</a></li>-->
                    <li><a href="<?php echo base_url(); ?>once/"><span class="fa fa-coffee" aria-hidden="true"></span>&nbsp;&nbsp;Once</a></li>
                    <!--
                    <li><a href="<?php echo base_url(); ?>cena/"><span class="fa fa-cutlery" aria-hidden="true"></span>&nbsp;&nbsp;Cena</a></li>-->
                    <li><a href="<?php echo base_url(); ?>colacion/"><span class="fa fa-tag" aria-hidden="true"></span>&nbsp;&nbsp;Colaciones</a></li>
                    <!--
                    <li><a href="<?php echo base_url(); ?>col_20/"><span class="fa fa-tag" aria-hidden="true"></span>&nbsp;&nbsp;Col_20</a></li>-->
                </ul>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>
