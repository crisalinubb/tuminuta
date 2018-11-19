<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Producto extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_producto", "objProducto");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Productos');

		#Metas
		$this->layout->setMeta('title','Productos');
		$this->layout->setMeta('description','Productos');
		$this->layout->setMeta('keywords','Productos');

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
		$config['base_url'] = base_url() . 'producto/';
		$config['total_rows'] = count($this->objProducto->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/producto'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objProducto->listar($where, $pagina, $config['per_page']);

		$contenido['productos'] = $this->objProducto->listar();

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('producto', 'Producto', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'id_producto' => null,
				'nombre_producto' => $this->input->post('producto')
			);
			
			if($this->objProducto->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Producto');

			#metas
			$this->layout->setMeta('title','Agregar Producto');
			$this->layout->setMeta('description','Agregar Producto');
			$this->layout->setMeta('keywords','Agregar Producto');

			#js
			$this->layout->js('js/sistema/producto/agregar.js');

			#nav
			$this->layout->nav(array("Productos "=> "producto", "Agregar Producto" =>"/"));

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('producto', 'Producto', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'nombre_producto' => $this->input->post('producto')
			);

			if($this->objProducto->actualizar($datos,array("id_producto"=>$this->input->post('producto')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "producto/");
			#js
			$this->layout->js('js/sistema/producto/editar.js');

			#title
			$this->layout->title('Editar Producto');

			#metas
			$this->layout->setMeta('title','Editar Producto');
			$this->layout->setMeta('description','Editar Producto');
			$this->layout->setMeta('keywords','Editar Producto');

			#contenido
			if($contenido['producto'] = $this->objProducto->obtener(array("id_producto" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Producto "=>"producto", "Editar Producto" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "producto/");

			#Title
			$this->layout->title('Productos');

			#Metas
			$this->layout->setMeta('title','Productos');
			$this->layout->setMeta('description','Productos');
			$this->layout->setMeta('keywords','Productos');

			//buscando datos de elemento eliminado
			$producto_eliminado = $this->objProducto->obtener(array('id_producto' => $codigo));

			//borrando el registro
			$this->objProducto->eliminar($codigo);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'producto/';
			$config['total_rows'] = count($this->objProducto->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/producto'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objProducto->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $producto_eliminado->nombre_producto." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['productos'] = $this->objProducto->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('productos',true);

		#Title
		$this->layout->title('Productos');

		#Metas
		$this->layout->setMeta('title','Productos');
		$this->layout->setMeta('description','Productos');
		$this->layout->setMeta('keywords','Productos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objProducto->obtenerProducto($query);

		$contenido['productos'] = $this->objProducto->listar();

		$this->layout->view('index', $contenido);

	}

}
