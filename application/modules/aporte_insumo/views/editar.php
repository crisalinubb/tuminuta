<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li><a href="<?php echo base_url(); ?>insumos/">Insumos</a></li>
  <li><a href="<?php echo base_url(); ?>aporte_insumo/index/<?php echo $aportes_insumos->id_insumo; ?>">Aportes por Insumos</a></li>
  <li class="active">Agregar Aporte a Insumo</li>
</ol>

<div class="page-header">
  <h1>Editar Aporte por Insumo</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>

     <div class="form-group">
      <div class="col-sm-10">
        <input type="hidden" id="codigo_insumo" name="codigo_insumo" class="form-control validate[required]" value="<?php echo $aportes_insumos->id_insumo; ?>" />
      </div>
    </div>

    <div class="form-group">
      <label for="codigo_aporte" class="col-sm-2 control-label">Aporte Nutricional</label>
      <div class="col-sm-4">
        <select id="codigo_aporte" name="codigo_aporte" class="selectpicker" data-live-search="true" required>
           <option disabled>Seleccione</option>
           <?php if($aportes_nutricionales){ ?>
           <?php foreach($aportes_nutricionales as $aporte_nutricional){ ?>
              <option value="<?php echo $aporte_nutricional->id_aporte_nutricional; ?>"  <?php if($aportes_insumos->id_aporte == $aporte_nutricional->id_aporte_nutricional) echo "selected"; ?>><?php echo $aporte_nutricional->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

     <div class="form-group">
      <label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
      <div class="col-sm-10">
        <input type="text" id="cantidad" name="cantidad" class="form-control validate[required]" value="<?php echo $aportes_insumos->cantidad; ?>" required/>
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $aportes_insumos->id_aporteinsumo; ?>" />
      </div>
    </div>

     <div class="form-group">
      <label for="cantidad_aporte" class="col-sm-2 control-label">Cantidad Aporte</label>
      <div class="col-sm-10">
        <input type="number" id="cantidad_aporte" name="cantidad_aporte" class="form-control validate[required]" value="<?php echo $aportes_insumos->cantidadAporte; ?>" required/>
      </div>
    </div>

    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg sbt">Guardar</button>
    </div>
  </fieldset>
</form>

<script>

$(document).ready(function() {
  $('#codigo_aporte option:not(:selected)').attr('disabled',true);
});

// $(document).ready(function() {
//   //evento que se ejecuta cuando se hace click en el activo de la tabla tarjeta
// $(".sbt").click(function() {  
//       //se envio el valor del activo


//         var request = $.ajax({
//         url: "<?php echo base_url(); ?>aporte_insumo/editar",
//         type: "POST",          
//         dataType: "json",
//         data: { codigo: $("#codigo").val(), codigo_insumo: $("#codigo_insumo").val(),codigo_aporte: $("#codigo_aporte").val(),cantidad: $("#cantidad").val(),cantidad_aporte: $("#cantidad_aporte").val()},
        
//         success: function(json){
//                    if(json.result){
//                        noty({
//                            text: json.msg,
//                            layout: 'topCenter',
//                            type: 'success',
//                            //timeout: 2000,
//                            killer: true
//                        });

//                       //  setTimeout(function() {
//                       //   window.location.replace('<?php echo base_url();?>aporte_insumo/index/'+$("#codigo_insumo").val())
//                       //      }, 1000);
//                       setTimeout(function(){
//                            window.location.href = window.location.pathname.replace("aporte_insumo/index/"+$("#codigo_insumo").val(), "");
//                        }, 1000);
//                    }
                    
  
//                    }
//                    else
//                    {
//                        noty({
//                            text: json.msg,
//                            layout: 'topCenter',
//                            type: 'error',
//                            timeout: 2000,
//                            killer: true
//                        });

//                    }
//         }
//       });

//         // request.done(function(data) {


//         //   window.location.replace('<?php echo base_url();?>tarjeta/');
                
//         // });

//         // request.fail(function(jqXHR, textStatus) {
//         //   alert( "Peticion Fallida: " + textStatus );
//         // }); 
      

//   });
// });
</script>