<div class="page-header">
  <h1>Solicitud</h1>
</div>
<form action="<?php echo base_url(); ?>index/enviar_solicitud" method="post" class="form-horizontal">
  <div>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut:</label>
      <div class="col-sm-4">
        <strong><?php echo number_format($paciente_general->rut, 0, ".", ".") . "-" . $paciente_general->dv;?></strong>
      </div>

      <label for="codigo_paciente" class="col-sm-2 control-label">Codigo del paciente:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_general->codigo_atencion;?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre Completo:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_general->nombre." ".$paciente_general->apellido_paterno." ".$paciente_general->apellido_materno;?></strong>
      </div>

     <label for="fecha1" class="col-sm-2 control-label">Fecha de Nacimiento:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_general->fecha_nacimiento; ?></strong>
      </div>
      </div>

    <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">Estatura:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->estatura; ?></strong>
      </div>

      <label for="peso" class="col-sm-2 control-label">Peso:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->peso; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="estatura" class="col-sm-2 control-label">IMC:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->imc; ?></strong>
      </div>

       <label for="ingreso" class="col-sm-2 control-label">Fecha de Ingreso:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->fecha_ingreso; ?></strong>
      </div>
    </div>

     <div class="form-group">
      <label for="diagnostico" class="col-sm-2 control-label">Diagnostico:</label>
      <div class="col-sm-4">
        <?php $diagnostico = $this->objDiagnostico->obtener(array('id_diagnostico' => $paciente_hospitalizado->diagnostico)); ?>
        <strong><?php echo $diagnostico->diagnostico_descripcion; ?></strong>
      </div>

      <label for="obs" class="col-sm-2 control-label">Observacion del Diagnostico:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->observacion_diagnostico; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="anamnesis" class="col-sm-2 control-label">Anamnesis:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->anamnesis; ?></strong>
      </div>
      
      <label for="tratamiento" class="col-sm-2 control-label">Tratamiento:</label>
      <div class="col-sm-4">
        <strong><?php echo $paciente_hospitalizado->tratamiento; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="servicio" class="col-sm-2 control-label">Servicio Clinico:</label>
      <div class="col-sm-4">
        <?php $servicio = $this->objServicioClinico->obtener(array('id_servicio' => $paciente_hospitalizado->codigo_servicio)); ?>
        <strong><?php echo $servicio->nombre_servicio; ?></strong>
      </div>
      
      <label for="sala" class="col-sm-2 control-label">Sala:</label>
      <div class="col-sm-4">
        <?php $sala = $this->objSalas->obtener(array('id_sala' => $paciente_hospitalizado->codigo_sala)); ?>
        <strong><?php echo $sala->NOMSALA; ?></strong>
      </div>
    </div>

    <div class="form-group">
      <label for="cama" class="col-sm-2 control-label">Cama:</label>
      <div class="col-sm-4">
        <?php $cama = $this->objCamas->obtener(array('id_cama' => $paciente_hospitalizado->codigo_cama)); ?>
        <strong><?php echo $cama->cama; ?></strong>
      </div>
    </div>
  </div>

   <input type="hidden" id="id_paciente_general" name="id_paciente_general" class="form-control validate[required]" value="<?php echo $paciente_general->id_paciente; ?>"/>

   <input type="hidden" id="codigo_servicio" name="codigo_servicio" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_servicio; ?>"/>

   <input type="hidden" id="codigo_sala" name="codigo_sala" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_sala; ?>"/>

   <input type="hidden" id="codigo_cama" name="codigo_cama" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->codigo_cama; ?>"/>

   <input type="hidden" id="diagnostico" name="diagnostico" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->diagnostico; ?>"/>

   <input type="hidden" id="id_paciente" name="id_paciente" class="form-control validate[required]" value="<?php echo $paciente_hospitalizado->id_paciente; ?>"/>

  <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:10px;"></th> 
        <th scope="col" style="width:10px;">Receta/Plato</th> 
        <th scope="col" style="width:10px;">Kcal</th>       
        <th scope="col" style="width:10px;">Prot</th> 
        <th scope="col" style="width:10px;">Lip</th>
        <th scope="col" style="width:10px;">Cho</th> 
      </tr>
    </thead>
    <tbody class="table-hover">
        <tr>
          <td><p><strong>Desayuno:</strong></p></td>
          <td>
            <select id="codigo_desayuno" name="codigo_desayuno" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($desayunos){ ?>
           <option value="0" selected>Sin Solicitar</option>
           <?php foreach($desayunos as $desayuno){ ?>
              <option value="<?php echo $desayuno->id_receta; ?>" <?php if($codigos['desayuno_codigo'] == $desayuno->id_receta) echo "selected"; ?>><?php echo $desayuno->receta_nombre; ?></option>

           <?php } ?>
           <?php } ?>
        </select>
          </td>
          <td><label id="desayuno_kcal"></label></td>
          <td><label id="desayuno_prot"></label></td>
          <td><label id="desayuno_lip"></label></td>
          <td><label id="desayuno_cho"></label></td>
        </tr>
         
        <tr>
          <td><p><strong>Almuerzo:</strong></p></td>
          <td>
            <select id="codigo_almuerzo" name="codigo_almuerzo" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <option value="0" selected>Sin Solicitar</option>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>" <?php if($codigos['almuerzo_codigo'] == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
          </td>
          <td><label id="alm_kcal"></label></td>
          <td><label id="alm_prot"></label></td>
          <td><label id="alm_lip"></label></td>
          <td><label id="alm_cho"></label></td>
        </tr>
     

        <tr>
          <td><p><strong>Once:</strong></p></td>
          <td>
            <select id="codigo_once" name="codigo_once" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($onces){ ?>
           <option value="0" selected>Sin Solicitar</option>
           <?php foreach($onces as $once){ ?>
              <option value="<?php echo $once->id_receta; ?>" <?php if($codigos['once_codigo'] == $once->id_receta) echo "selected"; ?>><?php echo $once->receta_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
          </td>
          <td><label id="once_kcal"></label></td>
          <td><label id="once_prot"></label></td>
          <td><label id="once_lip"></label></td>
          <td><label id="once_cho"></label></td>
        </tr>
      
        <tr>
          <td><p><strong>Cena:</strong></p></td>
         <td>
           <select id="codigo_cena" name="codigo_cena" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($regimenes){ ?>
           <option value="0" selected>Sin Solicitar</option>
           <?php foreach($regimenes as $regimen){ ?>
              <option value="<?php echo $regimen->id_regimen; ?>" <?php if($codigos['cena_codigo'] == $regimen->id_regimen) echo "selected"; ?>><?php echo $regimen->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
         </td>
          <td><label id="cena_kcal"></label></td>
          <td><label id="cena_prot"></label></td>
          <td><label id="cena_lip"></label></td>
          <td><label id="cena_cho"></label></td>
        </tr>

        <tr>
          <td><p><strong>Col_10:</strong></p></td>
          <td>
            <select id="codigo_col10" name="codigo_col10" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($colaciones){ ?>
           <option value="0" selected>Sin Solicitar</option>
           <?php foreach($colaciones as $col){ ?>
              <option value="<?php echo $col->id_receta; ?>" <?php if($codigos['col10_codigo'] == $col->id_receta) echo "selected"; ?>><?php echo $col->receta_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
          </td>
          <td><label id="col10_kcal"></label></td>
          <td><label id="col10_prot"></label></td>
          <td><label id="col10_lip"></label></td>
          <td><label id="col10_cho"></label></td>
        </tr>

        <tr>
          <td><p><strong>Col_20:</strong></p></td>
          <td>
            <select id="codigo_col20" name="codigo_col20" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($colaciones){ ?>
           <option value="0" selected>Sin Solicitar</option>
           <?php foreach($colaciones as $col){ ?>
              <option value="<?php echo $col->id_receta; ?>" <?php if($codigos['col20_codigo'] == $col->id_receta) echo "selected"; ?>><?php echo $col->receta_nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
          </td>
          <td><label id="col20_kcal"></label></td>
          <td><label id="col20_prot"></label></td>
          <td><label id="col20_lip"></label></td>
          <td><label id="col20_cho"></label></td>
        </tr>

    </tbody>
    <tfoot>
    <tr>
        <td><strong>Total:</strong></td>
        <td></td>
        <td><label id="total_kcal"></label></td>
        <td><label id="total_prot"></label></td>
        <td><label id="total_lip"></label></td>
        <td><label id="total_cho"></label></td>
    </tr>
  </tfoot>
  </table>

    <div class="text-box">
      <!--
      <input type="submit" name="boton2" class="btn btn-info btn-lg" value="Calculo Informacion Nutricional">-->
      <input type="submit" name="boton3" class="btn btn-warning btn-lg" value="Limpiar">
      <button type="button" class="btn btn-secondary btn-lg" data-toggle="collapse" data-target="#demo"> + Agregar Formula</button>
    </div>  

      <div id="demo" class="collapse">
      	<div >
     <div class="container">
      <div class="form-group">
      <label for="formula" class="col-sm-2 control-label">Formula</label>
      <div class="col-sm-4">
        <select id="formula" name="formula" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($formulas){ ?>
           <?php foreach($formulas as $formula){ ?>
              <option value="<?php echo $formula->id_receta; ?>" <?php if($codigos['formula_codigo'] == $formula->id_receta) echo "selected"; ?>><?php echo $formula->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>

    <br>
    <br>

    <div class="form-group">
      <label for="compl1" class="col-sm-2 control-label">Complemento</label>
      <div class="col-sm-3">
        <select id="compl1" name="compl1" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($complementos){ ?>
           <?php foreach($complementos as $complemento){ ?>
              <option value="<?php echo $complemento->id_receta; ?>" <?php if($codigos['c1_codigo'] == $complemento->id_receta) echo "selected"; ?>><?php echo $complemento->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

      <div class="col-sm-3">
        <select id="compl2" name="compl2" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($complementos){ ?>
           <?php foreach($complementos as $complemento){ ?>
              <option value="<?php echo $complemento->id_receta; ?>" <?php if($codigos['c2_codigo'] == $complemento->id_receta) echo "selected"; ?>><?php echo $complemento->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

      <div class="col-sm-3">
        <select id="compl3" name="compl3" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($complementos){ ?>
           <?php foreach($complementos as $complemento){ ?>
              <option value="<?php echo $complemento->id_receta; ?>" <?php if($codigos['c3_codigo'] == $complemento->id_receta) echo "selected"; ?>><?php echo $complemento->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>

    </div>

    <div class="form-group">
      <label for="volumen" class="col-sm-2 control-label">Volumen</label>
      <div class="col-sm-2">
        <input type="text" id="volumen" name="volumen" class="form-control validate[required]" value="<?php echo $codigos['volumen']; ?>" placeholder="medida en cc" />
      </div>
    
      <label for="frecuencia" class="col-sm-2 control-label">Frecuencia</label>
      <div class="col-sm-2">
        <input type="text" id="frecuencia" name="frecuencia" class="form-control validate[required]" value="<?php echo $codigos['frecuencia']; ?>" placeholder="veces al dia" />
      </div>
    </div>

    <div class="form-group">
      <label for="bajada" class="col-sm-2 control-label">Bajada</label>
      <div class="col-sm-2">
      <label class="radio-inline">
        <input type="radio" name="bajada" value="or">OR
      </label>
      <label class="radio-inline">
        <input type="radio" name="bajada" value="via">VIA
      </label>
      <label class="radio-inline">
        <input type="radio" name="bajada" value="nr">NR
      </label>
    </div>
    </div>

    <div class="form-group">
      <label for="frecuencia" class="col-sm-2 control-label">Horario</label>
      <div class="col-sm-2">
      <div class="checkbox">
        <label><input type="checkbox" name="check[]" value="1">9:00</label>
      </div>
      <div class="checkbox">
        <label><input type="checkbox" name="check[]" value="2">14:00</label>
      </div>
      <div class="checkbox disabled">
        <label><input type="checkbox" name="check[]" value="3">18:00</label>
      </div>
      <div class="checkbox disabled">
        <label><input type="checkbox"  name="check[]" value="4">22:00</label>
      </div>
      </div>
    </div>
    </div>
    </div>
  </div>
   
    <div class="text-box">
      <input type="submit" name="boton1" class="btn btn-success btn-lg" value="Enviar Solicitud">
    </div>
</form>

<script>

  $(document).ready(function() {                       
                $("#datos_menu").click(function() {
                    $("#menu_desayuno").each(function() {
                        $.post("<?php echo base_url(); ?>index/buscarMenu"
                            , function(data) {
                            $("#datos_menu").html(data);
                        });
                    });
                });
            });

function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('check')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

//cuando los select cambien
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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

       $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

       $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      });

       $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

  });

                 
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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

      $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      });

      $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

      $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      });

      $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

     $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      }); 

     $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

  });

});

$(document).ready(function() {                       
  $("#codigo_almuerzo").change(function() {

    $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_kcal").html(data);
        });
    });

     $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_prot").html(data);
        });
    });

    $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_lip").html(data);
        });
    });

   $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_cho").html(data);
        });
    });

    kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

     $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      }); 

     $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

  });

});

