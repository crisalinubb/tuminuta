<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Insumo_receta extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_insumoreceta", "objInsumoreceta");
		$this->load->model("insumos/modelo_insumos", "objInsumo");
		$this->load->model("recetas/modelo_recetas", "objRecetas");
		$this->load->model("aportes_nutricionales/modelo_aportesnutricionales", "objAportesNutricionales");
		$this->load->model("rubros/modelo_rubro", "objRubro");
		#current
		$this->layout->current = 1;
	}

	public function index($receta = false){
		//$receta= $this->input->get('receta',TRUE);

		#Title
		$this->layout->title('Insumo por Recetas');

		#Metas
		$this->layout->setMeta('title','Insumo por Recetas');
		$this->layout->setMeta('description','Insumo por Recetas');
		$this->layout->setMeta('keywords','Insumo por Recetas');

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
		$config['base_url'] = base_url() . 'insumo_receta/';
		$config['total_rows'] = count($this->objInsumoreceta->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/insumo_receta'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objInsumoreceta->listar($where, $pagina, $config['per_page']);

		#nav
		$this->layout->nav(array("Recetas "=> "recetas", "Insumos por Receta" =>"/"));

		$contenido['id_receta'] = $receta;

		$contenido['datos'] = $this->objInsumoreceta->obtener_InsumoReceta($receta);

		$contenido['pagination'] = $this->pagination->create_links();

		//buscamos los insumos de esa receta
		$contenido['insumos_aporte'] = $this->objInsumoreceta->join_insumo_receta($receta);

		$contenido['costo_receta'] = $this->objInsumoreceta->costo_receta($receta);

		$contenido['rubros'] = $this->objRubro->listar();

		$this->layout->view('index', $contenido);
	}

	public function agregar($receta = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'id_insumo_receta' => null,
				'id_receta' => $this->input->post('codigo_receta'),
				'id_insumo' => $this->input->post('codigo_insumo'),
				'cantidad' => $this->input->post('cantidad')
			);
			
			$id_receta = $this->input->post('codigo_receta');
			if($this->objInsumoreceta->insertar($datos)){
						
				#Title
				$this->layout->title('Insumo por Recetas');

				#Metas
				$this->layout->setMeta('title','Insumo por Recetas');
				$this->layout->setMeta('description','Insumo por Recetas');
				$this->layout->setMeta('keywords','Insumo por Recetas');

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
				$config['base_url'] = base_url() . 'insumo_receta/';
				$config['total_rows'] = count($this->objInsumoreceta->listar($where));
				$config['per_page'] = 15;
				$config['suffix'] = $url;
				$config['first_url'] = base_url() . '/insumo_receta'.$url;

				$this->pagination->initialize($config);

				//$contenido['datos'] = $this->objInsumoreceta->listar($where, $pagina, $config['per_page']);

				$contenido['id_receta'] = $id_receta;

				$contenido['datos'] = $this->objInsumoreceta->obtener_InsumoReceta($id_receta);

				$contenido['pagination'] = $this->pagination->create_links();

				$contenido['insumos_aporte'] = $this->objInsumoreceta->join_insumo_receta($this->input->post('codigo_receta'));

				$contenido['costo_receta'] = $this->objInsumoreceta->costo_receta($id_receta);

				$contenido['rubros'] = $this->objRubro->listar();

				$this->layout->view('index', $contenido);

			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Insumo por Receta');

			#metas
			$this->layout->setMeta('title','Agregar Insumo por Receta');
			$this->layout->setMeta('description','Agregar Insumo por Receta');
			$this->layout->setMeta('keywords','Agregar Insumo por Receta');

			#js
			//$this->layout->js('js/sistema/insumo_receta/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			//$this->layout->nav(array("Insumos por Recetas "=> "insumo_receta", "Agregar Insumo por Receta" =>"/"));

			//$receta = $this->input->get('receta',true);

			$contenido['receta'] = $receta;
			//$contenido["recetas"]= $this->objRecetas->listar();
			$contenido["insumos"]= $this->objInsumo->listar(array('estado' => 0));

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'id_receta' => $this->input->post('codigo_receta'),
				'id_insumo' => $this->input->post('codigo_insumo'),
				'cantidad' => $this->input->post('cantidad')
			);

			$receta = $this->input->post('codigo_receta');
			if($this->objInsumoreceta->actualizar($datos,array("id_insumo_receta"=>$this->input->post('codigo')))){
				
					#Title
					$this->layout->title('Insumo por Recetas');

					#Metas
					$this->layout->setMeta('title','Insumo por Recetas');
					$this->layout->setMeta('description','Insumo por Recetas');
					$this->layout->setMeta('keywords','Insumo por Recetas');

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
					$config['base_url'] = base_url() . 'insumo_receta/';
					$config['total_rows'] = count($this->objInsumoreceta->listar($where));
					$config['per_page'] = 15;
					$config['suffix'] = $url;
					$config['first_url'] = base_url() . '/insumo_receta'.$url;

					$this->pagination->initialize($config);

					//$contenido['datos'] = $this->objInsumoreceta->listar($where, $pagina, $config['per_page']);

					$contenido['id_receta'] = $receta;

					$contenido['datos'] = $this->objInsumoreceta->obtener_InsumoReceta($receta);

					$contenido['insumos_aporte'] = $this->objInsumoreceta->join_insumo_receta($this->input->post('codigo_receta'));

					$contenido['pagination'] = $this->pagination->create_links();

					$contenido['costo_receta'] = $this->objInsumoreceta->costo_receta($receta);

					$contenido['rubros'] = $this->objRubro->listar();

					$this->layout->view('index', $contenido);

			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "insumo_receta/");
			#js
			//$this->layout->js('js/sistema/insumo_receta/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Insumo por Receta');

			#metas
			$this->layout->setMeta('title','Editar Insumo por Receta');
			$this->layout->setMeta('description','Editar Insumo por Receta');
			$this->layout->setMeta('keywords','Editar Insumo por Receta');

			#contenido
			if($contenido['insumos_recetas'] = $this->objInsumoreceta->obtener(array("id_insumo_receta" => $codigo)));
			else show_error('');

			//$contenido["recetas"]= $this->objRecetas->listar();
			$contenido["insumos"]= $this->objInsumo->listar(array('estado' => 0));

			#nav
			//$this->layout->nav(array("Insumos por recetas "=>"insumo_receta", "Editar Insumo por receta" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "insumo_receta/");

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			//buscando datos de elemento eliminado
			$insumoreceta_eliminado = $this->objInsumoreceta->obtener(array('id_insumo_receta' => $codigo));

			$recetas = $this->objRecetas->obtener(array('id_receta' => $insumoreceta_eliminado->id_receta));
			$insumos = $this->objInsumo->obtener(array('id_insumo' => $insumoreceta_eliminado->id_insumo));

			$receta = $insumoreceta_eliminado->id_receta;

			//borrando el registro
			$this->objInsumoreceta->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'insumo_receta/';
			$config['total_rows'] = count($this->objInsumoreceta->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/insumo_receta'.$url;

			$this->pagination->initialize($config);

			//$contenido['datos'] = $this->objInsumoreceta->listar($where, $pagina, $config['per_page']);

			$contenido['id_receta'] = $receta;

			$contenido['datos'] = $this->objInsumoreceta->obtener_InsumoReceta($receta);

			$contenido['mesagge'] = $recetas->nombre." / ".$insumos->nombre." registro eliminado";

			$contenido['insumos_aporte'] = $this->objInsumoreceta->join_insumo_receta($recetas->id_receta);

			$contenido['pagination'] = $this->pagination->create_links();

			$contenido['costo_receta'] = $this->objInsumoreceta->costo_receta($receta);

			$contenido['rubros'] = $this->objRubro->listar();

			#nav
			$this->layout->nav(array("Recetas "=> "recetas", "Insumos por Receta" =>"/"));

			$this->layout->view('index', $contenido);
	}

	public function busquedaPorRubro(){

		$receta= $this->input->post('receta',TRUE);
		$rubro= $this->input->post('rubros',TRUE);

		#Title
		$this->layout->title('Insumo por Recetas');

		#Metas
		$this->layout->setMeta('title','Insumo por Recetas');
		$this->layout->setMeta('description','Insumo por Recetas');
		$this->layout->setMeta('keywords','Insumo por Recetas');

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
		$config['base_url'] = base_url() . 'insumo_receta/';
		$config['total_rows'] = count($this->objInsumoreceta->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/insumo_receta'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objInsumoreceta->listar($where, $pagina, $config['per_page']);

		#nav
		$this->layout->nav(array("Recetas "=> "recetas", "Insumos por Receta" =>"/"));

		$contenido['id_receta'] = $receta;

		$contenido['datos'] = $this->objInsumoreceta->busquedaPorRubro($receta, $rubro);

		$contenido['pagination'] = $this->pagination->create_links();

		//buscamos los insumos de esa receta
		$contenido['insumos_aporte'] = $this->objInsumoreceta->join_insumo_receta($receta);

		$contenido['costo_receta'] = $this->objInsumoreceta->costo_receta($receta);

		$contenido['rubros'] = $this->objRubro->listar();

		$this->layout->view('index', $contenido);
	}	

}
