<style type="text/css">
#myModal{ overflow:hidden;}
@media screen and (min-width: 768px) {
.modal-dialog {
	width: 500px;
}

</style>
<div id="page-wrapper">
  <!-- contenido -->
  <div id="login" class="col-sm-4">
    <div class="page-header">
      <center>
      <img src="<?php echo base_url() ?>/imagenes/sitio/miminuta.png" width="300" height="200" />
      </center>
    </div>
    <form id="form-login" name="form-login" method="post" class="form-horizontal form-signin" role="form">
      <div class="form-group">
        <label for="inputEmail3">Login</label>
        <input type="text" class="form-control validate[required]" id="login_user" name="login_user" autofocus onchange="myFunction()"/>
      </div>
      <div class="form-group">
        <label for="inputPassword3">Password</label>
        <input type="password" class="form-control validate[required]" id="inputPassword3" name="password" />
      </div>

      <div class="form-group">
      <label for="codigo_unidad">Institucion</label>
      <br>
        <select id="codigo_unidad" name="codigo_unidad" class="form-control validate[required]">
           <option disabled selected>Seleccione</option> 
        </select>
    </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
        <br />
        <br />
      </div>
    </form>
  </div>
</div>

<p id="clock" style="text-align: center;">
  <?php echo strftime("%A, %d de %B de %Y, %H:%M:%S", strtotime(date("Y-m-d H:i:s"))); ?>
</p>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel">Recuperar contraseña</h3>
      </div>
      <div class="modal-body">
        <form role="form"  id="form-recuperar" method="post">
          <input type="text" name="email" placeholder="Indica tu email" class="form-control validate[required,custom[email]]" />

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
	  </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
			function myFunction() {   
            //$(document).ready(function() {                       
                //$("#codigo_servicio").change(function() {
                   // $("#codigo_servicio option:selected").each(function() {
                        login = $('#login_user').val();
                        console.log(login);
                        $.post("<?php echo base_url(); ?>inicio/buscar_unidades", {
                            login : login
                        }, function(data) {
                            $("#codigo_unidad").html(data);
                        });
                   // });
                //});
            //});
            }
</script>