<?php if(isset($home_indicador)){ ?>

<?php }else{ ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <span class="navbar-brand"><img src="<?php echo base_url(); ?>imagenes/template/logo2.png" width="101" height="40" /></span>
    </div>
    
    <div class="collapse navbar-collapse navbar-ex1-collapse" id="menu">
        <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $this->session->userdata("usuario")->email; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>perfil/"><i class="icon-user"></i> Perfil</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>logout/"><i class="icon-power-off"></i> Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>
