<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Hospital extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_hospital", "objHospital");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Hospitales');

		#Metas
		$this->layout->setMeta('title','Hospitales');
		$this->layout->setMeta('description','Hospitales');
		$this->layout->setMeta('keywords','Hospitales');

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
			$where = "hos_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'hospital/';
		$config['total_rows'] = count($this->objHospital->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/hospital'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objHospital->listar($where, $pagina, $config['per_page']);

		$contenido['hospitales'] = $this->objHospital->listar();

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
				'id_hospital' => null,
				'hos_nombre' => $this->input->post('nombre')
			);
			
			if($this->objHospital->insertar($datos)){
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
			$this->layout->js('js/sistema/hospital/agregar.js');

			#nav
			$this->layout->nav(array("Hospital "=> "hospital", "Agregar Hospital" =>"/"));

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
				'hos_nombre' => $this->input->post('nombre')
			);

			if($this->objHospital->actualizar($datos,array("id_hospital"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "hospital/");
			#js
			$this->layout->js('js/sistema/hospital/editar.js');

			#title
			$this->layout->title('Editar Hospital');

			#metas
			$this->layout->setMeta('title','Editar Hospital');
			$this->layout->setMeta('description','Editar Hospital');
			$this->layout->setMeta('keywords','Editar Hospital');

			#contenido
			if($contenido['hospital'] = $this->objHospital->obtener(array("id_hospital" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Hospital "=>"hospitales", "Editar hospital" =>"/"));
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
			$hospital_eliminado = $this->objHospital->obtener(array('id_hospital' => $codigo));

			//borrando el registro
			$this->objHospital->eliminar($codigo);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objHospital->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'hospital/';
			$config['total_rows'] = count($this->objHospital->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/hospital'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objHospital->listar($where, $pagina, $config['per_page']);


			$contenido['mesagge'] = $hospital_eliminado->hos_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['hospitales'] = $this->objHospital->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('hospitales',true);

		#Title
		$this->layout->title('Hospitales');

		#Metas
		$this->layout->setMeta('title','Hospitales');
		$this->layout->setMeta('description','Hospitales');
		$this->layout->setMeta('keywords','Hospitales');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objHospital->obtenerHospital($query);

		$contenido['hospitales'] = $this->objHospital->listar();

		$this->layout->view('index', $contenido);

	}

}
