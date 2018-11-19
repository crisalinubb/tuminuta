<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Paciente extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_paciente", "objPaciente");
		$this->load->model("camas/modelo_camas", "objCamas");
		$this->load->model("salas/modelo_salas", "objSalas");
		$this->load->model("servicio_clinico/modelo_servicioclinico", "objServicioclinico");
		$this->load->model("paciente_general/modelo_pacientegeneral", "objPacGeneral");
		$this->load->model("modelo_diagnostico","objDiagnostico");
		$this->load->model("medico/modelo_medico","objMedico");
		#current
		$this->layout->current = 2;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Pacientes Hospitalizados');

		#Metas
		$this->layout->setMeta('title','Pacientes Hospitalizados');
		$this->layout->setMeta('description','Pacientes Hospitalizados');
		$this->layout->setMeta('keywords','Pacientes Hospitalizados');

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
		$config['base_url'] = base_url() . 'paciente/';
		$config['total_rows'] = count($this->objPaciente->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/paciente'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar($codigo = false){
		$contenido['pacientes'] = $this->objPacGeneral->obtener(array("id_paciente" => $codigo));
		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('codigo_servicio', 'Servicio Clinico', 'required');
			$this->form_validation->set_rules('codigo_sala', 'Sala', 'required');
			$this->form_validation->set_rules('codigo_cama', 'Cama', 'required');
			$this->form_validation->set_rules('estatura', 'Estatura','required|max_length[3]|trim|min_length[3]|numeric');
			$this->form_validation->set_rules('peso', 'Peso','required|max_length[2]|trim|min_length[2]|numeric');
			//$this->form_validation->set_rules('imc', 'IMC','required|max_length[2]|trim|min_length[2]|numeric');

			$this->form_validation->set_message('numeric', '* %s debe ingresar un numero no caracteres');
			$this->form_validation->set_message('max_length', '* %s excedido en caracteres');
			$this->form_validation->set_message('min_length', '* %s no tiene el minimo de caracteres');
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				//echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				//$this->session->set_flashdata('error', validation_errors());
				//redirect(base_url('paciente/agregar/'.$codigo));
				//exit;
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->objPaciente->obtener(array("codigo_cama" => $this->input->post('codigo_cama')))){
				echo json_encode(array("result"=>false,"msg"=>"Cama ocupada"));
				exit;
			}

			$dividendo = (($this->input->post('estatura')/100)*($this->input->post('estatura')/100));
			$imc = (int)($this->input->post('peso')/$dividendo);
			//print_r($imc);die();

			$datos = array(
				'id_paciente' => null,
				'codigo_paciente' => $this->input->post('codigo'),
				'codigo_atencion' => $this->input->post('codigo_atencion'),
				'diagnostico' => $this->input->post('diagnostico'),
				'medico_tratante' => $this->input->post('medico'),
				'observacion_diagnostico' => $this->input->post('observacion'),
				'estado' => 1,
				'fecha_ingreso' => date('Y-m-d H:i:s'),
				'codigo_servicio' => $this->input->post('codigo_servicio'),
				'codigo_sala' => $this->input->post('codigo_sala'),
				'codigo_cama' => $this->input->post('codigo_cama'),
				'estatura' => $this->input->post('estatura'),
				'peso' => $this->input->post('peso'),
				'imc' => $imc,
				'anamnesis' => $this->input->post('anamnesis'),
				'tratamiento' => $this->input->post('tratamiento'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			$this->objPaciente->cambiar_estado_uno($this->input->post('rut'));

			if($this->objPaciente->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
				
				$contenido['mesagge'] = $this->input->post('nombre')." ".$this->input->post('apellido')." hospitalizado !!!";
				#Title
				$this->layout->title('Pacientes Hospitalizados');

				#Metas
				$this->layout->setMeta('title','Pacientes Hospitalizados');
				$this->layout->setMeta('description','Pacientes Hospitalizados');
				$this->layout->setMeta('keywords','Pacientes Hospitalizados');

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
				$config['base_url'] = base_url() . 'paciente/';
				$config['total_rows'] = count($this->objPaciente->listar($where));
				$config['per_page'] = 15;
				$config['suffix'] = $url;
				$config['first_url'] = base_url() . '/paciente'.$url;

				$this->pagination->initialize($config);

				$contenido['datos'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

				$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

				$contenido['pagination'] = $this->pagination->create_links();

				$this->layout->view('index', $contenido);
				
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Paciente Hospitalizado');

			#metas
			$this->layout->setMeta('title','Agregar Paciente Hospitalizado');
			$this->layout->setMeta('description','Agregar Paciente Hospitalizado');
			$this->layout->setMeta('keywords','Agregar Paciente Hospitalizado');

			#js
			$this->layout->js('js/sistema/paciente/agregar.js');

			#JS - Datepicker
			$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
			$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
			$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

			$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Pacientes "=> "paciente", "Agregar Paciente" =>"/"));

			$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido["salas"]= $this->objSalas->listar();
			$contenido["camas"]= $this->objCamas->listar();
			$contenido["diagnosticos"] = $this->objDiagnostico->listar();
			$contenido["medicos"] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('codigo_servicio', 'Servicio Clinico', 'required');
			$this->form_validation->set_rules('codigo_sala', 'Sala', 'required');
			$this->form_validation->set_rules('codigo_cama', 'Cama', 'required');
			$this->form_validation->set_rules('estatura', 'Estatura','required|max_length[3]|trim|min_length[3]|numeric');
			$this->form_validation->set_rules('peso', 'Peso','required|max_length[2]|trim|min_length[2]|numeric');
			//$this->form_validation->set_rules('imc', 'IMC','required|max_length[2]|trim|min_length[2]|numeric');

			$this->form_validation->set_message('numeric', '* %s debe ingresar un numero no caracteres');
			$this->form_validation->set_message('max_length', '* %s excedido en caracteres');
			$this->form_validation->set_message('min_length', '* %s no tiene el minimo de caracteres');
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$verificar_cama = $this->objPaciente->cama_ocupada_editar($this->input->post('codigo_paciente'), $this->input->post('codigo_cama'));

			//print_r($verificar_cama->num_rows());die();

			if($verificar_cama->num_rows() > 0){
				echo json_encode(array("result"=>false,"msg"=>"Cama ocupada"));
				exit;
			}

			$dividendo = (($this->input->post('estatura')/100)*($this->input->post('estatura')/100));
			$imc = (int)($this->input->post('peso')/$dividendo);
			//print_r($imc);die();

			$fecha_nacimiento = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha1'))));

			$datos = array(
				'codigo_paciente' => $this->input->post('codigo_paciente'),
				'codigo_atencion' => $this->input->post('codigo_atencion'),
				'diagnostico' => $this->input->post('diagnostico'),
				'medico_tratante' => $this->input->post('medico'),
				'observacion_diagnostico' => $this->input->post('observacion'),
				'estado' => 1,
				'fecha_ingreso' => date('Y-m-d H:i:s'),
				'codigo_servicio' => $this->input->post('codigo_servicio'),
				'codigo_sala' => $this->input->post('codigo_sala'),
				'codigo_cama' => $this->input->post('codigo_cama'),
				'estatura' => $this->input->post('estatura'),
				'peso' => $this->input->post('peso'),
				'imc' => $imc,
				'anamnesis' => $this->input->post('anamnesis'),
				'tratamiento' => $this->input->post('tratamiento'),
				'id_unidad' => $this->session->userdata("usuario")->id_unidad
			);

			if($this->objPaciente->actualizar($datos,array("id_paciente"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "paciente/");
			#js
			$this->layout->js('js/sistema/paciente/editar.js');

			#title
			$this->layout->title('Editar Paciente Hospitalizado');

			#metas
			$this->layout->setMeta('title','Editar Paciente Hospitalizado');
			$this->layout->setMeta('description','Editar Paciente Hospitalizado');
			$this->layout->setMeta('keywords','Editar Paciente Hospitalizado');

			#contenido
			if($contenido['pacientes'] = $this->objPaciente->obtener(array("id_paciente" => $codigo)));
			else show_error('');

			$datos_pacientes = $this->objPaciente->obtener(array("id_paciente" => $codigo));

			//$datos_cama = $this->objCamas->obtener(array("id_cama" => $datos_pacientes->codigo_cama));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $datos_pacientes->codigo_paciente));

			$codigo_sala_datos = $this->objSalas->obtener(array('id_sala' => $datos_pacientes->codigo_sala));

			$contenido["servicios_clinicos"]= $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$contenido["salas"]= $this->objSalas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "CODSERV" => $datos_pacientes->codigo_servicio));

			$contenido["camas"]= $this->objCamas->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "codigo_sala" => $codigo_sala_datos->CODSALA));

			$contenido["diagnosticos"] = $this->objDiagnostico->listar();
			$contenido["medicos"] = $this->objMedico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			#nav
			$this->layout->nav(array("Pacientes "=>"paciente", "Editar Paciente" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "paciente/");
			//buscando datos de elemento eliminado
			$paciente_eliminado = $this->objPaciente->obtener(array('id_paciente' => $codigo));

			$this->objPaciente->cambiar_estado_cero($paciente_eliminado->rut);

			//borrando el registro
			$this->objPaciente->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'paciente/';
			$config['total_rows'] = count($this->objPaciente->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/paciente'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $paciente_eliminado->nombre." ".$paciente_eliminado->apellido." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

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

    public function buscarCamas() {
        $id_sala = $this->input->post('idSala');
        $codigo_sala = $this->objSalas->obtener(array('id_sala' => $id_sala));
        //print_r("entro".$id_servicio);die();
        if($id_sala){
            $camas = $this->objCamas->buscar_cama_por_sala($codigo_sala->CODSALA);
            echo '<option value="0">Camas</option>';
            foreach($camas->result() as $cama){
                echo '<option value="'. $cama->id_cama .'">'. $cama->cama .'</option>';
            }
        }  else {
            echo '<option value="0">Camas</option>';
        }
    }

    public function busqueda(){
		$query = $this->input->get('hospitalizados',true);

		#Title
		$this->layout->title('Pacientes Hospitalizados');

		#Metas
		$this->layout->setMeta('title','Pacientes Hospitalizados');
		$this->layout->setMeta('description','Pacientes Hospitalizados');
		$this->layout->setMeta('keywords','Pacientes Hospitalizados');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objPaciente->obtenerPacienteHospitalizado($query, $this->session->userdata("usuario")->id_unidad);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('index', $contenido);

	}

	public function busquedaPorSalas(){
		$query = $this->input->post('servicios',true);

		#Title
		$this->layout->title('Pacientes Hospitalizados');

		#Metas
		$this->layout->setMeta('title','Pacientes Hospitalizados');
		$this->layout->setMeta('description','Pacientes Hospitalizados');
		$this->layout->setMeta('keywords','Pacientes Hospitalizados');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objPaciente->obtenerPacienteHospitalizado_Por_Salas($query);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('index', $contenido);

	}

	public function ver_datos_paciente($codigo_paciente = false, $id_hospitalizado = false){
		#title
		$this->layout->title('Datos Paciente');

		#metas
		$this->layout->setMeta('title','Datos Paciente');
		$this->layout->setMeta('description','Datos Paciente');
		$this->layout->setMeta('keywords','Datos Paciente');

		$contenido['pacientes_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $codigo_paciente));
		
		$contenido['pacientes_hospitalizados'] = $this->objPaciente->obtener(array('id_paciente' => $id_hospitalizado));

		#nav
		$this->layout->nav(array("Pacientes Hospitalizados"=> "paciente", "Ver Datos Pacientes" =>"/"));

		$this->layout->view('datos_pacientes',$contenido);
	}

	public function prueba_pacientes(){
		$pacientes_sistal = $this->objPaciente->obtener_pacientes_prueba();

		foreach ($pacientes_sistal as $key) {
			$datos_hospitalizacion = $this->objPaciente->buscar_datos_hosp($key->codigo_servicio, $key->codigo_sala, $key->codigo_cama);

			$id_paciente = $this->objPacGeneral->obtener(array('codigo_paciente' => $key->codigo_paciente));

			if($datos_hospitalizacion){
				$this->objPaciente->eliminar_pacientes_prueba($key->id_paciente);
		
			}
		}
	}

}
