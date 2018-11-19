<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Trazabilidad extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 5;
		$this->layout->subCurrent = 2;
	}

	public function index(){
		$this->layout->title('Trazabilidad');
		$data = array();
		$result='';
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');

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

		$this->layout->view('index');        
	}
}