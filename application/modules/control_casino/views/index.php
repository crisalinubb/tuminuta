<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Control Casino</li>
</ol>

<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Control Acceso</h1>
  </div>
</div>

<div>
    <div class="form-group">
      <h4>Tipo de Comida</h4>
      <div class="col-sm-2">
      <label class="radio-inline">
        <input type="radio" name="tipo_comida" id="tipo_comida" value="1">Almuerzo
      </label>
      <label class="radio-inline">
        <input type="radio" name="tipo_comida" id="tipo_comida" value="2">Desayuno-Almuerzo
      </label>
      <label class="radio-inline">
        <input type="radio" name="tipo_comida" id="tipo_comida" value="3">Almuerzo-Once
      </label>
    </div>
    </div>

<!-- <center><label><strong>N° Tarjeta</strong></label>--> <input type="hidden" id="codigo_tarjeta" name="codigo_tarjeta" autofocus></center> 

<br>

<center><label><strong>N° Tarjeta Manual</strong></label> <input type="text" id="codigo_tarjeta_manual" name="codigo_tarjeta_manual"></center>

<br>
<div><center>
      <button type="button" class="ingresar btn btn-primary btn-lg" id="ingresar">Ingresar</button>
      </center>
</div>
</div>

<script>
$( "#codigo_tarjeta" ).keyup(function() {
  $("#codigo_tarjeta").val($("#codigo_tarjeta").val());
  $("#tipo_comida").val($("input[name='tipo_comida']:checked").val());
        var request = $.ajax({
        url: "<?php echo base_url(); ?>control_casino/validar_funcionario",
        type: "POST",          
        dataType: "json",
        data: { codigo_tarjeta: $('#codigo_tarjeta').val(), tipo_comida: $("input[name='tipo_comida']:checked").val()},

        success: function(json){
                   if(json.result){
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'success',
                           timeout: 2000,
                           killer: true
                       });

                       document.getElementById("codigo_tarjeta").value = "";
                       document.getElementById("codigo_tarjeta_manual").value = "";
                       document.getElementById("codigo_tarjeta").focus();
                   }
                   else
                   {
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'error',
                           timeout: 2000,
                           killer: true
                       });

                       document.getElementById("codigo_tarjeta").value = "";
                       document.getElementById("codigo_tarjeta_manual").value = "";
                       document.getElementById("codigo_tarjeta").focus();
                   }
               }
        
});
        });

$(document).ready(function(){
  $("#ingresar").click(function(){
    $("#codigo_tarjeta").val($("#codigo_tarjeta_manual").val());
    $("#tipo_comida").val($("input[name='tipo_comida']:checked").val());
     var request = $.ajax({
        url: "<?php echo base_url(); ?>control_casino/validar_funcionario_manual",
        type: "POST",          
        dataType: "json",
        data: { codigo_tarjeta: $('#codigo_tarjeta').val(), tipo_comida: $("input[name='tipo_comida']:checked").val()},

        success: function(json){
                   if(json.result){
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'success',
                           timeout: 2000,
                           killer: true
                       });

                       document.getElementById("codigo_tarjeta").value = "";
                       document.getElementById("codigo_tarjeta_manual").value = "";
                       document.getElementById("codigo_tarjeta").focus();
                   }
                   else
                   {
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'error',
                           timeout: 2000,
                           killer: true
                       });

                       document.getElementById("codigo_tarjeta").value = "";
                       document.getElementById("codigo_tarjeta_manual").value = "";
                       document.getElementById("codigo_tarjeta").focus();
                   }
               }
        
});

  });
});
</script>