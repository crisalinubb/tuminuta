<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Proveedor extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_proveedor", "objProveedor");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Proveedores');

		#Metas
		$this->layout->setMeta('title','Proveedores');
		$this->layout->setMeta('description','Proveedores');
		$this->layout->setMeta('keywords','Proveedores');

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
			$where = "nombre_proveedor like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'proveedor/';
		$config['total_rows'] = count($this->objProveedor->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/proveedor'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objProveedor->listar($where, $pagina, $config['per_page']);

		$contenido['proveedores'] = $this->objProveedor->listar();

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
				'id_proveedor' => null,
				'nombre_proveedor' => $this->input->post('nombre'),
				'direccion' => $this->input->post('direccion'),
				'telefono' => $this->input->post('telefono')
			);
			
			if($this->objProveedor->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Proveedores');

			#metas
			$this->layout->setMeta('title','Agregar Proveedores');
			$this->layout->setMeta('description','Agregar Proveedores');
			$this->layout->setMeta('keywords','Agregar Proveedores');

			#js
			$this->layout->js('js/sistema/proveedor/agregar.js');

			#nav
			$this->layout->nav(array("Proveedores "=> "proveedor", "Agregar Proveedores" =>"/"));

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
				'nombre_proveedor' => $this->input->post('nombre'),
				'direccion' => $this->input->post('direccion'),
				'telefono' => $this->input->post('telefono')
			);

			if($this->objProveedor->actualizar($datos,array("id_proveedor"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "proveedor/");
			#js
			$this->layout->js('js/sistema/proveedor/editar.js');

			#title
			$this->layout->title('Editar Proveedores');

			#metas
			$this->layout->setMeta('title','Editar Proveedores');
			$this->layout->setMeta('description','Editar Proveedores');
			$this->layout->setMeta('keywords','Editar Proveedores');

			#contenido
			if($contenido['proveedor'] = $this->objProveedor->obtener(array("id_proveedor" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Proveedores "=>"proveedor", "Editar Proveedores" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "proveedor/");

			#title
			$this->layout->title('Editar Proveedores');

			#metas
			$this->layout->setMeta('title','Editar Proveedores');
			$this->layout->setMeta('description','Editar Proveedores');
			$this->layout->setMeta('keywords','Editar Proveedores');

			//buscando datos de elemento eliminado
			$proveedor_eliminado = $this->objProveedor->obtener(array('id_proveedor' => $codigo));

			//borrando el registro
			$this->objProveedor->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'proveedor/';
			$config['total_rows'] = count($this->objProveedor->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/proveedor'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objProveedor->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $proveedor_eliminado->proveedor_nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['proveedores'] = $this->objProveedor->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('proveedores',true);

		#Title
		$this->layout->title('Proveedores');

		#Metas
		$this->layout->setMeta('title','Proveedores');
		$this->layout->setMeta('description','Proveedores');
		$this->layout->setMeta('keywords','Proveedores');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objProveedor->obtenerProveedor($query);

		$contenido['proveedores'] = $this->objProveedor->listar();

		$this->layout->view('index', $contenido);

	}
}
