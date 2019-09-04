<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Productos Solicitados</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Productos Solicitados</h1>
           
  </div>
</div>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
      <div class="form-group">
        <form class="form-inline" method="post" action='<?= base_url() ?>index/Informe_Producto'>
          <label for="fecha_desde" class="col-sm-2 control-label"><strong>Desde :</strong></label>
            <div class="col-sm-4">
              <div class="input-group date">
                <input id="fecha_desde" type="text" class="form-control" name="fecha_desde" value="<?php echo date("d/m/Y"); ?>"/>
              </div>
            </div>
            <label for="fecha_hasta" class="col-sm-2 control-label"><strong>Hasta :</strong></label>
            <div class="col-sm-4">
              <div class="input-group date">
                <input id="fecha_hasta" type="text" class="form-control" name="fecha_hasta" value="<?php echo date("d/m/Y"); ?>"/>
              </div>
            </div>
            <div align="center">
              <button type="submit" class="btn btn-success">Continuar >></button>
            </div>
                
        </form>
      </div> 
</div>

<script>

$("#fecha_desde").datepicker();
$("#fecha_hasta").datepicker();
</script>