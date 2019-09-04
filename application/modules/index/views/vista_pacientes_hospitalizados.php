<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Escoger Pacientes</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Escoger Pacientes</h1>

    <div class="col-md-3" style="margin-top:24px;">
        
      <div class="text-center new">
        <button type="button" class="btn btn-success col-md-12" data-toggle="modal" data-target="#exampleModal">Busqueda de Pacientes</button>
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
        <th scope="col" style="width:90px;">Rut</th>
        <th scope="col" style="width:100px;">Nombre</th>
        <th scope="col" style="width:100px;">Fecha de Nacimiento</th>
        <th scope="col" style="width:100px;">Telefono</th>
        <th scope="col" style="width:100px;">Fecha de Registro</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
    <?php if($datos){ ?>
      <?php foreach($datos as $pacientes): ?>
        <tr>
          <td><?php echo number_format($pacientes->rut, 0, ".", ".") . "-" . $pacientes->dv; ?></td>
          <td><?php echo $pacientes->nombre." ".$pacientes->apellido_paterno." ".$pacientes->apellido_materno;?></td>
          <td><?php echo date('d/m/Y',strtotime($pacientes->fecha_nacimiento));?></td>
          <td><?php echo $pacientes->telefono;?></td>
          <td><?php echo date('d/m/Y H:i:s',strtotime($pacientes->fecha_registro));?></td>
          <td class="editar">
            <?php if($pacientes->estado == 0){ ?>
            <a href="<?php echo base_url(); ?>index/agregar_hospitalizacion/<?php echo $pacientes->id_paciente; ?>/<?php echo $id_cama; ?>">
              <button title="Hospitalizar" type="button" class="btn btn-success btn-sm">Hospitalizar</button>
            </a>
            <?php } ?>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Busqueda de Pacientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url(); ?>index/busqueda_pacientes_sin_hospitalizar">

          <div class="form-group">
            <input type="hidden" id="id_cama" name="id_cama" class="form-control" value="<?php echo $id_cama; ?>" />
          </div>

          <div class="form-group">
            <label for="rut">Rut</label>
            <input type="number" class="form-control" id="rut" name="rut" placeholder="sin puntos, ni guion, ni dv.">
          </div>

          <div class="form-group">
            <label for="codpac">Codigo Paciente</label>
            <input type="text" class="form-control" id="codpac" name="codpac">
          </div>
          
          <div class="form-group">
            <label for="nombre_pac">Nombre Paciente</label>
            <input type="text" class="form-control" id="nombre_pac" name="nombre_pac">
          </div>

          <div class="form-group">
            <label for="apellido_pat">Apellido Paterno Paciente</label>
            <input type="text" class="form-control" id="apellido_pat" name="apellido_pat">
          </div>

          <div class="form-group">
            <label for="apellido_mat">Apellido Materno Paciente</label>
            <input type="text" class="form-control" id="apellido_mat" name="apellido_mat">
          </div>

          <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>
