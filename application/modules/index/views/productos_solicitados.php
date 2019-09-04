<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>index/vistaInformeProducto">Productos Solicitados</a></li>
  <li class="active">Resumen Solicitudes</li>
</ol>

<div id="tabla_principal">

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7" align="right">Resumen Productos Solicitados</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Imprimir" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

  <h3><strong><center><?php echo $fecha_desde.' - '.$fecha_hasta; ?></center></strong></h3>
  <?php foreach ($productos as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->resumen_solicitudes($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>

    <h1 align="center">Desayunos</h1>
  <?php foreach ($productos_desayunos as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_desayuno($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>

<h1 align="center">Almuerzos</h1>

  <?php foreach ($productos_almuerzos as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_almuerzo($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>


<h1 align="center">Onces</h1>

  <?php foreach ($productos_onces as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_once($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>

<h1 align="center">Cenas</h1>

  <?php foreach ($productos_cenas as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_cena($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>


<h1 align="center">Colacion 10</h1>

  <?php foreach ($productos_col10 as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_col10($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>

<h1 align="center">Colacion 20</h1>

  <?php foreach ($productos_col20 as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_col20($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>

<h1 align="center">Formulas</h1>

  <?php foreach ($productos_formula as $prod) : ?>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <td colspan="2"><center><strong><?php echo $prod->nombre_producto ; ?></strong></center></td>
      </tr>
      <tr>
        <th scope="col" style="width:50px;">Servicio Clinico</th>
        <th scope="col" style="width:50px;">Total</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php $contador_por_servicio = 0; ?>
    <?php foreach ($servicios as $serv) : ?>
      <?php $productos_solicitados_resumen = $this->objIndex->productos_solicitudes_formulas($prod->id_producto, $serv->id_servicio, $fecha_desde, $fecha_hasta, $this->session->userdata("usuario")->id_unidad); ?>
      <?php if ($productos_solicitados_resumen): ?>
        
      <?php $contador_productos_servicios = 0; ?>
      <?php foreach($productos_solicitados_resumen as $psr): ?>
        <?php  $contador_productos_servicios = $contador_productos_servicios+$psr->Total;?>
      <?php endforeach;?>
        <tr>
          <?php $contador_por_servicio = $contador_por_servicio + $contador_productos_servicios;?>
          <td><?php echo $serv->nombre_servicio; ?></td>
          <td><?php echo $contador_productos_servicios; ?></td>
        </tr>
      <?php endif ?>
  <?php endforeach;?>
    </tbody>
     <tfoot>
    <tr>
      <td><strong>Total</strong></td>
      <td><?php echo $contador_por_servicio; ?></td>
    </tr>
  </tfoot>
  </table>
</div>
<br>
  <?php endforeach;?>
  <hr/>

</div>

<script>
function myFunction() {
  var divToPrint=document.getElementById("tabla_principal");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>
