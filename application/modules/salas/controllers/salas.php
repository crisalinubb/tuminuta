<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Salas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_salas", "objSalas");
		$this->load->model("servicio_clinico/modelo_servicioclinico", "objServicioclinico");
		$this->load->model("hospital/modelo_hospital", "objHospital");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Salas');

		#Metas
		$this->layout->setMeta('title','Salas');
		$this->layout->setMeta('description','Salas');
		$this->layout->setMeta('keywords','Salas');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "NOMSALA like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'salas/';
		$config['total_rows'] = count($this->objSalas->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/salas'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'id_sala' => null,
				'CODSALA' => $this->input->post('codigo'),
				'NOMSALA' => $this->input->post('nombre'),
				'CODSERV' => $this->input->post('servicio_clinico'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);
			
			if($this->objSalas->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Sala');

			#metas
			$this->layout->setMeta('title','Agregar Sala');
			$this->layout->setMeta('description','Agregar Sala');
			$this->layout->setMeta('keywords','Agregar Sala');

			#js
			$this->layout->js('js/sistema/salas/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Salas "=> "salas", "Agregar Sala" =>"/"));

			$contenido["servicio_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

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
				'CODSALA' => $this->input->post('codigo_sala'),
				'NOMSALA' => $this->input->post('nombre'),
				'CODSERV' => $this->input->post('servicio_clinico'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objSalas->actualizar($datos,array("id_sala"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "salas/");
			#js
			$this->layout->js('js/sistema/salas/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Sala');

			#metas
			$this->layout->setMeta('title','Editar Sala');
			$this->layout->setMeta('description','Editar Sala');
			$this->layout->setMeta('keywords','Editar Sala');

			#contenido
			if($contenido['salas'] = $this->objSalas->obtener(array("id_sala" => $codigo)));
			else show_error('');

			$contenido["servicio_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			#nav
			$this->layout->nav(array("Salas "=>"salas", "Editar Sala" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "salas/");

			#title
			$this->layout->title('Editar Sala');

			#metas
			$this->layout->setMeta('title','Editar Sala');
			$this->layout->setMeta('description','Editar Sala');
			$this->layout->setMeta('keywords','Editar Sala');

			//buscando datos de elemento eliminado
			$sala_eliminado = $this->objSalas->obtener(array('id_sala' => $codigo));

			//borrando el registro
			$this->objSalas->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'salas/';
			$config['total_rows'] = count($this->objSalas->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/salas'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $sala_eliminado->NOMSALA." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();

			$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function buscarSalas() {
        $id_servicio = $this->input->post('idServicio');
        if($id_servicio){

            $salas = $this->objSalas->buscar_sala_por_servicio($id_servicio);
            echo '<option value="0">Salas</option>';
            foreach($salas->result() as $sala){
                echo '<option value="'. $sala->id_sala .'">'. $sala->NOMSALA .'</option>';
            }
        }  else {
            echo '<option value="0">Salas</option>';
        }
    }

    public function busqueda(){
		$servicio = $this->input->get('codigo_servicio',true);
		$sala = $this->input->get('codigo_sala',true);

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $sala));	

		#Title
		$this->layout->title('Salas');

		#Metas
		$this->layout->setMeta('title','Salas');
		$this->layout->setMeta('description','Salas');
		$this->layout->setMeta('keywords','Salas');

		if (($sala ==  0 || !$sala)) {
			$contenido['datos'] = $this->objSalas->obtenerServicio($servicio);
			//print_r("aaaaa");die();
		}else{
			$contenido['datos'] = $this->objSalas->obtenerSala($servicio, $codigo_sala->CODSALA);
			//print_r("ccccc");die();
		}

		$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

}
