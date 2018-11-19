<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Ver Recetas</h1>
    <div class="col-md-3" style="margin-top:24px;">
    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
       <form class="form-inline" method="post" action='<?= base_url() ?>detalle_codigo/agregar_receta/<?php echo $codigo_detalle; ?>'>
          <div class="text-center new">
          <button type="submit" class="btn btn-primary col-md-12">Agregar</button>
      </div>
      </form>
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
        <th scope="col" style="width:100px;">Receta</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($datos){ ?>
      <?php foreach($datos as $detalle_codigo): ?>
        <tr>
          <?php $receta = $this->objRecetas->obtener(array("id_receta" => $detalle_codigo->id_receta)); ?>
          <td><?php echo $receta->nombre;?></td>
          <td class="editar">
            
            <a href="<?php echo base_url(); ?>detalle_codigo/eliminar_receta/<?php echo $detalle_codigo->id_recetacodigo; ?>" onclick="return confirm('Esta seguro que desea eliminar este registro?');"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>

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