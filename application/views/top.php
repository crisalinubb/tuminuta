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
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Planificacion <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>planificacion/"><span class="fa fa-clipboard" aria-hidden="true"></span>&nbsp;&nbsp;Planificar</a></li>
                    <li><a href="<?php echo base_url(); ?>planificacion/repetirPlanificacion"><span class="fa fa-copy" aria-hidden="true"></span>&nbsp;&nbsp;Repeticion Planificacion</a></li>
                    <li><a href="<?php echo base_url(); ?>planificacion/InformePlanificacion"><span class="fa fa-bar-chart" aria-hidden="true"></span>&nbsp;&nbsp;Informe de Planificacion</a></li>
                    <li><a href="<?php echo base_url(); ?>planificacion/borrarPlanificacion"><span class="fa fa-eraser" aria-hidden="true"></span>&nbsp;&nbsp;Eliminar Planificacion</a></li>
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
             <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Produccion <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_desayuno"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Desayuno</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_almuerzo"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Almuerzo</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_once"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Once</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_cena"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Cena</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_col10"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Colacion de las 10</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_col20"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Colacion de las 20</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_formulaslacteas"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Formulas Lacteas</a></li>
                    <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_formulasenterales"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Formulas Enterales</a></li>
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
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Mantenedores <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>usuarios/usuarios"><span class="glyphicon glyphicon-user"></span>Usuarios</a></li>
                    <li><a href="<?php echo base_url(); ?>hospital/"><i class="fa fa-h-square"></i>&nbsp;&nbsp;Hospitales</a></li>
                    <!--
                    <li><a href="<?php echo base_url(); ?>detalle_codigo/"><span class="glyphicon glyphicon-barcode"></span>Detalle Codigo</a></li>-->
                    <li><a href="<?php echo base_url(); ?>rubros/"><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>Rubros</a></li>
                    <li><a href="<?php echo base_url(); ?>aportes_regimen/"><i class="fa fa-book"></i>&nbsp;&nbsp;Aportes por Regimen</a></li>
                    <li><a href="<?php echo base_url(); ?>unidades_medida/"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unidades de Medida</a></li>
                    <li><a href="<?php echo base_url(); ?>proveedor/"><span class="glyphicon glyphicon-shopping-cart"></span>Proveedores</a></li>
                    <li><a href="<?php echo base_url(); ?>insumos/"><i class="fa fa-apple"></i>&nbsp;&nbsp;Insumos</a></li>
                    <li><a href="<?php echo base_url(); ?>aportes_nutricionales/"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>Aportes nutricionales</a></li>
                    <li><a href="<?php echo base_url(); ?>tipos_de_recetas/"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>Tipos de Recetas</a></li>
                    <li><a href="<?php echo base_url(); ?>servicio_clinico/"><i class="fa fa-medkit"></i>&nbsp;&nbsp;Servicios Clinicos</a></li>
                    <li><a href="<?php echo base_url(); ?>camas/"><span class="fa fa-hotel" aria-hidden="true"></span>&nbsp;&nbsp;Camas</a></li>
                    <li><a href="<?php echo base_url(); ?>salas/"><span class="glyphicon glyphicon-road" aria-hidden="true"></span>Salas</a></li>
                    <li><a href="<?php echo base_url(); ?>servicios_alimentacion/"><span class="fa fa-dedent" aria-hidden="true"></span>&nbsp;&nbsp;Servicios de Alimentacion</a></li>
                    <li><a href="<?php echo base_url(); ?>regimen/"><span class="fa fa-edit" aria-hidden="true"></span>&nbsp;&nbsp;Regimen</a></li>
                    <li><a href="<?php echo base_url(); ?>recetas/"><span class="   glyphicon glyphicon-cutlery" aria-hidden="true"></span>Recetas</a></li>
                    <li><a href="<?php echo base_url(); ?>comuna/"><i class="fa fa-flag-o"></i>&nbsp;&nbsp;Comunas</a></li>
                    <li><a href="<?php echo base_url(); ?>diagnostico/"><i class="fa fa-h-square"></i>&nbsp;&nbsp;Diagnostico</a></li>
                    <li><a href="<?php echo base_url(); ?>escolaridad/"> <span class="glyphicon glyphicon-pencil"></span>Nivel de Educacion</a></li>
                    <li><a href="<?php echo base_url(); ?>etnia/"><i class="fa fa-chain"></i>&nbsp;&nbsp;Etnias</a></li>
                    <li><a href="<?php echo base_url(); ?>pais/"><i class="fa fa-flag"></i>&nbsp;&nbsp;Pais</a></li>
                    <li><a href="<?php echo base_url(); ?>region/"><i class="fa fa-flag-checkered"></i>&nbsp;&nbsp;Regiones</a></li>
                    <li><a href="<?php echo base_url(); ?>sexo/"><i class="fa fa-intersex"></i>&nbsp;&nbsp;Sexo</a></li>
                    <li><a href="<?php echo base_url(); ?>medico/"><i class="fa fa-user-md"></i>&nbsp;&nbsp;Medicos</a></li>
                    <li><a href="<?php echo base_url(); ?>producto/"><span class="glyphicon glyphicon-collapse-up"></span>Producto</a></li>
                    <li><a href="<?php echo base_url(); ?>destinos/"><span class="glyphicon glyphicon-flag"></span>Destinos</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Informes <span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>index/vista_informe_almuerzo"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Informe Solicitudes <br> Almuerzo</a></li>
                    <li><a href="<?php echo base_url(); ?>index/vista_informe_cena"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Informe Solicitudes <br> Cena</a></li>
                    <li><a href="<?php echo base_url(); ?>index/listado_ingesta_real"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Informe Ingesta Real</a></li>
                    <li><a href="<?php echo base_url(); ?>index/paciente_egresados"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Informe Pacientes <br>Egresados</a></li>
                    <li><a href="<?php echo base_url(); ?>index/vistaInformeProducto"><span class="fa fa-file-pdf-o" aria-hidden="true"></span>&nbsp;&nbsp;Informe Productos <br>Solicitados</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Casino<span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>control_casino/solicitud_por_servicio"><span class="fa fa-address-book" aria-hidden="true"></span>&nbsp;&nbsp;Solicitud por Servicio</a></li>
                    <li><a href="<?php echo base_url(); ?>control_casino/"><span class="fa fa-address-book" aria-hidden="true"></span>&nbsp;&nbsp;Control Casino</a></li>
                    <li><a href="<?php echo base_url(); ?>control_casino/registro_por_servicio"><span class="fa fa-address-book" aria-hidden="true"></span>&nbsp;&nbsp;Registro por servicio</a></li>
                    <li><a href="<?php echo base_url(); ?>funcionario/"><span class="fa fa-address-book" aria-hidden="true"></span>&nbsp;&nbsp;Funcionarios</a></li>
                    <li><a href="<?php echo base_url(); ?>tarjeta/"><span class="fa fa-address-book" aria-hidden="true"></span>&nbsp;&nbsp;Tarjetas</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"></span>Configuraciones<span class="caret"></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>index/migracion_datos"><span class="fa fa-refresh" aria-hidden="true"></span>&nbsp;&nbsp;Migración de Datos</a></li>
                    <li><a href="<?php echo base_url(); ?>index/liberar_clinica"><span class="fa fa-hourglass-o" aria-hidden="true"></span>&nbsp;&nbsp;Liberar Clinica</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>
