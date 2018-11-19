<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Region extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_region", "objRegion");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Region');

		#Metas
		$this->layout->setMeta('title','Region');
		$this->layout->setMeta('description','Region');
		$this->layout->setMeta('keywords','Region');

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
		$config['base_url'] = base_url() . 'region/';
		$config['total_rows'] = count($this->objRegion->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/region'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objRegion->listar($where, $pagina, $config['per_page']);

		$contenido['regiones'] = $this->objRegion->listar();

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
				'id_region' => null,
				'region_nombre' => $this->input->post('nombre')
			);
			
			if($this->objRegion->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Region');

			#metas
			$this->layout->setMeta('title','Agregar Region');
			$this->layout->setMeta('description','Agregar Region');
			$this->layout->setMeta('keywords','Agregar Region');

			#js
			$this->layout->js('js/sistema/region/agregar.js');

			#nav
			$this->layout->nav(array("Region "=> "hospital", "Agregar Region" =>"/"));

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
				'region_nombre' => $this->input->post('nombre')
			);

			if($this->objRegion->actualizar($datos,array("id_region"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "region/");
			#js
			$this->layout->js('js/sistema/region/editar.js');

			#title
			$this->layout->title('Editar Region');

			#metas
			$this->layout->setMeta('title','Editar Region');
			$this->layout->setMeta('description','Editar Region');
			$this->layout->setMeta('keywords','Editar Region');

			#contenido
			if($contenido['region'] = $this->objRegion->obtener(array("id_region" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Hospital "=>"region", "Editar Region" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "region/");

			//buscando datos de elemento eliminado
			$region_eliminada = $this->objRegion->obtener(array('id_region' => $codigo));

			//borrando el registro
			$this->objRegion->eliminar($codigo);

			$contenido['datos'] = $this->objRegion->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'region/';
			$config['total_rows'] = count($this->objRegion->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/region'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objRegion->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $region_eliminada->region_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['regiones'] = $this->objRegion->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('regiones',true);

		#Title
		$this->layout->title('Regiones');

		#Metas
		$this->layout->setMeta('title','Regiones');
		$this->layout->setMeta('description','Regiones');
		$this->layout->setMeta('keywords','Regiones');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objRegion->obtenerRegion($query);

		$contenido['regiones'] = $this->objRegion->listar();

		$this->layout->view('index', $contenido);

	}

}
