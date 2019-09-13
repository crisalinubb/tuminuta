<div class="page-header">
  <h1>Editar Tarjeta</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="codigo" class="col-sm-2 control-label">Numero Tarjeta</label>
      <div class="col-sm-10">
        <input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo $tarjetas->numero_tarjeta; ?>" readOnly/>
      </div>
    </div>

    <div class="form-group">
     <label for="fecha_desde" class="col-sm-2 control-label">Vigencia desde</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_desde" type="text" class="form-control" name="fecha_desde" value="<?php echo date('d/m/Y',strtotime($tarjetas->vigencia_desde));?> "/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
      </div>
      </div>

      <div class="form-group">
     <label for="fecha_hasta" class="col-sm-2 control-label">Vigencia hasta</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_hasta" type="text" class="form-control" name="fecha_hasta" value="<?php echo date('d/m/Y',strtotime($tarjetas->vigencia_hasta));?> "/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
      </div>
      </div>

    <div class="form-group">
      <label for="codigo_funcionario" class="col-sm-2 control-label">Funcionario</label>
      <div class="col-sm-4">
        <select id="codigo_funcionario" name="codigo_funcionario" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($funcionarios){ ?>
           <?php foreach($funcionarios as $fun){ ?>
            <option value="<?php echo $fun->id_funcionario; ?>" <?php if($tarjetas->fk_funcionario == $fun->id_funcionario) echo "selected"; ?>><?php echo $fun->nombre." ".$fun->apellido_pat." ".$fun->apellido_mat ; ?></option>
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
              <option value="<?php echo $t_t->id_tipotarjeta; ?>" <?php if($tarjetas->fk_tipotarjeta == $t_t->id_tipotarjeta) echo "selected"; ?>><?php echo $t_t->descripcion; ?></option>
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
              <option value="<?php echo $t_c->id_tipocomida; ?>" <?php if($tarjetas->fk_tipocomida == $t_c->id_tipocomida) echo "selected"; ?>><?php echo $t_c->nombre; ?></option>
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
