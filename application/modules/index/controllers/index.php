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
		$this->load->model("producto/modelo_producto", "objProducto");
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

			//MENU ADMINISTRADOR
			if($this->session->userdata("usuario")->id_perfil == 1){
				$this->layout->view('index_adm',$contenido);  
			//MENU ADMINISTRADOR DE ORGANIZACION
			}else if($this->session->userdata("usuario")->id_perfil == 2){
				$this->layout->view('index_adm_org',$contenido);  
			//MENU ADMINISTRADOR NUTRICIONISTA
			}else if($this->session->userdata("usuario")->id_perfil == 3){
				$this->layout->view('index_nutri',$contenido); 
			}
		//}else{
		//	$this->layout->title('Sistema Alimentación');
		//	$this->layout->setMeta('title','Sistema Alimentación');
		//	$this->layout->setMeta('description','Sistema Alimentación');
		//	$this->layout->setMeta('keywords','Sistema Alimentación');

		//	$contenido['unidades'] = $this->objIndex->unidades_usuario($this->session->userdata("usuario")->login);

		//	$this->layout->view('multiple_unidad',$contenido);
		//}      
	}

	public function ver_salas($servicio = false){
		//$servicio= $this->input->get('servicio',TRUE);	
		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$contenido['datos'] = $this->objIndex->Obtener_salas($servicio);

		$contenido['nombre_servicio'] = $this->objServicioClinico->obtener(array('id_servicio' => $servicio));

		$this->layout->view('salas',$contenido);
	}

	public function ver_camas($sala = false){
		//$sala= $this->input->get('sala',TRUE);	
		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $sala));
		$contenido['codigo_serv'] = $codigo_sala->CODSERV;
		//print_r($sala.'|'.$codigo_sala->CODSERV);die();

		//$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->CODSALA, $codigo_sala->CODSERV);
		$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->id_sala, $codigo_sala->CODSERV);

		$contenido['datos_salas'] = $this->objSalas->obtener(array('id_sala' => $sala));
		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

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
					   'egresado_sala' => $this->input->post('codigo_sala'),
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
		//$this->objPaciente->cambiar_estado_cero($this->input->post('rut'));
		$this->objPaciente->cambiar_estado_por_idpaciente($this->input->post('codigo'));

		//$this->objIndex->eliminar_paciente($this->input->post('codigo'));
		$this->objIndex->eliminar_paciente_hospitalizado($this->input->post('codigo'));

		$contenido['mesagge'] = $paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno." dado de alta";

		//$this->layout->view('paciente_egresado', $contenido);
		redirect('index/ver_camas/'.$this->input->post('codigo_sala'),$contenido);
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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0 ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));
			
			$this->layout->view('solicitud_clinica',$contenido);

		}else if ($this->input->post('boton1')) {
			//funcion de enviar la solicitud clinica
			if(!($this->input->post('codigo_desayuno')) && !($this->input->post('codigo_almuerzo')) && !($this->input->post('codigo_once')) && !($this->input->post('codigo_cena')) && !($this->input->post('codigo_col10')) && !($this->input->post('codigo_col20')) && !($this->input->post('formula'))){

				$contenido['mesagge'] = "No se ingresaron recetas, por favor ingresar alguna receta para registrar la solicitud de forma correcta";

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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

				$this->layout->view('solicitud_clinica',$contenido);
			}else{	
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
					'h22' => $h22,
					'formula_extra' => 0

				);
			$this->objIndex->insertar_solicitud($datos);

		$contenido['mesagge'] = "Solicitud ingresada para el paciente ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;

		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $this->input->post('codigo_sala')));
		$contenido['codigo_serv'] = $codigo_sala->CODSERV;
		//print_r($sala.'|'.$codigo_sala->CODSERV);die();

		//$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->CODSALA, $codigo_sala->CODSERV);

		$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->id_sala, $codigo_sala->CODSERV);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		//$this->layout->view('camas',$contenido);
		redirect('index/ver_camas/'.$this->input->post('codigo_sala'),$contenido);
		}	
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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
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

		$buscar_solictud_paciente = $this->objIndex->buscar_solicitud_dia_actual($paciente->id_paciente, $this->session->userdata("usuario")->id_unidad);

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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));
			
			$this->layout->view('editar_solicitud_clinica',$contenido);

		}else if ($this->input->post('boton1')) {
			//funcion de enviar la solicitud clinica
			if(!($this->input->post('codigo_desayuno')) && !($this->input->post('codigo_almuerzo')) && !($this->input->post('codigo_once')) && !($this->input->post('codigo_cena')) && !($this->input->post('codigo_col10')) && !($this->input->post('codigo_col20')) && !($this->input->post('formula'))){

				$contenido['mesagge'] = "No se ingresaron recetas, por favor ingresar alguna receta para registrar la solicitud de forma correcta";

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

			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
			$contenido['regimenes'] = $this->objRegimen->listar();
			$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
			$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

				$this->layout->view('solicitud_clinica',$contenido);
			}else{

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
					'h22' => $h22, 
					'formula_extra' => 0
				);
			$this->objIndex->editar_solicitud($datos,$this->input->post('codigo_solicitud'));

		$contenido['mesagge'] = "Solicitud editada para el paciente ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;

		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $this->input->post('codigo_sala')));
		$contenido['codigo_serv'] = $codigo_sala->CODSERV;
		//print_r($sala.'|'.$codigo_sala->CODSERV);die();

		//$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->CODSALA, $codigo_sala->CODSERV);
		$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->id_sala, $codigo_sala->CODSERV);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('camas',$contenido);
	}
			
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

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
		//$contenido['almuerzos'] = $this->objAlmuerzo->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
		//$contenido['cenas'] = $this->objCena->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['col_10'] = $this->objCol10->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
		//$contenido['col_20'] = $this->objCol20->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0  ));
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

		$contenido['pacientes'] = $this->objPacGeneral->listar(array("estado" => 0, "activo" => 0));

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
			//$contenido['sala'] = $this->objSalas->obtener(array('CODSALA' => $cama->codigo_sala));
			$contenido['sala'] = $this->objSalas->obtener(array('id_sala' => $cama->codigo_sala));

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
		$rut = $this->input->post('rut');
		$codpac = $this->input->post('codpac');
		$nombre_pac = $this->input->post('nombre_pac');
		$apellido_pat = $this->input->post('apellido_pat');
		$apellido_mat = $this->input->post('apellido_mat');
		$id_cama = $this->input->post('id_cama');

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

		//$contenido['datos'] = $this->objPacGeneral->listar(array("rut" => $query));
		$contenido['datos'] = $this->objPacGeneral->obtener_paciente_sin_hospitalizacion($rut, $codpac, $nombre_pac, $apellido_pac, $apellido_mat);

		//$contenido['pacientes'] = $this->objPacGeneral->listar(array("estado" => 0));

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

		if(!$id_servicio){

			$contenido['mesagge'] = "Debe ingresar al menos el servicio clinico a listar, intente de nuevo por favor";

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

		}else{

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

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($kcalDesayuno, 1);
        $info_once = $this->objIndex->inf_nutri($kcalOnce, 1);
        $info_col10 = $this->objIndex->inf_nutri($kcalCol10, 1);
        $info_col20 = $this->objIndex->inf_nutri($kcalCol20, 1);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

        //$Informacion_nutricional = $this->objIndex->Informacion_nutricional_Total($kcalDesayuno, $kcalOnce, $kcalCol10, $kcalCol20, 1);
            //echo '<option value="0">Camas</option>';
        	$suma_total = 0;
        	$suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$informacion_almuerzo[0]->Kcal+$informacion_cena[0]->Kcal;
            
        if($suma_total){
            //foreach($Informacion_nutricional as $datos){
            	//$suma_total = $suma_total + $Informacion_nutricional->Total;
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

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($kcalDesayuno, 2);
        $info_once = $this->objIndex->inf_nutri($kcalOnce, 2);
        $info_col10 = $this->objIndex->inf_nutri($kcalCol10, 2);
        $info_col20 = $this->objIndex->inf_nutri($kcalCol20, 2);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

            //echo '<option value="0">Camas</option>';
        $suma_total = 0;
        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$informacion_almuerzo[0]->Prot+$informacion_cena[0]->Prot;

        if($suma_total){
            //foreach($Informacion_nutricional as $datos){
            	//$suma_total = $suma_total + $Informacion_nutricional->Total;
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

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($kcalDesayuno, 3);
        $info_once = $this->objIndex->inf_nutri($kcalOnce, 3);
        $info_col10 = $this->objIndex->inf_nutri($kcalCol10, 3);
        $info_col20 = $this->objIndex->inf_nutri($kcalCol20, 3);
        
        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));
            //echo '<option value="0">Camas</option>';
        $suma_total = 0;
        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$informacion_almuerzo[0]->Lip+$informacion_cena[0]->Lip;
        if($suma_total){
            //foreach($Informacion_nutricional as $datos){
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

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($kcalDesayuno, 4);
        $info_once = $this->objIndex->inf_nutri($kcalOnce, 4);
        $info_col10 = $this->objIndex->inf_nutri($kcalCol10, 4);
        $info_col20 = $this->objIndex->inf_nutri($kcalCol20, 4);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $kcalAlm, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $kcalCena, 'id_tipoaporte' => 4));

            //echo '<option value="0">Camas</option>';
       	$suma_total = 0;
       	$suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$informacion_almuerzo[0]->Cho+$informacion_cena[0]->Cho;

        if($suma_total){
            //foreach($Informacion_nutricional as $datos){
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

    public function Informacion_nutricional_Total_kcal_formula() {
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        $info_formula = $this->objIndex->inf_nutri($formula, 1);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 1);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 1);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 1);

        $suma_total = 0;
        $suma_formula = 0;

        $suma_total = $info_formula->Total+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula =($suma_total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $suma_total;
        }
      
        if($suma_formula){
            //foreach($Informacion_nutricional as $datos){
            echo number_format($suma_formula, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_prot_formula() {
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');

        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        $info_formula = $this->objIndex->inf_nutri($formula, 2);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 2);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 2);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 2);

        $suma_total = 0;
        $suma_formula = 0;

        $suma_total = $info_formula->Total+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula =($suma_total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $suma_total;
        }
      
        if($suma_formula){
            //foreach($Informacion_nutricional as $datos){
                echo number_format($suma_formula, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_lip_formula() {
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
		$frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        $info_formula = $this->objIndex->inf_nutri($formula, 3);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 3);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 3);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 3);

        $suma_total = 0;
        $suma_formula = 0;

        $suma_total = $info_formula->Total+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula =($suma_total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $suma_total;
        }
      
        if($suma_formula){
            //foreach($Informacion_nutricional as $datos){
            echo number_format($suma_formula, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_cho_formula() {
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        $info_formula = $this->objIndex->inf_nutri($formula, 4);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 4);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 4);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 4);

        $suma_total = 0;
        $suma_formula = 0;

        $suma_total = $info_formula->Total+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula =($suma_total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $suma_total;
        }
      
        if($suma_formula){
            //foreach($Informacion_nutricional as $datos){
            echo number_format($suma_formula, 2, ',', '');
            //}
        }else{
           	echo '0';
        }
         
    }

    //suma total de informacion nutricional
    public function Informacion_nutricional_Total_kcal_sum() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 1);
        $info_once = $this->objIndex->inf_nutri($once, 1);
        $info_col10 = $this->objIndex->inf_nutri($col10, 1);
        $info_col20 = $this->objIndex->inf_nutri($col20, 1);
        $info_formula = $this->objIndex->inf_nutri($formula, 1);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 1);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 1);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 1);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Kcal+$informacion_cena[0]->Kcal;
      
        if($suma_total){
            echo number_format($suma_total, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_prot_sum() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 2);
        $info_once = $this->objIndex->inf_nutri($once, 2);
        $info_col10 = $this->objIndex->inf_nutri($col10, 2);
        $info_col20 = $this->objIndex->inf_nutri($col20, 2);
        $info_formula = $this->objIndex->inf_nutri($formula, 2);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 2);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 2);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 2);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Prot+$informacion_cena[0]->Prot;
      
        if($suma_total){
            echo number_format($suma_total, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_lip_sum() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 3);
        $info_once = $this->objIndex->inf_nutri($once, 3);
        $info_col10 = $this->objIndex->inf_nutri($col10, 3);
        $info_col20 = $this->objIndex->inf_nutri($col20, 3);
        $info_formula = $this->objIndex->inf_nutri($formula, 3);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 3);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 3);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 3);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }
        
        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Lip+$informacion_cena[0]->Lip;
      
        if($suma_total){
            echo number_format($suma_total, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }

    public function Informacion_nutricional_Total_cho_sum() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 4);
        $info_once = $this->objIndex->inf_nutri($once, 4);
        $info_col10 = $this->objIndex->inf_nutri($col10, 4);
        $info_col20 = $this->objIndex->inf_nutri($col20, 4);
        $info_formula = $this->objIndex->inf_nutri($formula, 4);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 4);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 4);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 4);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Cho+$informacion_cena[0]->Cho;

        if($suma_total){
                echo number_format($suma_total, 2, ',', '');
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

		$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0 ));
		$contenido['onces'] = $this->objOnce->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0 ));
		$contenido['colaciones'] = $this->objColacion->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad, "estado" => 0 ));
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

	public function formula_extra($codigo = false){
		#Title
		$this->layout->title('Formula Extra');

		#Metas
		$this->layout->setMeta('title','Formula Extra');
		$this->layout->setMeta('description','Formula Extra');
		$this->layout->setMeta('keywords','Formula Extra');

		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		//buscar datos del paciente
		$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
		$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

		$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		$this->layout->view('formula_extra',$contenido);
	}

	public function agregar_formula(){
		//funcion de enviar la solicitud clinica
		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $this->input->post('id_paciente_general')));
		
		if(!($this->input->post('formula')) || !($this->input->post('volumen')) || !($this->input->post('frecuencia'))){
			
			$contenido['mesagge'] = "Debe ingresar Formula, volumen y frecuencia, por favor intentar de nuevo";

			$recetas = array('formula_codigo'=> $this->input->post('formula'),
							 'c1_codigo'=> $this->input->post('compl1'),
							 'c2_codigo'=> $this->input->post('compl2'),
							 'c3_codigo'=> $this->input->post('compl3'),
							 'volumen'=> $this->input->post('volumen'),
							 'frecuencia'=> $this->input->post('frecuencia')
							);
			$contenido['codigos'] = $recetas;

			#Title
		$this->layout->title('Formula Extra');

		#Metas
		$this->layout->setMeta('title','Formula Extra');
		$this->layout->setMeta('description','Formula Extra');
		$this->layout->setMeta('keywords','Formula Extra');

		$paciente_hosp = $this->objPaciente->obtener(array('codigo_paciente' => $paciente->id_paciente));

		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		//buscar datos del paciente
		$contenido['paciente_hospitalizado'] = $this->objPaciente->obtener(array('codigo_paciente' => $paciente->id_paciente));

		$contenido['complementos'] = $this->objRecetas->listar(array("complemento" => 1));
		$contenido['formulas'] = $this->objRecetas->listar(array("formula" => 1));

		$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		$this->layout->view('formula_extra',$contenido);

		}else{
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
					'h22' => $h22, 
					'formula_extra' => 1

				);
			$this->objIndex->insertar_solicitud($datos);

		$contenido['mesagge'] = "Formula Extra ingresada para el paciente ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;

		//$this->layout->view('confirmacion_solicitud',$contenido);

		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $this->input->post('codigo_sala')));
		$contenido['codigo_serv'] = $codigo_sala->CODSERV;
		//print_r($sala.'|'.$codigo_sala->CODSERV);die();

		//$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->CODSALA, $codigo_sala->CODSERV);
		$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->id_sala, $codigo_sala->CODSERV);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		//$this->layout->view('camas',$contenido);
		redirect('index/ver_camas/'.$this->input->post('codigo_sala'),$contenido);
	}
	}

	//ver lo planificado en la solicitud
	public function obtener_planificacion_desayuno(){
		$servicio_alim = 1;
		$planificacion_desayuno = $this->objIndex->obtenerPlanicacion($servicio_alim);

		if($planificacion_desayuno){
           foreach($planificacion_desayuno as $plan_desayuno){ 
                echo '<tr>';
                	echo '<td>'.$plan_desayuno->nombre_receta.'</td>
                    	  <td>'.$plan_desayuno->nombre_regimen.'</td>';
                    $insumos = 	$this->objIndex->obtenerInsumos($plan_desayuno->id_receta); 
                    if($insumos){ 
                    	//$lista_insumos = '';
                   		echo '<td><ul>';
                   		foreach ($insumos as $datos_insumos) {
                   			//$lista_insumos = $lista_insumos.'-'.$datos_insumos->nombre_insumo;
							echo '<li>'.$datos_insumos->nombre_insumo.'</li>';
                   		}
						echo '</ul></td>';
                   		//echo '<td>'.$lista_insumos.'</td>';
                   	}else{
                   		echo '<td> No se registran insumos</td>';
                   	}	
               	echo '</tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 
	}

	public function obtener_planificacion_alm(){
		$servicio_alim = 2;
		$planificacion_alm = $this->objIndex->obtenerPlanicacion($servicio_alim);

		if($planificacion_alm){
           foreach($planificacion_alm as $plan_alm){ 
                echo '<tr>';
                	echo '<td>'.$plan_alm->nombre_receta.'</td>
                    	  <td>'.$plan_alm->nombre_regimen.'</td>';
                    $insumos = 	$this->objIndex->obtenerInsumos($plan_alm->id_receta); 
                    if($insumos){ 
                    	//$lista_insumos = '';
                   		echo '<td><ul>';
                   		foreach ($insumos as $datos_insumos) {
                   			//$lista_insumos = $lista_insumos.'-'.$datos_insumos->nombre_insumo;
							echo '<li>'.$datos_insumos->nombre_insumo.'</li>';
                   		}
						echo '</ul></td>';
                   		//echo '<td>'.$lista_insumos.'</td>';
                   	}else{
                   		echo '<td> No se registran insumos</td>';
                   	}	
               	echo '</tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 
	}

	public function obtener_planificacion_once(){
		$servicio_alim = 16;
		$planificacion_once = $this->objIndex->obtenerPlanicacion($servicio_alim);

		if($planificacion_once){
           foreach($planificacion_once as $plan_once){ 
                echo '<tr>';
                	echo '<td>'.$plan_once->nombre_receta.'</td>
                    	  <td>'.$plan_once->nombre_regimen.'</td>';
                    $insumos = 	$this->objIndex->obtenerInsumos($plan_once->id_receta); 
                    if($insumos){ 
                    	//$lista_insumos = '';
                   		echo '<td><ul>';
                   		foreach ($insumos as $datos_insumos) {
                   			//$lista_insumos = $lista_insumos.'-'.$datos_insumos->nombre_insumo;
							echo '<li>'.$datos_insumos->nombre_insumo.'</li>';
                   		}
						echo '</ul></td>';
                   		//echo '<td>'.$lista_insumos.'</td>';
                   	}else{
                   		echo '<td> No se registran insumos</td>';
                   	}	
               	echo '</tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 
	}

	public function obtener_planificacion_cena(){
		$servicio_alim = 4;
		$planificacion_cena = $this->objIndex->obtenerPlanicacion($servicio_alim);

		if($planificacion_cena){
           foreach($planificacion_cena as $plan_cena){ 
                echo '<tr>';
                	echo '<td>'.$plan_cena->nombre_receta.'</td>
                    	  <td>'.$plan_cena->nombre_regimen.'</td>';
                    $insumos = 	$this->objIndex->obtenerInsumos($plan_cena->id_receta); 
                    if($insumos){ 
                    	//$lista_insumos = '';
                   		echo '<td><ul>';
                   		foreach ($insumos as $datos_insumos) {
                   			//$lista_insumos = $lista_insumos.'-'.$datos_insumos->nombre_insumo;
							echo '<li>'.$datos_insumos->nombre_insumo.'</li>';
                   		}
						echo '</ul></td>';
                   		//echo '<td>'.$lista_insumos.'</td>';
                   	}else{
                   		echo '<td> No se registran insumos</td>';
                   	}	
               	echo '</tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 
	}

	public function obtener_planificacion_col(){
		$servicio_alim = 12;
		$planificacion_col = $this->objIndex->obtenerPlanicacion($servicio_alim);

		if($planificacion_col){
           foreach($planificacion_col as $plan_col){ 
                echo '<tr>';
                	echo '<td>'.$plan_col->nombre_receta.'</td>
                    	  <td>'.$plan_col->nombre_regimen.'</td>';
                    $insumos = 	$this->objIndex->obtenerInsumos($plan_col->id_receta); 
                    if($insumos){ 
                    	//$lista_insumos = '';
                   		echo '<td><ul>';
                   		foreach ($insumos as $datos_insumos) {
                   			//$lista_insumos = $lista_insumos.'-'.$datos_insumos->nombre_insumo;
							echo '<li>'.$datos_insumos->nombre_insumo.'</li>';
                   		}
						echo '</ul></td>';
                   		//echo '<td>'.$lista_insumos.'</td>';
                   	}else{
                   		echo '<td> No se registran insumos</td>';
                   	}	
               	echo '</tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 
	}

	public function vista_informe_almuerzo(){
		#Title
		$this->layout->title('Informe Solicitudes de Almuerzo');

		#Metas
		$this->layout->setMeta('title','Informe Solicitudes de Almuerzo');
		$this->layout->setMeta('description','Informe Solicitudes de Almuerzo');
		$this->layout->setMeta('keywords','Informe Solicitudes de Almuerzo');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_informe_almuerzo');
	}

	public function Informe_solicitudes_almuerzo(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		$this->layout->title('Informe Solicitudes de Almuerzo');
		$this->layout->setMeta('title','Informe Solicitudes de Almuerzo');
		$this->layout->setMeta('description','Informe Solicitudes de Almuerzo');
		$this->layout->setMeta('keywords','Informe Solicitudes de Almuerzo');

		$contenido['bases'] = $this->objIndex->Obtener_bases();

		$contenido['fecha'] = $fecha;

		$contenido['fecha_busqueda'] = $fecha_busqueda;

		$this->layout->view('informe_solicitudes_almuerzo',$contenido);
	}

	public function vista_informe_cena(){
		#Title
		$this->layout->title('Informe Solicitudes de Cena');

		#Metas
		$this->layout->setMeta('title','Informe Solicitudes de Cena');
		$this->layout->setMeta('description','Informe Solicitudes de Cena');
		$this->layout->setMeta('keywords','Informe Solicitudes de Cena');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_informe_cena');
	}

	public function Informe_solicitudes_cena(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		$this->layout->title('Solicitudes de Cena');
		$this->layout->setMeta('title','Solicitudes de Cena');
		$this->layout->setMeta('description','Solicitudes de Cena');
		$this->layout->setMeta('keywords','Solicitudes de Cena');

		$contenido['bases'] = $this->objIndex->Obtener_bases();

		$contenido['fecha'] = $fecha;

		$contenido['fecha_busqueda'] = $fecha_busqueda;

		$this->layout->view('informe_solicitudes_cena',$contenido);
	}

	public function ingesta_real($codigo = false){
		$paciente_hosp = $this->objPaciente->obtener(array('id_paciente' => $codigo));

		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

		$buscar_solictud_paciente = $this->objIndex->buscar_solicitud_dia_actual($paciente->id_paciente, $this->session->userdata("usuario")->id_unidad);

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
							 'c3_codigo'=> $compl3
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

			$contenido['paciente_general'] = $this->objPacGeneral->obtener(array('id_paciente' => $paciente_hosp->codigo_paciente));

			$this->layout->view('ingesta_real',$contenido);
	}

	public function agregar_ingesta_Real(){

		$paciente = $this->objPacGeneral->obtener(array('id_paciente' => $this->input->post('id_paciente_general')));

		$this->objIndex->agregar_ingesta_real($this->input->post('codigo_solicitud'), $this->input->post('porcentaje_ingesta'));

		$contenido['mesagge'] = "Porcentaje Ingesta real ingresada para el paciente ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;

		//$this->layout->view('confirmacion_solicitud',$contenido);

		$this->layout->title('Sistema Alimentación');
	
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

		$codigo_sala = $this->objSalas->obtener(array('id_sala' => $this->input->post('codigo_sala')));
		$contenido['codigo_serv'] = $codigo_sala->CODSERV;
		//print_r($sala.'|'.$codigo_sala->CODSERV);die();

		//$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->CODSALA, $codigo_sala->CODSERV);
		$contenido['datos'] = $this->objIndex->Obtener_camas($codigo_sala->id_sala, $codigo_sala->CODSERV);

		$contenido['hospitalizados'] = $this->objPaciente->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('camas',$contenido);
	}

	public function listado_ingesta_real(){
		$this->layout->title('Informe Ingesta Real');
	
		$this->layout->setMeta('title','Informe Ingesta Real');
		$this->layout->setMeta('description','Informe Ingesta Real');
		$this->layout->setMeta('keywords','Informe Ingesta Real');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['hospitalizados'] = $this->objPaciente->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('Informe_ingesta_real',$contenido);
	}

	public function busqueda_pacientes_ingesta_real(){
		$paciente = $this->input->post('hospitalizados');

		$consulta = $this->objIndex->consulta_solicitud_dia_actual($paciente, $this->session->userdata("usuario")->id_unidad);

		if ($consulta) {
			//armando el listado de informacion nutricional
			$desayuno = $consulta->id_desayuno;
	        $once = $consulta->id_once;
	        $col10 = $consulta->id_col10;
	        $col20 = $consulta->id_col20;
	        $almuerzo = $consulta->id_almuerzo;
	        $cena = $consulta->id_cena;
	        $formula = $consulta->id_formula;
	        $comp1 = $consulta->id_complemento1;
	        $comp2 = $consulta->id_complemento2;
	        $comp3 = $consulta->id_complemento3;

	        //consultas con cada aporte nutricional
	        //CALORIAS
	        $Informacion_nutricional_KCAL = $this->objIndex->Informacion_nutricional_Total_sum($desayuno, $once, $col10, $col20, $formula, $comp1, $comp2, $comp3, 1);

	        $Informacion_almuerzo_KCAL = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

	        $Informacion_cena_KCAL = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

	        $suma_total_KCAL = 0;
	        $total_kcal= 0;
	        $suma_total_KCAL = $Informacion_almuerzo_KCAL[0]->Kcal+$Informacion_cena_KCAL[0]->Kcal;
	      
	        if($Informacion_nutricional_KCAL || $Informacion_almuerzo_KCAL || $Informacion_cena_KCAL){
	            $suma_total_KCAL = $suma_total_KCAL + $Informacion_nutricional_KCAL->Total;
	            $total_kcal = number_format($suma_total_KCAL, 2, ',', '');
	        }else{
	           	$total_kcal = $suma_total_KCAL + 0;
	        }

	        //fin suma Total de calorias
	        //PROTEINAS
	        $Informacion_nutricional_PROT = $this->objIndex->Informacion_nutricional_Total_sum($desayuno, $once, $col10, $col20, $formula, $comp1, $comp2, $comp3, 2);

	        $Informacion_almuerzo_PROT = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

	        $Informacion_cena_PROT = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

	        $suma_total_prot = 0;
	        $total_prot= 0;
	        $suma_total_prot = $Informacion_almuerzo_PROT[0]->Prot+$Informacion_cena_PROT[0]->Prot;
	      
	        if($Informacion_nutricional_PROT || $Informacion_almuerzo_PROT || $Informacion_cena_PROT){
	            $suma_total_prot = $suma_total_prot + $Informacion_nutricional_PROT->Total;
	            $total_prot = number_format($suma_total_prot, 2, ',', '');
	        }else{
	           	$total_prot = $suma_total_prot + 0;
	        }

	        //fin suma Total de proteinas
	        //LIPIDOS
	        $Informacion_nutricional_LIP = $this->objIndex->Informacion_nutricional_Total_sum($desayuno, $once, $col10, $col20, $formula, $comp1, $comp2, $comp3, 3);

	        $Informacion_almuerzo_LIP = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

	        $Informacion_cena_LIP = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

	        $suma_total_lip = 0;
	        $total_lip= 0;
	        $suma_total_lip = $Informacion_almuerzo_LIP[0]->Lip+$Informacion_cena_LIP[0]->Lip;
	      
	        if($Informacion_nutricional_LIP || $Informacion_almuerzo_LIP || $Informacion_cena_LIP){
	            $suma_total_lip = $suma_total_lip + $Informacion_nutricional_LIP->Total;
	            $total_lip = number_format($suma_total_lip, 2, ',', '');
	        }else{
	           	$total_lip = $suma_total_lip + 0;
	        }

	        //fin suma Total de Lipidos
	        //CARBOHIDRATOS
	        $Informacion_nutricional_CHO = $this->objIndex->Informacion_nutricional_Total_sum($desayuno, $once, $col10, $col20, $formula, $comp1, $comp2, $comp3, 4);

	        $Informacion_almuerzo_CHO = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

	        $Informacion_cena_CHO = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

	        $suma_total_cho = 0;
	        $total_cho = 0;
	        $suma_total_cho = $Informacion_almuerzo_CHO[0]->Cho+$Informacion_cena_CHO[0]->Cho;
	      
	        if($Informacion_nutricional_CHO || $Informacion_almuerzo_CHO || $Informacion_cena_CHO){
	            $suma_total_cho = $suma_total_cho + $Informacion_nutricional_CHO->Total;
	            $total_cho =  number_format($suma_total_cho, 2, ',', '');
	        }else{
	           	$total_cho = $suma_total_cho + 0;
	        }
	        //fin suma Total de carbohidratos
	        //AGRUPAR INFORMACION NUTRICIONAL

	        $contenido['informacion_nutricional'] = $total_kcal.' | '.$total_prot.' | '.$total_lip.' | '.$total_cho;
	        $contenido['ingesta_real'] = $total_kcal*($consulta->porcentaje_ingesta/100).' | '.$total_prot*($consulta->porcentaje_ingesta/100).' | '.$total_lip*($consulta->porcentaje_ingesta/100).' | '.$total_cho*($consulta->porcentaje_ingesta/100);	

	        $contenido['pacientes'] = $this->objPaciente->obtener(array('codigo_paciente' => $consulta->id_paciente, 'id_unidad' => $this->session->userdata("usuario")->id_unidad));

	        //print_array($contenido['pacientes']);die();
			//print_r("aaaaaaaa");die();
		}else{
			$contenido['mesagge'] = 'No se puedo procesar la accion solicitada, debido que la solicitud clinica no tiene asignado un porcentaje ingesta real o no se ha generado la solicitud del paciente el dia de hoy';			
		}

		$this->layout->title('Informe Ingesta Real');
	
		$this->layout->setMeta('title','Informe Ingesta Real');
		$this->layout->setMeta('description','Informe Ingesta Real');
		$this->layout->setMeta('keywords','Informe Ingesta Real');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['hospitalizados'] = $this->objPaciente->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('Informe_ingesta_real',$contenido);
	}

	public function paciente_egresados(){
		$this->layout->title('Pacientes Egresados');
	
		$this->layout->setMeta('title','Pacientes Egresados');
		$this->layout->setMeta('description','Pacientes Egresados');
		$this->layout->setMeta('keywords','Pacientes Egresados');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['pacientes'] = $this->objPacGeneral->listar();

		$this->layout->view('paciente_egresados',$contenido);
	}

	public function busqueda_pacientes_egresados(){
		$id_paciente = $this->input->post('pacientes',true);

		$this->layout->title('Pacientes Egresados');
	
		$this->layout->setMeta('title','Pacientes Egresados');
		$this->layout->setMeta('description','Pacientes Egresados');
		$this->layout->setMeta('keywords','Pacientes Egresados');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objIndex->buscar_egresos($id_paciente, $this->session->userdata("usuario")->id_unidad);

		$this->layout->view('paciente_egresados',$contenido);
	}

	public function migracion_datos(){
		$this->layout->title('Migracion de Datos');
	
		$this->layout->setMeta('title','Migracion de Datos');
		$this->layout->setMeta('description','Migracion de Datos');
		$this->layout->setMeta('keywords','Migracion de Datos');

		#js
		$this->layout->js('js/sistema/index/file.js');

		$this->layout->view('migracion_datos');
	}

	public function importar_datos(){
		if($_FILES['archivo']['error'] == 0){

			if($_FILES['archivo']['name']==''){
				echo json_encode(array("result"=>false,"msg"=>"Debes subir un archivo"));
				exit;
			}
			
			$uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/archivos/';
			if(!file_exists($uploads_dir)){
				mkdir($uploads_dir,0777);
			}
			$uploads_dir .= "importaciones/";
			if(!file_exists($uploads_dir))
				mkdir($uploads_dir,0777);

			$extension = explode(".",$_FILES['archivo']['name']);
			$extension = array_pop($extension);
			$extension = strtolower($extension);
			$permitidas = array("xls","xlsx"); #extensiones permitidas
			$name = 'importacion_'.time();
			$tmp = $_FILES["archivo"]["tmp_name"];
			
			if(!in_array($extension, $permitidas)){
				echo json_encode(array("result"=>false,"msg"=>"<div>Formato no permitido, solo se acepta xls y xlsx</div>"));
				exit;
			}
			
			move_uploaded_file($tmp, $uploads_dir.$name . "." . $extension);
			if(is_file($uploads_dir.$name . "." . $extension))
				chmod($uploads_dir.$name . "." . $extension, 0777);

			$ext = "Excel5";
			if($extension == "xlsx")
				$ext = "Excel2007";
			
			$objReader = PHPExcel_IOFactory::createReader($ext);
			$objReader->setReadDataOnly(true);
			$objReader->setLoadSheetsOnly("Hoja1"); 
			if(!is_readable($uploads_dir.$name . "." . $extension)) {
				echo json_encode(array("result"=>false,"msg"=>"<div>El archivo esta corrupto.</div>"));
				exit;
			}
			$objPHPExcel = $objReader->load($uploads_dir.$name . "." . $extension);

			$letra = 'A';
			$i = 2;
			$contador_msg = 0;
			$arreglo_hhcc = array();

			while(true){
				//insercion en las bdd correspondientes
				//PACIENTE(INDICE)	
				$paciente = new stdClass();
				$paciente->rut = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
					//print_r("paso");die();
				$paciente->dv = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$paciente->codigo_paciente = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$paciente->nombre_paciente = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				if ($paciente->nombre_paciente) {

				$paciente->apellido_paterno = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$paciente->apellido_materno = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				//$paciente->fecha_nacimiento = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();


				//PACIENTE HOSPITALIZADO
				$paciente_hospitalizado = new stdClass();
				$paciente_hospitalizado->codigo_atencion = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				//DIAGNOSTICO
				$diagnostico = new stdClass();
				$diagnostico->codigo_diagnostico = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$diagnostico->diagnostico = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				//SERVICIO CLINICO
				$servicio = new stdClass();
				$servicio->codigo_servicio = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$servicio->nombre_servicio = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				//print_array($servicio);die();
				//SALA
				$sala = new stdClass();
				$sala->codigo_sala = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$sala->nombre_sala = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				//CAMA
				$cama = new stdClass();
				//$servicio->codigo_cama = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$cama->cama = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				$paciente_hospitalizado->peso = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$paciente_hospitalizado->estatura = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();

				//INGRESAMOS PACIENTES QUE NO ESTEN REGISTRADOS ACTUALMENTE
				//if(!$this->objPacGeneral->obtener(array("rut" => $paciente->rut))){
				if(!$this->objPacGeneral->obtener(array("codigo_paciente" => $paciente->codigo_paciente))){
					//$fecha_nacimiento = date("Y-m-d", strtotime(str_replace("/", "-", $paciente->fecha_nacimiento)));

						$datos = array(
							'id_paciente' => null,
							'rut' => $paciente->rut,
							'codigo_paciente' => $paciente->codigo_paciente,
							'dv' => $paciente->dv,
							'nombre' => strtoupper($paciente->nombre_paciente),
							'apellido_paterno' => strtoupper($paciente->apellido_paterno),
							'apellido_materno' => strtoupper($paciente->apellido_materno),
							'fecha_registro' => date('Y-m-d H:i:s'),
							'telefono' => null,
							//'fecha_nacimiento' => $fecha_nacimiento,
							'fecha_nacimiento' => null,
							'estado' => 1,
							'direccion' => null,
							'nombre_padre' => null,
							'nombre_madre' => null,
							'id_escolaridad' => null,
							'ocupacion_actual' => null,
							'sexo' => null,
							'correo' => null,
							'id_etnia' => null,
							'hc' => null,
							'pais' => null,
							'comuna' => null,
							'region' => null,
							'alergias' => null,
							'enfermedades_cronicas' => null,
							'farmacos_uso_habitual' => null,
							'antecedentes_familiares' => null,
							'fumador' => null,
							'cantidad_cigarros' => null
						);

						$this->objPacGeneral->insertar($datos);		
				}
				
				//INGRESAMOS DIAGNOSTICOS
				if(!$this->objDiagnostico->obtener(array("diagnostico_codigo" => "".$diagnostico->codigo_diagnostico.""))){
						$datos = array(
						'id_diagnostico' => null,
						'diagnostico_codigo' => $diagnostico->codigo_diagnostico,
						'diagnostico_descripcion' => $diagnostico->diagnostico,
						'diagnostico_observacion' => null
						);
					//print_r($datos);die();
					$this->objDiagnostico->insertar($datos);
				}

				//INGRESAMOS SERVICIO CLINICO
				if(!$this->objServicioClinico->obtener(array("codigo_servicio" => $servicio->codigo_servicio, 'id_unidad' => $this->session->userdata("usuario")->id_unidad))){
						$datos = array(
						'id_servicio' => null,
						'codigo_servicio' => $servicio->codigo_servicio,
						'nombre_servicio' => $servicio->nombre_servicio,
						'id_unidad' => $this->session->userdata("usuario")->id_unidad
					);
				
					$this->objServicioClinico->insertar($datos);
				}

				//INGRESAMOS SALAS
				$servicio_clinico = $this->objServicioClinico->obtener(array("codigo_servicio" => $servicio->codigo_servicio, 'id_unidad' => $this->session->userdata("usuario")->id_unidad));

				if(!$this->objSalas->obtener(array("CODSALA" => $sala->codigo_sala, 'CODSERV' => $servicio_clinico->id_servicio , 'id_unidad' => $this->session->userdata("usuario")->id_unidad))){	


					$datos = array(
						'id_sala' => null,
						'CODSALA' => $sala->codigo_sala,
						'NOMSALA' => $sala->nombre_sala,
						'CODSERV' => $servicio_clinico->id_servicio,
						'id_unidad' => $this->session->userdata("usuario")->id_unidad
					);
					
					$this->objSalas->insertar($datos);
				}

				$servicio_clinico = $this->objServicioClinico->obtener(array("codigo_servicio" => $servicio->codigo_servicio, 'id_unidad' => $this->session->userdata("usuario")->id_unidad));

				$salas = $this->objSalas->obtener(array("CODSALA" => $sala->codigo_sala, 'CODSERV' => $servicio_clinico->id_servicio , 'id_unidad' => $this->session->userdata("usuario")->id_unidad));
				
				//INGRESANDO LAS CAMAS
				if(!$this->objCamas->obtener(array("codigo_servicio" => $servicio_clinico->id_servicio, "codigo_sala" => $salas->id_sala, "cama" => $cama->cama, 'id_unidad' => $this->session->userdata("usuario")->id_unidad))){
						

						$datos = array(
							'id_cama' => null,
							'cama' => $cama->cama,
							'codigo_sala' => $salas->id_sala,
							'codigo_servicio' => $servicio_clinico->id_servicio,
							'id_unidad' => $this->session->userdata("usuario")->id_unidad
						);
						
						$this->objCamas->insertar($datos);
				}
				

				//INGRESAMOS LAS HOSPITALIZACIONES
				//if(!$this->objPaciente->obtener(array("rut" => $paciente->rut))){
					
					$dividendo = (($paciente_hospitalizado->estatura/100)*($paciente_hospitalizado->estatura/100));

					$imc = (int)($paciente_hospitalizado->peso/$dividendo);
					//print_r($imc);die();

					//$codigo_paciente = $this->objPacGeneral->obtener(array("rut" => $paciente->rut));

					$codigo_paciente = $this->objPacGeneral->obtener(array("codigo_paciente" => $paciente->codigo_paciente));

					$servicio_clinico = $this->objServicioClinico->obtener(array("codigo_servicio" => $servicio->codigo_servicio, 'id_unidad' => $this->session->userdata("usuario")->id_unidad));

					$salas = $this->objSalas->obtener(array("CODSALA" => $sala->codigo_sala, 'CODSERV' => $servicio_clinico->id_servicio , 'id_unidad' => $this->session->userdata("usuario")->id_unidad));

					$camas = $this->objCamas->obtener(array("codigo_servicio" => $servicio_clinico->id_servicio, "codigo_sala" => $salas->id_sala, "cama" => $cama->cama, 'id_unidad' => $this->session->userdata("usuario")->id_unidad));

					//print_array($camas);die();

					$diagnosticos = $this->objDiagnostico->obtener(array("diagnostico_codigo" => "".$diagnostico->codigo_diagnostico.""));

					if(!$this->objPaciente->obtener(array("codigo_cama" => $camas->id_cama))){
					//print_r("paso");die();

					$datos = array(
						'id_paciente' => null,
						'codigo_paciente' => $codigo_paciente->id_paciente,
						'codigo_atencion' => $paciente_hospitalizado->codigo_atencion,
						'diagnostico' => $diagnosticos->id_diagnostico,
						'medico_tratante' => null,
						'observacion_diagnostico' => null,
						'estado' => 1,
						'fecha_ingreso' => date('Y-m-d H:i:s'),
						'codigo_servicio' => $servicio_clinico->id_servicio,
						'codigo_sala' => $salas->id_sala,
						'codigo_cama' => $camas->id_cama,
						'estatura' => $paciente_hospitalizado->estatura,
						'peso' => $paciente_hospitalizado->peso,
						'imc' => $imc,
						'anamnesis' => null,
						'tratamiento' => null,
						'id_unidad' => $this->session->userdata("usuario")->id_unidad
					);

					$this->objPaciente->insertar($datos);

					}else{
						$contador_msg++;
						$mensaje_error = '';
						$mensaje_error = "Problema en la fila n° ".$i." | Cama Ocupada: servicio: ".$servicio_clinico->nombre_servicio." | sala: ".$salas->NOMSALA." | cama: ". $camas->cama;
						//$this->layout->view('migracion_datos', $contenido);
						//break;	
						array_push($arreglo_hhcc, $mensaje_error);
					}
				//}

				$letra = 'A';
				$i++;
			}else{
				break;	
			}	
						
			}
			
			if ($contador_msg) {
				$contenido['arreglo'] = $arreglo_hhcc;
				$this->layout->view('migracion_datos', $contenido);
			}else{
				$contenido['mesagge'] = "Datos Subidos correctamente!!!!";
				$this->layout->view('migracion_datos', $contenido);	
			}	
				
		}else{
			$contenido['mesagge'] = "ERROR !!!, Debe subir un archivo";
			$this->layout->view('migracion_datos', $contenido);
		}
	}

	public function Ejemplo_Migracion_Datos(){
		redirect(base_url() . "/archivos/ejemplo_migracion_datos.xlsx");
	}

	public function liberar_clinica(){
		$this->layout->title('Liberar Clinica');
	
		$this->layout->setMeta('title','Liberar Clinica');
		$this->layout->setMeta('description','Liberar Clinica');
		$this->layout->setMeta('keywords','Liberar Clinica');

		$this->layout->view('liberar_clinica');
	}

	public function liberar(){
		$this->layout->title('Liberar Clinica');
	
		$this->layout->setMeta('title','Liberar Clinica');
		$this->layout->setMeta('description','Liberar Clinica');
		$this->layout->setMeta('keywords','Liberar Clinica');

		//buscar los pacientes a liberar
		$pacientes_hospitalizados = $this->objPaciente->listar(array('id_unidad' => $this->session->userdata("usuario")->id_unidad));

		foreach ($pacientes_hospitalizados as $hosp) {
			$this->objIndex->desmarcar_estado_indicepaciente($hosp->codigo_paciente);
		}

		$this->objIndex->liberar_clinica($this->session->userdata("usuario")->id_unidad);

		$contenido['mesagge'] = "Clinica Liberada correctamente !!!";

		$this->layout->view('liberar_clinica', $contenido);
	}

	public function buscar_paciente_cama(){
		$id_paciente = $this->input->post('codigo_paciente');

		$paciente_hospitalizado = $this->objPaciente->obtener(array('id_paciente' => $id_paciente));
		$servicio = $this->objServicioClinico->obtener(array('id_servicio' => $paciente_hospitalizado->codigo_servicio));
		$sala = $this->objSalas->obtener(array('id_sala' => $paciente_hospitalizado->codigo_sala));
		$cama = $this->objCamas->obtener(array('id_cama' => $paciente_hospitalizado->codigo_cama));

		echo '<p> <h3>Ubicación Hospitalaria</h3>
		 <strong> Servicio Clinicio: '.$servicio->nombre_servicio.'<br>
		  Sala: '.$sala->NOMSALA	.'<br>
		  Cama: '.$cama->cama.' 
		 </strong></p>';
	}

	public function cambia_almuerzo_cena(){
		$codigo_almuerzo = $this->input->post('idAlmuerzo');
		$regimenes = $this->objRegimen->listar();
		$regimen = $this->objRegimen->obtener(array('id_regimen' => $codigo_almuerzo));

		echo '<select id="codigo_cena" name="codigo_cena" class="selectpicker validate" data-dropup-auto="false" data-live-search="true">
           <option disabled selected>Seleccione</option>';
        	if($regimenes){
        	echo '<option value="0">Sin Solicitar</option>';
        	if($codigo_almuerzo == $regimen->id_regimen){
        	echo '<option value="'.$regimen->id_regimen.'" selected>'.$regimen->nombre.'</option>';	
        	}
           foreach($regimenes as $regimen_array){ 
              echo '<option value="'.$regimen_array->id_regimen.'">'.$regimen_array->nombre.'</option>';
            } 
            }
        echo '</select>';

	}

	public function vistaInformeProducto(){
		#Title
		$this->layout->title('Informe Productos Solicitados');

		#Metas
		$this->layout->setMeta('title','Informe Productos Solicitados');
		$this->layout->setMeta('description','Informe Productos Solicitados');
		$this->layout->setMeta('keywords','Informe Productos Solicitados');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_informe_solicitados');
	}

	public function menu_productos_solicitados(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		//$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		//$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Productos Solicitados');
		$this->layout->setMeta('title','Productos Solicitados');
		$this->layout->setMeta('description','Productos Solicitados');
		$this->layout->setMeta('keywords','Productos Solicitados');

		//$contenido['productos'] = $this->objProducto->listar();
		//$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		//$this->layout->view('productos_solicitados',$contenido);
		$this->layout->view('menu_productos_solicitados',$contenido);
	}

	public function Informe_Producto(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Productos Solicitados');
		$this->layout->setMeta('title','Productos Solicitados');
		$this->layout->setMeta('description','Productos Solicitados');
		$this->layout->setMeta('keywords','Productos Solicitados');

		$contenido['productos'] = $this->objProducto->listar();
		
		$contenido['productos_desayunos'] = $this->objIndex->productos_desayunos($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);
		$contenido['productos_almuerzos'] = $this->objIndex->productos_almuerzos($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);
		$contenido['productos_onces'] = $this->objIndex->productos_onces($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);
		$contenido['productos_cenas'] = $this->objIndex->productos_cenas($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);
		$contenido['productos_col10'] = $this->objIndex->productos_col10($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);
		$contenido['productos_col20'] = $this->objIndex->productos_col20($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);
		$contenido['productos_formula'] = $this->objIndex->productos_formula($fecha_desde, $fecha_hasta,$this->session->userdata("usuario")->id_unidad);

		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados',$contenido);
	}

	public function Informe_Desayunos(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Desayunos');
		$this->layout->setMeta('title','Desayunos');
		$this->layout->setMeta('description','Desayunos');
		$this->layout->setMeta('keywords','Desayunos');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_desayuno',$contenido);
	}

	public function Informe_Almuerzos(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Almuerzos');
		$this->layout->setMeta('title','Almuerzos');
		$this->layout->setMeta('description','Almuerzos');
		$this->layout->setMeta('keywords','Almuerzos');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_almuerzo',$contenido);
	}

	public function Informe_Once(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Onces');
		$this->layout->setMeta('title','Onces');
		$this->layout->setMeta('description','Onces');
		$this->layout->setMeta('keywords','Onces');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_once',$contenido);
	}

	public function Informe_Cena(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Cenas');
		$this->layout->setMeta('title','Cenas');
		$this->layout->setMeta('description','Cenas');
		$this->layout->setMeta('keywords','Cenas');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_cena',$contenido);
	}

	public function Informe_Col10(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Colacion 10');
		$this->layout->setMeta('title','Colacion 10');
		$this->layout->setMeta('description','Colacion 10');
		$this->layout->setMeta('keywords','Colacion 10');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_col10',$contenido);
	}

	public function Informe_Col20(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Colacion 20');
		$this->layout->setMeta('title','Colacion 20');
		$this->layout->setMeta('description','Colacion 20');
		$this->layout->setMeta('keywords','Colacion 20');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_col20',$contenido);
	}

	public function Informe_Formulas(){
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$contenido['fecha_desde'] = $fecha_desde;
		$contenido['fecha_hasta'] = $fecha_hasta;

		$fecha1 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_desde)));
		$fecha2 = date("Y-m-d", strtotime(str_replace("/", "-", $fecha_hasta)));

		$this->layout->title('Formulas');
		$this->layout->setMeta('title','Formulas');
		$this->layout->setMeta('description','Formulas');
		$this->layout->setMeta('keywords','Formulas');

		$contenido['productos'] = $this->objProducto->listar();
		$contenido['servicios'] = $this->objServicioClinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad));

		$this->layout->view('productos_solicitados_formula',$contenido);
	}

	 public function aporte_kg_kcal() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $id_paciente = $this->input->post('id_paciente');  
		
		$peso_paciente = $this->objPaciente->obtener(array('id_paciente'=> $id_paciente));

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 1);
        $info_once = $this->objIndex->inf_nutri($once, 1);
        $info_col10 = $this->objIndex->inf_nutri($col10, 1);
        $info_col20 = $this->objIndex->inf_nutri($col20, 1);
        $info_formula = $this->objIndex->inf_nutri($formula, 1);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 1);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 1);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 1);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $aporte_kg_kcal = (($info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Kcal+$informacion_cena[0]->Kcal)/$peso_paciente->peso);
      
        if($aporte_kg_kcal){
            echo number_format($aporte_kg_kcal, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }

 	public function aporte_kg_prot() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $id_paciente = $this->input->post('id_paciente');  
		
		$peso_paciente = $this->objPaciente->obtener(array('id_paciente'=> $id_paciente));

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 2);
        $info_once = $this->objIndex->inf_nutri($once, 2);
        $info_col10 = $this->objIndex->inf_nutri($col10, 2);
        $info_col20 = $this->objIndex->inf_nutri($col20, 2);
        $info_formula = $this->objIndex->inf_nutri($formula, 2);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 2);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 2);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 2);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $aporte_kg_prot = (($info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Prot+$informacion_cena[0]->Prot)/$peso_paciente->peso);
      
        if($aporte_kg_prot){
            echo number_format($aporte_kg_prot, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }

    public function aporte_kg_lip() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $id_paciente = $this->input->post('id_paciente');  
		
		$peso_paciente = $this->objPaciente->obtener(array('id_paciente'=> $id_paciente));

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 3);
        $info_once = $this->objIndex->inf_nutri($once, 3);
        $info_col10 = $this->objIndex->inf_nutri($col10, 3);
        $info_col20 = $this->objIndex->inf_nutri($col20, 3);
        $info_formula = $this->objIndex->inf_nutri($formula, 3);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 3);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 3);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 3);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $aporte_kg_lip = (($info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Lip+$informacion_cena[0]->Lip)/$peso_paciente->peso);
      
        if($aporte_kg_lip){
            echo number_format($aporte_kg_lip, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }

    public function aporte_kg_cho() {
    	$desayuno = $this->input->post('desayuno');
        $once = $this->input->post('once');
        $col10 = $this->input->post('col10');
        $col20 = $this->input->post('col20');
        $almuerzo = $this->input->post('almuerzo');
        $cena = $this->input->post('cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $id_paciente = $this->input->post('id_paciente');  
		
		$peso_paciente = $this->objPaciente->obtener(array('id_paciente'=> $id_paciente));

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 4);
        $info_once = $this->objIndex->inf_nutri($once, 4);
        $info_col10 = $this->objIndex->inf_nutri($col10, 4);
        $info_col20 = $this->objIndex->inf_nutri($col20, 4);
        $info_formula = $this->objIndex->inf_nutri($formula, 4);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 4);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 4);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 4);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $aporte_kg_cho = (($info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Cho+$informacion_cena[0]->Cho)/$peso_paciente->peso);
      
        if($aporte_kg_cho){
            echo number_format($aporte_kg_cho, 2, ',', '');
        }else{
           	echo '0';
        }
         
    }   

    public function inf_nutri_recetas(){
    	$id_receta = $this->input->post('id_receta');
    	$arr = array();

    	//calculo de kcal en las recetas
        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,1);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	$arr['msg1'] = number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	$arr['msg1'] = 0;
            }
        }  else {
            $arr['msg1'] = 0;
        }

        //fin calculo de kcal

        //calculo de prot en las recetas
        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,2);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	$arr['msg2'] = number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	$arr['msg2'] = 0;
            }
        }  else {
            $arr['msg2'] = 0;
        }

        //fin calculo de prot
        //calculo de lip en las recetas
        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,3);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	$arr['msg3'] = number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	$arr['msg3'] = 0;
            }
        }  else {
            $arr['msg3'] = 0;
        }
        //fin calculo de lip

        //calculo de cho en las recetas
        if($id_receta){
            $Informacion_nutricional = $this->objIndex->Informacion_nutricional_por_receta($id_receta,4);
            //echo '<option value="0">Camas</option>';
            if($Informacion_nutricional){
            	foreach($Informacion_nutricional as $datos){
                	$arr['msg4'] = number_format($datos->Total, 2, ',', '');
            	}
            }else{
            	$arr['msg4'] = 0;
            }
        }  else {
            $arr['msg4'] = 0;
        }

        //fin calculo de cho

        echo json_encode($arr);
    }

    //calculo de informacion nutricional solo de recetas no de formulas
    public function calculo_inf_nutri_recetas(){
    	$id_desayuno = $this->input->post('id_desayuno');
        $id_once = $this->input->post('id_once');
        $id_col10 = $this->input->post('id_col10');
        $id_col20 = $this->input->post('id_col20');
        $id_almuerzo = $this->input->post('id_almuerzo');
        $id_cena = $this->input->post('id_cena');
        $arr = array();

        //Comenzamos la suma kcal
        $info_desayuno = $this->objIndex->inf_nutri($id_desayuno, 1);
        $info_once = $this->objIndex->inf_nutri($id_once, 1);
        $info_col10 = $this->objIndex->inf_nutri($id_col10, 1);
        $info_col20 = $this->objIndex->inf_nutri($id_col20, 1);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $id_almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $id_cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$informacion_almuerzo[0]->Kcal+$informacion_cena[0]->Kcal;
            
        if($suma_total){
          $arr['msg1'] = number_format($suma_total, 2, ',', '');
        }else{
          $arr['msg1'] = 0;
        }
        //termino de la suma kcal

        //Comenzamos la suma prot
        $info_desayuno_1 = $this->objIndex->inf_nutri($id_desayuno, 2);
        $info_once_1 = $this->objIndex->inf_nutri($id_once, 2);
        $info_col10_1 = $this->objIndex->inf_nutri($id_col10, 2);
        $info_col20_1 = $this->objIndex->inf_nutri($id_col20, 2);

        $informacion_almuerzo_1 = $this->objAporteReg->listar(array('id_regimen' => $id_almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_1 = $this->objAporteReg->listar(array('id_regimen' => $id_cena, 'id_tipoaporte' => 4));

        $suma_total_1 = 0;
        $suma_total_1 = $info_desayuno_1->Total+$info_once_1->Total+$info_col10_1->Total+$info_col20_1->Total+$informacion_almuerzo_1[0]->Prot+$informacion_cena_1[0]->Prot;

        if($suma_total_1){
            $arr['msg2'] = number_format($suma_total_1, 2, ',', '');
        }else{
           	$arr['msg2'] = 0;
        }
        //termino de la suma kcal

        //Comenzamos la suma lip
        $info_desayuno_2 = $this->objIndex->inf_nutri($id_desayuno, 3);
        $info_once_2 = $this->objIndex->inf_nutri($id_once, 3);
        $info_col10_2 = $this->objIndex->inf_nutri($id_col10, 3);
        $info_col20_2 = $this->objIndex->inf_nutri($id_col20, 3);

        $informacion_almuerzo_2 = $this->objAporteReg->listar(array('id_regimen' => $id_almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_2 = $this->objAporteReg->listar(array('id_regimen' => $id_cena, 'id_tipoaporte' => 4));

        $suma_total_2 = 0;
        $suma_total_2 = $info_desayuno_2->Total+$info_once_2->Total+$info_col10_2->Total+$info_col20_2->Total+$informacion_almuerzo_2[0]->Lip+$informacion_cena_2[0]->Lip;

        if($suma_total_2){
            $arr['msg3'] = number_format($suma_total_2, 2, ',', '');
        }else{
           	$arr['msg3'] = 0;
        }
        //termino de la suma lip

        //Comenzamos la suma cho
        $info_desayuno_3 = $this->objIndex->inf_nutri($id_desayuno, 4);
        $info_once_3 = $this->objIndex->inf_nutri($id_once, 4);
        $info_col10_3 = $this->objIndex->inf_nutri($id_col10, 4);
        $info_col20_3 = $this->objIndex->inf_nutri($id_col20, 4);

        $informacion_almuerzo_3 = $this->objAporteReg->listar(array('id_regimen' => $id_almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_3 = $this->objAporteReg->listar(array('id_regimen' => $id_cena, 'id_tipoaporte' => 4));

        $suma_total_3 = 0;
        $suma_total_3 = $info_desayuno_3->Total+$info_once_3->Total+$info_col10_3->Total+$info_col20_3->Total+$informacion_almuerzo_3[0]->Cho+$informacion_cena_3[0]->Cho;

        if($suma_total_3){
            $arr['msg4'] = number_format($suma_total_3, 2, ',', '');
        }else{
           	$arr['msg4'] = 0;
        }
        //termino de la suma lip
        echo json_encode($arr);

    }

	public function inf_nutri_recetas_almcena(){
		$id_receta = $this->input->post('id_receta');
		$id_tipo_aporte = $this->input->post('id_tipo_aporte');
		$arr = array();

		//calculo de kcal en almuerzo-cena
        if($id_receta){
            $Informacion_nutricional = $this->objAporteReg->listar(array('id_regimen' => $id_receta, 'id_tipoaporte' => $id_tipo_aporte));
            if($Informacion_nutricional){
                	$arr['msg1'] = number_format($Informacion_nutricional[0]->Kcal, 2, ',', '');
            }else{
            	$arr['msg1'] = 0;
            }
        }  else {
            $arr['msg1'] = 0;
        }
        //termino calculo de kcal en almuerzo-cena

        //calculo de prot en almuerzo-cena
        if($id_receta){
            $Informacion_nutricional_1 = $this->objAporteReg->listar(array('id_regimen' => $id_receta, 'id_tipoaporte' => $id_tipo_aporte));
            if($Informacion_nutricional_1){
               	$arr['msg2'] = number_format($Informacion_nutricional_1[0]->Prot, 2, ',', '');
            }else{
            	$arr['msg2'] = 0;
            }
        }  else {
            $arr['msg2'] = 0;
        }
        //termino calculo de prot en almuerzo-cena

        //calculo de lip en almuerzo-cena
        if($id_receta){
            $Informacion_nutricional_2 = $this->objAporteReg->listar(array('id_regimen' => $id_receta, 'id_tipoaporte' => $id_tipo_aporte));
            if($Informacion_nutricional_2){
               	$arr['msg3'] = number_format($Informacion_nutricional_2[0]->Lip, 2, ',', '');
            }else{
            	$arr['msg3'] = 0;
            }
        }  else {
            $arr['msg3'] = 0;
        }
        //termino calculo de lip en almuerzo-cena

        //calculo de cho en almuerzo-cena
        if($id_receta){
            $Informacion_nutricional_3 = $this->objAporteReg->listar(array('id_regimen' => $id_receta, 'id_tipoaporte' => $id_tipo_aporte));
            if($Informacion_nutricional_3){
               	$arr['msg4'] = number_format($Informacion_nutricional_3[0]->Cho, 2, ',', '');
            }else{
            	$arr['msg4'] = 0;
            }
        }  else {
            $arr['msg4'] = 0;
        }
        //termino calculo de cho en almuerzo-cena
        echo json_encode($arr);
	}

	public function inf_nutri_recetas_formula(){
		$formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $arr = array();

        //calculo de kcal en formulas
        $info_formula = $this->objIndex->inf_nutri($formula, 1);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 1);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 1);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 1);

        $suma_total = 0;
        $suma_formula = 0;

        $suma_total = $info_formula->Total+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula =($suma_total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $suma_total;
        }
      
        if($suma_formula){
            $arr['msg1'] = number_format($suma_formula, 2, ',', '');
        }else{
           	$arr['msg1'] = 0;
        }
        //termino del calculo de kcal en formulas

        //calculo de prot en formulas
        $info_formula_1 = $this->objIndex->inf_nutri($formula, 2);
        $info_comp1_1 = $this->objIndex->inf_nutri($comp1, 2);
        $info_comp2_1 = $this->objIndex->inf_nutri($comp2, 2);
        $info_comp3_1 = $this->objIndex->inf_nutri($comp3, 2);

        $suma_total_1 = 0;
        $suma_formula_1 = 0;

        $suma_total_1 = $info_formula_1->Total+$info_comp1_1->Total+$info_comp2_1->Total+$info_comp3_1->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_1 =($suma_total_1*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_1 = $suma_formula_1+ $suma_total_1;
        }
      
        if($suma_formula_1){
            $arr['msg2'] = number_format($suma_formula_1, 2, ',', '');
        }else{
           	$arr['msg2'] = 0;
        }
        //termino del calculo de prot en formulas

        //calculo de lip en formulas
        $info_formula_2 = $this->objIndex->inf_nutri($formula, 3);
        $info_comp1_2 = $this->objIndex->inf_nutri($comp1, 3);
        $info_comp2_2 = $this->objIndex->inf_nutri($comp2, 3);
        $info_comp3_2 = $this->objIndex->inf_nutri($comp3, 3);

        $suma_total_2 = 0;
        $suma_formula_2 = 0;

        $suma_total_2 = $info_formula_2->Total+$info_comp1_2->Total+$info_comp2_1->Total+$info_comp3_2->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_2 =($suma_total_2*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_2 = $suma_formula_2+ $suma_total_2;
        }
      
        if($suma_formula_2){
            $arr['msg3'] = number_format($suma_formula_2, 2, ',', '');
        }else{
           	$arr['msg3'] = 0;
        }
        //termino del calculo de lip en formulas

        //calculo de cho en formulas
        $info_formula_3 = $this->objIndex->inf_nutri($formula, 4);
        $info_comp1_3 = $this->objIndex->inf_nutri($comp1, 4);
        $info_comp2_3 = $this->objIndex->inf_nutri($comp2, 4);
        $info_comp3_3 = $this->objIndex->inf_nutri($comp3, 4);

        $suma_total_3 = 0;
        $suma_formula_3 = 0;

        $suma_total_3 = $info_formula_3->Total+$info_comp1_3->Total+$info_comp2_3->Total+$info_comp3_3->Total;

         //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_3 =($suma_total_3*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_3 = $suma_formula_3+ $suma_total_3;
        }
      
        if($suma_formula_3){
            $arr['msg4'] = number_format($suma_formula_3, 2, ',', '');
        }else{
           	$arr['msg4'] = 0;
        }
        //termino del calculo de cho en formulas

        echo json_encode($arr);
	}

	public function suma_total_solicitud(){
		$desayuno = $this->input->post('id_desayuno');
        $once = $this->input->post('id_once');
        $col10 = $this->input->post('id_col10');
        $col20 = $this->input->post('id_col20');
        $almuerzo = $this->input->post('id_almuerzo');
        $cena = $this->input->post('id_cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $arr = array();

        //Comenzamos la suma de kcal de la solicitud
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 1);
        $info_once = $this->objIndex->inf_nutri($once, 1);
        $info_col10 = $this->objIndex->inf_nutri($col10, 1);
        $info_col20 = $this->objIndex->inf_nutri($col20, 1);
        $info_formula = $this->objIndex->inf_nutri($formula, 1);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 1);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 1);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 1);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $suma_total = $info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Kcal+$informacion_cena[0]->Kcal;
      
        if($suma_total){
           $arr['msg1'] = number_format($suma_total, 2, ',', '');
        }else{
           $arr['msg1'] = 0;
        }
        //termino la suma de kcal de la solicitud

        //Comenzamos la suma de prot de la solicitud
        $info_desayuno_1 = $this->objIndex->inf_nutri($desayuno, 2);
        $info_once_1 = $this->objIndex->inf_nutri($once, 2);
        $info_col10_1 = $this->objIndex->inf_nutri($col10, 2);
        $info_col20_1 = $this->objIndex->inf_nutri($col20, 2);
        $info_formula_1 = $this->objIndex->inf_nutri($formula, 2);
        $info_comp1_1 = $this->objIndex->inf_nutri($comp1, 2);
        $info_comp2_1 = $this->objIndex->inf_nutri($comp2, 2);
        $info_comp3_1 = $this->objIndex->inf_nutri($comp3, 2);

        $informacion_almuerzo_1 = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_1 = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total_1 = 0;
        $suma_formula_1 = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_1 = $suma_formula_1 + ($info_formula_1->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_1 = $suma_formula_1+ $info_formula_1->Total;
        }

        $suma_total_1 = $info_desayuno_1->Total+$info_once_1->Total+$info_col10_1->Total+$info_col20_1->Total+$suma_formula_1+$info_comp1_1->Total+$info_comp2_1->Total+$info_comp3_1->Total+$informacion_almuerzo_1[0]->Prot+$informacion_cena_1[0]->Prot;
      
        if($suma_total_1){
           $arr['msg2'] = number_format($suma_total_1, 2, ',', '');
        }else{
           $arr['msg2'] = 0;
        }
        //termino la suma de prot de la solicitud

        //Comenzamos la suma de lip de la solicitud
        $info_desayuno_2 = $this->objIndex->inf_nutri($desayuno, 3);
        $info_once_2 = $this->objIndex->inf_nutri($once, 3);
        $info_col10_2 = $this->objIndex->inf_nutri($col10, 3);
        $info_col20_2 = $this->objIndex->inf_nutri($col20, 3);
        $info_formula_2 = $this->objIndex->inf_nutri($formula, 3);
        $info_comp1_2 = $this->objIndex->inf_nutri($comp1, 3);
        $info_comp2_2 = $this->objIndex->inf_nutri($comp2, 3);
        $info_comp3_2 = $this->objIndex->inf_nutri($comp3, 3);

        $informacion_almuerzo_2 = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_2 = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total_2 = 0;
        $suma_formula_2 = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_2 = $suma_formula_2 + ($info_formula_2->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_2 = $suma_formula_2+ $info_formula_2->Total;
        }

        $suma_total_2 = $info_desayuno_2->Total+$info_once_2->Total+$info_col10_2->Total+$info_col20_2->Total+$suma_formula_2+$info_comp1_2->Total+$info_comp2_2->Total+$info_comp3_2->Total+$informacion_almuerzo_2[0]->Lip+$informacion_cena_2[0]->Lip;
      
        if($suma_total_2){
           $arr['msg3'] = number_format($suma_total_2, 2, ',', '');
        }else{
           $arr['msg3'] = 0;
        }
        //termino la suma de lip de la solicitud

        //Comenzamos la suma de cho de la solicitud
        $info_desayuno_3 = $this->objIndex->inf_nutri($desayuno, 4);
        $info_once_3 = $this->objIndex->inf_nutri($once, 4);
        $info_col10_3 = $this->objIndex->inf_nutri($col10, 4);
        $info_col20_3 = $this->objIndex->inf_nutri($col20, 4);
        $info_formula_3 = $this->objIndex->inf_nutri($formula, 4);
        $info_comp1_3 = $this->objIndex->inf_nutri($comp1, 4);
        $info_comp2_3 = $this->objIndex->inf_nutri($comp2, 4);
        $info_comp3_3 = $this->objIndex->inf_nutri($comp3, 4);

        $informacion_almuerzo_3 = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_3 = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total_3 = 0;
        $suma_formula_3 = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_3 = $suma_formula_3 + ($info_formula_3->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_3 = $suma_formula_3+ $info_formula_3->Total;
        }

        $suma_total_3 = $info_desayuno_3->Total+$info_once_3->Total+$info_col10_3->Total+$info_col20_3->Total+$suma_formula_3+$info_comp1_3->Total+$info_comp2_3->Total+$info_comp3_3->Total+$informacion_almuerzo_3[0]->Cho+$informacion_cena_3[0]->Cho;
      
        if($suma_total_3){
           $arr['msg4'] = number_format($suma_total_3, 2, ',', '');
        }else{
           $arr['msg4'] = 0;
        }
        //termino la suma de cho de la solicitud

        echo json_encode($arr);
	}

	public function aporte_kg(){
		$desayuno = $this->input->post('id_desayuno');
        $once = $this->input->post('id_once');
        $col10 = $this->input->post('id_col10');
        $col20 = $this->input->post('id_col20');
        $almuerzo = $this->input->post('id_almuerzo');
        $cena = $this->input->post('id_cena');
        $formula = $this->input->post('formula');
        $comp1 = $this->input->post('comp1');
        $comp2 = $this->input->post('comp2');
        $comp3 = $this->input->post('comp3');
        $frecuencia = $this->input->post('frecuencia');
        $volumen = $this->input->post('volumen');
        $id_paciente = $this->input->post('id_paciente');  
        $arr = array();
		
		$peso_paciente = $this->objPaciente->obtener(array('id_paciente'=> $id_paciente));

        //Comenzamos la suma de cada receta
        $info_desayuno = $this->objIndex->inf_nutri($desayuno, 1);
        $info_once = $this->objIndex->inf_nutri($once, 1);
        $info_col10 = $this->objIndex->inf_nutri($col10, 1);
        $info_col20 = $this->objIndex->inf_nutri($col20, 1);
        $info_formula = $this->objIndex->inf_nutri($formula, 1);
        $info_comp1 = $this->objIndex->inf_nutri($comp1, 1);
        $info_comp2 = $this->objIndex->inf_nutri($comp2, 1);
        $info_comp3 = $this->objIndex->inf_nutri($comp3, 1);

        $informacion_almuerzo = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total = 0;
        $suma_formula = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula = $suma_formula + ($info_formula->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula = $suma_formula+ $info_formula->Total;
        }

        $aporte_kg_kcal = (($info_desayuno->Total+$info_once->Total+$info_col10->Total+$info_col20->Total+$suma_formula+$info_comp1->Total+$info_comp2->Total+$info_comp3->Total+$informacion_almuerzo[0]->Kcal+$informacion_cena[0]->Kcal)/$peso_paciente->peso);
      
        if($aporte_kg_kcal){
            $arr['msg1'] = number_format($aporte_kg_kcal, 2, ',', '');
        }else{
           	$arr['msg1'] = 0;
        }

        $info_desayuno_1 = $this->objIndex->inf_nutri($desayuno, 2);
        $info_once_1 = $this->objIndex->inf_nutri($once, 2);
        $info_col10_1 = $this->objIndex->inf_nutri($col10, 2);
        $info_col20_1 = $this->objIndex->inf_nutri($col20, 2);
        $info_formula_1 = $this->objIndex->inf_nutri($formula, 2);
        $info_comp1_1 = $this->objIndex->inf_nutri($comp1, 2);
        $info_comp2_1 = $this->objIndex->inf_nutri($comp2, 2);
        $info_comp3_1 = $this->objIndex->inf_nutri($comp3, 2);

        $informacion_almuerzo_1 = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_1 = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total_1 = 0;
        $suma_formula_1 = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_1 = $suma_formula_1 + ($info_formula_1->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_1 = $suma_formula_1+ $info_formula_1->Total;
        }

        $aporte_kg_prot_1 = (($info_desayuno_1->Total+$info_once_1->Total+$info_col10_1->Total+$info_col20_1->Total+$suma_formula_1+$info_comp1_1->Total+$info_comp2_1->Total+$info_comp3_1->Total+$informacion_almuerzo_1[0]->Prot+$informacion_cena_1[0]->Prot)/$peso_paciente->peso);
      
        if($aporte_kg_prot_1){
            $arr['msg2'] = number_format($aporte_kg_prot_1, 2, ',', '');
        }else{
           	$arr['msg2'] = 0;
        }

        $info_desayuno_2 = $this->objIndex->inf_nutri($desayuno, 3);
        $info_once_2 = $this->objIndex->inf_nutri($once, 3);
        $info_col10_2 = $this->objIndex->inf_nutri($col10, 3);
        $info_col20_2 = $this->objIndex->inf_nutri($col20, 3);
        $info_formula_2 = $this->objIndex->inf_nutri($formula, 3);
        $info_comp1_2 = $this->objIndex->inf_nutri($comp1, 3);
        $info_comp2_2 = $this->objIndex->inf_nutri($comp2, 3);
        $info_comp3_2 = $this->objIndex->inf_nutri($comp3, 3);

        $informacion_almuerzo_2 = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_2 = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total_2 = 0;
        $suma_formula_2 = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_2 = $suma_formula_2 + ($info_formula_2->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_2 = $suma_formula_2+ $info_formula_2->Total;
        }

        $aporte_kg_lip_2 = (($info_desayuno_2->Total+$info_once_2->Total+$info_col10_2->Total+$info_col20_2->Total+$suma_formula_2+$info_comp1_2->Total+$info_comp2_2->Total+$info_comp3_2->Total+$informacion_almuerzo_2[0]->Lip+$informacion_cena_2[0]->Lip)/$peso_paciente->peso);
      
        if($aporte_kg_lip_2){
            $arr['msg3'] = number_format($aporte_kg_lip_2, 2, ',', '');
        }else{
           	$arr['msg3'] = 0;
        }

        $info_desayuno_3 = $this->objIndex->inf_nutri($desayuno, 4);
        $info_once_3 = $this->objIndex->inf_nutri($once, 4);
        $info_col10_3 = $this->objIndex->inf_nutri($col10, 4);
        $info_col20_3 = $this->objIndex->inf_nutri($col20, 4);
        $info_formula_3 = $this->objIndex->inf_nutri($formula, 4);
        $info_comp1_3 = $this->objIndex->inf_nutri($comp1, 4);
        $info_comp2_3 = $this->objIndex->inf_nutri($comp2, 4);
        $info_comp3_3 = $this->objIndex->inf_nutri($comp3, 4);

        $informacion_almuerzo_3 = $this->objAporteReg->listar(array('id_regimen' => $almuerzo, 'id_tipoaporte' => 2));

        $informacion_cena_3 = $this->objAporteReg->listar(array('id_regimen' => $cena, 'id_tipoaporte' => 4));

        $suma_total_3 = 0;
        $suma_formula_3 = 0;

        //sumamos la formula
        if($frecuencia || $volumen){
        	$suma_formula_3 = $suma_formula_3 + ($info_formula_3->Total*(($volumen/100)*$frecuencia)); 
        }else{
        	$suma_formula_3 = $suma_formula_3+ $info_formula_3->Total;
        }

        $aporte_kg_cho_3 = (($info_desayuno_3->Total+$info_once_3->Total+$info_col10_3->Total+$info_col20_3->Total+$suma_formula_3+$info_comp1_3->Total+$info_comp2_3->Total+$info_comp3->Total+$informacion_almuerzo_3[0]->Cho+$informacion_cena_3[0]->Cho)/$peso_paciente->peso);
      
        if($aporte_kg_cho_3){
            $arr['msg4'] = number_format($aporte_kg_cho_3, 2, ',', '');
        }else{
           	$arr['msg4'] = 0;
        }

        echo json_encode($arr);
	}

}