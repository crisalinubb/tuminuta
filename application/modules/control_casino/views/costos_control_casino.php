<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>control_casino/vista_informe_control_casino">Fechas Inf. Prod. Alm.</a></li>
  <li class="active">Informe Produccion Almuerzo</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Costos Control Casino</h1>
    <h2>Fecha: <?php echo $fecha_busqueda; ?></h2>
  </div>
</div>

<div align="center">
    <button title="Imprimir" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<!-- Costos de Almuerzos -->
<h2><center>Almuerzos</center></h2>
<?php if($transacciones_almuerzo){ ?>

<?php if($planificacion_casino_alm){ ?>

  <?php foreach ($planificacion_cas_alm as $almuerzos) : ?>
<?php $costo_receta = $this->objInsumoreceta->costo_receta($almuerzos->id_receta); ?>

<?php $costo_total_receta = $costo_receta->SubTotal*$transacciones_almuerzo->Total;
      $costo_total = $costo_total+$costo_total_receta;
?>
<p align="right">Volumen: <?php echo $transacciones_almuerzo->Total; ?></p>

<p align="right">Valor Total Receta: $<?php echo number_format($costo_total_receta, 2, ',', '');?></p>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">

    <?php $receta = $this->objReceta->obtener(array('id_receta' => $almuerzos->id_receta));?>

    <h4><center><strong><?php echo $receta->nombre; ?></strong></center></h4>

  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Insumo</th>
        <th scope="col" style="width:50px;">Total</th>
        <th scope="col" style="width:50px;">Um</th>
        
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $insumos = $this->objProduccion->obtener_insumos_almuerzo($almuerzos->id_receta, $transacciones_almuerzo->Total); ?>
    <?php if($insumos){ ?>
      <?php foreach($insumos as $datos_insumos): ?>
        <tr>
          <td><?php echo $datos_insumos->nombre; ?></td>
          <?php if($datos_insumos->id_unidad_medida == 'GR' || $datos_insumos->id_unidad_medida == 'CC' ){ ?>
          <?php $cant_unidad_compra= 0;
                $cant_unidad_compra = $datos_insumos->Total / 1000;
           ?>
           <?php if($cant_unidad_compra > 1){ ?>
                <td><?php echo number_format($cant_unidad_compra, 2, ',', ''); ?></td>
                <td><?php echo $datos_insumos->unidad_compra; ?></td>
           <?php }else{ ?>
                <td><?php echo number_format($datos_insumos->Total, 2, ',', ''); ?></td>
                <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
           <?php } ?>
          <?php }else{ ?>
          <td><?php echo number_format($datos_insumos->Total, 2, ',', ''); ?></td>
          <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
          <?php } ?>
        </tr>
      <?php endforeach;?>
    <?php } else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;"><i>No se registran Insumos de esta receta</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php endforeach;?>
</div>

<?php }else{ ?>
<div class="alert alert-danger" role="alert"><?php echo 'No se registran planificacion de casino para ese dia'; ?></div>
<?php } ?>

<?php }else{ ?>
<div class="alert alert-danger" role="alert"><?php echo 'No se registran transacciones del dia seleccionado de almuerzos'; ?></div>
<?php } ?>
<!-- Fin Costos de Almuerzos -->

