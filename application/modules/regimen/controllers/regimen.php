<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Regimen extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_regimen", "objRegimen");
		$this->load->model("producto/modelo_producto", "objProducto");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Regimenes');

		#Metas
		$this->layout->setMeta('title','Regimenes');
		$this->layout->setMeta('description','Regimenes');
		$this->layout->setMeta('keywords','Regimenes');

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
			$where = "nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'regimen/';
		$config['total_rows'] = count($this->objRegimen->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/regimen'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objRegimen->listar($where, $pagina, $config['per_page']);

		$contenido['regimenes'] = $this->objRegimen->listar();

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
				'id_regimen' => null,
				'nombre' => $this->input->post('nombre'),
				'tipo' => $this->input->post('tipo'),
				'base' => $this->input->post('base'),
				'producto' => $this->input->post('producto')
			);
			
			if($this->objRegimen->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Regimen');

			#metas
			$this->layout->setMeta('title','Agregar Regimen');
			$this->layout->setMeta('description','Agregar Regimen');
			$this->layout->setMeta('keywords','Agregar Regimen');

			#js
			$this->layout->js('js/sistema/regimen/agregar.js');

			#nav
			$this->layout->nav(array("Regimenes "=> "regimen", "Agregar Regimen" =>"/"));

			$contenido['productos'] = $this->objProducto->listar();

			$contenido['bases'] = $this->objRegimen->listar();

			$this->layout->view('agregar',$contenido);
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
				'nombre' => $this->input->post('nombre'),
				'tipo' => $this->input->post('tipo'),
				'base' => $this->input->post('base'),
				'producto' => $this->input->post('producto')
			);

			if($this->objRegimen->actualizar($datos,array("id_regimen"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "regimen/");
			#js
			$this->layout->js('js/sistema/regimen/editar.js');

			#title
			$this->layout->title('Editar Regimen');

			#metas
			$this->layout->setMeta('title','Editar Regimen');
			$this->layout->setMeta('description','Editar Regimen');
			$this->layout->setMeta('keywords','Editar Regimen');

			#contenido
			if($contenido['regimenes'] = $this->objRegimen->obtener(array("id_regimen" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Regimenes "=>"regimen", "Editar Regimen" =>"/"));

			$contenido['productos'] = $this->objProducto->listar();
			$contenido['bases'] = $this->objRegimen->listar();

			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "regimen/");

			//buscando datos de elemento eliminado
			$regimen_eliminado = $this->objRegimen->obtener(array('id_regimen' => $codigo));

			//borrando el registro
			$this->objRegimen->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'regimen/';
			$config['total_rows'] = count($this->objRegimen->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/regimen'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objRegimen->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $regimen_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['regimenes'] = $this->objRegimen->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('regimenes',true);

		#Title
		$this->layout->title('Regimenes');

		#Metas
		$this->layout->setMeta('title','Regimenes');
		$this->layout->setMeta('description','Regimenes');
		$this->layout->setMeta('keywords','Regimenes');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objRegimen->obtenerRegimen($query);

		$contenido['regimenes'] = $this->objRegimen->listar();

		$this->layout->view('index', $contenido);

	}

}
