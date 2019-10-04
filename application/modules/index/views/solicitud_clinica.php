<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
  <li class="active">Solicitud Clinica</li>
</ol>

<?php if ($mesagge) { ?>
<div class="alert alert-danger" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div class="page-header">
  <h1>Solicitud</h1>
</div>
<form action="<?php echo base_url(); ?>index/enviar_solicitud" method="post" class="form-horizontal">
<!-- <form id="form-agregar" name="form-agregar" method="post" class="form-horizontal"> -->
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
        <th scope="col" style="width:10px;"></th>
      </tr>
    </thead>
    <tbody class="table-hover">
        <tr>
          <td><p><strong>Desayuno:</strong></p></td>
          <td>
            <select id="codigo_desayuno" name="codigo_desayuno" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($desayunos){ ?>
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
          <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="Obtener_planificacion_desayuno()"><span class="glyphicon glyphicon-info-sign"></span></button></td>
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
          <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="Obtener_planificacion_alm()"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        </tr>
     

        <tr>
          <td><p><strong>Once:</strong></p></td>
          <td>
            <select id="codigo_once" name="codigo_once" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($onces){ ?>
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
          <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="Obtener_planificacion_once()"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        </tr>
      
        <tr>
          <td><p><strong>Cena:</strong></p></td>
         <td id="td_cena">
           <select id="codigo_cena" name="codigo_cena" class="form-control" data-dropup-auto="false" data-live-search="true">
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
          <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="Obtener_planificacion_cena()"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        </tr>

        <tr>
          <td><p><strong>Col_10:</strong></p></td>
          <td>
            <select id="codigo_col10" name="codigo_col10" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($colaciones){ ?>
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
          <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="Obtener_planificacion_col()"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        </tr>

        <tr>
          <td><p><strong>Col_20:</strong></p></td>
          <td>
            <select id="codigo_col20" name="codigo_col20" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <option value="0" selected>Sin Solicitar</option>
           <?php if($colaciones){ ?>
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
          <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="Obtener_planificacion_col()"><span class="glyphicon glyphicon-info-sign"></span></button></td>
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

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Menu Diario</h4>
        </div>
        <div class="modal-body">
          <div class="thumbnail table-responsive all-responsive" id="multiselectForm">
            <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
              <thead>
                <tr>
                  <th scope="col" style="width:40px;">Receta</th>
                  <th scope="col" style="width:30px;">Regimen</th>
                  <th scope="col" style="width:40px;">Insumos</th>
              </thead>
              <tbody class="table-hover" id= "tbody" name="tbody">
            
              </tbody>
            </table>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

    <div class="text-box">
      <!--
      <input type="submit" name="boton2" class="btn btn-info btn-lg" value="Calculo Informacion Nutricional">-->
      <input type="submit" name="boton3" class="btn btn-warning btn-lg" value="Limpiar">
      <!-- <button type="reset" class="btn btn-warning btn-lg" value="Limpiar">Limpiar</button> -->
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
           <option value="0" selected>Sin Solicitar</option>
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
           <option value="0" selected>Sin Solicitar</option>
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
           <option value="0" selected>Sin Solicitar</option>
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
           <option value="0" selected>Sin Solicitar</option>
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
        <input type="text" id="volumen" name="volumen" class="form-control validate[required]" value="<?php if($codigos['volumen']){echo $codigos['volumen'];}else{ echo 0;} ?>" placeholder="medida en cc" />
      </div>
    
      <label for="frecuencia" class="col-sm-2 control-label">Frecuencia</label>
      <div class="col-sm-2">
        <input type="text" id="frecuencia" name="frecuencia" class="form-control validate[required]" value="<?php if($codigos['frecuencia']){echo $codigos['frecuencia'];}else{ echo 0;} ?>" placeholder="veces al dia" />
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
    <div>
      <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
        <thead>
          <tr>
            <th scope="col" style="width:20px;"></th>
            <th scope="col" style="width:30px;">Kcal</th> 
            <th scope="col" style="width:30px;">Prot</th>
            <th scope="col" style="width:30px;">Lip</th>
            <th scope="col" style="width:30px;">Cho</th>
          </tr>
        </thead>
        <tbody class="table-hover">
          <tr>
              <td><strong>Total Formula:</strong></td>
              <td><label id="total_kcal_formula"></label></td>
              <td><label id="total_prot_formula"></label></td>
              <td><label id="total_lip_formula"></label></td>
              <td><label id="total_cho_formula"></label></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <br>
  <br>
  <div>
      <table border="1" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
        <thead>
          <tr>
            <th scope="col" style="width:20px;"></th>
            <th scope="col" style="width:30px;">Kcal</th> 
            <th scope="col" style="width:30px;">Prot</th>
            <th scope="col" style="width:30px;">Lip</th>
            <th scope="col" style="width:30px;">Cho</th>
          </tr>
        </thead>
        <tbody class="table-hover">
          <tr>
              <td><strong>Total:</strong></td>
              <td><label id="total_kcal_sum"></label></td>
              <td><label id="total_prot_sum"></label></td>
              <td><label id="total_lip_sum"></label></td>
              <td><label id="total_cho_sum"></label></td>
          </tr>
        </tbody>
        <tr>
              <td><strong>Aportes por KG:</strong></td>
              <td><label id="aporte_kg_kcal"></label></td>
              <td><label id="aporte_kg_prot"></label></td>
              <td><label id="aporte_kg_lip"></label></td>
              <td><label id="aporte_kg_cho"></label></td>
          </tr>
      </table>
    </div>
   
    <div class="text-box">
      <input type="submit" name="boton1" class="btn btn-success btn-lg" value="Enviar Solicitud">
    </div>
</form>

<script>

  $(document).ready(function() {
    //$('#codigo_almuerzo').change(function(){ // when one changes
      //console.log($('#codigo_cena').val());
      //$('#codigo_cena').val( $(this).val() ) // they all change
    //});
    $("#codigo_almuerzo").on("change", function() {
    $("#codigo_cena").val($("#codigo_almuerzo").val());
      //calculo del columna de cena(receta)
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/inf_nutri_recetas_almcena",
        type: "POST",          
        dataType: "json",
        data: { id_receta: $('#codigo_cena').val(), id_tipo_aporte: 4 },
        });

        request.done(function(data) {

          $("#cena_kcal").html(data.msg1);           
          $("#cena_prot").html(data.msg2);
          $("#cena_lip").html(data.msg3);
          $("#cena_cho").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        });
        
      //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
  })
  });
 
  function Obtener_planificacion_desayuno() {
    $("#tbody").each(function() {
        $.post("<?php echo base_url(); ?>index/obtener_planificacion_desayuno", {

        }, function(data) {
          $("#tbody").html(data);
        });
    });
  }

  function Obtener_planificacion_alm() {
    $("#tbody").each(function() {
        $.post("<?php echo base_url(); ?>index/obtener_planificacion_alm", {

        }, function(data) {
          $("#tbody").html(data);
        });
    });
  }

  function Obtener_planificacion_once() {
    $("#tbody").each(function() {
        $.post("<?php echo base_url(); ?>index/obtener_planificacion_once", {

        }, function(data) {
          $("#tbody").html(data);
        });
    });
  }

  function Obtener_planificacion_cena() {
    $("#tbody").each(function() {
        $.post("<?php echo base_url(); ?>index/obtener_planificacion_cena", {

        }, function(data) {
          $("#tbody").html(data);
        });
    });
  }

  function Obtener_planificacion_col() {
    $("#tbody").each(function() {
        $.post("<?php echo base_url(); ?>index/obtener_planificacion_col", {

        }, function(data) {
          $("#tbody").html(data);
        });
    });
  }

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
  //calculo de inf. nutricional desayuno
  $("#codigo_desayuno").change(function() {
    //calculo del columna de desayuno(receta)
    var request = $.ajax({
    url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
    type: "POST",          
    dataType: "json",
    data: { id_receta: $('#codigo_desayuno').val() },
    });

    request.done(function(data) {

      $("#desayuno_kcal").html(data.msg1);           
      $("#desayuno_prot").html(data.msg2);
      $("#desayuno_lip").html(data.msg3);
      $("#desayuno_cho").html(data.msg4);                 
    });

    request.fail(function(jqXHR, textStatus) {
       alert( "Peticion Fallida: " + textStatus );
    });

      //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
      
  });

  //calculo de inf. nutricional once               
  $("#codigo_once").change(function() {
      //calculo del columna de once(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_once').val() },
      });

      request.done(function(data) {

        $("#once_kcal").html(data.msg1);           
        $("#once_prot").html(data.msg2);
        $("#once_lip").html(data.msg3);
        $("#once_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

      //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

  });
});

$(document).ready(function() {                       
    //calculo de inf. nutricional colacion de las 10
  $("#codigo_col10").change(function() {
      //calculo del columna de colacion de las 10(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_col10').val() },
      });

      request.done(function(data) {

        $("#col10_kcal").html(data.msg1);           
        $("#col10_prot").html(data.msg2);
        $("#col10_lip").html(data.msg3);
        $("#col10_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
      
      //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
  });
});

$(document).ready(function() {      
//calculo de inf. nutricional colacion de las 20                 
  $("#codigo_col20").change(function() {
    //calculo del columna de colacion de las 20(receta)
    var request = $.ajax({
    url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
    type: "POST",          
    dataType: "json",
    data: { id_receta: $('#codigo_col20').val() },
    });

    request.done(function(data) {

      $("#col20_kcal").html(data.msg1);           
      $("#col20_prot").html(data.msg2);
      $("#col20_lip").html(data.msg3);
      $("#col20_cho").html(data.msg4);                 
    });

    request.fail(function(jqXHR, textStatus) {
       alert( "Peticion Fallida: " + textStatus );
    });

    //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

  });
});

$(document).ready(function() {                       
    //calculo de inf. nutricional almuerzo
  $("#codigo_almuerzo").change(function() {
      //calculo del columna de almuerzo(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas_almcena",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_almuerzo').val(), id_tipo_aporte: 2 },
      });

      request.done(function(data) {

        $("#alm_kcal").html(data.msg1);           
        $("#alm_prot").html(data.msg2);
        $("#alm_lip").html(data.msg3);
        $("#alm_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

      //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });  
  });

});

$(document).ready(function() {                       
    //calculo de inf. nutricional cena
  $("#codigo_cena").change(function() {
        //calculo del columna de cena(receta)
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/inf_nutri_recetas_almcena",
        type: "POST",          
        dataType: "json",
        data: { id_receta: $('#codigo_cena').val(), id_tipo_aporte: 4 },
        });

        request.done(function(data) {

          $("#cena_kcal").html(data.msg1);           
          $("#cena_prot").html(data.msg2);
          $("#cena_lip").html(data.msg3);
          $("#cena_cho").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        });
        
      //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
      });

      request.done(function(data) {

        $("#total_kcal").html(data.msg1);           
        $("#total_prot").html(data.msg2);
        $("#total_lip").html(data.msg3);
        $("#total_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
  });
  });

$(document).ready(function() {
  //calculo de inf. nutricional de las formulas
$("#formula, #compl1, #compl2, #compl3").change(function() {  

  //calculo del total de formulas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas_formula",
      type: "POST",          
      dataType: "json",
      data: { formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val()},
      });

      request.done(function(data) {

        $("#total_kcal_formula").html(data.msg1);           
        $("#total_prot_formula").html(data.msg2);
        $("#total_lip_formula").html(data.msg3);
        $("#total_cho_formula").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      }); 

  });
});

$(document).ready(function() {
//suma total de informacion nutricional (recetas+formulas)
$("#codigo_desayuno, #codigo_once, #codigo_col10, #codigo_col20, #codigo_almuerzo, #codigo_cena, #formula, #compl1, #compl2, #compl3").change(function() {   
  
  //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/suma_total_solicitud",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val(),formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val()},
      });

      request.done(function(data) {

        $("#total_kcal_sum").html(data.msg1);           
        $("#total_prot_sum").html(data.msg2);
        $("#total_lip_sum").html(data.msg3);
        $("#total_cho_sum").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });   

  //aporte por kg
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/aporte_kg",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val(),formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val(), id_paciente: $('#id_paciente').val()},
      });

      request.done(function(data) {

        $("#aporte_kg_kcal").html(data.msg1);           
        $("#aporte_kg_prot").html(data.msg2);
        $("#aporte_kg_lip").html(data.msg3);
        $("#aporte_kg_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
  });
  
  $(document).ready(function() {
$("#frecuencia, #volumen").change(function() {   
   //calculo del total de recetas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/suma_total_solicitud",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val(),formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val()},
      });

      request.done(function(data) {

        $("#total_kcal_sum").html(data.msg1);           
        $("#total_prot_sum").html(data.msg2);
        $("#total_lip_sum").html(data.msg3);
        $("#total_cho_sum").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });   

  //aporte por kg
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/aporte_kg",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val(),formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val(), id_paciente: $('#id_paciente').val()},
      });

      request.done(function(data) {

        $("#aporte_kg_kcal").html(data.msg1);           
        $("#aporte_kg_prot").html(data.msg2);
        $("#aporte_kg_lip").html(data.msg3);
        $("#aporte_kg_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });
  
      //calculo del total de formulas
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas_formula",
      type: "POST",          
      dataType: "json",
      data: { formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val()},
      });

      request.done(function(data) {

        $("#total_kcal_formula").html(data.msg1);           
        $("#total_prot_formula").html(data.msg2);
        $("#total_lip_formula").html(data.msg3);
        $("#total_cho_formula").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      }); 

  });
});

