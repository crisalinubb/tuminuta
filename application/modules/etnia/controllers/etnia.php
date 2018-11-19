<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Etnia extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_etnia", "objEtnia");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Etnia');

		#Metas
		$this->layout->setMeta('title','Etnia');
		$this->layout->setMeta('description','Etnia');
		$this->layout->setMeta('keywords','Etnia');

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
		$config['base_url'] = base_url() . 'etnia/';
		$config['total_rows'] = count($this->objEtnia->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/etnia'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objEtnia->listar($where, $pagina, $config['per_page']);

		$contenido['etnias'] = $this->objEtnia->listar();

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
				'id_etnia' => null,
				'etnia_nombre' => $this->input->post('nombre')
			);
			
			if($this->objEtnia->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Etnia');

			#metas
			$this->layout->setMeta('title','Agregar Etnia');
			$this->layout->setMeta('description','Agregar Etnia');
			$this->layout->setMeta('keywords','Agregar Etnia');

			#js
			$this->layout->js('js/sistema/etnia/agregar.js');

			#nav
			$this->layout->nav(array("Etnia "=> "etnia", "Agregar Etnia" =>"/"));

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
				'etnia_nombre' => $this->input->post('nombre')
			);

			if($this->objEtnia->actualizar($datos,array("id_etnia"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "etnia/");
			#js
			$this->layout->js('js/sistema/etnia/editar.js');

			#title
			$this->layout->title('Editar Etnia');

			#metas
			$this->layout->setMeta('title','Editar Etnia');
			$this->layout->setMeta('description','Editar Etnia');
			$this->layout->setMeta('keywords','Editar Etnia');

			#contenido
			if($contenido['etnia'] = $this->objEtnia->obtener(array("id_etnia" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Etnia "=>"hospitales", "Editar Etnia" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "etnia/");

			//buscando datos de elemento eliminado
			$etnia_eliminada = $this->objEtnia->obtener(array('id_etnia' => $codigo));

			//borrando el registro
			$this->objEtnia->eliminar($codigo);

			$contenido['datos'] = $this->objEtnia->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'etnia/';
			$config['total_rows'] = count($this->objEtnia->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/etnia'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objEtnia->listar($where, $pagina, $config['per_page']);


			$contenido['mesagge'] = $etnia_eliminada->etnia_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['etnias'] = $this->objEtnia->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('etnias',true);

		#Title
		$this->layout->title('Etnias');

		#Metas
		$this->layout->setMeta('title','Etnias');
		$this->layout->setMeta('description','Etnias');
		$this->layout->setMeta('keywords','Etnias');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objEtnia->obtenerEtnia($query);

		$contenido['etnias'] = $this->objEtnia->listar();

		$this->layout->view('index', $contenido);

	}

}
