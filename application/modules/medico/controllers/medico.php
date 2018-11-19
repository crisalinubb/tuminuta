<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Medico extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_medico", "objMedico");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Medicos');

		#Metas
		$this->layout->setMeta('title','Medicos');
		$this->layout->setMeta('description','Medicos');
		$this->layout->setMeta('keywords','Medicos');

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
		$config['base_url'] = base_url() . 'medico/';
		$config['total_rows'] = count($this->objMedico->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/medico'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['medicos'] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'id_medico' => null,
				'medico_nombre' => $this->input->post('nombre'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);
			
			if($this->objMedico->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Medico');

			#metas
			$this->layout->setMeta('title','Agregar Medico');
			$this->layout->setMeta('description','Agregar Medico');
			$this->layout->setMeta('keywords','Agregar Medico');

			#js
			$this->layout->js('js/sistema/medico/agregar.js');

			#nav
			$this->layout->nav(array("Medico "=> "medico", "Agregar Medico" =>"/"));

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
				'medico_nombre' => $this->input->post('nombre')
			);

			if($this->objMedico->actualizar($datos,array("id_medico"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "medico/");
			#js
			$this->layout->js('js/sistema/medico/editar.js');

			#title
			$this->layout->title('Editar Medico');

			#metas
			$this->layout->setMeta('title','Editar Medico');
			$this->layout->setMeta('description','Editar Medico');
			$this->layout->setMeta('keywords','Editar Medico');

			#contenido
			if($contenido['medico'] = $this->objMedico->obtener(array("id_medico" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Medico "=>"medico", "Editar Medico" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "medico/");

			//buscando datos de elemento eliminado
			$medico_eliminado = $this->objMedico->obtener(array('id_medico' => $codigo));

			//borrando el registro
			$this->objMedico->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'medico/';
			$config['total_rows'] = count($this->objMedico->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/medico'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $medico_eliminado->medico_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['medicos'] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('medicos',true);

		#Title
		$this->layout->title('Medicos');

		#Metas
		$this->layout->setMeta('title','Medicos');
		$this->layout->setMeta('description','Medicos');
		$this->layout->setMeta('keywords','Medicos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objMedico->obtenerMedico($query);

		$contenido['medicos'] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

}
