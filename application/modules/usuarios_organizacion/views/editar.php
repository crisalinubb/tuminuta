<div class="page-header">
  <h1>Editar Usuario</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
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
        <input type="text" id="login" name="login" class="form-control validate[required]" value="<?php echo $usuarios->login; ?>">
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" id="password" name="password" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="hospitales" class="col-sm-2 control-label">Hospital</label>
      <div class="col-sm-4">
        <select id="id_hospital" name="id_hospital" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($hospitales){ ?>
           <?php foreach($hospitales as $hospital){ ?>
              <option value="<?php echo $hospital->id_hospital; ?>"  <?php if($usuarios->id_unidad == $hospital->id_hospital) echo "selected"; ?>><?php echo $hospital->hos_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>