$(document).ready(function() {

   $(".estado_entrega").click(function(e){

       e.preventDefault();
       var codigo = $(this).attr('rel');

       noty({
       layout: 'topCenter',
       fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
         text: '¿Está seguro que desea cambiar no entregar a este funcionario?',
         buttons: [
           {addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty) {
               $noty.close();
               $(window).unbind('beforeunload');

               noty({
                   text: 'El estado se está siendo actualizado. Por favor, espere un momento.',
                   layout: 'topCenter',
                   type: 'alert',
                   killer:true,
                   closeWith: [],
                   template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                   fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
               });
               
               $.ajax({
                   type: "POST",
                   data: "codigo="+codigo,
                   dataType: "json",
                   url: "<?php echo base_url(); ?>control_casino/cambia_estado_entrega",
                   success: function(json){
                       if(json.result){
                           noty({
                               text: "El estado ha sido actualizado con éxito.",
                               layout: 'topCenter',
                               type: 'success',
                               killer: true
                           });
                           setTimeout(function() {
                                   window.location.href = window.location.pathname;
                           }, 1000);
                       }
                       else
                       {
                           var error = noty({
                               text: json.msg,
                               layout: 'topCenter',
                               type: 'error',
                               timeout: 2000
                           });
                       }
                   }
               });
             }
           },
           {addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty) {
               $noty.close();
             }
           }
         ]
       });

   });

});
