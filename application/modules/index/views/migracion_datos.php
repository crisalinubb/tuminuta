<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
</ol>

<?php if ($mesagge) { ?>
<div class="alert alert-success" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<a href="<?php echo base_url();?>index/Ejemplo_Migracion_Datos">Descargar Formato del Excel</a>
<br>
<br>
<div class="w3-container">  
<form action="<?php echo base_url();?>index/importar_datos" enctype="multipart/form-data" method="post">
  <h3><strong>Migracion de Datos</strong></h3>
  <br>
  <br>
   <input id="archivo" accept=".xls,.xlsx" name="archivo" type="file" /> 
   <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
   <br>
   <span class="input-group-btn">
    <button type="submit" class="btn btn-default"><i class="fa fa-file-excel-o"> Subir Archivo</i></button>
    </span>
</form>
</div>

<?php if ($arreglo) { ?>
<?php $i=0; ?>
 <div><h3 style="color: red";>ERROR!!!!, Datos incorrectos, por favor revisar los siguientes lineas del excel:</h3>
  <ul class="list-group"> 
  <?php while ( $i < sizeof($arreglo)) { ?> 
    <li class="list-group-item list-group-item-danger" role="alert" style="color: red;"><strong><?php echo $arreglo[$i]."\r\n";?></strong></li>
    <?php $i++;?>
  <?php } ?>
</ul>
<?php } ?>