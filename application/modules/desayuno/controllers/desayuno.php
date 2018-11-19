<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Desayuno extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_desayuno", "objDesayuno");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("recetas/modelo_tiporeceta", "objTiporeceta");
		$this->load->model("detalle_codigo/modelo_detallecodigo", "objDetalle");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Desayunos');

		#Metas
		$this->layout->setMeta('title','Desayunos');
		$this->layout->setMeta('description','Desayunos');
		$this->layout->setMeta('keywords','Desayunos');

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
		$config['base_url'] = base_url() . 'desayuno/';
		$config['total_rows'] = count($this->objDesayuno->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/desayuno'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'id_desayuno' => null,
				'id_receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			//print_r($datos);die();
			
			if($this->objDesayuno->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Desayuno');

			#metas
			$this->layout->setMeta('title','Agregar Desayuno');
			$this->layout->setMeta('description','Agregar Desayuno');
			$this->layout->setMeta('keywords','Agregar Desayuno');

			#js
			$this->layout->js('js/sistema/desayuno/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Desayunos "=> "desayuno", "Agregar Desayuno" =>"/"));

			//$contenido["recetas"]= $this->objRecetas->listar();
			$contenido["regimenes"]= $this->objRegimen->listar();

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
				'id_receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objDesayuno->actualizar($datos,array("id_desayuno"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "desayuno/");
			#js
			$this->layout->js('js/sistema/desayuno/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Desayuno');

			#metas
			$this->layout->setMeta('title','Editar Desayuno');
			$this->layout->setMeta('description','Editar Desayuno');
			$this->layout->setMeta('keywords','Editar Desayuno');

			#contenido
			if($contenido['desayunos'] = $this->objDesayuno->obtener(array("id_desayuno" => $codigo)));
			else show_error('');

			$contenido["recetas"]= $this->objRecetas->listar();

			#nav
			$this->layout->nav(array("Desayuno "=>"desayuno", "Editar Desayuno" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "desayuno/");

			//buscando datos de elemento eliminado
			$desayuno_eliminado = $this->objDesayuno->obtener(array('id_desayuno' => $codigo));

			$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $desayuno_eliminado->id_receta));

			//borrando el registro
			$this->objDesayuno->eliminar($codigo);

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
			$config['base_url'] = base_url() . 'desayuno/';
			$config['total_rows'] = count($this->objDesayuno->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/desayuno'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('desayunos',true);

		#Title
		$this->layout->title('Desayunos');

		#Metas
		$this->layout->setMeta('title','Desayunos');
		$this->layout->setMeta('description','Desayunos');
		$this->layout->setMeta('keywords','Desayunos');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objDesayuno->obtenerDesayuno($query);

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

	public function buscar_recetas(){
		$contenido['datos'] = $this->objDesayuno->obtener_recetas_por_regimen($this->input->post('codigo_regimen'));

		#title
			$this->layout->title('Agregar Desayuno');

			#metas
			$this->layout->setMeta('title','Agregar Desayuno');
			$this->layout->setMeta('description','Agregar Desayuno');
			$this->layout->setMeta('keywords','Agregar Desayuno');

			#js
			$this->layout->js('js/sistema/desayuno/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Desayunos "=> "desayuno", "Agregar Desayuno" =>"/"));

		$contenido["regimenes"]= $this->objRegimen->listar();

		$contenido['regimen_select'] = $this->input->post('codigo_regimen');

		$this->layout->view('agregar', $contenido);
	}

	public function agregar_receta($codigo_receta = false){
		#title
			$this->layout->title('Agregar Desayuno');

			#metas
			$this->layout->setMeta('title','Agregar Desayuno');
			$this->layout->setMeta('description','Agregar Desayuno');
			$this->layout->setMeta('keywords','Agregar Desayuno');

			#js
			$this->layout->js('js/sistema/desayuno/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Desayunos "=> "desayuno", "Agregar Desayuno" =>"/"));
		
		//verificar si ya esta ingresada la receta en el menu
		$verificar = $this->objDesayuno->obtener(array('id_receta' => $codigo_receta, 'id_unidad' => $this->session->userdata("usuario")->id_unidad));
		if(!$verificar){

			$recetas_insertar = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$datos = array(
				'id_desayuno' => null,
				'id_receta' => $recetas_insertar->id_receta,
				'receta_nombre' => $recetas_insertar->nombre,
				'regimen' => $recetas_insertar->id_regimen,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
				//'desayuno_receta' => 1,
				//'desayuno_detallecodigo' => 0
			);

			$this->objDesayuno->insertar($datos);

			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $recetas_insertar->id_regimen;
			$contenido['mesagge'] = $recetas_insertar->nombre." receta ingresada correctamente";
			$contenido['datos'] = $this->objDesayuno->obtener_recetas_por_regimen($recetas_insertar->id_regimen);
			$this->layout->view('agregar', $contenido);

		}else{

			$regimen = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $regimen->id_regimen;
			$contenido['mesagge'] = $regimen->nombre." ya ingresada como desayuno";

			$contenido['datos'] = $this->objDesayuno->obtener_recetas_por_regimen($regimen->id_regimen);
			$this->layout->view('agregar', $contenido);
		}

	}

	public function agregar_detalle_codigo(){
		#title
		$this->layout->title('Agregar Detalle Codigo');

		#metas
		$this->layout->setMeta('title','Agregar Detalle Codigo');
		$this->layout->setMeta('description','Agregar Detalle Codigo');
		$this->layout->setMeta('keywords','Agregar Detalle Codigo');

		#js
		$this->layout->js('js/sistema/desayuno/agregar.js');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#nav
		$this->layout->nav(array("Desayunos "=> "desayuno", "Agregar Detalle Codigo" =>"/"));

		$contenido['datos']= $this->objDetalle->listar();

		$this->layout->view('agregar_detalle_codigo', $contenido);
	}

	public function agregar_detalle($codigo_detalle = false){
		#title
		$this->layout->title('Agregar Detalle Codigo');

		#metas
		$this->layout->setMeta('title','Agregar Detalle Codigo');
		$this->layout->setMeta('description','Agregar Detalle Codigo');
		$this->layout->setMeta('keywords','Agregar Detalle Codigo');

		#js
		$this->layout->js('js/sistema/desayuno/agregar.js');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#nav
		$this->layout->nav(array("Desayunos "=> "desayuno", "Agregar Detalle Codigo" =>"/"));
		
		//verificar si ya esta ingresada el detalle en el menu
		$verificar = $this->objDesayuno->obtener(array('receta' => $codigo_detalle, 'id_unidad' => $this->session->userdata("usuario")->id_unidad, 'desayuno_detallecodigo' => 1));
		if(!$verificar){

			$detalle_insertar = $this->objDetalle->obtener(array('id_detallecodigo' => $codigo_detalle));
			$datos = array(
				'id_desayuno' => null,
				'receta' => $detalle_insertar->id_detallecodigo,
				'receta_nombre' => $detalle_insertar->nombre,
				'regimen' => null,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad,
				'desayuno_receta' => 0,
				'desayuno_detallecodigo' => 1
			);

			$this->objDesayuno->insertar($datos);

			$contenido['mesagge'] = $detalle_insertar->nombre." detalle codigo ingresado correctamente";
			$contenido['datos']= $this->objDetalle->listar();
			$this->layout->view('agregar_detalle_codigo', $contenido);

		}else{

			$detalle = $this->objDetalle->obtener(array('id_detallecodigo' => $codigo_detalle));
			
			$contenido['mesagge'] = $detalle->nombre." ya ingresada como desayuno";

			$contenido['datos']= $this->objDetalle->listar();
			$this->layout->view('agregar_detalle_codigo', $contenido);
		}

	}

}
