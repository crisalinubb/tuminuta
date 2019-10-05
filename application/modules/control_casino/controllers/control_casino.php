<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Control_casino extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_funcionario", "objFuncionario");
		$this->load->model("modelo_solicitud_servicio", "objSolServ");
		$this->load->model("modelo_tarjeta", "objTarjeta");
		$this->load->model("modelo_tipo_comida", "objTipoComida");
		$this->load->model("modelo_tipo_contrato", "objTipoContrato");
		$this->load->model("modelo_tipo_tarjeta", "objTipoTarjeta");
		$this->load->model("modelo_transaccion_tarjeta", "objTransTarjeta");
		$this->load->model("servicio_clinico/modelo_servicioclinico", "objServicioClinico");
		#current
		//$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Control Casino');

		#Metas
		$this->layout->setMeta('title','Control Casino');
		$this->layout->setMeta('description','Control Casino');
		$this->layout->setMeta('keywords','Control Casino');

		$this->layout->view('index');
	}

	public function validar_funcionario(){
		$codigo_tarjeta = $this->input->post('codigo_tarjeta');
		$tipo_comida = $this->input->post('tipo_comida');

		//validadores por cada transaccion hecha de forma individual
		$validador_tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
		$validador_entrada = $this->objTransTarjeta->obtener_funcionario_dia_actual($codigo_tarjeta);
		$hora_actual = date('H:i');
		$dia_actual = date('Y-m-d');
		$horario_tipo_comida = $this->objTipoComida->obtener(array('id_tipocomida' => $tipo_comida));
		$validador_vigencia_tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
		$result= true;
		
		//validar si la tarjeta existe
		if (!$validador_tarjeta) {
			$msg = "tarjeta ingresada de forma incorrecta/ No se encuentra en el registro de tarjetas";
			$result= false;
		//validar si la tarjeta esta desactivada
		}elseif ($validador_tarjeta->activo == 1) {
			$msg = "La tarjeta esta desactivada";
			$result= false;
		//validar si la tarjeta tiene vigencia el dia de hoy
		}elseif (!($dia_actual >= $validador_vigencia_tarjeta->vigencia_desde && $dia_actual <= $validador_vigencia_tarjeta->vigencia_hasta)) {
			$msg = "La tarjeta actualmente no esta vigente";
			$result= false;
		//validar si ya ingreso en dia de hoy(dia actual)
		}elseif($validador_entrada === false){
			$msg = "Este funcionario ya registra una colación/comida el dia de hoy";
			$result= false;
			//validar horario del tipo de comida
		}elseif (!($hora_actual >= $horario_tipo_comida->horario_desde && $hora_actual <= $horario_tipo_comida->horario_hasta)) {
			$msg = "Opción de comida fuera de rangos de horarios";
			$result= false;
		}else {
			$datos = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));

			$funcionario = $this->objFuncionario->obtener(array('id_funcionario' => $datos->fk_funcionario));
			$servicio = $this->objServicioClinico->obtener(array('id_servicio' => $funcionario->fk_servicio));
			$tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
			$tipo_tarjeta = $this->objTipoTarjeta->obtener(array('id_tipotarjeta' => $tarjeta->fk_tipotarjeta));

			//Se ingresa los datos a la tabla transaccion y luego se muestra el msg con los datos
			$datos_transaccion = array('id_transaccion' => null, 
										'fk_tarjeta' => $codigo_tarjeta, 
										'fecha_registro' => date('Y-m-d H:i:s'),
										'fk_tipocomida' => $tipo_comida,  
										'fk_rutcontrol' => $this->session->userdata("usuario")->id_usuario,
										'estado' => 1, //1: activo 
										'tipo_transaccion' => 1 //1: transaccion individual(no por servicio)
								);

			$this->objTransTarjeta->insertar($datos_transaccion);

			$msg= "<strong>Usuario Autorizado</strong> <br>Funcionario: ".$funcionario->nombre." ".$funcionario->apellido_pat." ".$funcionario->apellido_mat."<br> Servicio: ".$servicio->nombre_servicio."<br> Tipo Tarjeta: ".$tipo_tarjeta->descripcion; 
			$result= true;

		}

		echo json_encode(array("result"=>$result,"msg"=>$msg));		
	}

	public function validar_funcionario_manual(){
		$codigo_tarjeta = $this->input->post('codigo_tarjeta');
		$tipo_comida = $this->input->post('tipo_comida');

		//validadores por cada transaccion hecha de forma individual
		$validador_tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
		$validador_entrada = $this->objTransTarjeta->obtener_funcionario_dia_actual($codigo_tarjeta);
		$hora_actual = date('H:i');
		$dia_actual = date('Y-m-d');
		$horario_tipo_comida = $this->objTipoComida->obtener(array('id_tipocomida' => $tipo_comida));
		$validador_vigencia_tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
		$result= true;
		
		//validar si la tarjeta existe
		if (!$validador_tarjeta) {
			$msg = "tarjeta ingresada de forma incorrecta/ No se encuentra en el registro de tarjetas";
			$result= false;
		//validar si la tarjeta esta desactivada
		}elseif ($validador_tarjeta->activo == 1) {
			$msg = "La tarjeta esta desactivada";
			$result= false;
		//validar si la tarjeta tiene vigencia el dia de hoy
		}elseif (!($dia_actual >= $validador_vigencia_tarjeta->vigencia_desde && $dia_actual <= $validador_vigencia_tarjeta->vigencia_hasta)) {
			$msg = "La tarjeta actualmente no esta vigente";
			$result= false;
		//validar si ya ingreso en dia de hoy(dia actual)
		}elseif($validador_entrada === false){
			$msg = "Este funcionario ya registra una colación/comida el dia de hoy";
			$result= false;
		//validar horario del tipo de comida
		}elseif (!($hora_actual >= $horario_tipo_comida->horario_desde && $hora_actual <= $horario_tipo_comida->horario_hasta)) {
			$msg = "Opción de comida fuera de rangos de horarios";
			$result= false;
		}else {
			$datos = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));

			$funcionario = $this->objFuncionario->obtener(array('id_funcionario' => $datos->fk_funcionario));
			$servicio = $this->objServicioClinico->obtener(array('id_servicio' => $funcionario->fk_servicio));
			$tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
			$tipo_tarjeta = $this->objTipoTarjeta->obtener(array('id_tipotarjeta' => $tarjeta->fk_tipotarjeta));

			//Se ingresa los datos a la tabla transaccion y luego se muestra el msg con los datos
			$datos_transaccion = array('id_transaccion' => null, 
										'fk_tarjeta' => $codigo_tarjeta, 
										'fecha_registro' => date('Y-m-d H:i:s'),
										'fk_tipocomida' => $tipo_comida,  
										'fk_rutcontrol' => $this->session->userdata("usuario")->id_usuario,
										'estado' => 1, //1: activo 
										'tipo_transaccion' => 1 //1: transaccion individual(no por servicio)
								);

			$this->objTransTarjeta->insertar($datos_transaccion);

			$msg= "<strong>Usuario Autorizado</strong> <br>Funcionario: ".$funcionario->nombre." ".$funcionario->apellido_pat." ".$funcionario->apellido_mat."<br> Servicio: ".$servicio->nombre_servicio."<br> Tipo Tarjeta: ".$tipo_tarjeta->descripcion; 
			$result= true;

		}

		echo json_encode(array("result"=>$result,"msg"=>$msg));		
	}

	public function solicitud_por_servicio(){
		#Title
		$this->layout->title('Solicitud por Servicio');

		#Metas
		$this->layout->setMeta('title','Solicitud por Servicio');
		$this->layout->setMeta('description','Solicitud por Servicio');
		$this->layout->setMeta('keywords','Solicitud por Servicio');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');
		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		//$contenido['funcionario'] = $this->objFuncionario->listar();
		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitud_servicio', $contenido);
	}

	public function busqueda_funcionarios(){
		$codigo_servicio = $this->input->post('servicios_clinicos');
		//print_r($codigo_servicio);die();

		#Title
		$this->layout->title('Solicitud por Servicio');

		#Metas
		$this->layout->setMeta('title','Solicitud por Servicio');
		$this->layout->setMeta('description','Solicitud por Servicio');
		$this->layout->setMeta('keywords','Solicitud por Servicio');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');
		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$servicio = $this->objServicioClinico->obtener(array('id_servicio' => $codigo_servicio));
		$contenido['nombre_servicio'] = $servicio->nombre_servicio;
		$contenido['codigo_servicio'] = $codigo_servicio;
		$contenido['tipos_comida'] = $this->objTipoComida->listar();
		$contenido['funcionarios'] = $this->objFuncionario->listar(array('fk_servicio' => $codigo_servicio));
		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitud_servicio', $contenido);
	}

	public function agregar_solicitud(){
		$codigo_servicio = $this->input->post('codigo_servicio');
		$funcionarios = $this->input->post('funcionarios');
		$tipo_comida = $this->input->post('tipos_comida');
		$fecha_solicitud = $this->input->post('fecha_solicitud');
		//print_r($fecha_solicitud);die();
		$fecha_registro_1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_solicitud)));
		$cont = 0;
		$arreglo_revision_funcionarios = array();

		//revisar si hay un funcionario que se registro el mismo dia(tabla solicitud_servicio)
		foreach ($funcionarios as $func) {
			$validador = $this->objSolServ->buscar_funcionario_solicitud_dia_actual_boolean($func);
			if ($validador == false) {
				//$tarjeta_funcionario = $this->objTarjeta->obtener(array('fk_funcionario' => $func));
				$datos_funcionario = $this->objFuncionario->obtener(array('id_funcionario' => $func));
				$mensaje_error = '';
				$mensaje_error = 'Funcionario '.$datos_funcionario->nombres.' '.$datos_funcionario->apellido_pat.' '.$datos_funcionario->apellido_mat.' ya tiene un solicitud ingresada para ese dia';
				array_push($arreglo_revision_funcionarios, $mensaje_error);
				$cont++;
			}
		}

		if ($cont == 0) {
			foreach ($funcionarios as $func) {
				$codigo_tarjeta = '';
				$codigo_tarjeta = $this->objTarjeta->obtener(array('fk_funcionario' => $func));
	
				$datos = array('id_solicitud' => null, 
								'tipo_solicitud' => 1, 
								'fecha_solicitud' => $fecha_registro_1,
								'fk_servicio' => $codigo_servicio, 
								'fk_funcionario' => $func, 
								'fk_tarjeta' => $codigo_tarjeta->numero_tarjeta, 
								'fk_tipocomida' => $tipo_comida, 
								'fecha_registro' => date('Y-m-d H:i:s'),  
								'usuario_digitador' => $this->session->userdata("usuario")->id_usuario,
								'estado' => 0, 
								'estado_entregado' => 0
						);
	
				$this->objSolServ->insertar($datos);
			}	
		}

		if ($cont == 0) {
			$contenido['mesagge'] = "Solicitudes realizadas correctamente!!!";
		}else {
			$contenido['arreglo'] = $arreglo_revision_funcionarios;
		}

		#Title
		$this->layout->title('Solicitud por Servicio');

		#Metas
		$this->layout->setMeta('title','Solicitud por Servicio');
		$this->layout->setMeta('description','Solicitud por Servicio');
		$this->layout->setMeta('keywords','Solicitud por Servicio');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitud_servicio', $contenido);
	}

	public function registro_por_servicio(){
		#Title
		$this->layout->title('Registro por Servicio');

		#Metas
		$this->layout->setMeta('title','Registro por Servicio');
		$this->layout->setMeta('description','Registro por Servicio');
		$this->layout->setMeta('keywords','Registro por Servicio');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');
		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		//$contenido['funcionario'] = $this->objFuncionario->listar();
		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('registro_servicio', $contenido);
	}

	public function busqueda_funcionarios_por_servicio(){
		$codigo_servicio = $this->input->post('servicios_clinicos');
		//print_r($codigo_servicio);die();

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#Title
		$this->layout->title('Registro por Servicio');

		#js
		//$this->layout->js('js/sistema/control_casino/index.js');

		#Metas
		$this->layout->setMeta('title','Registro por Servicio');
		$this->layout->setMeta('description','Registro por Servicio');
		$this->layout->setMeta('keywords','Registro por Servicio');

		$contenido['codigo_servicio'] = $codigo_servicio;
		//se debe hacer una busqueda por dia actual de los funcionarios que tiene solicitud por servicio
		$contenido['datos'] = $this->objSolServ->buscar_funcionario_solicitud_dia_actual($codigo_servicio);
		//$contenido['datos'] = $this->objSolServ->listar(array('fk_servicio' => $codigo_servicio));
		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('registro_servicio', $contenido);
	}

	public function transaccion_por_servicio(){
		$codigo_servicio = $this->input->post('codigo_servicio');
		$funcionarios_sol = $this->input->post('funcionarios_sol');
		$cont = 0;
		$arreglo_revision_funcionarios = array();

		//Primero validamos si es que hay problemas con algun funcionario
		//Sumar el cont en caso de haya problemas con un funcionario y poner en un array los funcionarios con problemas
		foreach ($funcionarios_sol as $func) {
			$tarjeta_funcionario = $this->objTarjeta->obtener(array('fk_funcionario' => $func));
			$validador = $this->objTransTarjeta->obtener_funcionario_dia_actual($tarjeta_funcionario->numero_tarjeta);
			if ($validador == false) {
				$datos_funcionario = $this->objFuncionario->obtener(array('id_funcionario' => $func));
				$mensaje_error = '';
				$mensaje_error = 'Funcionario '.$datos_funcionario->nombres.' '.$datos_funcionario->apellido_pat.' '.$datos_funcionario->apellido_mat.' ya registra una transaccion el dia de hoy';
				array_push($arreglo_revision_funcionarios, $mensaje_error);
				$cont++;
			}
		}

		//En caso de que el cont este en 0, agregar a los funcionarios a la tabla transaccion_tarjeta
		if ($cont == 0) {
			foreach ($funcionarios_sol as $func) {
				$tarjeta_funcionario = $this->objTarjeta->obtener(array('fk_funcionario' => $func));
				$datos_solicitud_funcionario = $this->objSolServ->obtener_tipocomida_funcionario_solicitud_dia_actual($func);
				$datos_transaccion = array('id_transaccion' => null,
										   'fk_tarjeta' => $tarjeta_funcionario->numero_tarjeta,
										   'fecha_registro' => date('Y-m-d H:i:s'),
										   'fk_tipocomida' => $datos_solicitud_funcionario->fk_tipocomida,
										   'fk_rutcontrol' => $this->session->userdata("usuario")->id_usuario,
										   'estado' => 1, //1: activo
										   'tipo_transaccion' => 2 //2: transaccion por servicio
									 );

			$this->objTransTarjeta->insertar($datos_transaccion);
			}	
		}

		#Title
		$this->layout->title('Registro por Servicio');

		#Metas
		$this->layout->setMeta('title','Registro por Servicio');
		$this->layout->setMeta('description','Registro por Servicio');
		$this->layout->setMeta('keywords','Registro por Servicio');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');
		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		if ($cont == 0) {
			$contenido['mesagge'] = "Transacciones realizadas correctamente!!!";
		}else {
			$contenido['arreglo'] = $arreglo_revision_funcionarios;
		}

		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('registro_servicio', $contenido);
	}

}
