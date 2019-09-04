<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Solicitudes Col-20</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitudes Col-20</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<?php $total_col20 = 0; ?>

<?php foreach ($colaciones as $recet) : ?>
  <?php $colaciones_array = $this->objIndex->solicitud_col20($recet->id_receta); ?>
    <?php if($colaciones_array){ ?>
  <h4><strong><?php echo $recet->receta_nombre; ?></strong></h4>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Cantidad</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $total = 0; ?>
      <?php foreach($colaciones_array as $des): ?>
        <tr>
          <td><?php echo $des->nombre_servicio; ?></td>
          <td><?php echo $des->Total; ?></td>
          <?php $total= $total+ $des->Total; ?>
        </tr>
      <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $total; ?></td>
    </tr>
    <?php $total_col20 = $total_col20+$total; ?>
  </tfoot>
  </table>
</div>
  <?php } ?>
  <?php endforeach;?>

<div>
  <p><h3><strong>Cantidad de Solicitudes: <?php echo $total_col20; ?></strong></h3></p>
</div>

<script>
function myFunction() {
    window.print();
}
</script>