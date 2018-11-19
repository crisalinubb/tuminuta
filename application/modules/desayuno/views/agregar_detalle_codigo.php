<div class="page-header">
  <h1>Agregar Detalle Codigo</h1>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:50px;">Detalle Codigo</th>  
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($datos){ ?>
      <?php foreach($datos as $detalle): ?>
        <tr>
          <td><?php echo $detalle->nombre;?></td>
          <td class="editar">

            <a href="<?php echo base_url(); ?>desayuno/agregar_detalle/<?php echo $detalle->id_detallecodigo; ?>">
              <button title="agregar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></button>
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
