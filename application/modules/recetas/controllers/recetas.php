<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Recetas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_recetas", "objRecetas");
		$this->load->model("modelo_tiporeceta", "objTiporeceta");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Recetas');

		#Metas
		$this->layout->setMeta('title','Recetas');
		$this->layout->setMeta('description','Recetas');
		$this->layout->setMeta('keywords','Recetas');

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
		$config['base_url'] = base_url() . 'recetas/';
		$config['total_rows'] = count($this->objRecetas->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/recetas'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objRecetas->listar($where, $pagina, $config['per_page']);

		$contenido['recetas'] = $this->objRecetas->listar();

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido["regimenes"]= $this->objRegimen->listar();

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
				'id_receta' => null,
				'nombre' => $this->input->post('nombre'),
				'id_regimen' => $this->input->post('codigo_regimen'),
				'id_tipo_receta' => $this->input->post('codigo_tiporeceta'),
				'formula' => $this->input->post('formula'),
				'complemento' => $this->input->post('complemento')
			);
			
			if($this->objRecetas->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Receta');

			#metas
			$this->layout->setMeta('title','Agregar Receta');
			$this->layout->setMeta('description','Agregar Receta');
			$this->layout->setMeta('keywords','Agregar Receta');

			#js
			$this->layout->js('js/sistema/recetas/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');
			#nav
			$this->layout->nav(array("Recetas "=> "recetas", "Agregar Receta" =>"/"));

			$contenido["tipo_recetas"]= $this->objTiporeceta->listar();
			$contenido["regimenes"]= $this->objRegimen->listar();

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
				'nombre' => $this->input->post('nombre'),
				'id_regimen' => $this->input->post('codigo_regimen'),
				'id_tipo_receta' => $this->input->post('codigo_tiporeceta'),
				'formula' => $this->input->post('formula'),
				'complemento' => $this->input->post('complemento')
			);

			if($this->objRecetas->actualizar($datos,array("id_receta"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "recetas/");
			#js
			$this->layout->js('js/sistema/recetas/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Receta');

			#metas
			$this->layout->setMeta('title','Editar Receta');
			$this->layout->setMeta('description','Editar Receta');
			$this->layout->setMeta('keywords','Editar Receta');

			#contenido
			if($contenido['recetas'] = $this->objRecetas->obtener(array("id_receta" => $codigo)));
			else show_error('');

			$contenido["tipo_recetas"]= $this->objTiporeceta->listar();
			$contenido["regimenes"]= $this->objRegimen->listar();

			#nav
			$this->layout->nav(array("Recetas "=>"recetas", "Editar Receta" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "recetas/");

			//buscando datos de elemento eliminado
			$receta_eliminado = $this->objRecetas->obtener(array('id_receta' => $codigo));

			//borrando el registro
			$this->objRecetas->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'recetas/';
			$config['total_rows'] = count($this->objRecetas->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/recetas'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objRecetas->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['recetas'] = $this->objRecetas->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$recetas = $this->input->get('recetas',true);
		$regimenes = $this->input->get('regimenes',true);

		#Title
		$this->layout->title('Recetas');

		#Metas
		$this->layout->setMeta('title','Recetas');
		$this->layout->setMeta('description','Recetas');
		$this->layout->setMeta('keywords','Recetas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		if (($recetas ==  0 || !$recetas)) {
			$contenido['datos'] = $this->objRecetas->listar(array('id_regimen' => $regimenes));
			//print_r("aaaaa");die();
		}else{
			$contenido['datos'] = $this->objRecetas->obtener_Receta_regimen($recetas, $regimenes);
			//print_r("ccccc");die();
		}

		$contenido['recetas'] = $this->objRecetas->listar();
		$contenido["regimenes"]= $this->objRegimen->listar();

		$this->layout->view('index', $contenido);

	}

	public function buscarRecetas(){
		$idRegimen = $this->input->post('idRegimen');
        if($idRegimen){
            $recetas = $this->objRecetas->listar(array('id_regimen' => $idRegimen));
            echo '<option value="0">Seleccione Receta</option>';
            foreach($recetas as $recet){
                echo '<option value="'. $recet->id_receta .'">'. $recet->nombre .'</option>';
            }
        }  else {
            echo '<option value="0">recetas</option>';
        }
	}

}
