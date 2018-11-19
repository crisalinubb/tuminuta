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

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <?php foreach ($datos_solicitud_desayunos as $desayunos) : ?>

  <?php $insumos = $this->objProduccion->obtener_insumos_desayuno($desayunos->total, $desayunos->id_receta); ?>

  <h4><center><strong><?php echo $desayunos->Producto; ?></strong></center></h4>
  <p align="right">Volumen: <?php echo $desayunos->total; ?></p>
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
          <td><?php echo $datos_insumos->Total; ?></td>
          <td><?php echo $datos_insumos->id_unidad_medida; ?></td>
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

<?php } ?>

<script>
function myFunction() {
    window.print();
}
</script>