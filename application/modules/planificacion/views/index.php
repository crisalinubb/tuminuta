<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Planificacion</h1>
  </div>
</div>
<form action="<?php echo base_url(); ?>planificacion/agregar" method="post" class="form-horizontal">
<?php if($codigos['fecha']){ ?>
  <h3><input type="text" id="fecha" name="fecha" value="<?php echo $codigos['fecha']; ?>" readOnly/></h3>
<?php  }else{?>
    <h3><input type="text" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" readOnly/></h3>
<?php } ?>


<div class="col-md-3" style="margin-top:24px;">

    <div style="overflow:hidden;" class="container">
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <div id="datetimepicker12"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="form-group">
      <label for="servicios_alimentacion" class="col-sm-3 control-label">Servicio de Alimentacion:</label>
      <div class="col-sm-3">
        <select id="servicios_alimentacion" name="servicios_alimentacion" class="form-control" data-live-search="true" required>
           <option value="" selected>Seleccione</option>
           <?php if($servicios_alimentacion){ ?>
           <?php foreach($servicios_alimentacion as $servicio_alimentacion){ ?>
              <option value="<?php echo $servicio_alimentacion->id_servicio_alimentacion; ?>"
                <?php if($codigos['servicio_codigo'] == $servicio_alimentacion->id_servicio_alimentacion) echo "selected"; ?>><?php echo $servicio_alimentacion->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

      <label for="regimenes" class="col-sm-3 control-label">Regimen:</label>
      <div class="col-sm-3">
        <select id="regimenes" name="regimenes" class="form-control validate[required]" data-live-search="true" required>
           <option value="" selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>" <?php if($codigos['regimen_codigo'] == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>


      <label for="destinos" class="col-sm-3 control-label">Destino:</label>
      <div class="col-sm-3">
        <select id="destinos" name="destinos" class="form-control validate[required]" data-live-search="true" required>
           <option value="" selected>Seleccione</option>
           <?php if($destinos){ ?>
           <?php foreach($destinos as $destino){ ?>
              <option value="<?php echo $destino->id_destino; ?>" <?php if($codigos['destino_codigo'] == $destino->id_destino) echo "selected"; ?>><?php echo $destino->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      
</div>

<div class="container">

    <label for="tipo" class="col-sm-3 control-label">Receta:</label>
      <div class="col-sm-5">
        <select id="recetas" name="recetas" class="js-example-responsive" style="width: 100%" required>
           <option value="">Seleccione</option>
           <?php if($resultado){ ?>
           <?php foreach($resultado as $recetas){ ?>
           <?php $recetas_datos = $this->objRecetas->obtener(array('id_receta' => $recetas->id_receta)); ?>
              <option value="<?php echo $recetas->id_receta; ?>"><?php echo $recetas_datos->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

      <label for="volumen" class="col-sm-2 control-label">Volumen:</label>
      <div class="col-sm-2">
        <input type="text" id="volumen" name="volumen" class="form-control validate[required]" required/>
      </div>
</div>

<div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Agregar</button>
</div>
</form>

<div class="text-box">
      <button type="button" id="buscar_datos" name="buscar_datos" class="btn btn-info btn-lg">Buscar ...</button>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Receta</th>
        <th scope="col" style="width:30px;">Volumen</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover" id= "tbody" name="tbody">
        <?php if($datos){ ?>
            <?php foreach($datos as $planificacion): ?>
                <tr>
                    <?php $recetas = $this->objRecetas->obtener(array('id_receta' => $planificacion->id_receta)); ?>
                    <td><?php echo $recetas->nombre;?></td>
                    <td><?php echo $planificacion->volumen_produccion;?></td>
                    <td class="editar">
                        <a href="<?php echo base_url(); ?>planificacion/editar/<?php echo $planificacion->id_planificacion; ?>">
                            <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                        </a>

                         <a href="<?php echo base_url(); ?>planificacion/eliminar/<?php echo $planificacion->id_planificacion; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php } else{ ?>
            <tr>
                <td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>
        <?php } ?>
    </tbody>
  </table>
</div>


<script type="text/javascript">
$(function () {
    $('#datetimepicker12').datepicker({
        inline: true,
        sideBySide: true,
        dateFormat: 'yy-m-d'
    });
});

$(document).ready(function() {                       
    $("#regimenes").change(function() {
        $("#regimenes option:selected").each(function() {
            idRegimen = $('#regimenes').val();
            idServicio = $('#servicios_alimentacion').val();
            $.post("<?php echo base_url(); ?>planificacion/buscar_recetas", {
                idRegimen : idRegimen,
                idServicio : idServicio
            }, function(data) {
                $("#recetas").html(data);
            });
        });
    });
});

$('#text').change(function(){
    $('#datetimepicker12').datepicker('setDate', $(this).val());
});
$('#datetimepicker12').change(function(){
    $('#fecha').attr('value',$(this).val());
});

$( "#buscar_datos" ).click(function() {
            idRegimen = $('#regimenes').val();
            idServicio = $('#servicios_alimentacion').val();
            idDestino = $('#destinos').val();
            fecha = $('#fecha').val();
            $.post("<?php echo base_url(); ?>planificacion/buscar_datos", {
                idRegimen : idRegimen,
                idServicio : idServicio,
                idDestino : idDestino,
                fecha : fecha
            }, function(data) {
                $("#tbody").html(data);
            });
});

$(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});

</script>
