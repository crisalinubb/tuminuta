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

    	$validador = $this->objSolServ->obtener(array('fk_tarjeta' => $codigo_tarjeta));

    	$funcionario = $this->objFuncionario->obtener(array('id_funcionario' => $validador->fk_funcionario));
    	$servicio = $this->objServicioClinico->obtener(array('id_servicio' => $funcionario->fk_servicio));
    	$tarjeta = $this->objTarjeta->obtener(array('numero_tarjeta' => $codigo_tarjeta));
    	$tipo_tarjeta = $this->objTipoTarjeta->obtener(array('id_tipotarjeta' => $tarjeta->fk_tipotarjeta));

    	$msg= "Funcionario: ".$funcionario->nombre." ".$funcionario->apellido_pat." ".$funcionario->apellido_mat."<br> Servicio: ".$servicio->nombre_servicio."<br> Tipo Tarjeta: ".$tipo_tarjeta->descripcion; 

        if($validador){
			echo json_encode(array("result"=>true,"msg"=>$msg));
				//exit;
		}else{
			echo json_encode(array("result"=>false,"msg"=>$codigo_tarjeta." funcionario no habilitado"));
			//exit;
		}
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
		$contenido['funcionarios'] = $this->objFuncionario->listar(array('fk_unidad' => $codigo_servicio));
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
					);

			$this->objSolServ->insertar($datos);
		}

		$contenido['mesagge'] = "Solicitudes realizadas correctamente!!!";

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

}
