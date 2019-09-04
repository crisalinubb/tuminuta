<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Destinos extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_destinos", "objDestinos");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Destinos');

		#Metas
		$this->layout->setMeta('title','Destinos');
		$this->layout->setMeta('description','Destinos');
		$this->layout->setMeta('keywords','Destinos');

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
		$config['base_url'] = base_url() . 'destinos/';
		$config['total_rows'] = count($this->objDestinos->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/destinos'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		//$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$contenido['destinos'] = $this->objDestinos->listar();
		$contenido['datos'] = $this->objDestinos->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('destino', 'Destino', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'id_destino' => null,
				'nombre' => $this->input->post('destino'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);
			
			if($this->objDestinos->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Destino');

			#metas
			$this->layout->setMeta('title','Agregar Destino');
			$this->layout->setMeta('description','Agregar Destino');
			$this->layout->setMeta('keywords','Agregar Destino');

			#js
			$this->layout->js('js/sistema/destinos/agregar.js');

			#nav
			$this->layout->nav(array("Destino "=> "destinos", "Agregar Destino" =>"/"));

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('destino', 'Destino', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'nombre' => $this->input->post('destino'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objDestinos->actualizar($datos,array("id_destino"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "destinos/");
			#js
			$this->layout->js('js/sistema/destinos/editar.js');

			#title
			$this->layout->title('Editar Destino');

			#metas
			$this->layout->setMeta('title','Editar Destino');
			$this->layout->setMeta('description','Editar Destino');
			$this->layout->setMeta('keywords','Editar Destino');

			#contenido
			if($contenido['destinos'] = $this->objDestinos->obtener(array("id_destino" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Destino "=>"destinos", "Editar Destino" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "destinos/");

			#Title
			$this->layout->title('Destinos');

			#Metas
			$this->layout->setMeta('title','Destinos');
			$this->layout->setMeta('description','Destinos');
			$this->layout->setMeta('keywords','Destinos');

			//buscando datos de elemento eliminado
			$destino_eliminado = $this->objDestinos->obtener(array('id_destino' => $codigo));

			//borrando el registro
			$this->objDestinos->eliminar($codigo);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'destinos/';
			$config['total_rows'] = count($this->objDestinos->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/destinos'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$contenido['mesagge'] = $destino_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('destinos',true);

		#Title
		$this->layout->title('Destinos');

		#Metas
		$this->layout->setMeta('title','Destinos');
		$this->layout->setMeta('description','Destinos');
		$this->layout->setMeta('keywords','Destinos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objDestinos->obtenerDestino($query);

		//$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['destinos'] = $this->objDestinos->listar();

		$this->layout->view('index', $contenido);

	}

}
