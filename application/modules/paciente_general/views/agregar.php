<div class="page-header">
  <h1>Agregar Paciente</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" placeholder="Ejemplo: 12345678 (sin punto ni dv)" />
      </div>
    </div>

    <div class="form-group">
      <label for="dv" class="col-sm-2 control-label">Digito Verificador</label>
      <div class="col-sm-10">
        <input type="text" id="dv" name="dv" size="1" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_paciente" class="col-sm-2 control-label">Codigo del paciente</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_paciente" name="codigo_paciente" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="apellidop" class="col-sm-2 control-label">Apellido Paterno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidop" name="apellidop" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="apellidom" class="col-sm-2 control-label">Apellido Materno</label>
      <div class="col-sm-10">
        <input type="text" id="apellidom" name="apellidom" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha1" type="text" class="form-control" name="fecha1" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
      </div>
      </div>

      <div class="form-group">
      <label for="telefono" class="col-sm-2 control-label">Telefono</label>
      <div class="col-sm-10">
        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ejemplo: 912345678" />
      </div>
    </div>

    <div class="form-group">
      <label for="direccion" class="col-sm-2 control-label">Direccion</label>
      <div class="col-sm-10">
        <input type="text" id="direccion" name="direccion" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre_padre" class="col-sm-2 control-label">Nombre del Padre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre_padre" name="nombre_padre" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre_madre" class="col-sm-2 control-label">Nombre de la Madre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre_madre" name="nombre_madre" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="id_escolaridad" class="col-sm-2 control-label">Escolaridad</label>
      <div class="col-sm-4">
        <select id="id_escolaridad" name="id_escolaridad" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($escolaridades){ ?>
           <?php foreach($escolaridades as $escolaridad){ ?>
              <option value="<?php echo $escolaridad->id_escolaridad; ?>"><?php echo $escolaridad->esc_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="ocupacion_actual" class="col-sm-2 control-label">Ocupacion Actual</label>
      <div class="col-sm-10">
        <input type="text" id="ocupacion_actual" name="ocupacion_actual" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="id_escolaridad" class="col-sm-2 control-label">Sexo</label>
      <div class="col-sm-4">
        <select id="sexo" name="sexo" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($sexos){ ?>
           <?php foreach($sexos as $sexo){ ?>
              <option value="<?php echo $sexo->id_sexo; ?>"><?php echo $sexo->sexo_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="correo" class="col-sm-2 control-label">Correo Electronico</label>
      <div class="col-sm-10">
        <input type="text" id="correo" name="correo" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="etnia" class="col-sm-2 control-label">Etnia</label>
      <div class="col-sm-4">
        <select id="etnia" name="etnia" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($etnias){ ?>
           <?php foreach($etnias as $etnia){ ?>
              <option value="<?php echo $etnia->id_etnia; ?>"><?php echo $etnia->etnia_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="hc" class="col-sm-2 control-label">Historia Clinica</label>
      <div class="col-sm-10">
        <input type="text" id="hc" name="hc" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="paises" class="col-sm-2 control-label">Pais</label>
      <div class="col-sm-4">
        <select id="paises" name="paises" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($paises){ ?>
           <?php foreach($paises as $pais){ ?>
              <option value="<?php echo $pais->id_pais; ?>"><?php echo $pais->pais_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="comunas" class="col-sm-2 control-label">Comuna</label>
      <div class="col-sm-4">
        <select id="comunas" name="comunas" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($comunas){ ?>
           <?php foreach($comunas as $comuna){ ?>
              <option value="<?php echo $comuna->id_comuna; ?>"><?php echo $comuna->comuna_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="regiones" class="col-sm-2 control-label">Region</label>
      <div class="col-sm-4">
        <select id="regiones" name="regiones" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($regiones){ ?>
           <?php foreach($regiones as $region){ ?>
              <option value="<?php echo $region->id_region; ?>"><?php echo $region->region_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="alergias" class="col-sm-2 control-label">Alergias</label>
      <div class="col-sm-10">
        <input type="text" id="alergias" name="alergias" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="enfermedades_cronicas" class="col-sm-2 control-label">Enfermedades Cronicas</label>
      <div class="col-sm-10">
        <input type="text" id="enfermedades_cronicas" name="enfermedades_cronicas" class="form-control" />
      </div>
    </div>

     <div class="form-group">
      <label for="farmacos" class="col-sm-2 control-label">Uso de Farmacos</label>
      <div class="col-sm-10">
        <input type="text" id="farmacos" name="farmacos" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="antecedentes_familiares" class="col-sm-2 control-label">Antecedentes Familiares</label>
      <div class="col-sm-10">
        <input type="text" id="antecedentes_familiares" name="antecedentes_familiares" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="fumador" class="col-sm-2 control-label">Fumador</label>
      <div class="col-sm-4">
        <select id="fumador" name="fumador" class="selectpicker" data-live-search="true">
           <option disabled>Seleccione</option>
           <option value="1" selected>Si</option>
           <option value="2">No</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="cant_cigarros" class="col-sm-2 control-label">Cantidad de cigarros</label>
      <div class="col-sm-10">
        <input type="text" id="cant_cigarros" name="cant_cigarros" class="form-control" />
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>