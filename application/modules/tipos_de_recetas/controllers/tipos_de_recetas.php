<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Tipos_de_recetas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_tiporecetas", "objTiporecetas");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Tipo de Recetas');

		#Metas
		$this->layout->setMeta('title','Tipo de Recetas');
		$this->layout->setMeta('description','Tipo de Recetas');
		$this->layout->setMeta('keywords','Tipo de Recetas');

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
		$config['base_url'] = base_url() . 'tipos_recetas/';
		$config['total_rows'] = count($this->objTiporecetas->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/tipos_recetas'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objTiporecetas->listar($where, $pagina, $config['per_page']);

		$contenido['tipos_de_recetas'] = $this->objTiporecetas->listar();

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
				'id_tipo_receta' => null,
				'nombre' => $this->input->post('nombre')
			);
			
			if($this->objTiporecetas->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Tipo de Receta');

			#metas
			$this->layout->setMeta('title','Agregar Tipo de Receta');
			$this->layout->setMeta('description','Agregar Tipo de Receta');
			$this->layout->setMeta('keywords','Agregar Tipo de Receta');

			#js
			$this->layout->js('js/sistema/tipos_de_recetas/agregar.js');

			#nav
			$this->layout->nav(array("Tipo de Receta "=> "tipos_de_recetas", "Agregar Tipo de Receta" =>"/"));

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

			if($this->objTiporecetas->actualizar($datos,array("id_tipo_receta"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "tipos_de_recetas/");
			#js
			$this->layout->js('js/sistema/tipos_de_recetas/editar.js');

			#title
			$this->layout->title('Editar Tipo de Receta');

			#metas
			$this->layout->setMeta('title','Editar Tipo de Receta');
			$this->layout->setMeta('description','Editar Tipo de Receta');
			$this->layout->setMeta('keywords','Editar Tipo de Receta');

			#contenido
			if($contenido['tipos_recetas'] = $this->objTiporecetas->obtener(array("id_tipo_receta" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Tipo de recetas "=>"tipos_de_recetas", "Editar Tipo de Receta" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "tipos_de_recetas/");

			//buscando datos de elemento eliminado
			$tiporeceta_eliminado = $this->objTiporecetas->obtener(array('id_tipo_receta' => $codigo));

			//borrando el registro
			$this->objTiporecetas->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'tipos_de_recetas/';
			$config['total_rows'] = count($this->objTiporecetas->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/tipos_de_recetas'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objTiporecetas->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $tiporeceta_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['tipos_de_recetas'] = $this->objTiporecetas->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('tipos_de_recetas',true);

		#Title
		$this->layout->title('Tipo de Recetas');

		#Metas
		$this->layout->setMeta('title','Tipo de Recetas');
		$this->layout->setMeta('description','Tipo de Recetas');
		$this->layout->setMeta('keywords','Tipo de Recetas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objTiporecetas->obtenerTiposRecetas($query);

		$contenido['tipos_de_recetas'] = $this->objTiporecetas->listar();

		$this->layout->view('index', $contenido);

	}

}
