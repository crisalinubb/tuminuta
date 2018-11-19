<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Insumos extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_insumos", "objInsumo");
		$this->load->model("rubros/modelo_rubro", "objRubro");
		$this->load->model("unidades_medida/modelo_unidadesmedida", "objUnidadesMed");
		$this->load->model("proveedor/modelo_proveedor", "objProveedor");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Insumos');

		#Metas
		$this->layout->setMeta('title','Insumos');
		$this->layout->setMeta('description','Insumos');
		$this->layout->setMeta('keywords','Insumos');

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
		$config['base_url'] = base_url() . 'insumos/';
		$config['total_rows'] = count($this->objInsumo->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/insumos'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objInsumo->listar($where, $pagina, $config['per_page']);

		$contenido['insumos'] = $this->objInsumo->listar();

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
				'id_insumo' => null,
				'codigo' => $this->input->post('codigo'),
				'nombre' => $this->input->post('nombre'),
				'id_rubro' => $this->input->post('codigo_rubro'),
				'id_unidad_medida' => $this->input->post('codigo_unidadmedida'),
				'perecible' => $this->input->post('perecible'),
				'factor_pedido' => $this->input->post('factor_pedido'),
				'costo' => $this->input->post('costo'),
				'id_proveedor' => $this->input->post('codigo_proveedor'),
				'factor_costo' => $this->input->post('factor_costo')
			);
			
			if($this->objInsumo->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Insumo');

			#metas
			$this->layout->setMeta('title','Agregar Insumo');
			$this->layout->setMeta('description','Agregar Insumo');
			$this->layout->setMeta('keywords','Agregar Insumo');

			#js
			$this->layout->js('js/sistema/insumos/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Insumos "=> "insumos", "Agregar Insumo" =>"/"));

			$contenido["unidades_medidas"]= $this->objUnidadesMed->listar();
			$contenido["rubros"]= $this->objRubro->listar();
			$contenido["proveedores"]= $this->objProveedor->listar();

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
				'codigo' => $this->input->post('codigo_insumo'),
				'nombre' => $this->input->post('nombre'),
				'id_rubro' => $this->input->post('codigo_rubro'),
				'id_unidad_medida' => $this->input->post('codigo_unidadmedida'),
				'perecible' => $this->input->post('perecible'),
				'factor_pedido' => $this->input->post('factor_pedido'),
				'costo' => $this->input->post('costo'),
				'id_proveedor' => $this->input->post('codigo_proveedor'),
				'factor_costo' => $this->input->post('factor_costo')
			);

			if($this->objInsumo->actualizar($datos,array("id_insumo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "insumos/");
			#js
			$this->layout->js('js/sistema/insumos/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Insumo');

			#metas
			$this->layout->setMeta('title','Editar Insumo');
			$this->layout->setMeta('description','Editar Insumo');
			$this->layout->setMeta('keywords','Editar Insumo');

			#contenido
			if($contenido['insumos'] = $this->objInsumo->obtener(array("id_insumo" => $codigo)));
			else show_error('');

			$contenido["unidades_medidas"]= $this->objUnidadesMed->listar();
			$contenido["rubros"]= $this->objRubro->listar();
			$contenido["proveedores"]= $this->objProveedor->listar();

			#nav
			$this->layout->nav(array("Insumos "=>"insumos", "Editar Insumos" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "insumos/");

			//buscando datos de elemento eliminado
			$insumo_eliminado = $this->objInsumo->obtener(array('id_insumo' => $codigo));

			//borrando el registro
			$this->objInsumo->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'insumos/';
			$config['total_rows'] = count($this->objInsumo->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/insumos'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objInsumo->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $insumo_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['insumos'] = $this->objInsumo->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('insumos',true);

		#Title
		$this->layout->title('Insumos');

		#Metas
		$this->layout->setMeta('title','Insumos');
		$this->layout->setMeta('description','Insumos');
		$this->layout->setMeta('keywords','Insumos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objInsumo->obtenerInsumos($query);

		$contenido['insumos'] = $this->objInsumo->listar();

		$this->layout->view('index', $contenido);
	}

}
