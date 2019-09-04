<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Solicitudes Desayuno</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitudes Desayuno</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

<?php $total_des = 0; ?>

	<?php foreach ($desayunos as $recet) : ?>
  <?php $desayunos_array = $this->objIndex->solicitud_desayunos($recet->id_receta); ?>
		<?php if($desayunos_array){ ?>
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
			<?php foreach($desayunos_array as $des): ?>
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
    <?php $total_des = $total_des+$total; ?>
  </tfoot>
  </table>
</div>
  <?php } ?>
  <?php endforeach;?>

<div>
  <p><h3><strong>Cantidad de Solicitudes: <?php echo $total_des; ?></strong></h3></p>
</div>

<script>
function myFunction() {
    window.print();
}
</script>