$(document).ready(function() {                       
  $("#codigo_cena").change(function() {

    $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_kcal").html(data);
        });
    });

     $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_prot").html(data);
        });
    });

    $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_lip").html(data);
        });
    });

   $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_cho").html(data);
        });
    });

    kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

     $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      }); 

     $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

  });
  });


//cuando carge la pagina
window.onload = function() {

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

       kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

       $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

       $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      });

       $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });


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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

      $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      });

      $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });


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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

      $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      });

      $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });


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

      kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
            kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

     $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      }); 

     $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

     $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_kcal").html(data);
        });
    });

     $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_prot").html(data);
        });
    });

    $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_lip").html(data);
        });
    });

   $("#codigo_almuerzo").each(function() {
      idAlmuerzo = $('#codigo_almuerzo').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho_alm", {
          idAlmuerzo : idAlmuerzo
        }, function(data) {
          $("#alm_cho").html(data);
        });
    });

    kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

     $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      }); 

     $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

     $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_kcal_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_kcal").html(data);
        });
    });

     $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_prot_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_prot").html(data);
        });
    });

    $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_lip_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_lip").html(data);
        });
    });

   $("#codigo_cena").each(function() {
      idCena = $('#codigo_cena').val();
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_cho_cena", {
          idCena : idCena
        }, function(data) {
          $("#cena_cho").html(data);
        });
    });

    kcalDesayuno = $('#codigo_desayuno').val();
      kcalOnce = $('#codigo_once').val();
      kcalCol10 = $('#codigo_col10').val();
      kcalCol20 = $('#codigo_col20').val();
      kcalAlmuerzo = $('#codigo_almuerzo').val();
      kcalCena = $('#codigo_cena').val();
      $("#total_kcal").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_kcal", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_kcal").html(data);
        });
      });

      $("#total_prot").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_prot", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_prot").html(data);
        });
      });

     $("#total_lip").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_lip", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_lip").html(data);
        });
      }); 

     $("#total_cho").each(function() {
        $.post("<?php echo base_url(); ?>index/Informacion_nutricional_Total_cho", {
             kcalDesayuno : kcalDesayuno,
            kcalOnce : kcalOnce,
            kcalCol10 : kcalCol10,
            kcalCol20 : kcalCol20,
            kcalAlmuerzo : kcalAlmuerzo,
            kcalCena : kcalCena
        }, function(data) {
          $("#total_cho").html(data);
        });
      });

  };

</script>
