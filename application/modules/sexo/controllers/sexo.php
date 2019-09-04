<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Sexo extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_sexo", "objSexo");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Sexos');

		#Metas
		$this->layout->setMeta('title','Sexos');
		$this->layout->setMeta('description','Sexos');
		$this->layout->setMeta('keywords','Sexos');

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
		$config['base_url'] = base_url() . 'sexo/';
		$config['total_rows'] = count($this->objSexo->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/sexo'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objSexo->listar($where, $pagina, $config['per_page']);

		$contenido['sexos'] = $this->objSexo->listar();

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
				'id_sexo' => null,
				'sexo_nombre' => $this->input->post('nombre')
			);
			
			if($this->objSexo->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Sexo');

			#metas
			$this->layout->setMeta('title','Agregar Sexo');
			$this->layout->setMeta('description','Agregar Sexo');
			$this->layout->setMeta('keywords','Agregar Sexo');

			#js
			$this->layout->js('js/sistema/sexo/agregar.js');

			#nav
			$this->layout->nav(array("Sexo "=> "sexo", "Agregar Sexo" =>"/"));

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
				'sexo_nombre' => $this->input->post('nombre')
			);

			if($this->objSexo->actualizar($datos,array("id_sexo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "sexo/");
			#js
			$this->layout->js('js/sistema/sexo/editar.js');

			#title
			$this->layout->title('Editar Sexo');

			#metas
			$this->layout->setMeta('title','Editar Sexo');
			$this->layout->setMeta('description','Editar Sexo');
			$this->layout->setMeta('keywords','Editar Sexo');

			#contenido
			if($contenido['sexo'] = $this->objSexo->obtener(array("id_sexo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Sexo "=>"sexo", "Editar Sexo" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "sexo/");

			//buscando datos de elemento eliminado
			$sexo_eliminado = $this->objSexo->obtener(array('id_sexo' => $codigo));

			//borrando el registro
			$this->objSexo->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'sexo/';
			$config['total_rows'] = count($this->objSexo->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/sexo'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objSexo->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $sexo_eliminado->sexo_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['sexos'] = $this->objSexo->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('sexos',true);

		#Title
		$this->layout->title('Sexos');

		#Metas
		$this->layout->setMeta('title','Sexos');
		$this->layout->setMeta('description','Sexos');
		$this->layout->setMeta('keywords','Sexos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objSexo->obtenerSexo($query);

		$contenido['sexos'] = $this->objSexo->listar();

		$this->layout->view('index', $contenido);

	}

  	public function prueba(){
  		$this->layout->view('prueba');
  	}

  	public function prueba_td(){
  		$sexo = $this->objSexo->obtener(array('id_sexo' => 1));
  		//print_r("aaaaaaa");die();
  		$arr = array();
  		$arr['msg1'] = $sexo->id_sexo;
  		$arr['msg2'] = $sexo->sexo_nombre; 		
  		
		echo json_encode($arr);
  	}

}
