<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Diagnostico extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_diagnostico", "objDiagnostico");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Diagnosticos');

		#Metas
		$this->layout->setMeta('title','Diagnosticos');
		$this->layout->setMeta('description','Diagnosticos');
		$this->layout->setMeta('keywords','Diagnosticos');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "diagnostico_descripcion like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'diagnostico/';
		$config['total_rows'] = count($this->objDiagnostico->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/diagnostico'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objDiagnostico->listar($where, $pagina, $config['per_page']);

		//$contenido['diagnosticos'] = $this->objDiagnostico->listar();

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
				'id_diagnostico' => null,
				'diagnostico_codigo' => $this->input->post('codigo_diagnostico'),
				'diagnostico_descripcion' => $this->input->post('nombre'),
				'diagnostico_observacion' => $this->input->post('observacion')
			);
			
			if($this->objDiagnostico->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Diagnostico');

			#metas
			$this->layout->setMeta('title','Agregar Diagnostico');
			$this->layout->setMeta('description','Agregar Diagnostico');
			$this->layout->setMeta('keywords','Agregar Diagnostico');

			#js
			$this->layout->js('js/sistema/diagnostico/agregar.js');

			#nav
			$this->layout->nav(array("Diagnostico "=> "diagnostico", "Agregar Diagnostico" =>"/"));

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
				'diagnostico_codigo' => $this->input->post('codigo_diagnostico'),
				'diagnostico_descripcion' => $this->input->post('nombre'),
				'diagnostico_observacion' => $this->input->post('observacion')
			);

			if($this->objDiagnostico->actualizar($datos,array("id_diagnostico"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "diagnostico/");
			#js
			$this->layout->js('js/sistema/diagnostico/editar.js');

			#title
			$this->layout->title('Editar Diagnostico');

			#metas
			$this->layout->setMeta('title','Editar Diagnostico');
			$this->layout->setMeta('description','Editar Diagnostico');
			$this->layout->setMeta('keywords','Editar Diagnostico');

			#contenido
			if($contenido['diagnostico'] = $this->objDiagnostico->obtener(array("id_diagnostico" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Diagnostico "=>"diagnostico", "Editar Diagnostico" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "diagnostico/");

			//buscando datos de elemento eliminado
			$diagnostico_eliminado = $this->objDiagnostico->obtener(array('id_diagnostico' => $codigo));

			//borrando el registro
			$this->objDiagnostico->eliminar($codigo);

			$contenido['datos'] = $this->objDiagnostico->listar($where, $pagina, $config['per_page']);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'diagnostico/';
			$config['total_rows'] = count($this->objDiagnostico->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/diagnostico'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objDiagnostico->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $diagnostico_eliminado->diagnostico_descripcion." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['diagnosticos'] = $this->objDiagnostico->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('diagnosticos',true);

		#Title
		$this->layout->title('Diagnosticos');

		#Metas
		$this->layout->setMeta('title','Diagnosticos');
		$this->layout->setMeta('description','Diagnosticos');
		$this->layout->setMeta('keywords','Diagnosticos');

		$contenido['datos'] = $this->objDiagnostico->obtenerDiagnostico($query);

		$contenido['diagnosticos'] = $this->objDiagnostico->listar();

		$this->layout->view('index', $contenido);

	}

}