//se agregan los datos de la solicitud clinica
$(document).ready(function() {

});

});

//cuando carge la pagina
window.onload = function() {
    //calculo del columna de desayuno(receta)
    var request = $.ajax({
    url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
    type: "POST",          
    dataType: "json",
    data: { id_receta: $('#codigo_desayuno').val() },
    });

    request.done(function(data) {

      $("#desayuno_kcal").html(data.msg1);           
      $("#desayuno_prot").html(data.msg2);
      $("#desayuno_lip").html(data.msg3);
      $("#desayuno_cho").html(data.msg4);                 
    });

    request.fail(function(jqXHR, textStatus) {
       alert( "Peticion Fallida: " + textStatus );
    });

    //calculo del columna de once(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_once').val() },
      });

      request.done(function(data) {

        $("#once_kcal").html(data.msg1);           
        $("#once_prot").html(data.msg2);
        $("#once_lip").html(data.msg3);
        $("#once_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

     //calculo del columna de colacion de las 10(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_col10').val() },
      });

      request.done(function(data) {

        $("#col10_kcal").html(data.msg1);           
        $("#col10_prot").html(data.msg2);
        $("#col10_lip").html(data.msg3);
        $("#col10_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

      //calculo del columna de colacion de las 20(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_col20').val() },
      });

      request.done(function(data) {

        $("#col20_kcal").html(data.msg1);           
        $("#col20_prot").html(data.msg2);
        $("#col20_lip").html(data.msg3);
        $("#col20_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

       //calculo del columna de almuerzo(receta)
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/inf_nutri_recetas_almcena",
      type: "POST",          
      dataType: "json",
      data: { id_receta: $('#codigo_almuerzo').val(), id_tipo_aporte: 2 },
      });

      request.done(function(data) {

        $("#alm_kcal").html(data.msg1);           
        $("#alm_prot").html(data.msg2);
        $("#alm_lip").html(data.msg3);
        $("#alm_cho").html(data.msg4);                 
      });

      request.fail(function(jqXHR, textStatus) {
         alert( "Peticion Fallida: " + textStatus );
      });

      //calculo del columna de cena(receta)
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/inf_nutri_recetas_almcena",
        type: "POST",          
        dataType: "json",
        data: { id_receta: $('#codigo_cena').val(), id_tipo_aporte: 4 },
        });

        request.done(function(data) {

          $("#cena_kcal").html(data.msg1);           
          $("#cena_prot").html(data.msg2);
          $("#cena_lip").html(data.msg3);
          $("#cena_cho").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        });

        //calculo del total de formulas
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/inf_nutri_recetas_formula",
        type: "POST",          
        dataType: "json",
        data: { formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val()},
        });

        request.done(function(data) {

          $("#total_kcal_formula").html(data.msg1);           
          $("#total_prot_formula").html(data.msg2);
          $("#total_lip_formula").html(data.msg3);
          $("#total_cho_formula").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        });

        //calculo del total de recetas
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/calculo_inf_nutri_recetas",
        type: "POST",          
        dataType: "json",
        data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val()},
        });

        request.done(function(data) {

          $("#total_kcal").html(data.msg1);           
          $("#total_prot").html(data.msg2);
          $("#total_lip").html(data.msg3);
          $("#total_cho").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        }); 

        //calculo del total de recetas
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/suma_total_solicitud",
        type: "POST",          
        dataType: "json",
        data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val(),formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val()},
        });

        request.done(function(data) {

          $("#total_kcal_sum").html(data.msg1);           
          $("#total_prot_sum").html(data.msg2);
          $("#total_lip_sum").html(data.msg3);
          $("#total_cho_sum").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        }); 

        //aporte por kg
        var request = $.ajax({
        url: "<?php echo base_url(); ?>index/aporte_kg",
        type: "POST",          
        dataType: "json",
        data: { id_desayuno: $('#codigo_desayuno').val(), id_once: $('#codigo_once').val(), id_col10: $('#codigo_col10').val(), id_col20: $('#codigo_col20').val(), id_almuerzo: $('#codigo_almuerzo').val(),id_cena: $('#codigo_cena').val(),formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val(), id_paciente: $('#id_paciente').val()},
        });

        request.done(function(data) {

          $("#aporte_kg_kcal").html(data.msg1);           
          $("#aporte_kg_prot").html(data.msg2);
          $("#aporte_kg_lip").html(data.msg3);
          $("#aporte_kg_cho").html(data.msg4);                 
        });

        request.fail(function(jqXHR, textStatus) {
           alert( "Peticion Fallida: " + textStatus );
        });

  };

</script>