<!-- Costos de Desayuno-Almuerzo -->
<h2><center>Desayuno-Almuerzo</center></h2>
<?php if($transacciones_des_alm){ ?>

<?php if($planificacion_casino_des){ ?>


  <?php foreach ($planificacion_cas_des as $almuerzos) : ?>
<?php $costo_receta = $this->objInsumoreceta->costo_receta($almuerzos->id_receta); ?>

<?php $costo_total_receta = $costo_receta->SubTotal*$transacciones_des_alm->Total;
      $costo_total = $costo_total+$costo_total_receta;
?>
<p align="right">Volumen: <?php echo $transacciones_des_alm->Total; ?></p>

<p align="right">Valor Total Receta: $<?php echo number_format($costo_total_receta, 2, ',', '');?></p>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">

    <?php $receta = $this->objReceta->obtener(array('id_receta' => $planificacion_casino_des->id_receta));?>

    <h4><center><strong><?php echo $receta->nombre; ?></strong></center></h4>

  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Insumo</th>
        <th scope="col" style="width:50px;">Total</th>
        <th scope="col" style="width:50px;">Um</th>
        
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $insumos = $this->objProduccion->obtener_insumos_almuerzo($almuerzos->id_receta, $transacciones_des_alm->Total); ?>
    <?php if($insumos){ ?>
      <?php foreach($insumos as $datos_insumos): ?>
        <tr>
          <td><?php echo $datos_insumos->nombre; ?></td>
          <?php if($datos_insumos->id_unidad_medida == 'GR' || $datos_insumos->id_unidad_medida == 'CC' ){ ?>
          <?php $cant_unidad_compra= 0;
                $cant_unidad_compra = $datos_insumos->Total / 1000;
           ?>
           <?php if($cant_unidad_compra > 1){ ?>
                <td><?php echo number_format($cant_unidad_compra, 2, ',', ''); ?></td>
                <td><?php echo $datos_insumos->unidad_compra; ?></td>
           <?php }else{ ?>
                <td><?php echo number_format($datos_insumos->Total, 2, ',', ''); ?></td>
                <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
           <?php } ?>
          <?php }else{ ?>
          <td><?php echo number_format($datos_insumos->Total, 2, ',', ''); ?></td>
          <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
          <?php } ?>
        </tr>
      <?php endforeach;?>
    <?php } else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;"><i>No se registran Insumos de esta receta</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php endforeach;?>
</div>

<?php }else{ ?>
<div class="alert alert-danger" role="alert"><?php echo 'No se registran planificacion de casino para ese dia'; ?></div>
<?php } ?>

<?php }else{ ?>
<div class="alert alert-danger" role="alert"><?php echo 'No se registran transacciones del dia seleccionado de Desayuno'; ?></div>
<?php } ?>
<!-- Fin Costos de Desayuno-Almuerzo-->

<!-- Costos de Almuerzo-Once -->
<h2><center>Almuerzo-Once</center></h2>
<?php if($transacciones_alm_once){ ?>

<?php if($planificacion_casino_once){ ?>

  <?php foreach ($planificacion_cas_onc as $almuerzos) : ?>
<?php $costo_receta = $this->objInsumoreceta->costo_receta($almuerzos->id_receta); ?>

<?php $costo_total_receta = $costo_receta->SubTotal*$transacciones_alm_once->Total;
      $costo_total = $costo_total+$costo_total_receta;
?>
<p align="right">Volumen: <?php echo $transacciones_alm_once->Total; ?></p>

<p align="right">Valor Total Receta: $<?php echo number_format($costo_total_receta, 2, ',', '');?></p>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">

    <?php $receta = $this->objReceta->obtener(array('id_receta' => $almuerzos->id_receta));?>

    <h4><center><strong><?php echo $receta->nombre; ?></strong></center></h4>

  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Insumo</th>
        <th scope="col" style="width:50px;">Total</th>
        <th scope="col" style="width:50px;">Um</th>
        
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $insumos = $this->objProduccion->obtener_insumos_almuerzo($almuerzos->id_receta, $transacciones_alm_once->Total); ?>
    <?php if($insumos){ ?>
      <?php foreach($insumos as $datos_insumos): ?>
        <tr>
          <td><?php echo $datos_insumos->nombre; ?></td>
          <?php if($datos_insumos->id_unidad_medida == 'GR' || $datos_insumos->id_unidad_medida == 'CC' ){ ?>
          <?php $cant_unidad_compra= 0;
                $cant_unidad_compra = $datos_insumos->Total / 1000;
           ?>
           <?php if($cant_unidad_compra > 1){ ?>
                <td><?php echo number_format($cant_unidad_compra, 2, ',', ''); ?></td>
                <td><?php echo $datos_insumos->unidad_compra; ?></td>
           <?php }else{ ?>
                <td><?php echo number_format($datos_insumos->Total, 2, ',', ''); ?></td>
                <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
           <?php } ?>
          <?php }else{ ?>
          <td><?php echo number_format($datos_insumos->Total, 2, ',', ''); ?></td>
          <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
          <?php } ?>
        </tr>
      <?php endforeach;?>
    <?php } else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;"><i>No se registran Insumos de esta receta</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php endforeach;?>
</div>

<?php }else{ ?>
<div class="alert alert-danger" role="alert"><?php echo 'No se registran planificacion de casino para ese dia'; ?></div>
<?php } ?>

<?php }else{ ?>
<div class="alert alert-danger" role="alert"><?php echo 'No se registran transacciones del dia seleccionado de Once'; ?></div>
<?php } ?>
<!-- Fin Costos de Almuerzo-Once-->

<!-- Costo total control receta -->
<div>
   <p align="center"><strong>Costo Total: $<?php echo number_format($costo_total, 2, ',', '');?></strong></p>
</div>

<script>
function myFunction() {
    window.print();
}
</script>