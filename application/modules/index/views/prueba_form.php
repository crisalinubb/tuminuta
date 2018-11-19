<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="<?php echo base_url(); ?>index/ver_datos_prueba" method="post" class="form-horizontal">
  First name:<br>
  <input type="text" name="firstname" value="Mickey">
  <br>
  Last name:<br>
  <input type="text" name="lastname" value="Mouse">
  <br><br>
  <input type="submit" name="boton1" value="primer_boton">
  <input type="submit" name="boton2" value="segundo_boton">
</form> 

</body>
</html>
