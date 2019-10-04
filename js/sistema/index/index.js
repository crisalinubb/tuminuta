$(document).ready(function() {
    //evento que se ejecuta cuando se hace click en el estado de la tabla desayuno
  $(".datos").click(function() {  
        //se envio el valor del estado
        var datos = $(this).attr('rel'); 
        
        var r = confirm("¿Esta seguro que quiere realizar cambios de asignación?");
        if (r == true) {
  
          var request = $.ajax({
          url: "<?php echo base_url(); ?>index/vincular_desvincular_servicio",
          type: "POST",          
          dataType: "json",
          data: { datos: datos},
          
          success: function(json){
                     if(json.result){
                         noty({
                             text: json.msg,
                             layout: 'topCenter',
                             type: 'success',
                             timeout: 2000,
                             killer: true
                         });
  
                      //    setTimeout(function() {
                      //     window.location.replace('<?php echo base_url();?>desayuno/');
                      //        }, 1000)
                      setTimeout(function() {
                          window.location.href = window.location.pathname;
                      }, 1000);
                      
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
  
                     }
          }
        });
        }
        
  
    });
  });