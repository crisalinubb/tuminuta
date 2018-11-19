<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Produccion Formula Lacteas</h1>
    <h2>Fecha: <?php echo $fecha; ?></h2>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<?php if($datos_solicitud_lacteas){ ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <?php foreach ($datos_solicitud_lacteas as $formula_lactea) : ?>

  <?php  $nombre_formula = '';
         $formula = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_formula));
         $nombre_formula = $formula->nombre;
  ?>

  <?php if($formula_lactea->id_complemento1){ ?>
  <?php $comp1 = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_complemento1)); 
        $nombre_formula= $formula->nombre.' + '.$comp1->nombre;?>
  <?php } ?>

  <?php if($formula_lactea->id_complemento2){ ?>
  <?php $comp2 = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_complemento2)); 
        $nombre_formula= $formula->nombre.' + '.$comp1->nombre.' + '.$comp2->nombre;?>
  <?php } ?>

  <?php if($formula_lactea->id_complemento3){ ?>
  <?php $comp3 = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_complemento3)); 
        $nombre_formula= $formula->nombre.' + '.$comp1->nombre.' + '.$comp2->nombre.' + '.$comp3->nombre;?>
  <?php } ?>

    <?php $insumos = $this->objProduccion->obtener_insumos_formula_lactea($formula_lactea->Total, $formula_lactea->id_formula, $formula_lactea->id_complemento1, $formula_lactea->id_complemento2, $formula_lactea->id_complemento3); ?>

  <h4><center><strong><?php echo $nombre_formula; ?></strong></center></h4>
  <p align="right">Volumen: <?php echo $formula_lactea->Total; ?> cc</p>
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