<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Aporte_insumo extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_aporteinsumo", "objAportesInsumo");
		$this->load->model("insumos/modelo_insumos", "objInsumo");
		$this->load->model("aportes_nutricionales/modelo_aportesnutricionales", "objAportesNutricionales");
		#current
		$this->layout->current = 1;
	}

	public function index($insumo = false){
		//$insumo= $this->input->get('insumo',TRUE);
		#Title
		$this->layout->title('Aportes por Insumos');

		#Metas
		$this->layout->setMeta('title','Aportes por Insumos');
		$this->layout->setMeta('description','Aportes por Insumos');
		$this->layout->setMeta('keywords','Aportes por Insumos');

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
		$config['base_url'] = base_url() . 'aporte_insumo/';
		$config['total_rows'] = count($this->objAportesInsumo->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/aporte_insumo'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objAportesInsumo->listar($where, $pagina, $config['per_page']);

		#nav
		$this->layout->nav(array("Insumos "=> "insumos", "Aportes por Insumo" =>"/"));

		$contenido['datos'] = $this->objAportesInsumo->obtener_AporteInsumo($insumo);

		$contenido['id_insumo'] = $insumo;

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar($insumo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('codigo_aporte', 'Aporte Nutricional', 'required');
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required');
			$this->form_validation->set_rules('cantidad_aporte', 'Cantidad Aporte', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			if(($this->objAportesInsumo->obtener(array('id_aporte' => $this->input->post('codigo_aporte'), 'id_insumo' =>$this->input->post('insumo'))))){
				echo json_encode(array("result"=>false,"msg"=>"Este aporte ya esta en esta insumo"));
				exit;
			}
			
			$datos = array(
				'id_aporteinsumo' => null,
				'id_insumo' => $this->input->post('insumo'),
				'id_aporte' => $this->input->post('codigo_aporte'),
				'cantidad' => $this->input->post('cantidad'),
				'cantidadAporte' => $this->input->post('cantidad_aporte')
			);
			
			$insumo_agregar = $this->input->post('insumo');
			if($this->objAportesInsumo->insertar($datos)){
				//echo json_encode(array("result"=>true));
				//exit;
		// 		$insumo= $insumo_agregar;
		// #Title
		// $this->layout->title('Aportes por Insumos');

		// #Metas
		// $this->layout->setMeta('title','Aportes por Insumos');
		// $this->layout->setMeta('description','Aportes por Insumos');
		// $this->layout->setMeta('keywords','Aportes por Insumos');

		// #filtros
		// $where = $contenido['q_f'] = '';
		// if($this->input->get('q')){
		// 	$contenido['q_f'] = $q = $this->input->get('q');
		// 	$where = "nombre like '%$q%'";
		// }

		// #url
		// $url = explode('?',$_SERVER['REQUEST_URI']);
		// if(isset($url[1]))
		// 	$contenido['url'] = $url = '/?'.$url[1];
		// else
		// 	$contenido['url'] = $url = '/';

		// #paginacion
		// $config['base_url'] = base_url() . 'aporte_insumo/';
		// $config['total_rows'] = count($this->objAportesInsumo->listar($where));
		// $config['per_page'] = 15;
		// $config['suffix'] = $url;
		// $config['first_url'] = base_url() . '/aporte_insumo'.$url;

		// $this->pagination->initialize($config);

		// //$contenido['datos'] = $this->objAportesInsumo->listar($where, $pagina, $config['per_page']);

		// #nav
		// $this->layout->nav(array("Insumos "=> "insumos", "Aportes por Insumo" =>"/"));

		// $contenido['datos'] = $this->objAportesInsumo->obtener_AporteInsumo($insumo);

		// $contenido['id_insumo'] = $insumo;

		// $contenido['pagination'] = $this->pagination->create_links();

		// $this->layout->view('index', $contenido);

		//redirect('aporte_insumo/index/'.$this->input->post('insumo'),$contenido);
			echo json_encode(array("result"=>true));
			exit;	
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Aporte por Insumo');

			#metas
			$this->layout->setMeta('title','Agregar Aporte por Insumo');
			$this->layout->setMeta('description','Agregar Aporte por Insumo');
			$this->layout->setMeta('keywords','Agregar Aporte por Insumo');

			#js
			$this->layout->js('js/sistema/aporte_insumo/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			//$this->layout->nav(array("Aportes por Insumos "=> "aporte_insumo", "Agregar Aporte por Insumo" =>"/"));

			//$insumo = $this->input->get('insumo',true);

			$contenido['insumo'] = $insumo; 
			$contenido["insumos"]= $this->objInsumo->listar();
			$contenido["aportes_nutricionales"]= $this->objAportesNutricionales->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('codigo_aporte', 'Aporte Nutricional', 'required');
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required');
			$this->form_validation->set_rules('cantidad_aporte', 'Cantidad Aporte', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'id_insumo' => $this->input->post('codigo_insumo'),
				'id_aporte' => $this->input->post('codigo_aporte'),
				'cantidad' => $this->input->post('cantidad'),
				'cantidadAporte' => $this->input->post('cantidad_aporte')
			);

			//$insumo = $this->input->post('codigo_insumo');
			if($this->objAportesInsumo->actualizar($datos,array("id_aporteinsumo"=>$this->input->post('codigo')))){
				
				// echo json_encode(array("result"=>true));
				// exit;
				// $this->layout->title('Aportes por Insumos');

				// #Metas
				// $this->layout->setMeta('title','Aportes por Insumos');
				// $this->layout->setMeta('description','Aportes por Insumos');
				// $this->layout->setMeta('keywords','Aportes por Insumos');

				// #filtros
				// $where = $contenido['q_f'] = '';
				// if($this->input->get('q')){
				// 	$contenido['q_f'] = $q = $this->input->get('q');
				// 	$where = "nombre like '%$q%'";
				// }

				// #url
				// $url = explode('?',$_SERVER['REQUEST_URI']);
				// if(isset($url[1]))
				// 	$contenido['url'] = $url = '/?'.$url[1];
				// else
				// 	$contenido['url'] = $url = '/';

				// #paginacion
				// $config['base_url'] = base_url() . 'aporte_insumo/';
				// $config['total_rows'] = count($this->objAportesInsumo->listar($where));
				// $config['per_page'] = 15;
				// $config['suffix'] = $url;
				// $config['first_url'] = base_url() . '/aporte_insumo'.$url;

				// $this->pagination->initialize($config);

				// //$contenido['datos'] = $this->objAportesInsumo->listar($where, $pagina, $config['per_page']);
				
				// #nav
				// $this->layout->nav(array("Insumos "=> "insumos", "Aportes por Insumo" =>"/"));

				// $contenido['datos'] = $this->objAportesInsumo->obtener_AporteInsumo($insumo);

				// $contenido['id_insumo'] = $insumo;

				// $contenido['pagination'] = $this->pagination->create_links();

				// $this->layout->view('index', $contenido);
				redirect('aporte_insumo/index/'.$this->input->post('codigo_insumo'),$contenido);				
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "aporte_insumo/");
			#js
			//$this->layout->js('js/sistema/aporte_insumo/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');
			
			#title
			$this->layout->title('Editar Aporte por Insumo');

			#metas
			$this->layout->setMeta('title','Editar Aporte por Insumo');
			$this->layout->setMeta('description','Editar Aporte por Insumo');
			$this->layout->setMeta('keywords','Editar Aporte por Insumo');

			#contenido
			if($contenido['aportes_insumos'] = $this->objAportesInsumo->obtener(array("id_aporteinsumo" => $codigo)));
			else show_error('');

			$contenido["insumos"]= $this->objInsumo->listar();
			$contenido["aportes_nutricionales"]= $this->objAportesNutricionales->listar();

			#nav
			//$this->layout->nav(array("Aportes por Insumos "=>"aporte_insumo", "Editar Aporte por Insumo" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "aporte_insumo/");

			//buscando datos de elemento eliminado
			$aporteinsumo_eliminado = $this->objAportesInsumo->obtener(array('id_aporteinsumo' => $codigo));

			$aporte = $this->objAportesNutricionales->obtener(array('id_aporte_nutricional' => $aporteinsumo_eliminado->id_aporte));

			$insumo = $this->objInsumo->obtener(array('id_insumo' => $aporteinsumo_eliminado->id_insumo));

			//print_array($insumo);die();

			//borrando el registro
			$this->objAportesInsumo->eliminar($codigo);

			#Title
			$this->layout->title('Aportes por Insumos');

			#Metas
			$this->layout->setMeta('title','Aportes por Insumos');
			$this->layout->setMeta('description','Aportes por Insumos');
			$this->layout->setMeta('keywords','Aportes por Insumos');

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'aporte_insumo/';
			$config['total_rows'] = count($this->objAportesInsumo->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/aporte_insumo'.$url;

			$this->pagination->initialize($config);

			//$contenido['datos'] = $this->objAportesInsumo->listar($where, $pagina, $config['per_page']);

			#nav
			$this->layout->nav(array("Insumos "=> "insumos", "Aportes por Insumo" =>"/"));

			$contenido['datos'] = $this->objAportesInsumo->obtener_AporteInsumo($insumo->id_insumo);

			$contenido['id_insumo'] = $insumo->id_insumo;

			$contenido['mesagge'] = $insumo->nombre." / ".$aporte->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();

			$this->layout->view('index', $contenido);
	}

}
