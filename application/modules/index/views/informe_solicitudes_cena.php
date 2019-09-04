<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>index/vista_informe_cena">Informe Cena</a></li>
  <li class="active">Informe Solicitudes Cena</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Informe Solicitudes Cena</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

  <h3><strong><center><?php echo $fecha; ?></center></strong></h3>
  <?php foreach ($bases as $bas) : ?>
  <?php $infor_cena = $this->objIndex->informe_cena($fecha_busqueda ,$bas->base, $this->session->userdata("usuario")->id_unidad); ?>
    <?php if($infor_cena){ ?>
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
      <?php foreach($infor_cena as $reg_cena): ?>
        <tr>
          <td><?php echo $reg_cena->nombre; ?></td>
          <td><?php echo $reg_cena->Total; ?></td>
          <?php $total= $total+ $reg_cena->Total; ?>
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