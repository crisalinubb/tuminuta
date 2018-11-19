<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Produccion extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_produccion", "objProduccion");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		#current
		$this->layout->current = 1;
	}

	public function vista_produccion_desayuno(){
		#Title
		$this->layout->title('Produccion Desayuno');

		#Metas
		$this->layout->setMeta('title','Produccion Desayuno');
		$this->layout->setMeta('description','Produccion Desayuno');
		$this->layout->setMeta('keywords','Produccion Desayuno');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_desayuno');
	}

	public function Produccion_desayuno(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Desayuno');

		#Metas
		$this->layout->setMeta('title','Produccion Desayuno');
		$this->layout->setMeta('description','Produccion Desayuno');
		$this->layout->setMeta('keywords','Produccion Desayuno');

		$contenido['datos_solicitud_desayunos'] = $this->objProduccion->consulta_solicitudes_desayuno($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$contenido['fecha'] = $fecha;

		$this->layout->view('produccion_desayuno', $contenido);
	}

	public function vista_produccion_almuerzo(){
		#Title
		$this->layout->title('Produccion Almuerzo');

		#Metas
		$this->layout->setMeta('title','Produccion Almuerzo');
		$this->layout->setMeta('description','Produccion Almuerzo');
		$this->layout->setMeta('keywords','Produccion Almuerzo');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_almuerzo');
	}

	public function Produccion_almuerzo(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Almuerzo');

		#Metas
		$this->layout->setMeta('title','Produccion Almuerzo');
		$this->layout->setMeta('description','Produccion Almuerzo');
		$this->layout->setMeta('keywords','Produccion Almuerzo');

		$contenido['datos_solicitud_almuerzo'] = $this->objProduccion->consulta_solicitudes_almuerzo($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$contenido['fecha'] = $fecha;
		$contenido['fecha_busqueda'] = $fecha_busqueda;

		$this->layout->view('Produccion_almuerzo', $contenido);
	}

	public function vista_produccion_once(){
		#Title
		$this->layout->title('Produccion Once');

		#Metas
		$this->layout->setMeta('title','Produccion Once');
		$this->layout->setMeta('description','Produccion Once');
		$this->layout->setMeta('keywords','Produccion Once');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_once');
	}

	public function Produccion_once(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));
		#Title
		$this->layout->title('Produccion Once');

		#Metas
		$this->layout->setMeta('title','Produccion Once');
		$this->layout->setMeta('description','Produccion Once');
		$this->layout->setMeta('keywords','Produccion Once');

		$contenido['datos_solicitud_once'] = $this->objProduccion->consulta_solicitudes_once($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$contenido['fecha'] = $fecha;

		$this->layout->view('produccion_once', $contenido);
	}

	public function vista_produccion_cena(){
		#Title
		$this->layout->title('Produccion Cena');

		#Metas
		$this->layout->setMeta('title','Produccion Cena');
		$this->layout->setMeta('description','Produccion Cena');
		$this->layout->setMeta('keywords','Produccion Cena');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_cena');
	}

	public function Produccion_cena(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Cena');

		#Metas
		$this->layout->setMeta('title','Produccion Cena');
		$this->layout->setMeta('description','Produccion Cena');
		$this->layout->setMeta('keywords','Produccion Cena');

		$contenido['datos_solicitud_cena'] = $this->objProduccion->consulta_solicitudes_cena($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$contenido['fecha'] = $fecha;
		$contenido['fecha_busqueda'] = $fecha_busqueda;

		$this->layout->view('produccion_cena', $contenido);
	}

	public function vista_produccion_col10(){
		#Title
		$this->layout->title('Produccion Colacion de las 10');

		#Metas
		$this->layout->setMeta('title','Produccion Colacion de las 10');
		$this->layout->setMeta('description','Produccion Colacion de las 10');
		$this->layout->setMeta('keywords','Produccion Colacion de las 10');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_col10');
	}

	public function Produccion_col10(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Colacion de las 10');

		#Metas
		$this->layout->setMeta('title','Produccion Colacion de las 10');
		$this->layout->setMeta('description','Produccion Colacion de las 10');
		$this->layout->setMeta('keywords','Produccion Colacion de las 10');

		$contenido['fecha'] = $fecha;

		$contenido['datos_solicitud_col10'] = $this->objProduccion->consulta_solicitudes_col10($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$this->layout->view('produccion_col10', $contenido);
	}

	public function vista_produccion_col20(){
		#Title
		$this->layout->title('Produccion Colacion de las 20');

		#Metas
		$this->layout->setMeta('title','Produccion Colacion de las 20');
		$this->layout->setMeta('description','Produccion Colacion de las 20');
		$this->layout->setMeta('keywords','Produccion Colacion de las 20');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_col20');
	}

	public function Produccion_col20(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Colacion de las 20');

		#Metas
		$this->layout->setMeta('title','Produccion Colacion de las 20');
		$this->layout->setMeta('description','Produccion Colacion de las 20');
		$this->layout->setMeta('keywords','Produccion Colacion de las 20');

		$contenido['datos_solicitud_col20'] = $this->objProduccion->consulta_solicitudes_col20($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$contenido['fecha'] = $fecha;

		$this->layout->view('produccion_col20', $contenido);
	}

	public function vista_produccion_formulaslacteas(){
		#Title
		$this->layout->title('Produccion Formulas Lacteas');

		#Metas
		$this->layout->setMeta('title','Produccion Formulas Lacteas');
		$this->layout->setMeta('description','Produccion Formulas Lacteas');
		$this->layout->setMeta('keywords','Produccion Formulas Lacteas');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_formulaslacteas');
	}

	public function Produccion_formulas_lacteas(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Formulas Lacteas');

		#Metas
		$this->layout->setMeta('title','Produccion Formulas Lacteas');
		$this->layout->setMeta('description','Produccion Formulas Lacteas');
		$this->layout->setMeta('keywords','Produccion Formulas Lacteas');

		$contenido['fecha'] = $fecha;

		$contenido['datos_solicitud_lacteas'] = $this->objProduccion->consulta_solicitudes_lacteas($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$this->layout->view('produccion_formulas_lacteas', $contenido);
	}

	public function vista_produccion_formulasenterales(){
		#Title
		$this->layout->title('Produccion Formulas Enterales');

		#Metas
		$this->layout->setMeta('title','Produccion Formulas Enterales');
		$this->layout->setMeta('description','Produccion Formulas Enterales');
		$this->layout->setMeta('keywords','Produccion Formulas Enterales');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		$this->layout->view('vista_produccion_formulasenterales');
	}

	public function Produccion_formulas_enterales(){
		$fecha = $this->input->post('fecha');

		$fecha_busqueda = date("Y-m-d", strtotime(str_replace("/", "-", $fecha)));

		#Title
		$this->layout->title('Produccion Formulas Enterales');

		#Metas
		$this->layout->setMeta('title','Produccion Formulas Enterales');
		$this->layout->setMeta('description','Produccion Formulas Enterales');
		$this->layout->setMeta('keywords','Produccion Formulas Enterales');

		$contenido['fecha'] = $fecha;

		$contenido['datos_solicitud_enterales'] = $this->objProduccion->consulta_solicitudes_enterales($this->session->userdata("usuario")->id_unidad, $fecha_busqueda);

		$this->layout->view('Produccion_formulas_enterales', $contenido);
	}

}
