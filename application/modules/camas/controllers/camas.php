<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Camas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_camas", "objCamas");
		$this->load->model("salas/modelo_salas", "objSalas");
		$this->load->model("servicio_clinico/modelo_servicioclinico", "objServicioclinico");
		$this->load->model("hospital/modelo_hospital", "objHospital");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Camas');

		#Metas
		$this->layout->setMeta('title','Camas');
		$this->layout->setMeta('description','Camas');
		$this->layout->setMeta('keywords','Camas');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "cama like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'camas/';
		$config['total_rows'] = count($this->objCamas->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/camas'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objCamas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['camas'] = $this->objCamas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$contenido['pagination'] = $this->pagination->create_links();

		$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido["camas"]= $this->objCamas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('cama', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$codigo_sala = $this->objSalas->obtener(array('id_sala' => $this->input->post('codigo_sala')));
			
			$datos = array(
				'id_cama' => null,
				'cama' => $this->input->post('cama'),
				'codigo_sala' => $codigo_sala->CODSALA,
				'codigo_servicio' => $this->input->post('codigo_servicio'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);
			
			if($this->objCamas->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Cama');

			#metas
			$this->layout->setMeta('title','Agregar Cama');
			$this->layout->setMeta('description','Agregar Cama');
			$this->layout->setMeta('keywords','Agregar Cama');

			#js
			$this->layout->js('js/sistema/camas/agregar.js');

			#nav
			$this->layout->nav(array("Camas "=> "camas", "Agregar Camas" =>"/"));

			$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('cama', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$codigo_sala = $this->objSalas->obtener(array('id_sala' => $this->input->post('codigo_sala')));
			
			$datos = array(
				'cama' => $this->input->post('cama'),
				'codigo_sala' => $codigo_sala->CODSALA,
				'codigo_servicio' => $this->input->post('codigo_servicio'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objCamas->actualizar($datos,array("id_cama"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "camas/");
			#js
			$this->layout->js('js/sistema/camas/editar.js');

			#title
			$this->layout->title('Editar Cama');

			#metas
			$this->layout->setMeta('title','Editar Cama');
			$this->layout->setMeta('description','Editar Cama');
			$this->layout->setMeta('keywords','Editar Cama');

			#contenido
			if($contenido['camas'] = $this->objCamas->obtener(array("id_cama" => $codigo)));
			else show_error('');

			$datos_cama = $this->objCamas->obtener(array("id_cama" => $codigo));
			$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "CODSERV" => $datos_cama->codigo_servicio));
			
			#nav
			$this->layout->nav(array("Camas "=>"camas", "Editar Camas" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "camas/");

			//buscando datos de elemento eliminado
			$cama_eliminado = $this->objCamas->obtener(array('id_cama' => $codigo));

			//borrando el registro
			$this->objCamas->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'camas/';
			$config['total_rows'] = count($this->objCamas->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/camas'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objCamas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $cama_eliminado->cama." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();

			$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			//$contenido["camas"]= $this->objCamas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function buscarSalas() {
        $id_servicio = $this->input->post('idServicio');
        if($id_servicio){

            $salas = $this->objSalas->buscar_sala_por_servicio($id_servicio);
            //echo '<option value="0">Salas</option>';
            foreach($salas->result() as $sala){
                echo '<option value="'. $sala->id_sala .'">'. $sala->NOMSALA .'</option>';
            }
        }  else {
            echo '<option value="0">Salas</option>';
        }
    }

    public function buscarCamas() {
        $id_sala = $this->input->post('idSala');
        $codigo_sala = $this->objSalas->obtener(array('id_sala' => $id_sala));
        //print_r("entro".$id_servicio);die();
        if($id_sala){
            $camas = $this->objCamas->buscar_cama_por_sala($codigo_sala->CODSALA);
            //echo '<option value="0">Camas</option>';
            foreach($camas->result() as $cama){
                echo '<option value="'. $cama->id_cama .'">'. $cama->cama .'</option>';
            }
        }  else {
            echo '<option value="0">Camas</option>';
        }
    }

    public function busqueda(){
		$servicio = $this->input->get('codigo_servicio',true);
		$sala = $this->input->get('codigo_sala',true);
		$cama = $this->input->get('codigo_cama',true);

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $sala));

		#Title
		$this->layout->title('Camas');

		#Metas
		$this->layout->setMeta('title','Camas');
		$this->layout->setMeta('description','Camas');
		$this->layout->setMeta('keywords','Camas');

		if (($sala ==  0 || !$sala) &&($cama ==  0 || !$cama)) {
			$contenido['datos'] = $this->objCamas->obtener_cama_servicio($servicio);
			//print_r("aaaaa");die();
		}else if (($cama ==  0 || !$cama)) {
			$contenido['datos'] = $this->objCamas->obtener_cama_servicio_sala($servicio, $codigo_sala->CODSALA);
			//print_r("bbbbb");die();
		}else{
			$contenido['datos'] = $this->objCamas->obtenerCama($servicio, $codigo_sala->CODSALA, $cama);
			//print_r("ccccc");die();
		}

		$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido["salas"]= $this->objSalas->listar();
		$contenido["camas"]= $this->objCamas->listar();

		$this->layout->view('index', $contenido);

	}

}
