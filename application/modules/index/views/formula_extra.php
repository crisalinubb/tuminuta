<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index/">Inicio</a></li>
</ol>

<?php if ($mesagge) { ?>
<div class="alert alert-danger" role="alert"><?php echo $mesagge; ?></div>
<?php } ?>

<div class="page-header">
  <h1>Formula Extra</h1>
</div>
<form action="<?php echo base_url(); ?>index/agregar_formula" method="post" class="form-horizontal">
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

      <div>
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
           <?php if($complementos){ ?>
           <option value="0" selected>Sin Solicitar</option>
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
        <input type="text" id="volumen" name="volumen" class="form-control validate[required]" value="<?php echo $codigos['volumen']; ?>" placeholder="medida en cc"/>
      </div>
    
      <label for="frecuencia" class="col-sm-2 control-label">Frecuencia</label>
      <div class="col-sm-2">
        <input type="text" id="frecuencia" name="frecuencia" class="form-control validate[required]" value="<?php echo $codigos['frecuencia']; ?>" placeholder="veces al dia"/>
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
        <tr>
              <td><strong>Aportes por KG:</strong></td>
              <td><label id="aporte_kg_kcal"></label></td>
              <td><label id="aporte_kg_prot"></label></td>
              <td><label id="aporte_kg_lip"></label></td>
              <td><label id="aporte_kg_cho"></label></td>
          </tr>
      </table>
    </div>
  </div>
  <br>
  <br>
  
    <div class="text-box">
      <button type="submit" name="boton1" class="btn btn-success btn-lg" value="Enviar Solicitud">Enviar Solicitud</button>
    </div>
</form>

<script>

function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('check')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

  $(document).ready(function() {
$("#formula, #compl1, #compl2, #compl3, #volumen, #frecuencia").change(function() {   
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
      
      //aporte por kg
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/aporte_kg",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: 0, id_once: 0, id_col10: 0, id_col20: 0, id_almuerzo: 0,id_cena: 0,formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val(), id_paciente: $('#id_paciente').val()},
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
});

//cuando carge la pagina
window.onload = function() {
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

      //aporte por kg
      var request = $.ajax({
      url: "<?php echo base_url(); ?>index/aporte_kg",
      type: "POST",          
      dataType: "json",
      data: { id_desayuno: 0, id_once: 0, id_col10: 0, id_col20: 0, id_almuerzo: 0,id_cena: 0,formula: $('#formula').val(), comp1: $('#compl1').val(), comp2: $('#compl2').val(), comp3: $('#compl3').val(), frecuencia: $('#frecuencia').val(),volumen: $('#volumen').val(), id_paciente: $('#id_paciente').val()},
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