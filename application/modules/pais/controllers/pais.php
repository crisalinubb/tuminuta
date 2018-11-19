<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Pais extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_pais", "objPais");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Pais');

		#Metas
		$this->layout->setMeta('title','Pais');
		$this->layout->setMeta('description','Pais');
		$this->layout->setMeta('keywords','Pais');

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
		$config['base_url'] = base_url() . 'pais/';
		$config['total_rows'] = count($this->objPais->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/pais'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objPais->listar($where, $pagina, $config['per_page']);

		$contenido['paises'] = $this->objPais->listar();

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
				'id_pais' => null,
				'pais_nombre' => $this->input->post('nombre')
			);
			
			if($this->objPais->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Pais');

			#metas
			$this->layout->setMeta('title','Agregar Pais');
			$this->layout->setMeta('description','Agregar Pais');
			$this->layout->setMeta('keywords','Agregar Pais');

			#js
			$this->layout->js('js/sistema/pais/agregar.js');

			#nav
			$this->layout->nav(array("Pais "=> "pais", "Agregar Pais" =>"/"));

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
				'pais_nombre' => $this->input->post('nombre')
			);

			if($this->objPais->actualizar($datos,array("id_pais"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "pais/");
			#js
			$this->layout->js('js/sistema/pais/editar.js');

			#title
			$this->layout->title('Editar Pais');

			#metas
			$this->layout->setMeta('title','Editar Pais');
			$this->layout->setMeta('description','Editar Pais');
			$this->layout->setMeta('keywords','Editar Pais');

			#contenido
			if($contenido['pais'] = $this->objPais->obtener(array("id_pais" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Pais "=>"pais", "Editar Pais" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "pais/");

			//buscando datos de elemento eliminado
			$pais_eliminado = $this->objPais->obtener(array('id_pais' => $codigo));

			//borrando el registro
			$this->objPais->eliminar($codigo);

			$contenido['datos'] = $this->objPais->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'pais/';
			$config['total_rows'] = count($this->objPais->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/pais'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objPais->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $pais_eliminado->pais_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['paises'] = $this->objPais->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('paises',true);

		#Title
		$this->layout->title('Paises');

		#Metas
		$this->layout->setMeta('title','Paises');
		$this->layout->setMeta('description','Paises');
		$this->layout->setMeta('keywords','Paises');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objPais->obtenerPais($query);

		$contenido['paises'] = $this->objPais->listar();

		$this->layout->view('index', $contenido);

	}

}
