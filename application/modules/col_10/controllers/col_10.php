<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Col_10 extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_col10", "objCol10");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("recetas/modelo_tiporeceta", "objTiporeceta");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Colacion de las 10');

		#Metas
		$this->layout->setMeta('title','Colacion de las 10');
		$this->layout->setMeta('description','Colacion de las 10');
		$this->layout->setMeta('keywords','Colacion de las 10');

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
		$config['base_url'] = base_url() . 'col_10/';
		$config['total_rows'] = count($this->objCol10->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/col_10'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido['col_10'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'id_col10' => null,
				'receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			//print_r($datos);die();
			
			if($this->objCol10->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Colacion de las 10');

			#metas
			$this->layout->setMeta('title','Agregar Colacion de las 10');
			$this->layout->setMeta('description','Agregar Colacion de las 10');
			$this->layout->setMeta('keywords','Agregar Colacion de las 10');

			#js
			$this->layout->js('js/sistema/col_10/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Colaciones de las 10 "=> "col_10", "Agregar Colacion de las 10" =>"/"));

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
				'receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objCol10->actualizar($datos,array("id_col10"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "col_10/");
			#js
			$this->layout->js('js/sistema/col_10/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Colacion de las 10');

			#metas
			$this->layout->setMeta('title','Editar Colacion de las 10');
			$this->layout->setMeta('description','Editar Colacion de las 10');
			$this->layout->setMeta('keywords','Editar Colacion de las 10');

			#contenido
			if($contenido['col10'] = $this->objCol10->obtener(array("id_col10" => $codigo)));
			else show_error('');

			//$contenido["recetas"]= $this->objRecetas->listar();
			$contenido["regimenes"]= $this->objRegimen->listar();

			#nav
			$this->layout->nav(array("Colaciones de las 10 "=>"col_10", "Editar Colacion de las 10" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "col_10/");

			//buscando datos de elemento eliminado
			$col10_eliminado = $this->objCol10->obtener(array('id_col10' => $codigo));

			$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $col10_eliminado->receta));

			//borrando el registro
			$this->objCol10->eliminar($codigo);

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
			$config['base_url'] = base_url() . 'col_10/';
			$config['total_rows'] = count($this->objCol10->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/col_10'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['col_10'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('col_10',true);

		#Title
		$this->layout->title('Colacion de las 10');

		#Metas
		$this->layout->setMeta('title','Colacion de las 10');
		$this->layout->setMeta('description','Colacion de las 10');
		$this->layout->setMeta('keywords','Colacion de las 10');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objCol10->obtenerCol10($query);

		$contenido['col_10'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

	public function buscar_recetas(){
		$contenido['datos'] = $this->objCol10->obtener_recetas_por_regimen($this->input->post('codigo_regimen'));

		#title
		$this->layout->title('Agregar Colacion de las 10');

		#metas
		$this->layout->setMeta('title','Agregar Colacion de las 10');
		$this->layout->setMeta('description','Agregar Colacion de las 10');
		$this->layout->setMeta('keywords','Agregar Colacion de las 10');

		#js
		$this->layout->js('js/sistema/col_10/agregar.js');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#nav
		$this->layout->nav(array("Colaciones de las 10 "=> "col_10", "Agregar Colacion de las 10" =>"/"));

		$contenido["regimenes"]= $this->objRegimen->listar();

		$contenido['regimen_select'] = $this->input->post('codigo_regimen');

		$this->layout->view('agregar', $contenido);
	}

	public function agregar_receta($codigo_receta = false){
		#title
		$this->layout->title('Agregar Colacion de las 10');

		#metas
		$this->layout->setMeta('title','Agregar Colacion de las 10');
		$this->layout->setMeta('description','Agregar Colacion de las 10');
		$this->layout->setMeta('keywords','Agregar Colacion de las 10');

		#js
		$this->layout->js('js/sistema/col_10/agregar.js');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#nav
		$this->layout->nav(array("Colaciones de las 10 "=> "col_10", "Agregar Colacion de las 10" =>"/"));
		
		//verificar si ya esta ingresada la receta en el menu
		$verificar = $this->objCol10->obtener(array('receta' => $codigo_receta, 'id_unidad' => $this->session->userdata("usuario")->id_unidad ));
		if(!$verificar){

			$recetas_insertar = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$datos = array(
				'id_col10' => null,
				'receta' => $recetas_insertar->id_receta,
				'receta_nombre' => $recetas_insertar->nombre,
				'regimen' => $recetas_insertar->id_regimen,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			$this->objCol10->insertar($datos);

			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $recetas_insertar->id_regimen;
			$contenido['mesagge'] = $recetas_insertar->nombre." receta ingresada correctamente";
			$contenido['datos'] = $this->objCol10->obtener_recetas_por_regimen($recetas_insertar->id_regimen);
			$this->layout->view('agregar', $contenido);

		}else{

			$regimen = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $regimen->id_regimen;
			$contenido['mesagge'] = $regimen->nombre." ya ingresada como colacion de las 10";

			$contenido['datos'] = $this->objCol10->obtener_recetas_por_regimen($regimen->id_regimen);
			$this->layout->view('agregar', $contenido);
		}

	}

}
