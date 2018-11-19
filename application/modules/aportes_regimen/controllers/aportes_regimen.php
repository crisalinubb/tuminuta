<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Aportes_regimen extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_aportesregimen", "objAporteReg");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("modelo_tipoaportes", "objTipoAport");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Aportes por Regimen');

		#Metas
		$this->layout->setMeta('title','Aportes por Regimen');
		$this->layout->setMeta('description','Aportes por Regimen');
		$this->layout->setMeta('keywords','Aportes por Regimen');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'aportes_regimen/';
		$config['total_rows'] = count($this->objAporteReg->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/aportes_regimen'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objAporteReg->listar($where, $pagina, $config['per_page']);

		$contenido['regimenes'] = $this->objAporteReg->listar();

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('codigo_regimen', 'Regimen', 'required');
			$this->form_validation->set_rules('tipo_aporte', 'Tipo de Aporte', 'required');
			$this->form_validation->set_rules('kcal', 'Kcal', 'required');
			$this->form_validation->set_rules('prot', 'Prot', 'required');
			$this->form_validation->set_rules('lip', 'Lip', 'required');
			$this->form_validation->set_rules('cho', 'Cho', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->objAporteReg->obtener(array("id_regimen" => $this->input->post('codigo_regimen'), "id_tipoaporte" => $this->input->post('tipo_aporte')))){
				echo json_encode(array("result"=>false,"msg"=>"Aporte por regimen ya ingresado"));
				exit;
			}

			$datos = array(
				'Id_Aporte_Nut' => null,
				'id_regimen' => $this->input->post('codigo_regimen'),
				'id_tipoaporte' => $this->input->post('tipo_aporte'),
				'Kcal' => $this->input->post('kcal'),
				'Prot' => $this->input->post('prot'),
				'Lip' => $this->input->post('lip'),
				'Cho' => $this->input->post('cho')

			);
			
			if($this->objAporteReg->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Aportes por Regimen');

			#metas
			$this->layout->setMeta('title','Agregar Aportes por Regimen');
			$this->layout->setMeta('description','Agregar Aportes por Regimen');
			$this->layout->setMeta('keywords','Agregar Aportes por Regimen');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#js
			$this->layout->js('js/sistema/aporte_regimen/agregar.js');

			#nav
			$this->layout->nav(array("Aportes por Regimen "=> "aportes_regimen", "Agregar Aportes por Regimen" =>"/"));

			$contenido['tipo_aporte'] = $this->objTipoAport->listar();
			$contenido['regimenes'] = $this->objRegimen->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('codigo_regimen', 'Regimen', 'required');
			$this->form_validation->set_rules('tipo_aporte', 'Tipo de Aporte', 'required');
			$this->form_validation->set_rules('kcal', 'Kcal', 'required');
			$this->form_validation->set_rules('prot', 'Prot', 'required');
			$this->form_validation->set_rules('lip', 'Lip', 'required');
			$this->form_validation->set_rules('cho', 'Cho', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'id_regimen' => $this->input->post('codigo_regimen'),
				'id_tipoaporte' => $this->input->post('tipo_aporte'),
				'Kcal' => $this->input->post('kcal'),
				'Prot' => $this->input->post('prot'),
				'Lip' => $this->input->post('lip'),
				'Cho' => $this->input->post('cho')

			);


			if($this->objAporteReg->actualizar($datos,array("Id_Aporte_Nut"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "aportes_regimen/");
			#js
			$this->layout->js('js/sistema/aporte_regimen/editar.js');

			#title
			$this->layout->title('Editar Aportes por Insumo');

			#metas
			$this->layout->setMeta('title','Editar Aportes por Regimen');
			$this->layout->setMeta('description','Editar Aportes por Regimen');
			$this->layout->setMeta('keywords','Editar Aportes por Regimen');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#contenido
			if($contenido['aportes_regimen'] = $this->objAporteReg->obtener(array("Id_Aporte_Nut" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Aportes por Regimen "=> "aportes_regimen", "Editar Aportes por Regimen" =>"/"));

			$contenido['tipo_aporte'] = $this->objTipoAport->listar();
			$contenido['regimenes'] = $this->objRegimen->listar();

			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "aportes_regimen/");

			#title
			$this->layout->title('Aportes por Regimen');

			#metas
			$this->layout->setMeta('title','Aportes por Regimen');
			$this->layout->setMeta('description','Aportes por Regimen');
			$this->layout->setMeta('keywords','Aportes por Regimen');

			//buscando datos de elemento eliminado
			$aportreg_eliminado = $this->objAporteReg->obtener(array('Id_Aporte_Nut' => $codigo));

			$tipo_aporte = $this->objTipoAport->obtener(array('id_tipoaporte' => $aportreg_eliminado->id_tipoaporte));
			$regimen = $this->objRegimen->obtener(array('id_regimen' => $aportreg_eliminado->id_regimen));

			//borrando el registro
			$this->objAporteReg->eliminar($codigo);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#url
			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'aportes_regimen/';
			$config['total_rows'] = count($this->objAporteReg->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/aportes_regimen'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objAporteReg->listar($where, $pagina, $config['per_page']);

			$contenido['regimenes'] = $this->objAporteReg->listar();

			$contenido['pagination'] = $this->pagination->create_links();

			$contenido['mesagge'] = $regimen->nombre." - ".$tipo_aporte->tipoaporte_nombre." registro eliminado";

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->post('regimenes');

		#title
		$this->layout->title('Aportes por Regimen');

		#metas
		$this->layout->setMeta('title','Aportes por Regimen');
		$this->layout->setMeta('description','Aportes por Regimen');
		$this->layout->setMeta('keywords','Aportes por Regimen');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objAporteReg->obtener_Aporte_Regimen($query);

		$contenido['regimenes'] = $this->objAporteReg->listar();

		$this->layout->view('index', $contenido);

	}

}
