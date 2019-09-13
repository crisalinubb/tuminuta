<div class="page-header">
  <h1>Agregar Tarjeta</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="numero_tarjeta" class="col-sm-2 control-label">Numero Tarjeta</label>
      <div class="col-sm-10">
        <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control validate[required]"/>
      </div>
    </div>

    <div class="form-group">
     <label for="fecha_desde" class="col-sm-2 control-label">Vigencia desde</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_desde" type="text" class="form-control" name="fecha_desde" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
      </div>
      </div>

      <div class="form-group">
     <label for="fecha_hasta" class="col-sm-2 control-label">Vigencia hasta</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_hasta" type="text" class="form-control" name="fecha_hasta" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
      </div>
      </div>

    <div class="form-group">
      <label for="codigo_funcionario" class="col-sm-2 control-label">Funcionario</label>
      <div class="col-sm-4">
        <select id="codigo_funcionario" name="codigo_funcionario" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($funcionarios){ ?>
           <?php foreach($funcionarios as $fun){ ?>
              <option value="<?php echo $fun->id_funcionario; ?>" data-subtext="<?php echo $fun->rut; ?>"><?php echo $fun->nombre." ".$fun->apellido_pat." ".$fun->apellido_mat; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_tipotarjeta" class="col-sm-2 control-label">Tipo tarjeta</label>
      <div class="col-sm-4">
        <select id="codigo_tipotarjeta" name="codigo_tipotarjeta" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($tipos_tarjetas){ ?>
           <?php foreach($tipos_tarjetas as $t_t){ ?>
              <option value="<?php echo $t_t->id_tipotarjeta; ?>"><?php echo $t_t->descripcion; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_tipocomida" class="col-sm-2 control-label">Tipo Comida</label>
      <div class="col-sm-4">
        <select id="codigo_tipocomida" name="codigo_tipocomida" class="form-control validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($tipos_comidas){ ?>
           <?php foreach($tipos_comidas as $t_c){ ?>
              <option value="<?php echo $t_c->id_tipocomida; ?>"><?php echo $t_c->nombre; ?></option>
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
