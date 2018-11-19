<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Almuerzo extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_almuerzo", "objAlmuerzo");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Almuerzos');

		#Metas
		$this->layout->setMeta('title','Almuerzos');
		$this->layout->setMeta('description','Almuerzos');
		$this->layout->setMeta('keywords','Almuerzos');

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
		$config['base_url'] = base_url() . 'almuerzo/';
		$config['total_rows'] = count($this->objAlmuerzo->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/almuerzo'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido['almuerzos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			//$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			//$this->form_validation->set_message('required', '* %s es obligatorio');
			//$this->form_validation->set_error_delimiters('<div>','</div>');

			//if(!$this->form_validation->run()){
			//	echo json_encode(array("result"=>false,"msg"=>validation_errors()));
			//	exit;
			//}
			$receta = $this->objRecetas->obtener(array('id_receta' => $this->input->post('codigo_receta')));

			$datos = array(
				'id_almuerzo' => null,
				'receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			//print_r($datos);die();
			
			if($this->objAlmuerzo->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Almuerzo');

			#metas
			$this->layout->setMeta('title','Agregar Almuerzo');
			$this->layout->setMeta('description','Agregar Almuerzo');
			$this->layout->setMeta('keywords','Agregar Almuerzo');

			#js
			$this->layout->js('js/sistema/almuerzo/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Almuerzos "=> "almuerzo", "Agregar Almuerzo" =>"/"));

			$contenido["recetas"]= $this->objRecetas->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			//$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			//$this->form_validation->set_message('required', '* %s es obligatorio');
			//$this->form_validation->set_error_delimiters('<div>','</div>');

			//if(!$this->form_validation->run()){
			//	echo json_encode(array("result"=>false,"msg"=>validation_errors()));
			//	exit;
			//}
			$receta = $this->objRecetas->obtener(array('id_receta' => $this->input->post('codigo_receta')));
			
			$datos = array(
				'receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objAlmuerzo->actualizar($datos,array("id_almuerzo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "almuerzo/");
			#js
			$this->layout->js('js/sistema/almuerzo/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Almuerzo');

			#metas
			$this->layout->setMeta('title','Editar Almuerzo');
			$this->layout->setMeta('description','Editar Almuerzo');
			$this->layout->setMeta('keywords','Editar Almuerzo');

			#contenido
			if($contenido['almuerzos'] = $this->objAlmuerzo->obtener(array("id_almuerzo" => $codigo)));
			else show_error('');

			$contenido["recetas"]= $this->objRecetas->listar();

			#nav
			$this->layout->nav(array("Desayuno "=>"desayuno", "Editar Desayuno" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "almuerzo/");

			//buscando datos de elemento eliminado
			$almuerzo_eliminado = $this->objAlmuerzo->obtener(array('id_almuerzo' => $codigo));

			$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $almuerzo_eliminado->receta));

			//borrando el registro
			$this->objAlmuerzo->eliminar($codigo);

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
			$config['base_url'] = base_url() . 'almuerzo/';
			$config['total_rows'] = count($this->objAlmuerzo->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/almuerzo'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['almuerzos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('almuerzos',true);

		#Title
		$this->layout->title('Almuerzos');

		#Metas
		$this->layout->setMeta('title','Almuerzos');
		$this->layout->setMeta('description','Almuerzos');
		$this->layout->setMeta('keywords','Almuerzos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objAlmuerzo->obtenerAlmuerzo($query);

		$contenido['almuerzos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

}
