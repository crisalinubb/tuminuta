<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitudes Cena</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<?php foreach ($regimenes as $reg) : ?>
  <?php $cenas_array = $this->objIndex->solicitud_cena($reg->id_regimen); ?>
    <?php if($cenas_array){ ?>
  <h4><strong><?php echo $reg->nombre; ?></strong></h4>
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
      <?php foreach($cenas_array as $alm): ?>
        <tr>
          <td><?php echo $alm->nombre_servicio; ?></td>
          <td><?php echo $alm->Total; ?></td>
          <?php $total= $total+ $alm->Total; ?>
        </tr>
      <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $total; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
  <?php } ?>
  <?php endforeach;?>

<script>
function myFunction() {
    window.print();
}
</script>