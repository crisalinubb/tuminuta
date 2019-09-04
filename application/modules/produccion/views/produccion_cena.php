<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_cena">Produccion Cena</a></li>
  <li class="active">Informe Produccion Cena</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Produccion Cena</h1>
    <h2>Fecha: <?php echo $fecha; ?></h2>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<?php if($datos_solicitud_cena){ ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <?php foreach ($datos_solicitud_cena as $cenas) : ?>

  <?php $datos_planificacion = $this->objProduccion->consulta_planificacion_cena($this->session->userdata("usuario")->id_unidad, $cenas->total, $cenas->Regimen, $fecha_busqueda); ?>

  <?php $Regimen = $this->objRegimen->obtener(array('id_regimen' => $cenas->Regimen)); ?>
  <h2><?php echo $Regimen->nombre; ?></h2>
  
  <?php if($datos_planificacion){ ?>

  <?php foreach($datos_planificacion as $planificacion): ?>

    <h4><center><strong><?php echo $planificacion->nombre; ?></strong></center></h4>
    <p align="right">Volumen: <?php echo $planificacion->total; ?></p>
    <p align="right">Volumen Extra: <?php echo $planificacion->volumen_produccion; ?></p>
    <p align="right">Total: <?php echo $planificacion->volumen; ?></p>

  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:200px;">Insumo</th>
        <th scope="col" style="width:50px;">Total</th>
        <th scope="col" style="width:50px;">Um</th>
        
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $insumos = $this->objProduccion->obtener_insumos_cena($planificacion->id_receta, $planificacion->volumen); ?>
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
<?php } ?>
  <?php endforeach;?>

</div>

<?php } ?>

<script>
function myFunction() {
    window.print();
}
</script>