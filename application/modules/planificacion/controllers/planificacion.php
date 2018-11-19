<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Planificacion extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("planificacion/modelo_planificacion", "objPlanifica");
		$this->load->model("servicios_alimentacion/modelo_serviciosalimentacion", "objServiciosalimentacion");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("destinos/modelo_destinos", "objDestinos");

		$this->load->model("desayuno/modelo_desayuno", "objDesayuno");
		$this->load->model("almuerzo/modelo_almuerzo", "objAlmuerzo");
		$this->load->model("once/modelo_once", "objOnce");
		$this->load->model("cena/modelo_cena", "objCena");
		$this->load->model("colacion/modelo_colacion", "objColacion");
		$this->load->model("col_20/modelo_col20", "objCol20");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		#current
		$this->layout->current = 1;
	}

	public function index(){
		#Title
		$this->layout->title('Planificacion Dia');

		#Metas
		$this->layout->setMeta('title','Planificacion Dia');
		$this->layout->setMeta('description','Planificacion Dia');
		$this->layout->setMeta('keywords','Planificacion Dia');

		#js
		$this->layout->js('js/sistema/planificacion/agregar.js');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['regimenes'] = $this->objRegimen->listar(array('tipo' => 1));

		$this->layout->view('index', $contenido);
	}

	public function buscar_recetas() {
        $regimen = $this->input->post('idRegimen');
        $servicio = $this->input->post('idServicio');

        	if($servicio == 1){
        		$resultado = $this->objPlanifica->obtener_recetas_desayuno($regimen, $this->session->userdata("usuario")->id_unidad);
        	}else if($servicio == 12){
        		$resultado = $this->objPlanifica->obtener_recetas_colacion($regimen, $this->session->userdata("usuario")->id_unidad);
        	}else if($servicio == 14){
        		$resultado_regimen = $this->objPlanifica->obtener_recetas_formulas($regimen);
        	}else if($servicio == 16){
        		$resultado = $this->objPlanifica->obtener_recetas_once($regimen, $this->session->userdata("usuario")->id_unidad);
        	}else{
        		$resultado_regimen = $this->objPlanifica->obtener_recetas_por_regimen($regimen);
        	}

        if($resultado || $resultado_regimen){

        	if($resultado){
        		//print_r("aaaaaa");die();
        		foreach($resultado as $recetas){
                	echo '<option value="'. $recetas->id_receta .'">'. $recetas->receta_nombre .'</option>';
            	}
        	}else if($resultado_regimen){
        		foreach($resultado_regimen as $recetas){
                	echo '<option value="'. $recetas->id_receta .'">'. $recetas->nombre .'</option>';
            	}
        	}

        }  else {
            echo 'No se encontraron recetas';
        }
    }

    public function agregar(){
    	//die();
    	#Title
		$this->layout->title('Planificacion Dia');

		#Metas
		$this->layout->setMeta('title','Planificacion Dia');
		$this->layout->setMeta('description','Planificacion Dia');
		$this->layout->setMeta('keywords','Planificacion Dia');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$fecha_registro = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post("fecha"))));

		$datos = array('id_planificacion' => null,
					   'fecha' => $fecha_registro,
					   'id_receta' => $this->input->post('recetas'),
					   'id_destino' => $this->input->post('destinos'),			
					   'id_servicio_alimentacion' => $this->input->post('servicios_alimentacion'),
					   'id_regimen' => $this->input->post('regimenes'),
					   'volumen_produccion' => $this->input->post('volumen'),
					   'id_usuario' => $this->session->userdata("usuario")->id_usuario,
					   'id_unidad' => $this->session->userdata("usuario")->id_unidad
				);

		$this->objPlanifica->insertar($datos);

		$recetas = array('servicio_codigo'=> $this->input->post('servicios_alimentacion'),
						 'regimen_codigo'=> $this->input->post('regimenes'),
						 'destino_codigo'=> $this->input->post('destinos'),
						 'fecha' => $this->input->post("fecha")
					);
		$contenido['codigos'] = $recetas;

			if($this->input->post('servicios_alimentacion') == 1){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_desayuno($this->input->post('regimenes'), $this->session->userdata("usuario")->id_unidad);
        	}else if($this->input->post('servicios_alimentacion') == 12){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_colacion($this->input->post('regimenes'), $this->session->userdata("usuario")->id_unidad);
        	}else if($this->input->post('servicios_alimentacion') == 14){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_formulas($this->input->post('regimenes'));
        	}else if($this->input->post('servicios_alimentacion') == 16){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_once($this->input->post('regimenes'), $this->session->userdata("usuario")->id_unidad);
        	}else{
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_por_regimen($this->input->post('regimenes'));
        	}

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['regimenes'] = $this->objRegimen->listar(array('tipo' => 1));

		//$contenido['datos'] = $this->objPlanifica->listar();
		$contenido['datos'] = $this->objPlanifica->obtener_recetas_agregar($this->input->post("fecha"),$this->input->post('destinos'),$this->input->post('servicios_alimentacion'), $this->session->userdata("usuario")->id_unidad, $this->input->post('regimenes'));

		$this->layout->view('index', $contenido);
    }

    public function editar($codigo_planificacion = false){
		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#title
		$this->layout->title('Editar Planificacion');

		#metas
		$this->layout->setMeta('title','Editar Planificacion');
		$this->layout->setMeta('description','Editar Planificacion');
		$this->layout->setMeta('keywords','Editar Planificacion');

		#contenido
		if($contenido['receta_planificacion'] = $this->objPlanifica->obtener(array("id_planificacion" => $codigo_planificacion)));
		else show_error('');

		$this->layout->view('editar',$contenido);
    }

    public function editar_receta_planificacion(){
    	#Title
		$this->layout->title('Planificacion Dia');

		#Metas
		$this->layout->setMeta('title','Planificacion Dia');
		$this->layout->setMeta('description','Planificacion Dia');
		$this->layout->setMeta('keywords','Planificacion Dia');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$datos_planificacion = $this->objPlanifica->obtener(array('id_planificacion' => $this->input->post('codigo')));

		$this->objPlanifica->modificar_volumen($this->input->post('codigo'),$this->input->post('volumen'));

		$recetas = array('servicio_codigo'=> $datos_planificacion->id_servicio_alimentacion,
						 'regimen_codigo'=> $datos_planificacion->id_regimen,
						 'destino_codigo'=> $datos_planificacion->id_destino,
						 'fecha' => date("Y-m-d", strtotime($datos_planificacion->fecha))
					);
		$contenido['codigos'] = $recetas;

		if($datos_planificacion->id_servicio_alimentacion== 1){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_desayuno($datos_planificacion->id_regimen, $this->session->userdata("usuario")->id_unidad);
        	}else if($datos_planificacion->id_servicio_alimentacion == 12){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_colacion($datos_planificacion->id_regimen, $this->session->userdata("usuario")->id_unidad);
        	}else if($datos_planificacion->id_servicio_alimentacion == 14){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_formulas($datos_planificacion->id_regimen);
        	}else if($datos_planificacion->id_servicio_alimentacion == 16){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_once($datos_planificacion->id_regimen, $this->session->userdata("usuario")->id_unidad);
        	}else{
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_por_regimen($datos_planificacion->id_regimen);
        	}

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['regimenes'] = $this->objRegimen->listar(array('tipo' => 1));

		//$contenido['datos'] = $this->objPlanifica->listar();
		$contenido['datos'] = $this->objPlanifica->obtener_recetas_agregar($datos_planificacion->fecha,$datos_planificacion->id_destino, $datos_planificacion->id_servicio_alimentacion, $this->session->userdata("usuario")->id_unidad, $datos_planificacion->id_regimen);

		$this->layout->view('index', $contenido);
    }

    public function eliminar($codigo = false){
    	#Title
		$this->layout->title('Planificacion Dia');

		#Metas
		$this->layout->setMeta('title','Planificacion Dia');
		$this->layout->setMeta('description','Planificacion Dia');
		$this->layout->setMeta('keywords','Planificacion Dia');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$datos_planificacion = $this->objPlanifica->obtener(array('id_planificacion' => $codigo));

		$this->objPlanifica->eliminar($codigo);

		$recetas = array('servicio_codigo'=> $datos_planificacion->id_servicio_alimentacion,
						 'regimen_codigo'=> $datos_planificacion->id_regimen,
						 'destino_codigo'=> $datos_planificacion->id_destino,
						 'fecha' => date("Y-m-d", strtotime($datos_planificacion->fecha))
					);
		$contenido['codigos'] = $recetas;

		if($datos_planificacion->id_servicio_alimentacion== 1){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_desayuno($datos_planificacion->id_regimen, $this->session->userdata("usuario")->id_unidad);
        	}else if($datos_planificacion->id_servicio_alimentacion == 12){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_colacion($datos_planificacion->id_regimen, $this->session->userdata("usuario")->id_unidad);
        	}else if($datos_planificacion->id_servicio_alimentacion == 14){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_formulas($datos_planificacion->id_regimen);
        	}else if($datos_planificacion->id_servicio_alimentacion == 16){
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_once($datos_planificacion->id_regimen, $this->session->userdata("usuario")->id_unidad);
        	}else{
        		$contenido['resultado'] = $this->objPlanifica->obtener_recetas_por_regimen($datos_planificacion->id_regimen);
        	}

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));
		$contenido['regimenes'] = $this->objRegimen->listar(array('tipo' => 1));

		//$contenido['datos'] = $this->objPlanifica->listar();
		$contenido['datos'] = $this->objPlanifica->obtener_recetas_agregar($datos_planificacion->fecha,$datos_planificacion->id_destino, $datos_planificacion->id_servicio_alimentacion, $this->session->userdata("usuario")->id_unidad, $datos_planificacion->id_regimen);

		$this->layout->view('index', $contenido);
    }

    public function repetirPlanificacion(){
    	#Title
		$this->layout->title('Repetir Planificacion');

		#Metas
		$this->layout->setMeta('title','Repetir Planificacion');
		$this->layout->setMeta('description','Repetir Planificacion');
		$this->layout->setMeta('keywords','Repetir Planificacion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('repetir_planificacion', $contenido);
    }

    public function agregar_repeticion_planificacion(){
    	#Title
		$this->layout->title('Repetir Planificacion');

		#Metas
		$this->layout->setMeta('title','Repetir Planificacion');
		$this->layout->setMeta('description','Repetir Planificacion');
		$this->layout->setMeta('keywords','Repetir Planificacion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$datos = array('servicio_codigo'=> $this->input->post('servicios_alimentacion'),
						 'destino_codigo'=> $this->input->post('destinos'),
						 'fecha' => $this->input->post('fecha'),
						 'fecha1' => $this->input->post('fecha1')
					);
		$contenido['codigos'] = $datos;

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$datos_planificacion = $this->objPlanifica->obtener_planificacion($this->input->post('fecha'), $this->input->post('servicios_alimentacion'), $this->input->post('destinos'), $this->session->userdata("usuario")->id_unidad);

		$fecha_registro = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post("fecha1"))));

		foreach ($datos_planificacion as $datos) {
			$datos = array('id_planificacion' => null,
					   'fecha' => $fecha_registro,
					   'id_receta' => $datos->id_receta,
					   'id_destino' => $datos->id_destino,			
					   'id_servicio_alimentacion' => $datos->id_servicio_alimentacion,
					   'id_regimen' => $datos->id_regimen,
					   'volumen_produccion' => $datos->volumen_produccion,
					   'id_usuario' => $this->session->userdata("usuario")->id_usuario,
					   'id_unidad' => $this->session->userdata("usuario")->id_unidad
				);

			$this->objPlanifica->insertar($datos);
		}

		$contenido['datos'] = $this->objPlanifica->obtener_recetas_repeticion($this->input->post('fecha'), $this->input->post('destinos'), $this->input->post('servicios_alimentacion'), $this->session->userdata("usuario")->id_unidad);

		$this->layout->view('repetir_planificacion', $contenido);
    }

    public function InformePlanificacion(){
    	#Title
		$this->layout->title('Informe Planificacion');

		#Metas
		$this->layout->setMeta('title','Informe Planificacion');
		$this->layout->setMeta('description','Informe Planificacion');
		$this->layout->setMeta('keywords','Informe Planificacion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('informe_planificacion', $contenido);
    }

    public function Generar_Informe(){
    	#Title
		$this->layout->title('Informe Planificacion');

		#Metas
		$this->layout->setMeta('title','Informe Planificacion');
		$this->layout->setMeta('description','Informe Planificacion');
		$this->layout->setMeta('keywords','Informe Planificacion');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$fecha_registro = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post("fecha"))));

		$datos = array(	'fecha'=> $fecha_registro,
						'servicios_alimentacion'=> $this->input->post('servicios_alimentacion'),
						'destino'=> $this->input->post('destinos')
							);

		$contenido['codigos'] = $datos;

		$contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->listar();
		
		$contenido['destinos'] = $this->objDestinos->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$contenido['regimenes'] = $this->objPlanifica->obtener_regimenes_planificacion();

		$this->layout->view('informe_planificacion', $contenido);
    }

    public function buscar_datos(){
    	$regimen = $this->input->post('idRegimen');
        $servicio = $this->input->post('idServicio');
        $destino = $this->input->post('idDestino');
        $fecha_registro = $this->input->post('fecha');

        $contenido = $this->objPlanifica->obtener_recetas_agregar($fecha_registro, $destino, $servicio, $this->session->userdata("usuario")->id_unidad, $regimen);


        if($contenido){
           foreach($contenido as $planificacion){ 
                echo '<tr>';
                    $recetas = $this->objRecetas->obtener(array('id_receta' => $planificacion->id_receta)); 
           
                    echo '<td>'.$recetas->nombre.'</td>
                    <td>'.$planificacion->volumen_produccion.'</td>
                    <td class="editar">
                        <a href="'.base_url('planificacion/editar/'.$planificacion->id_planificacion).'">
                            <button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                        </a>

                         <a href="'.base_url('planificacion/eliminar/'.$planificacion->id_planificacion).'" onclick="return confirm("Esta seguro que desea eliminar este registro?");"><button title="Eliminar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
                    </td>
                </tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 

           
    }

    public function buscar_datos_repetir_plan(){
        $servicio = $this->input->post('idServicio');
        $destino = $this->input->post('idDestino');
        $fecha_registro = $this->input->post('fecha');

        $contenido = $this->objPlanifica->obtener_recetas_repeticion($fecha_registro, $destino, $servicio, $this->session->userdata("usuario")->id_unidad);


        if($contenido){
           foreach($contenido as $planificacion){ 
                echo '<tr>';
                    $recetas = $this->objRecetas->obtener(array('id_receta' => $planificacion->id_receta)); 
           
                    echo '<td>'.$recetas->nombre.'</td>
                    <td>'.$planificacion->volumen_produccion.'</td>
                </tr>';
            }
        } else{ 
            echo '<tr>
       			<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
            </tr>';
         } 

           
    }
}
