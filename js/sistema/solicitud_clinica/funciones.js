
$(document).ready(function() {                       
  $("#codigo_desayuno").change(function() {

    $("#codigo_desayuno").each(function() {
      idDesayuno = $('#codigo_desayuno').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#desayuno_kcal").html(data);
        });
    });

    $("#codigo_desayuno").each(function() {
      idDesayuno = $('#codigo_desayuno').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#desayuno_prot").html(data);
        });
    });

    $("#codigo_desayuno").each(function() {
      idDesayuno = $('#codigo_desayuno').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#desayuno_lip").html(data);
        });
    });

    $("#codigo_desayuno").each(function() {
      idDesayuno = $('#codigo_desayuno').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#desayuno_cho").html(data);
        });
    });

    idDesayuno = $('#codigo_desayuno').val();
   idAlmuerzo = $('#codigo_almuerzo').val();
  idOnce = $('#codigo_once').val();
  idCena = $('#codigo_cena').val();
  idCol10 = $('#codigo_col10').val();
  idCol20 = $('#codigo_col20').val();
       
  $("#total_aportes").each(function() { 
    $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total", {
      idDesayuno : idDesayuno,
      idAlmuerzo : idAlmuerzo,
      idOnce : idOnce,
      idCena : idCena,
      idCol10 : idCol10,
      idCol20 : idCol20
    }, function(data) {
      $("#total_aportes").html(data);
    });
  });

  });
});

$(document).ready(function() {                       
  $("#codigo_once").change(function() {

    $("#codigo_once").each(function() {
      idDesayuno = $('#codigo_once').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#once_kcal").html(data);
        });
    });

    $("#codigo_once").each(function() {
      idDesayuno = $('#codigo_once').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#once_prot").html(data);
        });
    });

    $("#codigo_once").each(function() {
      idDesayuno = $('#codigo_once').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#once_lip").html(data);
        });
    });

    $("#codigo_once").each(function() {
      idDesayuno = $('#codigo_once').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#once_cho").html(data);
        });
    });

  });
});

$(document).ready(function() {                       
  $("#codigo_col10").change(function() {

    $("#codigo_col10").each(function() {
      idDesayuno = $('#codigo_col10').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col10_kcal").html(data);
        });
    });

    $("#codigo_col10").each(function() {
      idDesayuno = $('#codigo_col10').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col10_prot").html(data);
        });
    });

    $("#codigo_col10").each(function() {
      idDesayuno = $('#codigo_col10').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col10_lip").html(data);
        });
    });

    $("#codigo_col10").each(function() {
      idDesayuno = $('#codigo_col10').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col10_cho").html(data);
        });
    });

  });
});

$(document).ready(function() {                       
  $("#codigo_col20").change(function() {

    $("#codigo_col20").each(function() {
      idDesayuno = $('#codigo_col20').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col20_kcal").html(data);
        });
    });

    $("#codigo_col20").each(function() {
      idDesayuno = $('#codigo_col20').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col20_prot").html(data);
        });
    });

    $("#codigo_col20").each(function() {
      idDesayuno = $('#codigo_col20').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col20_lip").html(data);
        });
    });

    $("#codigo_col20").each(function() {
      idDesayuno = $('#codigo_col20').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho", {
          idDesayuno : idDesayuno
        }, function(data) {
          $("#col20_cho").html(data);
        });
    });

  });
});

$(document).ready(function() {                       
  idDesayuno = $('#codigo_desayuno').val();
  idAlmuerzo = $('#codigo_almuerzo').val();
  idOnce = $('#codigo_once').val();
  idCena = $('#codigo_cena').val();
  idCol10 = $('#codigo_col10').val();
  idCol20 = $('#codigo_col20').val();
       
  $("#total_aportes").each(function() { 
    $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total", {
      idDesayuno : idDesayuno,
      idAlmuerzo : idAlmuerzo,
      idOnce : idOnce,
      idCena : idCena,
      idCol10 : idCol10,
      idCol20 : idCol20
    }, function(data) {
      $("#total_aportes").html(data);
    });
  });
   
});
