<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Menu de Productos Solicitados</li>
</ol>

 <h1 class="col-md-7">Menu de Productos Solicitados</h1>
 <br>
<div class="page-header">
  <div class="row">
    <div>
    	<div class="jumbotron">
        <form action="<?php echo base_url(); ?>index/Informe_Producto" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Resumen Productos Solicitados</button>
  		  </form>
        <hr>
  		  <form action="<?php echo base_url(); ?>index/Informe_Desayunos" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Desayunos</button>
        </form>
        <hr>
        <form action="<?php echo base_url(); ?>index/Informe_Almuerzos" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Almuerzos</button>
        </form>
        <hr>
        <form action="<?php echo base_url(); ?>index/Informe_Once" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Onces</button>
        </form>
        <hr>
        <form action="<?php echo base_url(); ?>index/Informe_Cena" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Cenas</button>
        </form>
        <hr>
        <form action="<?php echo base_url(); ?>index/Informe_Col10" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Col-10</button>
        </form>
        <hr>
        <form action="<?php echo base_url(); ?>index/Informe_Col20" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Col-20</button>
        </form>
        <hr>
        <form action="<?php echo base_url(); ?>index/Informe_Formulas" method="post" target="_blank">
          <input type="hidden" id="fecha_desde" name="fecha_desde" class="form-control validate[required]" value="<?php echo $fecha_desde; ?>" />
          <input type="hidden" id="fecha_hasta" name="fecha_hasta" class="form-control validate[required]" value="<?php echo $fecha_hasta; ?>" />
          <button type="submit" class="btn btn-success">Productos Solicitados Formulas</button>
        </form>
        <hr>
		</div>
  </div>
</div>