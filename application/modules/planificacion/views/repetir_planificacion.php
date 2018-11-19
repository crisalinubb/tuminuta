<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Repetir Planificacion</h1>
  </div>
</div>
<form action="<?php echo base_url(); ?>planificacion/agregar_repeticion_planificacion" method="post" class="form-horizontal">
<div class="container-fluid">
  <div class="row">
    
    <div class="col-sm-3">
      <?php if($codigos['fecha']){ ?>
          <h3><input type="text" id="fecha" name="fecha" value="<?php echo $codigos['fecha']; ?>" readOnly/></h3>
      <?php  }else{?>
          <h3><input type="text" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" readOnly/></h3>
      <?php } ?>
      <div id="datetimepicker12"></div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">

      <label for="servicios_alimentacion" class="col-sm-3 control-label">Servicio de Alimentacion:</label>
      <div class="col-sm-6">
        <select id="servicios_alimentacion" name="servicios_alimentacion" class="form-control"
         data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($servicios_alimentacion){ ?>
           <?php foreach($servicios_alimentacion as $servicio_alimentacion){ ?>
              <option value="<?php echo $servicio_alimentacion->id_servicio_alimentacion; ?>"
                <?php if($codigos['servicio_codigo'] == $servicio_alimentacion->id_servicio_alimentacion) echo "selected"; ?>><?php echo $servicio_alimentacion->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
      </div>

      <div class="form-group">
      <label for="destinos" class="col-sm-3 control-label">Destino:</label>
      <div class="col-sm-6">
        <select id="destinos" name="destinos" class="form-control validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($destinos){ ?>
           <?php foreach($destinos as $destino){ ?>
              <option value="<?php echo $destino->id_destino; ?>" <?php if($codigos['destino_codigo'] == $destino->id_destino) echo "selected"; ?>><?php echo $destino->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

      </div>
    </div>

    <div class="col-sm-3">
      <?php if($codigos['fecha1']){ ?>
          <h3><input type="text" id="fecha" name="fecha" value="<?php echo $codigos['fecha1']; ?>" readOnly/></h3>
      <?php  }else{?>
          <h3><input type="text" id="fecha1" name="fecha1" value="<?php echo date("Y-m-d"); ?>" readOnly/></h3>
      <?php } ?>
        <div id="datetimepicker11"></div>
    </div>

  </div>
</div>

<div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Copiar</button>
</div>
</form>

<div class="text-box">
      <button type="button" id="buscar_datos" name="buscar_datos" class="btn btn-info btn-lg">Buscar ...</button>
</div>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:75px;">Receta</th>
        <th scope="col" style="width:30px;">Volumen</th>
    </thead>
    <tbody class="table-hover" id= "tbody" name="tbody">
        
      <?php if($datos){ ?>
            <?php foreach($datos as $planificacion): ?>
                <tr>
                    <?php $recetas = $this->objRecetas->obtener(array('id_receta' => $planificacion->id_receta)); ?>
                    <td><?php echo $recetas->nombre;?></td>
                    <td><?php echo $planificacion->volumen_produccion;?></td>
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

$('#text').change(function(){
    $('#datetimepicker12').datepicker('setDate', $(this).val());
});
$('#datetimepicker12').change(function(){
    $('#fecha').attr('value',$(this).val());
});

$(function () {
    $('#datetimepicker11').datepicker({
        inline: true,
        sideBySide: true,
        dateFormat: 'yy-m-d'
    });
});

$('#text').change(function(){
    $('#datetimepicker11').datepicker('setDate', $(this).val());
});
$('#datetimepicker11').change(function(){
    $('#fecha1').attr('value',$(this).val());
});

$( "#buscar_datos" ).click(function() {
            idServicio = $('#servicios_alimentacion').val();
            idDestino = $('#destinos').val();
            fecha = $('#fecha').val();
            $.post("<?php echo base_url(); ?>planificacion/buscar_datos_repetir_plan", {
                idServicio : idServicio,
                idDestino : idDestino,
                fecha : fecha
            }, function(data) {
                $("#tbody").html(data);
            });
});

</script>
