<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Detalle_codigo extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_detallecodigo", "objDetalle");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("recetas/modelo_tiporeceta", "objTiporeceta");
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Detalle Codigo');

		#Metas
		$this->layout->setMeta('title','Detalle Codigo');
		$this->layout->setMeta('description','Detalle Codigo');
		$this->layout->setMeta('keywords','Detalle Codigo');

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
		$config['base_url'] = base_url() . 'detalle_codigo/';
		$config['total_rows'] = count($this->objDetalle->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/detalle_codigo'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objDetalle->listar($where, $pagina, $config['per_page']);

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
				'id_detallecodigo' => null,
				'nombre' => $this->input->post('nombre')
			);
			
			if($this->objDetalle->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;		
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#Title
			$this->layout->title('Agregar Detalle Codigo');

			#Metas
			$this->layout->setMeta('title','Agregar Detalle Codigo');
			$this->layout->setMeta('description','Agregar Detalle Codigo');
			$this->layout->setMeta('keywords','Agregar Detalle Codigo');

			#js
			$this->layout->js('js/sistema/detalle_codigo/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Agregar Detalle codigo" =>"/"));

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

			if($this->objDetalle->actualizar($datos,array("id_detallecodigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;	

			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "detalle_codigo/");
			#js
			$this->layout->js('js/sistema/detalle_codigo/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Detalle Codigo');

			#metas
			$this->layout->setMeta('title','Editar Detalle Codigo');
			$this->layout->setMeta('description','Editar Detalle Codigo');
			$this->layout->setMeta('keywords','Editar Detalle Codigo');

			#contenido
			if($contenido['detalle_codigo'] = $this->objDetalle->obtener(array("id_detallecodigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Detalle Codigo "=>"detalle_codigo", "Editar Detalle Codigo" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "detalle_codigo/");

			//buscando datos de elemento eliminado
			$detallecodigo_eliminado = $this->objDetalle->obtener(array('id_detallecodigo' => $codigo));

			//borrando el registro
			$this->objDetalle->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'detalle_codigo/';
			$config['total_rows'] = count($this->objDetalle->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/detalle_codigo'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objDetalle->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $detallecodigo_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();

			$this->layout->view('index', $contenido);
	}

	public function ver_recetas($codigo_detalle = false){
		#Title
		$this->layout->title('Ver Recetas');

		#Metas
		$this->layout->setMeta('title','Ver Recetas');
		$this->layout->setMeta('description','Ver Recetas');
		$this->layout->setMeta('keywords','Ver Recetas');

		$contenido['datos'] = $this->objDetalle->obtener_recetas($codigo_detalle);
		$contenido['codigo_detalle'] = $codigo_detalle;

		$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Ver Receta" =>"/"));

		$this->layout->view('ver_recetas', $contenido);
	}

	public function agregar_receta($codigo_detalle){
			#title
			$this->layout->title('Agregar Receta');

			#metas
			$this->layout->setMeta('title','Agregar Receta');
			$this->layout->setMeta('description','Agregar Receta');
			$this->layout->setMeta('keywords','Agregar Receta');

			#js
			//$this->layout->js('js/sistema/desayuno/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['codigo_detalle'] = $codigo_detalle;

			$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Agregar Receta" =>"/"));

			$this->layout->view('agregar_receta', $contenido);
		}

		public function buscar_recetas(){
		$contenido['datos'] = $this->objDetalle->obtener_recetas_por_regimen($this->input->post('codigo_regimen'));

		#title
			$this->layout->title('Agregar Desayuno');

			#metas
			$this->layout->setMeta('title','Agregar Desayuno');
			$this->layout->setMeta('description','Agregar Desayuno');
			$this->layout->setMeta('keywords','Agregar Desayuno');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido["regimenes"]= $this->objRegimen->listar();

		$contenido['regimen_select'] = $this->input->post('codigo_regimen');
		$contenido['codigo_detalle'] = $this->input->post('codigo');

		$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Agregar Receta" =>"/"));

		$this->layout->view('agregar_receta', $contenido);
	}

	public function agregar_receta_detallecodigo($codigo_receta = false, $codigo_detalle = false){
		#title
			$this->layout->title('Agregar Receta');

			#metas
			$this->layout->setMeta('title','Agregar Receta');
			$this->layout->setMeta('description','Agregar Receta');
			$this->layout->setMeta('keywords','Agregar Receta');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		
		//verificar si ya esta ingresada la receta en el menu
		$verificar = $this->objDetalle->obtener_detalle_receta($codigo_receta, $codigo_detalle);
		if($verificar->num_rows() == 0){

			$recetas_insertar = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$datos = array(
				'id_recetacodigo' => null,
				'id_receta' => $codigo_receta,
				'id_detallecodigo' => $codigo_detalle
			);

			$this->objDetalle->insertar_detalle_receta($datos);

			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $recetas_insertar->id_regimen;
			$contenido['mesagge'] = $recetas_insertar->nombre." receta ingresada correctamente";
			$contenido['datos'] = $this->objDetalle->obtener_recetas_por_regimen($recetas_insertar->id_regimen);
			$contenido['codigo_detalle'] = $codigo_detalle;

			$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Agregar Receta" =>"/"));

			$this->layout->view('agregar_receta', $contenido);

		}else{

			$regimen = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $regimen->id_regimen;
			$contenido['mesagge'] = $regimen->nombre." ya agregada";

			$contenido['datos'] = $this->objDetalle->obtener_recetas_por_regimen($regimen->id_regimen);
			$contenido['codigo_detalle'] = $codigo_detalle;

			$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Agregar Receta" =>"/"));

			$this->layout->view('agregar_receta', $contenido);
		}

	}

	public function eliminar_receta($codigo_receta_detalle = false){
		#Title
		$this->layout->title('Ver Recetas');

		#Metas
		$this->layout->setMeta('title','Ver Recetas');
		$this->layout->setMeta('description','Ver Recetas');
		$this->layout->setMeta('keywords','Ver Recetas');

		$id_detalle =  $this->objDetalle->obtener_detalle_receta_por_reetadetalle($codigo_receta_detalle);

		$this->objDetalle->eliminar_receta_codigo($codigo_receta_detalle);

		$contenido['datos'] = $this->objDetalle->obtener_recetas($id_detalle->id_detallecodigo);
		$contenido['codigo_detalle'] = $id_detalle->id_detallecodigo;

		$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $id_detalle->id_receta));

		$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

		$this->layout->nav(array("Detalle codigo "=> "detalle_codigo", "Ver Receta" =>"/"));

		$this->layout->view('ver_recetas', $contenido);
	}
}
