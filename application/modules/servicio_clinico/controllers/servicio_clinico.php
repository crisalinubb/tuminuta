<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Servicio_clinico extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_servicioclinico", "objServicioClinico");
		$this->load->model("modelo_destino", "objDestino");
		$this->load->model("hospital/modelo_hospital", "objHospital");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Servicio Clinico');

		#Metas
		$this->layout->setMeta('title','Servicio Clinico');
		$this->layout->setMeta('description','Servicio Clinico');
		$this->layout->setMeta('keywords','Servicio Clinico');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "nombre_servicio like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'servicio_clinico/';
		$config['total_rows'] = count($this->objServicioClinico->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/servicio_clinico'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'id_servicio' => null,
				'codigo_servicio' => $this->input->post('codigo'),
				'nombre_servicio' => $this->input->post('nombre'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);
			
			if($this->objServicioClinico->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Servicio Clinico');

			#metas
			$this->layout->setMeta('title','Agregar Servicio Clinico');
			$this->layout->setMeta('description','Agregar Servicio Clinico');
			$this->layout->setMeta('keywords','Agregar Servicio Clinico');

			#js
			$this->layout->js('js/sistema/servicio_clinico/agregar.js');

			#nav
			$this->layout->nav(array("Servicio Clinico "=> "servicio_clinico", "Agregar Servicio Clinico" =>"/"));

			//$contenido["destinos"]= $this->objDestino->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'codigo_servicio' => $this->input->post('codigo_servicio'),
				'nombre_servicio' => $this->input->post('nombre'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objServicioClinico->actualizar($datos,array("id_servicio"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "servicio_clinico/");
			#js
			$this->layout->js('js/sistema/servicio_clinico/editar.js');

			#title
			$this->layout->title('Editar Servicio Clinico');

			#metas
			$this->layout->setMeta('title','Editar Servicio Clinico');
			$this->layout->setMeta('description','Editar Servicio Clinico');
			$this->layout->setMeta('keywords','Editar Servicio Clinico');

			#contenido
			if($contenido['servicio_clinico'] = $this->objServicioClinico->obtener(array("id_servicio" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Servicio Clinico "=>"servicio_clinico", "Editar Servicio Clinico" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "servicio_clinico/");

			//buscando datos de elemento eliminado
			$servicioclinico_eliminado = $this->objServicioClinico->obtener(array('id_servicio' => $codigo));

			//borrando el registro
			$this->objServicioClinico->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'servicio_clinico/';
			$config['total_rows'] = count($this->objServicioClinico->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/servicio_clinico'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $servicioclinico_eliminado->nombre_servicio." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	//actualizar datos de las camas
	public function actualizarCamas(){
		$camas = $this->objServicioClinico->obtener_camas();
		foreach ($camas->result() as $cama) {
			$codigo_servicio= '';
			$codigo_servicio = $this->objServicioClinico->obtener(array('codigo_servicio' => $cama->codigo_servicio));
			$this->objServicioClinico->actualizar_id_camas($cama->id_cama,$codigo_servicio->id_servicio);
		}
	}

	//actualizar datos de las salas
	public function actualizarSalas(){
		$salas = $this->objServicioClinico->obtener_salas();
		foreach ($salas->result() as $sala) {
			$codigo_servicio= '';
			$codigo_servicio = $this->objServicioClinico->obtener(array('codigo_servicio' => $sala->CODSERV));
			$this->objServicioClinico->actualizar_id_salas($sala->id_sala,$codigo_servicio->id_servicio);
		}
	}

	public function busqueda(){
		$query = $this->input->get('servicios_clinicos',true);

		#Title
		$this->layout->title('Servicio Clinico');

		#Metas
		$this->layout->setMeta('title','Servicio Clinico');
		$this->layout->setMeta('description','Servicio Clinico');
		$this->layout->setMeta('keywords','Servicio Clinico');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objServicioClinico->obtenerServicioClinico($query);

		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

}
