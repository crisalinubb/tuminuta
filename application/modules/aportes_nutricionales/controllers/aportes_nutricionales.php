<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Aportes_nutricionales extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_aportesnutricionales", "objAportesNutricionales");
		$this->load->model("unidades_medida/modelo_unidadesmedida", "objUnidadesMed");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Aportes nutricionales');

		#Metas
		$this->layout->setMeta('title','Aportes nutricionales');
		$this->layout->setMeta('description','Aportes nutricionales');
		$this->layout->setMeta('keywords','Aportes nutricionales');

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
		$config['base_url'] = base_url() . 'aportes_nutricionales/';
		$config['total_rows'] = count($this->objAportesNutricionales->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/aportes_nutricionales'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objAportesNutricionales->listar($where, $pagina, $config['per_page']);

		$contenido['aportes_nutricionales'] = $this->objAportesNutricionales->listar();

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
				'id_aporte_nutricional' => $this->objAportesNutricionales->getLastId(),
				'nombre' => $this->input->post('nombre'),
				'id_unidad_medida' => $this->input->post('unidades_medida')
			);
			
			if($this->objAportesNutricionales->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Aporte nutricional');

			#metas
			$this->layout->setMeta('title','Agregar Aporte nutricional');
			$this->layout->setMeta('description','Agregar Aporte nutricional');
			$this->layout->setMeta('keywords','Agregar Aporte nutricional');

			#js
			$this->layout->js('js/sistema/aportes_nutricionales/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Aportes nutricionales "=> "aportes_nutricionales", "Agregar Aporte nutricional" =>"/"));

			$contenido["unidades_medida"]= $this->objUnidadesMed->listar();

			$this->layout->view('agregar', $contenido);
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
				'id_aporte_nutricional' => $this->objAportesNutricionales->getLastId(),
				'nombre' => $this->input->post('nombre'),
				'id_unidad_medida' => $this->input->post('unidades_medida')
			);

			if($this->objAportesNutricionales->actualizar($datos,array("id_aporte_nutricional"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "aportes_nutricionales/");
			#js
			$this->layout->js('js/sistema/aportes_nutricionales/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Aporte Nutricional');

			#metas
			$this->layout->setMeta('title','Editar Aporte Nutricional');
			$this->layout->setMeta('description','Editar Aporte Nutricional');
			$this->layout->setMeta('keywords','Editar Aporte Nutricional');

			#contenido
			if($contenido['aportes_nutricionales'] = $this->objAportesNutricionales->obtener(array("id_aporte_nutricional" => $codigo)));
			else show_error('');

			$contenido["unidades_medida"]= $this->objUnidadesMed->listar();

			#nav
			$this->layout->nav(array("Aportes Nutricionales "=>"aportes_nutricionales", "Editar Aporte Nutricional" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "aportes_nutricionales/");

			#title
			$this->layout->title('Editar Aporte Nutricional');

			#metas
			$this->layout->setMeta('title','Editar Aporte Nutricional');
			$this->layout->setMeta('description','Editar Aporte Nutricional');
			$this->layout->setMeta('keywords','Editar Aporte Nutricional');

			//buscando datos de elemento eliminado
			$aporte_eliminado = $this->objAportesNutricionales->obtener(array('id_aporte_nutricional' => $codigo));

			//borrando el registro
			$this->objAportesNutricionales->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'aportes_nutricionales/';
			$config['total_rows'] = count($this->objAportesNutricionales->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/aportes_nutricionales'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objAportesNutricionales->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $aporte_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['aportes_nutricionales'] = $this->objAportesNutricionales->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('aportes_nutricionales',true);

		#Title
		$this->layout->title('Aportes nutricionales');

		#Metas
		$this->layout->setMeta('title','Aportes nutricionales');
		$this->layout->setMeta('description','Aportes nutricionales');
		$this->layout->setMeta('keywords','Aportes nutricionales');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objAportesNutricionales->obtenerAportesNutricionales($query);

		$contenido['aportes_nutricionales'] = $this->objAportesNutricionales->listar();

		$this->layout->view('index', $contenido);

	}

}
