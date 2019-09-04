<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Editar Perfil</li>
</ol>

<div class="page-header">
  <h1>Editar Perfil</h1>
</div>
<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal" action="<?php echo base_url(); ?>usuarios/modificar_perfil/">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" value="<?php echo $usuarios->rut; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="dv" class="col-sm-2 control-label">Digito Verificador</label>
      <div class="col-sm-10">
        <input type="text" id="dv" name="dv" class="form-control validate[required]" value="<?php echo $usuarios->dv; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $usuarios->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $usuarios->id_usuario; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="apellidoP" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidoP" name="apellidoP" class="form-control validate[required]" value="<?php echo $usuarios->apellidoPaterno; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidoM" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidoM" name="apellidoM" class="form-control validate[required]" value="<?php echo $usuarios->apellidoMaterno; ?>" />
      </div>
    </div>

     <div class="form-group">
      <label for="login" class="col-sm-2 control-label">Login</label>
      <div class="col-sm-10">
        <input type="text" id="login" name="login" class="form-control" value="<?php echo $usuarios->login; ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" id="password" name="password" class="form-control" required />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>