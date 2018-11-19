<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Comuna extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_comuna", "objComuna");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Comunas');

		#Metas
		$this->layout->setMeta('title','Comunas');
		$this->layout->setMeta('description','Comunas');
		$this->layout->setMeta('keywords','Comunas');

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
			$where = "comuna_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'comuna/';
		$config['total_rows'] = count($this->objComuna->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/comuna'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objComuna->listar($where, $pagina, $config['per_page']);

		$contenido['comunas'] = $this->objComuna->listar();

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
				'id_comuna' => null,
				'comuna_nombre' => $this->input->post('nombre')
			);
			
			if($this->objComuna->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Comuna');

			#metas
			$this->layout->setMeta('title','Agregar Comuna');
			$this->layout->setMeta('description','Agregar Comuna');
			$this->layout->setMeta('keywords','Agregar Comuna');

			#js
			$this->layout->js('js/sistema/comuna/agregar.js');

			#nav
			$this->layout->nav(array("Comuna "=> "comuna", "Agregar Comuna" =>"/"));

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
				'comuna_nombre' => $this->input->post('nombre')
			);

			if($this->objComuna->actualizar($datos,array("id_comuna"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "comuna/");
			#js
			$this->layout->js('js/sistema/comuna/editar.js');

			#title
			$this->layout->title('Editar Comuna');

			#metas
			$this->layout->setMeta('title','Editar Comuna');
			$this->layout->setMeta('description','Editar Comuna');
			$this->layout->setMeta('keywords','Editar Comuna');

			#contenido
			if($contenido['comuna'] = $this->objComuna->obtener(array("id_comuna" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Comuna "=>"comuna", "Editar Comuna" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "comuna/");

			//buscando datos de elemento eliminado
			$comuna_eliminada = $this->objComuna->obtener(array('id_comuna' => $codigo));

			//borrando el registro
			$this->objComuna->eliminar($codigo);

			$contenido['datos'] = $this->objComuna->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'comuna/';
			$config['total_rows'] = count($this->objComuna->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/comuna'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objComuna->listar($where, $pagina, $config['per_page']);


			$contenido['mesagge'] = $comuna_eliminada->comuna_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['comunas'] = $this->objComuna->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('comunas',true);

		#Title
		$this->layout->title('Comunas');

		#Metas
		$this->layout->setMeta('title','Comunas');
		$this->layout->setMeta('description','Comunas');
		$this->layout->setMeta('keywords','Comunas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objComuna->obtenerComuna($query);

		$contenido['comunas'] = $this->objComuna->listar();

		$this->layout->view('index', $contenido);

	}

}
