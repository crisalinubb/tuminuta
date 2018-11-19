<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Planificacion</h1>
  </div>
</div>
<form action="<?php echo base_url(); ?>planificacion/Generar_Informe" method="post" class="form-horizontal">
<div class="container-fluid">
  <div class="row">
    
    <div class="col-sm-3">
      <h3><input type="text" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" readOnly/></h3>
      <div id="datetimepicker12"></div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">

      <label for="servicios_alimentacion" class="col-sm-3 control-label">Servicio de Alimentacion:</label>
      <div class="col-sm-6">
        <select id="servicios_alimentacion" name="servicios_alimentacion" class="form-control" required>
           <option value="" selected>Seleccione</option>
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
        <select id="destinos" name="destinos" class="form-control" required>
           <option value="" selected>Seleccione</option>
           <?php if($destinos){ ?>
           <?php foreach($destinos as $destino){ ?>
              <option value="<?php echo $destino->id_destino; ?>" <?php if($codigos['destino_codigo'] == $destino->id_destino) echo "selected"; ?>><?php echo $destino->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

      </div>
    </div>

  </div>
</div>

<div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Generar Informe</button>
      <button type="button" class="btn btn-primary btn-lg" onclick="myFunction()">Imprimir</button>
</div>
</form>

<?php if($regimenes){ ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <?php foreach ($regimenes as $regimen) : ?>

  <?php $recetas = $this->objPlanifica->obtener_receta_planificacion($codigos['fecha'], $codigos['destino'], $codigos['servicios_alimentacion'], $regimen->id_regimen); ?>

  <?php if($recetas){ ?>

  <h2><?php echo $regimen->nombre; ?></h2>

  <?php foreach ($recetas as $datos_recetas) :?>
  <h4><center><strong><?php echo $datos_recetas->nombre; ?></strong></center></h4>
  <p align="right">Volumen: <?php echo $datos_recetas->volumen_produccion; ?></p>
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Insumo</th>
        <th scope="col" style="width:50px;">Total</th>
        <th scope="col" style="width:50px;">Um</th>
        
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $insumos = $this->objPlanifica->obtener_insumos_planificacion($datos_recetas->volumen_produccion, $datos_recetas->id_receta); ?>
    <?php if($insumos){ ?>
      <?php foreach($insumos as $datos_insumos): ?>
        <tr>
          <td><?php echo $datos_insumos->Insumo; ?></td>
          <td><?php echo $datos_insumos->Total; ?></td>
          <td><?php echo $datos_insumos->Um; ?></td>
        </tr>
      <?php endforeach;?>
    <?php } else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;"><i>No se registra Insumos</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
 <?php endforeach;?>
  <?php } ?>

  <?php endforeach;?>

</div>

<?php } ?>

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

function myFunction() {
    var divToPrint=document.getElementById("multiselectForm");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

</script>
