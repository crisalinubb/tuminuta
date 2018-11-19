<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Unidades_medida extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_unidadesmedida", "objUnidadesMed");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Unidades de medida');

		#Metas
		$this->layout->setMeta('title','Unidades de medida');
		$this->layout->setMeta('description','Unidades de medida');
		$this->layout->setMeta('keywords','Unidades de medida');

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
		$config['base_url'] = base_url() . 'unidades_medida/';
		$config['total_rows'] = count($this->objUnidadesMed->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/unidades_medida'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objUnidadesMed->listar($where, $pagina, $config['per_page']);

		$contenido['unidades_medida'] = $this->objUnidadesMed->listar();

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
				'id_unidad_medidad' => $this->input->post('codigo'),
				'nombre' => $this->input->post('nombre')
			);
			
			if($this->objUnidadesMed->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Unidades de Medida');

			#metas
			$this->layout->setMeta('title','Agregar Unidades de Medida');
			$this->layout->setMeta('description','Agregar Unidades de Medida');
			$this->layout->setMeta('keywords','Agregar Unidades de Medida');

			#js
			$this->layout->js('js/sistema/unidades_medida/agregar.js');

			#nav
			$this->layout->nav(array("Unidades de Medida "=> "unidades_medida", "Agregar Unidades de Medida" =>"/"));

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
				'id_unidad_medidad' => $this->input->post('codigo'),
				'nombre' => $this->input->post('nombre')
			);


			if($this->objUnidadesMed->actualizar($datos,array("id_unidad_medidad"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "unidades_medida/");
			#js
			$this->layout->js('js/sistema/unidades_medida/editar.js');

			#title
			$this->layout->title('Editar Unidades de Medida');

			#metas
			$this->layout->setMeta('title','Editar Unidades de Medida');
			$this->layout->setMeta('description','Editar Unidades de Medida');
			$this->layout->setMeta('keywords','Editar Unidades de Medida');

			#contenido
			if($contenido['unidad_medida'] = $this->objUnidadesMed->obtener(array("id_unidad_medidad" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Unidades de Medida "=>"unidades_medida", "Editar Unidades de Medida" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "unidades_medida/");

			#title
			$this->layout->title('Editar Unidades de Medida');

			#metas
			$this->layout->setMeta('title','Editar Unidades de Medida');
			$this->layout->setMeta('description','Editar Unidades de Medida');
			$this->layout->setMeta('keywords','Editar Unidades de Medida');

			//buscando datos de elemento eliminado
			$unidad_eliminado = $this->objUnidadesMed->obtener(array('id_unidad_medidad' => $codigo));

			//borrando el registro
			$this->objUnidadesMed->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'unidades_medida/';
			$config['total_rows'] = count($this->objUnidadesMed->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/unidades_medida'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objUnidadesMed->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $unidad_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['unidades_medida'] = $this->objUnidadesMed->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('unidades_medida',true);

		#Title
		$this->layout->title('Unidades de medida');

		#Metas
		$this->layout->setMeta('title','Unidades de medida');
		$this->layout->setMeta('description','Unidades de medida');
		$this->layout->setMeta('keywords','Unidades de medida');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objUnidadesMed->obtenerUnidadMedida($query);

		$contenido['unidades_medida'] = $this->objUnidadesMed->listar();

		$this->layout->view('index', $contenido);

	}

}
