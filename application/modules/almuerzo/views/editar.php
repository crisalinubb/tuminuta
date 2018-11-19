<div class="page-header">
  <h1>Editar Desayuno</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div title="Click para Cerrar" id="carga" style="cursor:pointer;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;box-shadow:inset # 696763 0px 0px 14px;background-position:center;background-size:100%;background-color:# fff;width:300px;color:# fff;text-align:center;height:170px;padding:52px 12px 12px 12px;position:fixed;top:30%;left:40%;z-index:6;">
          <h2>Cargando por favor espere...</h2>
          </div>
    <div class="form-group">
      <div class="col-sm-10">
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $almuerzos->id_almuerzo; ?>" />
      </div>
    </div>

      <div class="form-group">
      <label for="codigo_receta" class="col-sm-2 control-label">Receta</label>
      <div class="col-sm-4">
        <select id="codigo_receta" name="codigo_receta" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($recetas){ ?>
           <?php foreach($recetas as $receta){ ?>
              <option value="<?php echo $receta->id_receta; ?>"  <?php if($almuerzos->receta == $receta->id_receta) echo "selected"; ?>><?php echo $receta->nombre; ?></option>
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
<script type="text/javascript">
function cargando() {
    $("#carga").animate({ "opacity": "1" }, 1000, function () { $("#carga").css("display", "Block"); });

}

function cerrar() {
    $("#carga").animate({ "opacity": "0" }, 1000, function () { $("#carga").css("display", "none"); });
}

$(document).ready(function () {
    window.onload = cerrar;
    $("#carga").click(function () { cerrar(); });
    window.onbeforeunload = cargando;
});       
</script>