<div class="page-header">
  <h1>Agregar Diagnostico</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>

    <div class="form-group">
      <label for="codigo_diagnostico" class="col-sm-2 control-label">Codigo Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="codigo_diagnostico" name="codigo_diagnostico" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Diagnostico</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
      </div>
    </div>

    <div class="form-group">
      <label for="observacion" class="col-sm-2 control-label">Observacion</label>
      <div class="col-sm-10">
        <input type="text" id="observacion" name="observacion" class="form-control" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>