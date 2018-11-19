<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Cena extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_cena", "objCena");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Cenas');

		#Metas
		$this->layout->setMeta('title','Cenas');
		$this->layout->setMeta('description','Cenas');
		$this->layout->setMeta('keywords','Cenas');

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
		$config['base_url'] = base_url() . 'cena/';
		$config['total_rows'] = count($this->objCena->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/cena'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido['cenas'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'id_cena' => null,
				'receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			//print_r($datos);die();
			
			if($this->objCena->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Cena');

			#metas
			$this->layout->setMeta('title','Agregar Cena');
			$this->layout->setMeta('description','Agregar Cena');
			$this->layout->setMeta('keywords','Agregar Cena');

			#js
			$this->layout->js('js/sistema/cena/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Cenas "=> "cena", "Agregar Cena" =>"/"));

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

			if($this->objCena->actualizar($datos,array("id_cena"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "cena/");
			#js
			$this->layout->js('js/sistema/cena/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Cena');

			#metas
			$this->layout->setMeta('title','Editar Cena');
			$this->layout->setMeta('description','Editar Cena');
			$this->layout->setMeta('keywords','Editar Cena');

			#contenido
			if($contenido['cenas'] = $this->objCena->obtener(array("id_cena" => $codigo)));
			else show_error('');

			$contenido["recetas"]= $this->objRecetas->listar();

			#nav
			$this->layout->nav(array("Cenas "=>"cena", "Editar Cena" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "cena/");

			//buscando datos de elemento eliminado
			$cena_eliminado = $this->objCena->obtener(array('id_cena' => $codigo));

			$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $cena_eliminado->receta));

			//borrando el registro
			$this->objCena->eliminar($codigo);

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
			$config['base_url'] = base_url() . 'cena/';
			$config['total_rows'] = count($this->objCena->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/cena'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['cenas'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('cenas',true);

		#Title
		$this->layout->title('Cenas');

		#Metas
		$this->layout->setMeta('title','Cenas');
		$this->layout->setMeta('description','Cenas');
		$this->layout->setMeta('keywords','Cenas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objCena->obtenerCena($query);

		$contenido['cenas'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

}
