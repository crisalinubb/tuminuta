<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table data-toggle="table" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" id="menu_table" border="1">
    <thead>
    <tr>
        <th class="centerText" data-field="item_id">ID</th>
        <th class="centerText" data-field="name">Name</th>
    </tr>
    </thead>
    <tbody >
      <td id="mybox1" class="mybox1"></td>
      <td id="mybox2" class="mybox2"></td>
    </tbody>
</table>
<button class="btn_datos" id="btn_datos">presionar</button>
</body>
</html>

<script type="text/javascript">	

$( "#btn_datos" ).click(function() {
    

    var request = $.ajax({
  url: "<?php echo base_url(); ?>sexo/prueba_td",
  type: "POST",          
  dataType: "json"
  });

  request.done(function(data) {

    $("#mybox1").html(data.msg1);           
    $("#mybox2").html(data.msg2);           
  });

  request.fail(function(jqXHR, textStatus) {
     alert( "Peticion Fallida: " + textStatus );
  });


});

</script>   