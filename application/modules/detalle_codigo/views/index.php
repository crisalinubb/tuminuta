<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Detalle Codigo</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>detalle_codigo/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
      </div>
    </div>
  </div>
</div>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:100px;">Detalle Codigo</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($datos){ ?>
      <?php foreach($datos as $detalle_codigo): ?>
        <tr>
          <td><?php echo $detalle_codigo->nombre; ?></td>
          <td class="editar">
            <a href="<?php echo base_url(); ?>detalle_codigo/editar/<?php echo $detalle_codigo->id_detallecodigo; ?>">
              <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
            </a>

            <a href="<?php echo base_url(); ?>detalle_codigo/eliminar/<?php echo $detalle_codigo->id_detallecodigo; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

             <a href="<?php echo base_url(); ?>detalle_codigo/ver_recetas/<?php echo $detalle_codigo->id_detallecodigo; ?>">
              <button title="Ver Recetas" type="button" class="btn btn-success btn-sm">Ver Recetas</button>
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

<!-- [PAGINACION] -->
<?php echo $pagination; ?>