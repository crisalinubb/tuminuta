<div class="page-header">
  <h1>Agregar Desayuno</h1>
</div>
<form action="<?php echo base_url(); ?>desayuno/buscar_recetas" method="post" class="form-horizontal">
  <fieldset>
    
    <div class="form-group">
      <label for="codigo_regimen" class="col-sm-2 control-label">Regimen</label>
      <div class="col-sm-4">
        <select id="codigo_regimen" name="codigo_regimen" class="selectpicker validate[required]" data-live-search="true">
           <option disabled>Seleccione</option>
           <?php if($regimenes){ ?>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>"  <?php if($regimen_select == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>
    
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Buscar</button>
    </div>
  </fieldset>
</form>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:100px;">Nombre de la Receta</th>
        <th scope="col" style="width:100px;">Tipo de receta</th>  
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($datos){ ?>
      <?php foreach($datos as $recetas): ?>
        <tr>
          <td><?php echo $recetas->nombre;?></td>
          <?php $tipo_receta = $this->objTiporeceta->obtener(array("id_tipo_receta" => $recetas->id_tipo_receta)); ?>
          <td><?php echo $tipo_receta->nombre;?></td>
          <td class="editar">

            <a href="<?php echo base_url(); ?>desayuno/agregar_receta/<?php echo $recetas->id_receta; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></button>
            </a>

          </td>
        </tr>
      <?php endforeach;?>
    <?php } else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
