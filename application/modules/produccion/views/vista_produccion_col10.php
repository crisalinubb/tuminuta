<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Produccion Col-10</li>
</ol>


<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Produccion Col-10</h1>
           
  </div>
</div>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
      <div class="form-group">
        <form class="form-inline" method="post" action='<?= base_url() ?>produccion/Produccion_col10'>
          <label for="fecha" class="col-sm-2 control-label"><strong>Fecha :</strong></label>
            <div class="col-sm-4">
              <div class="input-group date">
                <input id="fecha" type="text" class="form-control" name="fecha" value="<?php echo date("d/m/Y"); ?>"/>
              </div>
            </div>
                <button type="submit" class="btn btn-success">Continuar >></button>
        </form>
      </div> 
</div>

<script>

$("#fecha").datepicker();
</script>