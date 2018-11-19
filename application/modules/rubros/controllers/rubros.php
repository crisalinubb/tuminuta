<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Rubros extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_rubro", "objRubro");
		#current
		$this->layout->current = 1;

	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Rubros');

		#Metas
		$this->layout->setMeta('title','Rubros');
		$this->layout->setMeta('description','Rubros');
		$this->layout->setMeta('keywords','Rubros');

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
		$config['base_url'] = base_url() . 'rubros/';
		$config['total_rows'] = count($this->objRubro->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/rubros'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objRubro->listar($where, $pagina, $config['per_page']);

		$contenido['rubros'] = $this->objRubro->listar();

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
				'id_rubro' => null,
				'nombre' => $this->input->post('nombre')
			);
			
			if($this->objRubro->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Hospital');

			#metas
			$this->layout->setMeta('title','Agregar Hospital');
			$this->layout->setMeta('description','Agregar Hospital');
			$this->layout->setMeta('keywords','Agregar Hospital');

			#js
			$this->layout->js('js/sistema/rubros/agregar.js');

			#nav
			$this->layout->nav(array("Rubros "=> "rubro", "Agregar Rubros" =>"/"));

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
				'nombre' => $this->input->post('nombre')
			);

			if($this->objRubro->actualizar($datos,array("id_rubro"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "rubros/");
			#js
			$this->layout->js('js/sistema/rubros/editar.js');

			#title
			$this->layout->title('Editar Hospital');

			#metas
			$this->layout->setMeta('title','Editar Hospital');
			$this->layout->setMeta('description','Editar Hospital');
			$this->layout->setMeta('keywords','Editar Hospital');

			#contenido
			if($contenido['rubro'] = $this->objRubro->obtener(array("id_rubro" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Rubros "=>"rubros", "Editar Rubros" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "hospital/");

			#title
			$this->layout->title('Editar Hospital');

			#metas
			$this->layout->setMeta('title','Editar Hospital');
			$this->layout->setMeta('description','Editar Hospital');
			$this->layout->setMeta('keywords','Editar Hospital');

			//buscando datos de elemento eliminado
			$rubro_eliminado = $this->objRubro->obtener(array('id_rubro' => $codigo));

			//borrando el registro
			$this->objRubro->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#paginacion
			$config['base_url'] = base_url() . 'rubros/';
			$config['total_rows'] = count($this->objRubro->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/rubros'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objRubro->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $rubro_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['rubros'] = $this->objRubro->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('rubros',true);

		#Title
		$this->layout->title('Rubros');

		#Metas
		$this->layout->setMeta('title','Rubros');
		$this->layout->setMeta('description','Rubros');
		$this->layout->setMeta('keywords','Rubros');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objRubro->obtenerRubro($query);

		$contenido['rubros'] = $this->objRubro->listar();

		$this->layout->view('index', $contenido);

	}
}
