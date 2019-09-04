<div class="page-header">
  <h1>Agregar Usuario</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]"/>
      </div>
    </div>

    <div class="form-group">
      <label for="dv" class="col-sm-2 control-label">Digito Verificador</label>
      <div class="col-sm-10">
        <input type="text" id="dv" name="dv" class="form-control validate[required]"/>
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]">
      </div>
    </div>

    <div class="form-group">
      <label for="apellidoP" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidoP" name="apellidoP" class="form-control validate[required]"/>
      </div>
    </div>

    <div class="form-group">
      <label for="apellidoM" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidoM" name="apellidoM" class="form-control validate[required]"/>
      </div>
    </div>

    <div class="form-group">
      <label for="login" class="col-sm-2 control-label">Login</label>
      <div class="col-sm-10">
        <input type="text" id="login" name="login" class="form-control validate[required]">
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" id="password" name="password" class="form-control validate[required]" />
      </div>
    </div>

    <?php if($this->session->userdata("usuario")->id_perfil == 1){?>
    <div class="form-group">
      <label for="unidad" class="col-sm-2 control-label">Unidad/Organizacion</label>
      <div class="col-sm-4">
        <select id="unidad" name="unidad" class="form-control validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($unidades){ ?>
           <?php foreach($unidades as $unidad){ ?>
              <option value="<?php echo $unidad->id_hospital; ?>"><?php echo $unidad->hos_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>
    <?php } ?>

    <div class="form-group">
      <label for="perfil" class="col-sm-2 control-label">Perfiles</label>
      <div class="col-sm-4">
        <select id="perfil" name="perfil" class="form-control validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($perfiles){ ?>
           <?php foreach($perfiles as $perfil){ ?>
              <option value="<?php echo $perfil->id_perfil; ?>"><?php echo $perfil->perfil_nombre; ?></option>
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