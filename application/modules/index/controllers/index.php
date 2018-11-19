<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Index extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_index", "objIndex");
		$this->load->model("salas/modelo_salas", "objSalas");
		$this->load->model("camas/modelo_camas", "objCamas");
		$this->load->model("servicio_clinico/modelo_servicioclinico", "objServicioClinico");
		$this->load->model("paciente/modelo_paciente","objPaciente");
		$this->load->model("paciente_general/modelo_pacientegeneral", "objPacGeneral");
		$this->load->model("paciente/modelo_diagnostico", "objDiagnostico");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		$this->load->model("insumo_receta/modelo_insumoreceta","objInsumoReceta");
		$this->load->model("regimen/modelo_regimen", "objRegimen");

		$this->load->model("desayuno/modelo_desayuno", "objDesayuno");
		$this->load->model("almuerzo/modelo_almuerzo", "objAlmuerzo");
		$this->load->model("once/modelo_once", "objOnce");
		$this->load->model("cena/modelo_cena", "objCena");
		$this->load->model("colacion/modelo_colacion", "objColacion");
		$this->load->model("col_20/modelo_col20", "objCol20");

		$this->load->model("usuarios/modelo_usuario","objUsuario");
		$this->load->model("medico/modelo_medico","objMedico");
		$this->load->model("hospital/modelo_hospital", "objHospital");

		$this->load->model("aportes_regimen/modelo_aportesregimen", "objAporteReg");

		$this->load->model("planificacion/modelo_planificacion", "objPlanifica");
	}

	public function index(){
		//$usuario_multiple_unidad = $this->objIndex->multiple_unidad($this->session->userdata("usuario")->login);
		//print_r($usuario_multiple_unidad);die();
		//if($usuario_multiple_unidad ==1){
			$this->layout->title('Sistema Alimentación');
			$this->layout->setMeta('title','Sistema Alimentación');
			$this->layout->setMeta('description','Sistema Alimentación');
			$this->layout->setMeta('keywords','Sistema Alimentación');

			$contenido['datos'] = $this->objIndex->Obtener_servicios();
			$this->layout->view('index',$contenido);  
		//}else{
		//	$this->layout->title('Sistema Alimentación');
		//	$this->layout->setMeta('title','Sistema Alimentación');
		//	$this->layout->setMeta('description','Sistema Alimentación');
		//	$this->layout->setMeta('keywords','Sistema Alimentación');

		//	$contenido['unidades'] = $this->objIndex->unidades_usuario($this->session->userdata("usuario")->login);

		//	$this->layout->view('multiple_unidad',$contenido);
		//}      
	}

	public function ver_salas($codigo = false){
		$servicio= $this->input->get('servicio',TRUE);	
		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$contenido['datos'] = $this->objIndex->Obtener_salas($servicio);
		$this->layout->view('salas',$contenido);
	}

	public function ver_camas($codigo = false){
		$sala= $this->input->get('sala',TRUE);	
		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $sala));
		$contenido['codigo_serv'] = $codigo_sala->CODSERV;
		//print_r($sala.'|'.$codigo_sala->CODSERV);die();

		$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->CODSALA, $codigo_sala->CODSERV);

		$this->layout->view('camas',$contenido);
	}

	public function pacientes_hospitalizados($codigo = false){
		$cama= $this->input->get('cama',TRUE);	
		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$contenido['datos'] = $this->objIndex->buscar_paciente_hospitalizado($cama);

		$this->layout->view('pacientes_hospitalizados',$contenido);
	}

	public function dar_alta_paciente($codigo = false){
		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$contenido['paciente'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		//buscar datos del paciente
		$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$this->layout->view('paciente_alta',$contenido);
	}

	public function registrar_alta($codigo = false){

		$paciente = $this->objPacGeneral->obtener(array('rut' => $this->input->post('rut')));

		$datos = array('id_egresado' => null,
					   'codigo_paciente' => $this->input->post('codigo'),
					   'egresado_codigoatencion' => $this->input->post('codigo_atencion'),
					   'egresado_diagnostico' => $this->input->post('diagnostico'),
					   'egresado_observacion' => $this->input->post('observacion'),
					   'egresado_motivoegreso' => $this->input->post('alta_medica'),
					   'egresado_fechaegreso' => date('Y-m-d H:i:s'),
					   'egresado_servicio' => $this->input->post('codigo_servicio'),
					   'egresadp_sala' => $this->input->post('codigo_sala'),
					   'egresado_cama' => $this->input->post('codigo_cama'),
					   'usuario_egreso' => $this->session->userdata("usuario")->id_usuario,
					   'egresado_estatura' => $this->input->post('estatura'),
					   'egresado_peso' => $this->input->post('peso'),
					   'egresado_imc' => $this->input->post('imc'),
					   'egresado_anamnesis' => $this->input->post('anamnesis'),
					   'egresado_tratamiento' => $this->input->post('tratamiento'),
					   'egresado_unidad' => $this->session->userdata("usuario")->id_unidad
				 );
		
		$this->objIndex->agregar_alta($datos);
		$this->objPaciente->cambiar_estado_cero($this->input->post('rut'));

		$this->objIndex->eliminar_paciente($this->input->post('codigo'));

		$contenido['mesagge'] = $paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno." dado de alta";

		$this->layout->view('paciente_egresado', $contenido);
	}

	public function solicitud_clinica($codigo = false){
		//validamos si se habia hecho una solicitud el dia anterior
		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		$buscar_solictud_paciente = $this->objIndex->buscar_solicitud($paciente->id_paciente, $this->session->userdata("usuario")->id_unidad);

		if($buscar_solictud_paciente){

			$desayuno= $buscar_solictud_paciente->id_desayuno;
			$almuerzo= $buscar_solictud_paciente->id_almuerzo;
			$once= $buscar_solictud_paciente->id_once;
			$cena= $buscar_solictud_paciente->id_cena;
			$col_10= $buscar_solictud_paciente->id_col10;
			$col_20= $buscar_solictud_paciente->id_col20;
			$paciente_hospitalizado= $codigo;
			$formula = $buscar_solictud_paciente->id_formula;
			$compl1 = $buscar_solictud_paciente->id_complemento1;
			$compl2 = $buscar_solictud_paciente->id_complemento2;
			$compl3 = $buscar_solictud_paciente->id_complemento3;
			$volumen = $buscar_solictud_paciente->volumen;
			$frecuencia = $buscar_solictud_paciente->frecuencia;

			$recetas = array('desayuno_codigo'=> $desayuno,
							 'almuerzo_codigo'=> $almuerzo,
							 'once_codigo'=> $once,
							 'cena_codigo'=> $cena,
							 'col10_codigo'=> $col_10,
							 'col20_codigo'=> $col_20,
							 'formula_codigo'=> $formula,
							 'c1_codigo'=> $compl1,
							 'c2_codigo'=> $compl2,
							 'c3_codigo'=> $compl3,
							 'volumen'=> $volumen,
							 'frecuencia'=> $frecuencia
							);
			$contenido['codigos'] = $recetas;

			$this->layout->title('Solicitud Clinica');
		
			$this->layout->setMeta('title','Solicitud Clinica');
			$this->layout->setMeta('description','Solicitud Clinica');
			$this->layout->setMeta('keywords','Solicitud Clinica');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscar datos del paciente
			$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));
			
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$this->layout->view('solicitud_clinica',$contenido);

		}else{
			$this->layout->title('Solicitud Clinica');
	
			$this->layout->setMeta('title','Solicitud Clinica');
			$this->layout->setMeta('description','Solicitud Clinica');
			$this->layout->setMeta('keywords','Solicitud Clinica');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscar datos del paciente
			$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $codigo));

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

			$this->layout->view('solicitud_clinica',$contenido);
		}	
	}

	public function enviar_solicitud(){
		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $this->input->post('id_paciente')));
		if($this->input->post('boton3')){
			//Funcion Limpiar
			$paciente_hospitalizado= $this->input->post('id_paciente');
			
			$this->layout->title('Solicitud Clinica');
		
			$this->layout->setMeta('title','Solicitud Clinica');
			$this->layout->setMeta('description','Solicitud Clinica');
			$this->layout->setMeta('keywords','Solicitud Clinica');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscar datos del paciente
			$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));
			
			$this->layout->view('solicitud_clinica',$contenido);

		}else if ($this->input->post('boton1')) {
			//funcion de enviar la solicitud clinica

			$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $this->input->post('id_paciente_general')));

			$arreglo_horario = $this->input->post('check');
			$h9 = 0;
			$h14 = 0;
			$h18 = 0;
			$h22 = 0;

			foreach( $arreglo_horario as $horario ) {
				if ($horario == 1) {
					$h9 = 1;
				}else if ($horario == 2) {
					$h14 = 1;
				}else if ($horario == 3) {
					$h18 = 1;
				}else if ($horario == 4) {
					$h22 = 1;
				}
			}

			$datos = array(
					'id_solicitud' => null,
					'id_paciente' => $paciente->id_paciente,
					'id_servicioclinico' => $this->input->post('codigo_servicio'),
					'id_sala' => $this->input->post('codigo_sala'),
					'id_cama' => $this->input->post('codigo_cama'),
					'id_unidad' => $this->session->userdata("usuario")->id_unidad,
					'id_desayuno' => $this->input->post('codigo_desayuno'),
					'id_almuerzo' => $this->input->post('codigo_almuerzo'),
					'id_once' => $this->input->post('codigo_once'),
					'id_cena' => $this->input->post('codigo_cena'),
					'id_col10' => $this->input->post('codigo_col10'),
					'id_col20' => $this->input->post('codigo_col20'),
					'id_usuario' => $this->session->userdata("usuario")->id_usuario,
					'diagnostico' => $this->input->post('diagnostico'),
					'fecha_registro' => date('Y-m-d H:i:s'),
					'id_formula' => $this->input->post('formula'),
					'id_complemento1' => $this->input->post('compl1'),
					'id_complemento2' => $this->input->post('compl2'),
					'id_complemento3' => $this->input->post('compl3'),
					'volumen' => $this->input->post('volumen'),
					'frecuencia' => $this->input->post('frecuencia'),
					'bajada' => $this->input->post('bajada'),
					'h9' => $h9,
					'h14' => $h14,
					'h18' => $h18,
					'h22' => $h22

				);
			$this->objIndex->insertar_solicitud($datos);

		$contenido['mesagge'] = "Solicitud ingresada para el paciente ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;

		$this->layout->view('confirmacion_solicitud',$contenido);
			
		}else if ($this->input->post('boton2')) {
			//funcion de calculo de informacion nutricional
			
			$desayuno= $this->input->post('codigo_desayuno');
			$almuerzo= $this->input->post('codigo_almuerzo');
			$once= $this->input->post('codigo_once');
			$cena= $this->input->post('codigo_cena');
			$col_10= $this->input->post('codigo_col10');
			$col_20= $this->input->post('codigo_col20');
			$paciente_hospitalizado= $this->input->post('id_paciente');

			$recetas = array('desayuno_codigo'=> $desayuno,
							 'almuerzo_codigo'=> $almuerzo,
							 'once_codigo'=> $once,
							 'cena_codigo'=> $cena,
							 'col10_codigo'=> $col_10,
							 'col20_codigo'=> $col_20
							);
			$contenido['codigos'] = $recetas;

			$this->layout->title('Solicitud Clinica');
		
			$this->layout->setMeta('title','Solicitud Clinica');
			$this->layout->setMeta('description','Solicitud Clinica');
			$this->layout->setMeta('keywords','Solicitud Clinica');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscar datos del paciente
			$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

			$this->layout->view('solicitud_clinica',$contenido);
		}
		
	}

	public function editar_solicitud_clinica($codigo = false){
		//validamos si se habia hecho una solicitud el dia anterior
		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		$buscar_solictud_paciente = $this->objIndex->buscar_solicitud_dia_actual($paciente->id_paciente);

		$contenido['codigo_solicitud'] = $buscar_solictud_paciente->id_solicitud;

			$desayuno= $buscar_solictud_paciente->id_desayuno;
			$almuerzo= $buscar_solictud_paciente->id_almuerzo;
			$once= $buscar_solictud_paciente->id_once;
			$cena= $buscar_solictud_paciente->id_cena;
			$col_10= $buscar_solictud_paciente->id_col10;
			$col_20= $buscar_solictud_paciente->id_col20;
			$paciente_hospitalizado= $codigo;
			$formula = $buscar_solictud_paciente->id_formula;
			$compl1 = $buscar_solictud_paciente->id_complemento1;
			$compl2 = $buscar_solictud_paciente->id_complemento2;
			$compl3 = $buscar_solictud_paciente->id_complemento3;
			$volumen = $buscar_solictud_paciente->volumen;
			$frecuencia = $buscar_solictud_paciente->frecuencia;

			$recetas = array('desayuno_codigo'=> $desayuno,
							 'almuerzo_codigo'=> $almuerzo,
							 'once_codigo'=> $once,
							 'cena_codigo'=> $cena,
							 'col10_codigo'=> $col_10,
							 'col20_codigo'=> $col_20,
							 'formula_codigo'=> $formula,
							 'c1_codigo'=> $compl1,
							 'c2_codigo'=> $compl2,
							 'c3_codigo'=> $compl3,
							 'volumen'=> $volumen,
							 'frecuencia'=> $frecuencia
							);
			$contenido['codigos'] = $recetas;

			$this->layout->title('Solicitud Clinica');
		
			$this->layout->setMeta('title','Solicitud Clinica');
			$this->layout->setMeta('description','Solicitud Clinica');
			$this->layout->setMeta('keywords','Solicitud Clinica');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscar datos del paciente
			$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));
			
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$this->layout->view('editar_solicitud_clinica',$contenido);

	}

	public function editar_solicitud(){
		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $this->input->post('id_paciente')));
		if($this->input->post('boton3')){
			//Funcion Limpiar
			$paciente_hospitalizado= $this->input->post('id_paciente');
			
			$contenido['codigo_solicitud'] = $this->input->post('codigo_solicitud');

			$this->layout->title('Solicitud Clinica');
		
			$this->layout->setMeta('title','Solicitud Clinica');
			$this->layout->setMeta('description','Solicitud Clinica');
			$this->layout->setMeta('keywords','Solicitud Clinica');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscar datos del paciente
			$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));
			
			$this->layout->view('editar_solicitud_clinica',$contenido);

		}else if ($this->input->post('boton1')) {
			//funcion de enviar la solicitud clinica

			$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $this->input->post('id_paciente_general')));

			$arreglo_horario = $this->input->post('check');
			$h9 = 0;
			$h14 = 0;
			$h18 = 0;
			$h22 = 0;

			foreach( $arreglo_horario as $horario ) {
				if ($horario == 1) {
					$h9 = 1;
				}else if ($horario == 2) {
					$h14 = 1;
				}else if ($horario == 3) {
					$h18 = 1;
				}else if ($horario == 4) {
					$h22 = 1;
				}
			}

			$datos = array(
					'id_paciente' => $paciente->id_paciente,
					'id_servicioclinico' => $this->input->post('codigo_servicio'),
					'id_sala' => $this->input->post('codigo_sala'),
					'id_cama' => $this->input->post('codigo_cama'),
					'id_unidad' => $this->session->userdata("usuario")->id_unidad,
					'id_desayuno' => $this->input->post('codigo_desayuno'),
					'id_almuerzo' => $this->input->post('codigo_almuerzo'),
					'id_once' => $this->input->post('codigo_once'),
					'id_cena' => $this->input->post('codigo_cena'),
					'id_col10' => $this->input->post('codigo_col10'),
					'id_col20' => $this->input->post('codigo_col20'),
					'id_usuario' => $this->session->userdata("usuario")->id_usuario,
					'diagnostico' => $this->input->post('diagnostico'),
					'fecha_registro' => date('Y-m-d H:i:s'),
					'id_formula' => $this->input->post('formula'),
					'id_complemento1' => $this->input->post('compl1'),
					'id_complemento2' => $this->input->post('compl2'),
					'id_complemento3' => $this->input->post('compl3'),
					'volumen' => $this->input->post('volumen'),
					'frecuencia' => $this->input->post('frecuencia'),
					'bajada' => $this->input->post('bajada'),
					'h9' => $h9,
					'h14' => $h14,
					'h18' => $h18,
					'h22' => $h22

				);
			$this->objIndex->editar_solicitud($datos,$this->input->post('codigo_solicitud'));

		$contenido['mesagge'] = "Solicitud editada para el paciente ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;

		$this->layout->view('confirmacion_solicitud',$contenido);
			
		}
		
	}

	public function mis_servicios(){
		$this->layout->title('Sistema Alimentación');
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$contenido['datos'] = $this->objIndex->obtener_servicios_asociados($this->session->userdata("usuario")->id_usuario);
		$this->layout->view('mis_servicios',$contenido); 
	}

	public function calculo_informacion(){
		$desayuno= $this->input->get('desayuno',TRUE);
		$almuerzo= $this->input->get('almuerzo',TRUE);
		$once= $this->input->get('once',TRUE);
		$cena= $this->input->get('cena',TRUE);
		$col_10= $this->input->get('col_10',TRUE);
		$col_20= $this->input->get('col_20',TRUE);
		$paciente_hospitalizado= $this->input->get('paciente',TRUE);

		$recetas = array('desayuno_codigo'=> $desayuno,
						 'almuerzo_codigo'=> $almuerzo,
						 'once_codigo'=> $once,
						 'cena_codigo'=> $cena,
						 'col10_codigo'=> $col_10,
						 'col20_codigo'=> $col_20
						);
		$contenido['codigos'] = $recetas;

		$this->layout->title('Solicitud Clinica');
	
		$this->layout->setMeta('title','Solicitud Clinica');
		$this->layout->setMeta('description','Solicitud Clinica');
		$this->layout->setMeta('keywords','Solicitud Clinica');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		//buscar datos del paciente
		$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		//$contenido['almuerzos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		//$contenido['cenas'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['col_10'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['regimenes'] = $this->objRegimen->listar();

		$this->layout->view('solicitud_clinica',$contenido);

	}

	public function limpiar(){
		$paciente_hospitalizado= $this->input->get('paciente',TRUE);
		
		$this->layout->title('Solicitud Clinica');
	
		$this->layout->setMeta('title','Solicitud Clinica');
		$this->layout->setMeta('description','Solicitud Clinica');
		$this->layout->setMeta('keywords','Solicitud Clinica');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		//buscar datos del paciente
		$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $paciente_hospitalizado));

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['almuerzos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['cenas'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['col_10'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('solicitud_clinica',$contenido);
	}

	public function mostrar_usuarios(){
		if($this->session->userdata("usuario")->id_perfil == 1){
			$contenido['datos'] = $this->objUsuario->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));
		}elseif($this->session->userdata("usuario")->id_perfil == 2){
			$contenido['datos'] = $this->objUsuario->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "id_perfil" => 3));
		}
		$this->layout->view('asignar_servicios',$contenido);
	}

	public function vista_asignar_servicios($codigo_usuario = false){
		$contenido['codigo_usuario'] = $codigo_usuario;

		$contenido['datos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('asignacion_servicios',$contenido);
	}

	public function ingresar_servicioasociado($codigo_servicio = false, $codigo_usuario = false){
		$contenido['codigo_usuario'] = $codigo_usuario;
		$contenido['codigo_servicio'] = $codigo_servicio;

		$datos = array('id_servicoas' => null,
					   'id_usuario' => $codigo_usuario,
					   'id_servicio' => $codigo_servicio 
					);

		$this->objIndex->agregar_servicio_asociado($datos);

		$contenido['datos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('asignacion_servicios',$contenido);
	}

	public function desvincular_servicioasociado($codigo_servicio = false, $codigo_usuario = false){
		$contenido['codigo_usuario'] = $codigo_usuario;
		$contenido['codigo_servicio'] = $codigo_servicio;

		$this->objIndex->desvincular_servicio_asociado($codigo_usuario, $codigo_servicio);

		$contenido['datos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('asignacion_servicios',$contenido);
	}

	public function hospitalizar_paciente($id_cama = false){
		#Title
		$this->layout->title('Pacientes');

		#Metas
		$this->layout->setMeta('title','Pacientes');
		$this->layout->setMeta('description','Pacientes');
		$this->layout->setMeta('keywords','Pacientes');

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
		$config['base_url'] = base_url() . 'paciente_general/';
		$config['total_rows'] = count($this->objPacGeneral->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/paciente_general'.$url;

		$this->pagination->initialize($config);

		$contenido['id_cama'] = $id_cama;

		//$contenido['datos'] = $this->objPacGeneral->listar(array("estado" => 0));

		$contenido['pacientes'] = $this->objPacGeneral->listar(array("estado" => 0));

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('vista_pacientes_hospitalizados', $contenido);
	}

	public function agregar_hospitalizacion($codigo_paciente = false, $codigo_cama = false){

	$contenido['pacientes'] = $this->objPacGeneral->obtener(array("id_paciente" => $codigo_paciente));
		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('rut', 'rut', 'required');
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
				//redirect(base_url('index/agregar_hospitalizacion/'.$codigo_paciente.'/'.$codigo_cama));
				//exit;
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$fecha_nacimiento = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha1'))));

			$dividendo = (($this->input->post('estatura')/100)*($this->input->post('estatura')/100));
			$imc = (int)($this->input->post('peso')/$dividendo);

			//print_r($imc);die();

			$datos = array(
				'id_paciente' => null,
				'codigo_paciente' => $codigo_paciente,
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
				/*

				$contenido['mesagge'] = $this->input->post('nombre')." ".$this->input->post('apellido')." hospitalizado !!!";
				#Title
				$this->layout->title('Pacientes Hospitalizados');

				#Metas
				$this->layout->setMeta('title','Pacientes Hospitalizados');
				$this->layout->setMeta('description','Pacientes Hospitalizados');
				$this->layout->setMeta('keywords','Pacientes Hospitalizados');

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

				$contenido['datos'] = $this->objPaciente->listar($where, $pagina, $config['per_page']);

				$contenido['pagination'] = $this->pagination->create_links();

				$this->layout->view('index', $contenido);
				*/
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
			$this->layout->js('js/sistema/paciente_hospitalizar/agregar.js');

			#JS - Datepicker
			$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
			$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
			$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

			$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

			$cama = $this->objCamas->obtener(array('id_cama' => $codigo_cama));
			$contenido['sala'] = $this->objSalas->obtener(array('CODSALA' => $cama->codigo_sala));

			$contenido["camas"] = $this->objCamas->obtener(array('id_cama' => $codigo_cama));

			$contenido["diagnosticos"] = $this->objDiagnostico->listar();
			$contenido["medicos"] = $this->objMedico->listar();
			$contenido['paciente_codigo'] = $codigo_paciente;

			$this->layout->view('agregar_hospitalizacion', $contenido);
		}

	}

	public function ingresar_unidad_usuario($id_unidad = false){
		$this->layout->title('Sistema Alimentación');
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		//$contenido['datos'] = $this->objIndex->Obtener_servicios();

		$where = array(
				"login" => $this->session->userdata("usuario")->login,
				"id_unidad" => $id_unidad
		);

		$usuario = $this->objUsuario->obtener($where);
		$this->session->set_userdata('usuario',$usuario);

		$this->layout->view('index',$contenido); 
	}

	public function solicitud_desayuno(){
		$this->layout->title('Solicitudes de Desayuno');
		$this->layout->setMeta('title','Solicitudes de Desayuno');
		$this->layout->setMeta('description','Solicitudes de Desayuno');
		$this->layout->setMeta('keywords','Solicitudes de Desayuno');
		
		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitudes_desayuno',$contenido);
	}

	public function solicitud_once(){
		$this->layout->title('Solicitudes de Once');
		$this->layout->setMeta('title','Solicitudes de Once');
		$this->layout->setMeta('description','Solicitudes de Once');
		$this->layout->setMeta('keywords','Solicitudes de Once');

		$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitudes_once',$contenido);
	}

	public function solicitud_col10(){
		$this->layout->title('Solicitudes Colacion de las 10');
		$this->layout->setMeta('title','Solicitudes Colacion de las 10');
		$this->layout->setMeta('description','Solicitudes Colacion de las 10');
		$this->layout->setMeta('keywords','Solicitudes Colacion de las 10');

		$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitudes_col10',$contenido);
	}

	public function solicitud_col20(){
		$this->layout->title('Solicitudes Colacion de las 20');
		$this->layout->setMeta('title','Solicitudes Colacion de las 20');
		$this->layout->setMeta('description','Solicitudes Colacion de las 20');
		$this->layout->setMeta('keywords','Solicitudes Colacion de las 20');

		$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitudes_col20',$contenido);
	}

	public function solicitud_almuerzo(){
		$this->layout->title('Solicitudes de Almuerzo');
		$this->layout->setMeta('title','Solicitudes de Almuerzo');
		$this->layout->setMeta('description','Solicitudes de Almuerzo');
		$this->layout->setMeta('keywords','Solicitudes de Almuerzo');

		$contenido['regimenes'] = $this->objRegimen->listar();

		$this->layout->view('solicitudes_almuerzo',$contenido);
	}

	public function solicitud_cena(){
		$this->layout->title('Solicitudes de Cena');
		$this->layout->setMeta('title','Solicitudes de Cena');
		$this->layout->setMeta('description','Solicitudes de Cena');
		$this->layout->setMeta('keywords','Solicitudes de Cena');

		$contenido['regimenes'] = $this->objRegimen->listar();

		$this->layout->view('solicitudes_cena',$contenido);
	}

	public function solicitud_formulas_lacteas(){
		$this->layout->title('Solicitudes de Formulas Lacteas');
		$this->layout->setMeta('title','Solicitudes de Formulas Lacteas');
		$this->layout->setMeta('description','Solicitudes de Formulas Lacteas');
		$this->layout->setMeta('keywords','Solicitudes de Formulas Lacteas');

		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitudes_formulas_lacteas',$contenido);
	}

	public function solicitud_formulas_enterales(){
		$this->layout->title('Solicitudes de Formulas Enterales');
		$this->layout->setMeta('title','Solicitudes de Formulas Enterales');
		$this->layout->setMeta('description','Solicitudes de Formulas Enterales');
		$this->layout->setMeta('keywords','Solicitudes de Formulas Enterales');

		$contenido['servicios_clinicos'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('solicitudes_formulas_enterales',$contenido);
	}

	public function busqueda_pacientes_sin_hospitalizar(){
		$query = $this->input->get('pacientes',true);
		$id_cama = $this->input->get('id_cama',true);

		#Title
		$this->layout->title('Pacientes');

		#Metas
		$this->layout->setMeta('title','Pacientes');
		$this->layout->setMeta('description','Pacientes');
		$this->layout->setMeta('keywords','Pacientes');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['id_cama'] = $id_cama;

		$contenido['datos'] = $this->objPacGeneral->listar(array("rut" => $query));

		$contenido['pacientes'] = $this->objPacGeneral->listar(array("rut" => $query));

		$this->layout->view('vista_pacientes_hospitalizados', $contenido);

	}

	public function listaDistribucion(){
		#Title
		$this->layout->title('Lista de Distribucion');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion');
		$this->layout->setMeta('description','Lista de Distribucion');
		$this->layout->setMeta('keywords','Lista de Distribucion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');
		
		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('listaDistribucion', $contenido);
	}

	public function busquedaPorServicio(){
		$id_servicio = $this->input->post('servicios');
		$id_sala = $this->input->post('salas');
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Lista de Distribucion');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion');
		$this->layout->setMeta('description','Lista de Distribucion');
		$this->layout->setMeta('keywords','Lista de Distribucion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		if(!$id_sala){
			$contenido['datos'] = $this->objIndex->buscar_listado_distribucion($id_servicio, $fecha_busqueda);
		}else if($id_sala && $id_servicio){
			$contenido['datos'] = $this->objIndex->buscar_listado_distribucion_por_sala($id_servicio, $id_sala, $fecha_busqueda);
		}

		$servicios_select = $this->objServicioClinico->obtener(array('id_servicio' => $id_servicio)); 

		$contenido['nombre_servicio'] = $servicios_select->nombre_servicio;
		$contenido['fecha'] = $fecha;

		$this->layout->view('listaDistribucion', $contenido);
	}

	public function listaDistribucion_Formulas_Lacteas(){
		#Title
		$this->layout->title('Lista de Distribucion Formulas Lacteas');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion Formulas Lacteas');
		$this->layout->setMeta('description','Lista de Distribucion Formulas Lacteas');
		$this->layout->setMeta('keywords','Lista de Distribucion Formulas Lacteas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('listaDistribucion_Formulas_Lacteas', $contenido);
	}

	public function busquedaPorServicio_Formulas_Lacteas(){
		$id_servicio = $this->input->post('servicios');
		$id_sala = $this->input->post('salas');
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Lista de Distribucion Formulas Lacteas');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion Formulas Lacteas');
		$this->layout->setMeta('description','Lista de Distribucion Formulas Lacteas');
		$this->layout->setMeta('keywords','Lista de Distribucion Formulas Lacteas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		if(!$id_sala){
			$contenido['datos'] = $this->objIndex->solicitud_formula_lactea_por_fecha($id_servicio, $fecha_busqueda);
		}else if($id_sala && $id_servicio){
			$contenido['datos'] = $this->objIndex->solicitud_formula_lactea_por_sala($id_servicio, $id_sala, $fecha_busqueda);
		}	

		$servicios_select = $this->objServicioClinico->obtener(array('id_servicio' => $id_servicio)); 

		$contenido['nombre_servicio'] = $servicios_select->nombre_servicio;
		$contenido['fecha'] = $fecha;

		$this->layout->view('listaDistribucion_Formulas_Lacteas', $contenido);
	}

	public function listaDistribucion_Formulas_Enterales(){
		#Title
		$this->layout->title('Lista de Distribucion Formulas Enterales');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion Formulas Enterales');
		$this->layout->setMeta('description','Lista de Distribucion Formulas Enterales');
		$this->layout->setMeta('keywords','Lista de Distribucion Formulas Enterales');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('listaDistribucion_Formulas_Enterales', $contenido);
	}

	public function busquedaPorServicio_Formulas_Enterales(){
		$id_servicio = $this->input->post('servicios');
		$id_sala = $this->input->post('salas');
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Lista de Distribucion Formulas Enterales');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion Formulas Enterales');
		$this->layout->setMeta('description','Lista de Distribucion Formulas Enterales');
		$this->layout->setMeta('keywords','Lista de Distribucion Formulas Enterales');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		if(!$id_sala){
			$contenido['datos'] = $this->objIndex->solicitud_formula_enterales_por_fecha($id_servicio, $fecha_busqueda);
		}else if($id_sala && $id_servicio){
			$contenido['datos'] = $this->objIndex->solicitud_formula_enterales_por_sala($id_servicio, $id_sala, $fecha_busqueda);
		}

		$servicios_select = $this->objServicioClinico->obtener(array('id_servicio' => $id_servicio)); 

		$contenido['nombre_servicio'] = $servicios_select->nombre_servicio;
		$contenido['fecha'] = $fecha;

		$this->layout->view('listaDistribucion_Formulas_Enterales', $contenido);
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

	public function Informacion_nutricional_kcal() {
        $id_receta = $this->input->post('idDesayuno');

        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,1);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	echo number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_prot() {
        $id_receta = $this->input->post('idDesayuno');

        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,2);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	echo number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_lip() {
        $id_receta = $this->input->post('idDesayuno');

        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,3);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	echo number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_cho() {
        $id_receta = $this->input->post('idDesayuno');

        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,4);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	echo number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_Total_kcal() {
        $kcalDesayuno = $this->input->post('kcalDesayuno');
        $kcalOnce = $this->input->post('kcalOnce');
        $kcalCol10 = $this->input->post('kcalCol10');
        $kcalCol20 = $this->input->post('kcalCol20');
        $kcalAlm = $this->input->post('kcalAlmuerzo');
        $kcalCena = $this->input->post('kcalCena');

        $Informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $Informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

        $Informacion_nutricional = $this->objIndex->Informacion_nutricional_Total($kcalDesayuno, $kcalOnce, $kcalCol10, $kcalCol20, 1);
            //echo '<option value="0">Camas</option>';
        	$suma_total = 0;
        	$suma_total = $Informacion_almuerzo[0]->Kcal+$Informacion_cena[0]->Kcal;
            
        if($Informacion_nutricional || $Informacion_almuerzo || $Informacion_cena){
            //foreach($Informacion_nutricional as $datos){
            	$suma_total = $suma_total + $Informacion_nutricional->Total;
                echo number_format($suma_total, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_prot() {
        $kcalDesayuno = $this->input->post('kcalDesayuno');
        $kcalOnce = $this->input->post('kcalOnce');
        $kcalCol10 = $this->input->post('kcalCol10');
        $kcalCol20 = $this->input->post('kcalCol20');
        $kcalAlm = $this->input->post('kcalAlmuerzo');
        $kcalCena = $this->input->post('kcalCena');

        $Informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $Informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

        $Informacion_nutricional = $this->objIndex->Informacion_nutricional_Total($kcalDesayuno, $kcalOnce, $kcalCol10, $kcalCol20, 2);
            //echo '<option value="0">Camas</option>';
        $suma_total = 0;
        	$suma_total = $Informacion_almuerzo[0]->Prot+$Informacion_cena[0]->Prot;
        if($Informacion_nutricional || $Informacion_almuerzo || $Informacion_cena){
            //foreach($Informacion_nutricional as $datos){
            	$suma_total = $suma_total + $Informacion_nutricional->Total;
                echo number_format($suma_total, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_lip() {
        $kcalDesayuno = $this->input->post('kcalDesayuno');
        $kcalOnce = $this->input->post('kcalOnce');
        $kcalCol10 = $this->input->post('kcalCol10');
        $kcalCol20 = $this->input->post('kcalCol20');
        $kcalAlm = $this->input->post('kcalAlmuerzo');
        $kcalCena = $this->input->post('kcalCena');

        $Informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $Informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

        $Informacion_nutricional = $this->objIndex->Informacion_nutricional_Total($kcalDesayuno, $kcalOnce, $kcalCol10, $kcalCol20, 3);
            //echo '<option value="0">Camas</option>';
        $suma_total = 0;
        	$suma_total = $Informacion_almuerzo[0]->Lip+$Informacion_cena[0]->Lip;
        if($Informacion_nutricional || $Informacion_almuerzo || $Informacion_cena){
            //foreach($Informacion_nutricional as $datos){
            	$suma_total = $suma_total + $Informacion_nutricional->Total;
                echo number_format($suma_total, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_cho() {
        $kcalDesayuno = $this->input->post('kcalDesayuno');
        $kcalOnce = $this->input->post('kcalOnce');
        $kcalCol10 = $this->input->post('kcalCol10');
        $kcalCol20 = $this->input->post('kcalCol20');
        $kcalAlm = $this->input->post('kcalAlmuerzo');
        $kcalCena = $this->input->post('kcalCena');

        $Informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $Informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

        $Informacion_nutricional = $this->objIndex->Informacion_nutricional_Total($kcalDesayuno, $kcalOnce, $kcalCol10, $kcalCol20, 4);
            //echo '<option value="0">Camas</option>';
       	$suma_total = 0;
        	$suma_total = $Informacion_almuerzo[0]->Cho+$Informacion_cena[0]->Cho;
        if($Informacion_nutricional || $Informacion_almuerzo || $Informacion_cena){
            //foreach($Informacion_nutricional as $datos){
            	$suma_total = $suma_total + $Informacion_nutricional->Total;
                echo number_format($suma_total, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    //solo almuerzo
    public function Informacion_nutricional_kcal_alm() {
        $id_regimen = $this->input->post('idAlmuerzo');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 2));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Kcal, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_prot_alm() {
        $id_regimen = $this->input->post('idAlmuerzo');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 2));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Prot, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_lip_alm() {
        $id_regimen = $this->input->post('idAlmuerzo');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 2));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Lip, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_cho_alm() {
        $id_regimen = $this->input->post('idAlmuerzo');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 2));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Cho, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    //solo cena
    public function Informacion_nutricional_kcal_cena() {
        $id_regimen = $this->input->post('idCena');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 4));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Kcal, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_prot_cena() {
        $id_regimen = $this->input->post('idCena');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 4));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Prot, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_lip_cena() {
        $id_regimen = $this->input->post('idCena');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 4));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Lip, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Informacion_nutricional_cho_cena() {
        $id_regimen = $this->input->post('idCena');

        if($id_regimen){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_regimen, 'id_tipoaporte' => 4));
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	//foreach($Informacion_nutricional as $datos){
                	echo number_format($Informacion_nutricional[0]->Cho, 2, ',', '');
            	//}
            }else{
            	echo '0';
            }
        }  else {
            echo '0';
        }
    }

    public function Buscar_planificacion_desayuno() {
        $Informacion_nutricional = $this->objIndex->Informacion_nutricional_Total($kcalDesayuno, $kcalOnce, $kcalCol10, $kcalCol20, 4);
            //echo '<option value="0">Camas</option>';
        if($Informacion_nutricional){
            foreach($Informacion_nutricional as $datos){
                echo number_format($datos->Total, 2, ',', '');
            }
        }else{
           	echo '0';
        }
         
    }

    public function editar($codigo_solicitud = false){
    	#Title
		$this->layout->title('Editar Solicitud');

		#Metas
		$this->layout->setMeta('title','Editar Solicitud');
		$this->layout->setMeta('description','Editar Solicitud');
		$this->layout->setMeta('keywords','Editar Solicitud');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

    	$sol = $this->objIndex->buscar_solicitud_por_id($codigo_solicitud);

    	$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $sol->id_paciente));

    	$contenido['solicitud'] = $this->objIndex->buscar_solicitud_por_id($codigo_solicitud);

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['regimenes'] = $this->objRegimen->listar();

		$this->layout->view('editar_solicitud_lista_dist', $contenido);
			
	}

	public function editar_sol_list(){
		//editando la solicitud
		$sol = $this->objIndex->buscar_solicitud_por_id($this->input->post('codigo'));
		$paciente_general = $this->objPacGeneral->obtener(array('id_paciente' => $sol->id_paciente));

		$contenido['mesagge'] = "Solicitud del Paciente: ".$paciente_general->nombre." ".$paciente_general->apellido_paterno." ".$paciente_general->apellido_materno.", con fecha : ". $sol->fecha_registro." fue editada existosamente";

		$this->objIndex->editar_solicitud_por_listado($this->input->post('codigo'), $this->input->post('codigo_desayuno'), $this->input->post('codigo_almuerzo'), $this->input->post('codigo_once'), $this->input->post('codigo_cena'), $this->input->post('codigo_col10'), $this->input->post('codigo_col20'), $this->session->userdata("usuario")->id_usuario);

		#Title
		$this->layout->title('Lista de Distribucion');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion');
		$this->layout->setMeta('description','Lista de Distribucion');
		$this->layout->setMeta('keywords','Lista de Distribucion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');
		
		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('listaDistribucion', $contenido);
	}

	public function eliminar($codigo_solicitud = false){
		//editando la solicitud
		$sol = $this->objIndex->buscar_solicitud_por_id($codigo_solicitud);
		$paciente_general = $this->objPacGeneral->obtener(array('id_paciente' => $sol->id_paciente));

		$contenido['mesagge'] = "Solicitud del Paciente: ".$paciente_general->nombre." ".$paciente_general->apellido_paterno." ".$paciente_general->apellido_materno.", con fecha : ". $sol->fecha_registro." fue eliminada correctamente";

		$this->objIndex->eliminar_solicitud($codigo_solicitud);

		#Title
		$this->layout->title('Lista de Distribucion');

		#Metas
		$this->layout->setMeta('title','Lista de Distribucion');
		$this->layout->setMeta('description','Lista de Distribucion');
		$this->layout->setMeta('keywords','Lista de Distribucion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');
		
		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('listaDistribucion', $contenido);
	}

}