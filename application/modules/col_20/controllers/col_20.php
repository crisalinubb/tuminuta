<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Col_20 extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_col20", "objCol20");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("recetas/modelo_tiporeceta", "objTiporeceta");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Colacion de las 20');

		#Metas
		$this->layout->setMeta('title','Colacion de las 20');
		$this->layout->setMeta('description','Colacion de las 20');
		$this->layout->setMeta('keywords','Colacion de las 20');

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
		$config['base_url'] = base_url() . 'col_20/';
		$config['total_rows'] = count($this->objCol20->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/col_20'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'id_col20' => null,
				'receta' => $this->input->post('codigo_receta'),
				'receta_nombre' => $receta->nombre,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad 
			);

			//print_r($datos);die();
			
			if($this->objCol20->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Colacion de las 20');

			#metas
			$this->layout->setMeta('title','Agregar Colacion de las 20');
			$this->layout->setMeta('description','Agregar Colacion de las 20');
			$this->layout->setMeta('keywords','Agregar Colacion de las 20');

			#js
			$this->layout->js('js/sistema/col_20/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Colaciones de las 20 "=> "col_20", "Agregar Colacion de las 20" =>"/"));

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

			if($this->objCol20->actualizar($datos,array("id_col20"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "col_20/");
			#js
			$this->layout->js('js/sistema/col_20/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Colacion de las 20');

			#metas
			$this->layout->setMeta('title','Editar Colacion de las 20');
			$this->layout->setMeta('description','Editar Colacion de las 20');
			$this->layout->setMeta('keywords','Editar Colacion de las 20');

			#contenido
			if($contenido['col20'] = $this->objCol20->obtener(array("id_col20" => $codigo)));
			else show_error('');

			$contenido["recetas"]= $this->objRecetas->listar();

			#nav
			$this->layout->nav(array("Colaciones de las 20 "=>"col_20", "Editar Colacion de las 20" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "col_20/");

			//buscando datos de elemento eliminado
			$col20_eliminado = $this->objCol20->obtener(array('id_col20' => $codigo));

			$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $col20_eliminado->receta));

			//borrando el registro
			$this->objCol20->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'col_20/';
			$config['total_rows'] = count($this->objCol20->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/col_20'.$url;

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('col_20',true);

		#Title
		$this->layout->title('Colacion de las 20');

		#Metas
		$this->layout->setMeta('title','Colacion de las 20');
		$this->layout->setMeta('description','Colacion de las 20');
		$this->layout->setMeta('keywords','Colacion de las 20');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objCol20->obtenerCol20($query);

		$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

	public function buscar_recetas(){
		$contenido['datos'] = $this->objCol20->obtener_recetas_por_regimen($this->input->post('codigo_regimen'));

		#title
			$this->layout->title('Agregar Colacion de las 20');

			#metas
			$this->layout->setMeta('title','Agregar Colacion de las 20');
			$this->layout->setMeta('description','Agregar Colacion de las 20');
			$this->layout->setMeta('keywords','Agregar Colacion de las 20');

			#js
			$this->layout->js('js/sistema/col_20/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Colaciones de las 20 "=> "col_20", "Agregar Colacion de las 20" =>"/"));

		$contenido["regimenes"]= $this->objRegimen->listar();

		$contenido['regimen_select'] = $this->input->post('codigo_regimen');

		$this->layout->view('agregar', $contenido);
	}

	public function agregar_receta($codigo_receta = false){
		#title
			$this->layout->title('Agregar Colacion de las 20');

			#metas
			$this->layout->setMeta('title','Agregar Colacion de las 20');
			$this->layout->setMeta('description','Agregar Colacion de las 20');
			$this->layout->setMeta('keywords','Agregar Colacion de las 20');

			#js
			$this->layout->js('js/sistema/col_20/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Colaciones de las 20 "=> "col_20", "Agregar Colacion de las 20" =>"/"));
		
		//verificar si ya esta ingresada la receta en el menu
		$verificar = $this->objCol20->obtener(array('receta' => $codigo_receta, 'id_unidad' => $this->session->userdata("usuario")->id_unidad ));
		if(!$verificar){

			$recetas_insertar = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$datos = array(
				'id_col20' => null,
				'receta' => $recetas_insertar->id_receta,
				'receta_nombre' => $recetas_insertar->nombre,
				'regimen' => $recetas_insertar->id_regimen,
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			$this->objCol20->insertar($datos);

			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $recetas_insertar->id_regimen;
			$contenido['mesagge'] = $recetas_insertar->nombre." receta ingresada correctamente";
			$contenido['datos'] = $this->objCol20->obtener_recetas_por_regimen($recetas_insertar->id_regimen);
			$this->layout->view('agregar', $contenido);

		}else{

			$regimen = $this->objRecetas->obtener(array('id_receta' => $codigo_receta));
			$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido['regimen_select'] = $regimen->id_regimen;
			$contenido['mesagge'] = $regimen->nombre." ya ingresada como colacion de las 10";

			$contenido['datos'] = $this->objCol20->obtener_recetas_por_regimen($regimen->id_regimen);
			$this->layout->view('agregar', $contenido);
		}

	}

}
