<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Escolaridad extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_escolaridad", "objEscolaridad");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Escolaridades');

		#Metas
		$this->layout->setMeta('title','Escolaridades');
		$this->layout->setMeta('description','Escolaridades');
		$this->layout->setMeta('keywords','Escolaridades');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'escolaridad/';
		$config['total_rows'] = count($this->objEscolaridad->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/escolaridad'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objEscolaridad->listar($where, $pagina, $config['per_page']);

		$contenido['escolaridades'] = $this->objEscolaridad->listar();

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
				'id_escolaridad' => null,
				'esc_nombre' => $this->input->post('nombre')
			);
			
			if($this->objEscolaridad->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Escolaridad');

			#metas
			$this->layout->setMeta('title','Agregar Escolaridad');
			$this->layout->setMeta('description','Agregar Escolaridad');
			$this->layout->setMeta('keywords','Agregar Escolaridad');

			#js
			$this->layout->js('js/sistema/escolaridad/agregar.js');

			#nav
			$this->layout->nav(array("Escolaridad "=> "escolaridad", "Agregar Escolaridad" =>"/"));

			$this->layout->view('agregar');
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
				'esc_nombre' => $this->input->post('nombre')
			);

			if($this->objEscolaridad->actualizar($datos,array("id_escolaridad"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "escolaridad/");
			#js
			$this->layout->js('js/sistema/escolaridad/editar.js');

			#title
			$this->layout->title('Editar Escolaridad');

			#metas
			$this->layout->setMeta('title','Editar Escolaridad');
			$this->layout->setMeta('description','Editar Escolaridad');
			$this->layout->setMeta('keywords','Editar Escolaridad');

			#contenido
			if($contenido['escolaridad'] = $this->objEscolaridad->obtener(array("id_escolaridad" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Escolaridad "=>"escolaridad", "Editar Escolaridad" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "escolaridad/");

			//buscando datos de elemento eliminado
			$escolaridad_eliminado = $this->objEscolaridad->obtener(array('id_escolaridad' => $codigo));

			//borrando el registro
			$this->objEscolaridad->eliminar($codigo);

			$contenido['datos'] = $this->objEscolaridad->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'escolaridad/';
			$config['total_rows'] = count($this->objEscolaridad->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/escolaridad'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objEscolaridad->listar($where, $pagina, $config['per_page']);


			$contenido['mesagge'] = $escolaridad_eliminado->esc_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['escolaridades'] = $this->objEscolaridad->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('escolaridades',true);

		#Title
		$this->layout->title('Escolaridades');

		#Metas
		$this->layout->setMeta('title','Escolaridades');
		$this->layout->setMeta('description','Escolaridades');
		$this->layout->setMeta('keywords','Escolaridades');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objEscolaridad->obtenerEscolaridad($query);

		$contenido['escolaridades'] = $this->objEscolaridad->listar();

		$this->layout->view('index', $contenido);

	}

}
