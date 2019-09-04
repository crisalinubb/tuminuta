<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>index/vista_informe_almuerzo">Informe Almuerzo</a></li>
  <li class="active">Informe Solicitudes Almuerzo</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Solicitudes Almuerzo</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

  <h3><strong><center><?php echo $fecha; ?></center></strong></h3>
  <?php foreach ($bases as $bas) : ?>
  <?php $infor_alm = $this->objIndex->informe_almuerzo($fecha_busqueda ,$bas->base, $this->session->userdata("usuario")->id_unidad); ?>
    <?php if($infor_alm){ ?>
    <?php $base = $this->objRegimen->obtener(array('id_regimen' => $bas->base)); ?>
  <h4><strong><?php echo $base->nombre; ?></strong></h4>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Regimen</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $total = 0; ?>
      <?php foreach($infor_alm as $reg_alm): ?>
        <tr>
          <td><?php echo $reg_alm->nombre; ?></td>
          <td><?php echo $reg_alm->Total; ?></td>
          <?php $total= $total+ $reg_alm->Total; ?>
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