<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitudes Once</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

  <?php foreach ($onces as $onc) : ?>
  <?php $onces_array = $this->objIndex->solicitud_onces($onc->id_receta); ?>
    <?php if($onces_array){ ?>
  <h4><strong><?php echo $onc->receta_nombre; ?></strong></h4>
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
      <?php foreach($onces_array as $des): ?>
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