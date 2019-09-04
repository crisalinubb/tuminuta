<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_desayuno">Produccion Desayuno</a></li>
  <li class="active">Informe Produccion Desayuno</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Produccion Desayuno</h1>
    <h2>Fecha: <?php echo $fecha; ?></h2>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<?php if($datos_solicitud_desayunos){ ?>

<?php $costo_total_desayunos = 0; ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <?php foreach ($datos_solicitud_desayunos as $desayunos) : ?>

  <?php $insumos = $this->objProduccion->obtener_insumos_desayuno($desayunos->total, $desayunos->id_receta); ?>

  <?php $costo_receta = $this->objInsumoreceta->costo_receta($desayunos->id_receta); ?>

  <h4><center><strong><?php echo $desayunos->Producto; ?></strong></center></h4>

  <p align="right">Volumen: <?php echo $desayunos->total; ?></p>
  <?php $costo_total_receta = $costo_receta->SubTotal*$desayunos->total;
        $costo_total_desayunos = $costo_total_desayunos+$costo_total_receta;
  ?>
  <p align="right">Valor Total Receta: $<?php echo number_format($costo_total_receta, 2, ',', '');?></p>

  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Insumo</th>
        <th scope="col" style="width:50px;">Total</th>
        <th scope="col" style="width:50px;">Um</th>
        
      </tr>
    </thead>
    <tbody class="table-hover">
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
        <td colspan="4" style="text-align:center;"><i>No se registra Insumos</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>

  <?php endforeach;?>

</div>

<div>
   <p align="center"><strong>Costo Total Desayunos: $<?php echo number_format($costo_total_desayunos, 2, ',', '');?></strong></p>
</div>

<?php } ?>

<script>
function myFunction() {
    window.print();
}
</script>