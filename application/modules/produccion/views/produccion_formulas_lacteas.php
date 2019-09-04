<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>produccion/vista_produccion_formulaslacteas">Produccion Formula Lacteas</a></li>
  <li class="active">Informe Produccion Formula Lacteas</li>
</ol>

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

<?php $costo_total_lacteas = 0; ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <?php foreach ($datos_solicitud_lacteas as $formula_lactea) : ?>

  <?php  $nombre_formula = '';
         $formula = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_formula));
         $nombre_formula = $formula->nombre;

         $costo_receta_formula = $this->objInsumoreceta->costo_receta($formula_lactea->id_formula);
  ?>

  <?php if($formula_lactea->id_complemento1){ ?>
  <?php $comp1 = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_complemento1)); 
        $nombre_formula= $formula->nombre.' + '.$comp1->nombre;

        $costo_receta_comp1 = $this->objInsumoreceta->costo_receta($formula_lactea->id_complemento1);
        ?>
  <?php } ?>

  <?php if($formula_lactea->id_complemento2){ ?>
  <?php $comp2 = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_complemento2)); 
        $nombre_formula= $formula->nombre.' + '.$comp1->nombre.' + '.$comp2->nombre;

        $costo_receta_comp2 = $this->objInsumoreceta->costo_receta($formula_lactea->id_complemento2);
        ?>
  <?php } ?>

  <?php if($formula_lactea->id_complemento3){ ?>
  <?php $comp3 = $this->objRecetas->obtener(array("id_receta" => $formula_lactea->id_complemento3)); 
        $nombre_formula= $formula->nombre.' + '.$comp1->nombre.' + '.$comp2->nombre.' + '.$comp3->nombre;

        $costo_receta_comp3 = $this->objInsumoreceta->costo_receta($formula_lactea->id_complemento3);
        ?>
  <?php } ?>

    <?php $insumos = $this->objProduccion->obtener_insumos_formula_lactea($formula_lactea->Total, $formula_lactea->id_formula, $formula_lactea->id_complemento1, $formula_lactea->id_complemento2, $formula_lactea->id_complemento3); ?>

  <h4><center><strong><?php echo $nombre_formula; ?></strong></center></h4>
  <p align="right">Volumen: <?php echo $formula_lactea->Total; ?> cc</p>

  <?php $costo_total_receta = ($costo_receta_formula->SubTotal*($formula_lactea->Total/1000))+($costo_receta_comp1->SubTotal*($formula_lactea->Total/1000))+($costo_receta_comp2->SubTotal*($formula_lactea->Total/1000))+ ($costo_receta_comp3->SubTotal*($formula_lactea->Total/1000));

        $costo_total_lacteas = $costo_total_lacteas+$costo_total_receta;
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
   <p align="center"><strong>Costo Total Formulas Lacteas: $<?php echo number_format($costo_total_lacteas, 2, ',', '');?></strong></p>
</div>

<?php } ?>

<script>
function myFunction() {
    window.print();
}
</script>