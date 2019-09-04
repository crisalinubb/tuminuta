<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Solicitudes Formulas Enterales</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitudes Formulas Enterales</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
  </div>
</div>

<div align="center">
    <button title="Asignar servicios" type="button" class="btn btn-danger btn-sm" onclick="myFunction()"> Imprimir</button>
</div>

  <?php foreach ($servicios_clinicos as $ser) : ?>
      <?php $enteral_array = $this->objIndex->solicitud_formula_enterales($ser->id_servicio); ?>
    <?php if($enteral_array){ ?>
  <h2><?php echo $ser->nombre_servicio; ?></h2>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Sala</th>
        <th scope="col" style="width:50px;">Cama</th>
        <th scope="col" style="width:80px;">Paciente</th>
        <th scope="col" style="width:50px;">Formula</th>
        <th scope="col" style="width:50px;">Comp1</th>
        <th scope="col" style="width:50px;">Comp2</th>
        <th scope="col" style="width:50px;">Comp3</th>
        <th scope="col" style="width:50px;">Vol.</th>
        <th scope="col" style="width:50px;">Frec.</th>
        <th scope="col" style="width:50px;">Obs</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <?php foreach($enteral_array as $formula_enteral): ?>
        <tr>
          <?php $sala = $this->objSalas->obtener(array('id_sala' => $formula_enteral->id_sala)); ?>
          <td><?php echo $sala->NOMSALA; ?></td>
          <?php $cama = $this->objCamas->obtener(array('id_cama' => $formula_enteral->id_cama)); ?>
          <td><?php echo $cama->cama; ?></td>
          <?php $paciente = $this->objPacGeneral->obtener(array('id_paciente' => $formula_enteral->id_paciente)); ?>
          <td><?php echo $paciente->nombre.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno; ?></td>
          <?php $formula = $this->objRecetas->obtener(array('id_receta' => $formula_enteral->id_formula)); ?>
          <td><?php echo $formula->nombre; ?></td>
          <?php $comp1 = $this->objRecetas->obtener(array('id_receta' => $formula_enteral->id_complemento1)); ?>
          <td><?php echo $comp1->nombre; ?></td>
          <?php $comp2 = $this->objRecetas->obtener(array('id_receta' => $formula_enteral->id_complemento2)); ?>
          <td><?php echo $comp2->nombre; ?></td>
          <?php $comp3 = $this->objRecetas->obtener(array('id_receta' => $formula_enteral->id_complemento3)); ?>
          <td><?php echo $comp3->nombre; ?></td>
          <td><?php echo $formula_enteral->volumen; ?></td>
          <td><?php echo $formula_enteral->frecuencia; ?></td>
          <td></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
    <?php }?>
  <?php endforeach;?>

<script>
function myFunction() {
    window.print();
}
</script>