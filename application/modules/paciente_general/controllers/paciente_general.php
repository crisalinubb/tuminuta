<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Paciente_general extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_pacientegeneral", "objPacGeneral");
		$this->load->model("modelo_escolaridad", "objEscolaridad");
		$this->load->model("modelo_sexo", "objSexo");
		$this->load->model("modelo_etnia", "objEtnia");
		$this->load->model("modelo_pais", "objPais");
		$this->load->model("modelo_comuna", "objComuna");
		$this->load->model("modelo_region", "objRegion");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
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

		//$contenido['datos'] = $this->objPacGeneral->listar($where, $pagina, $config['per_page']);

		$contenido['pacientes'] = $this->objPacGeneral->listar();

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){
		//print_r($this->input->post('rut'));
		//if ($this->objPacGeneral->buscar_paciente($this->input->post('rut'))->num_rows() > 0 ) {

			
		//	echo json_encode(array("result"=>false,"msg"=>"Rut ya registrado en el sistema"));
		//		exit;
			
		//}else{
		if($this->input->post()){
			//$punto = '.';
			//$validar_rut = strpos($this->input->post('rut'), $punto);
			//print_r($validar_rut); 
			//if($pos === false){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('rut', 'Rut','required|numeric|min_length[7]|max_length[8]|is_unique[paciente_general.rut]');
			$this->form_validation->set_rules('dv', 'Digito verificador','required|min_length[1]|max_length[1]');
			$this->form_validation->set_rules('nombre', 'Nombre','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellidop', 'apellidop','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellidom', 'apellidom','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('correo', 'Correo Electronico','max_length[50]|trim|valid_email');
			$this->form_validation->set_rules('telefono', 'Telefono','max_length[9]|trim|numeric');

			$this->form_validation->set_message('valid_email', '* %s invalido');
			$this->form_validation->set_message('is_unique', '* %s ya ingresado');
			$this->form_validation->set_message('numeric', '* %s debe ingresar un numero no caracteres');
			$this->form_validation->set_message('max_length', '* %s excedido en caracteres');
			$this->form_validation->set_message('min_length', '* %s no tiene el minimo de caracteres');
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$fecha_nacimiento = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha1'))));

			$datos = array(
				'id_paciente' => null,
				'rut' => $this->input->post('rut'),
				'codigo_paciente' => $this->input->post('codigo_paciente'),
				'dv' => $this->input->post('dv'),
				'nombre' => strtoupper($this->input->post('nombre')),
				'apellido_paterno' => strtoupper($this->input->post('apellidop')),
				'apellido_materno' => strtoupper($this->input->post('apellidom')),
				'fecha_registro' => date('Y-m-d H:i:s'),
				'telefono' => $this->input->post('telefono'),
				'fecha_nacimiento' => $fecha_nacimiento,
				'estado' => 0,
				'direccion' => $this->input->post('direccion'),
				'nombre_padre' => strtoupper($this->input->post('nombre_padre')),
				'nombre_madre' => strtoupper($this->input->post('nombre_madre')),
				'id_escolaridad' => $this->input->post('id_escolaridad'),
				'ocupacion_actual' => $this->input->post('ocupacion_actual'),
				'sexo' => $this->input->post('sexo'),
				'correo' => $this->input->post('correo'),
				'id_etnia' => $this->input->post('etnia'),
				'hc' => $this->input->post('hc'),
				'pais' => $this->input->post('paises'),
				'comuna' => $this->input->post('comunas'),
				'region' => $this->input->post('regiones'),
				'alergias' => $this->input->post('alergias'),
				'enfermedades_cronicas' => $this->input->post('enfermedades_cronicas'),
				'farmacos_uso_habitual' => $this->input->post('farmacos'),
				'antecedentes_familiares' => $this->input->post('antecedentes_familiares'),
				'fumador' => $this->input->post('fumador'),
				'cantidad_cigarros' => $this->input->post('cant_cigarros')
			);
		
			if($this->objPacGeneral->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		//}else{
			//print_r($this->input->post('rut'));
			//echo json_encode(array("result"=>false,"msg"=>"El rut tiene puntos, por favor volver a ingresar sin puntos"));
			//	exit;
		//}
		}else{
			#title
			$this->layout->title('Agregar Paciente');

			#metas
			$this->layout->setMeta('title','Agregar Paciente');
			$this->layout->setMeta('description','Agregar Paciente');
			$this->layout->setMeta('keywords','Agregar Paciente');

			#js
			$this->layout->js('js/sistema/paciente_general/agregar.js');

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
			$this->layout->nav(array("Paciente "=> "paciente_general", "Agregar Paciente" =>"/"));

			$contenido['escolaridades'] = $this->objEscolaridad->listar();
			$contenido['sexos'] = $this->objSexo->listar();
			$contenido['etnias'] = $this->objEtnia->listar();
			$contenido['paises'] = $this->objPais->listar();
			$contenido['comunas'] = $this->objComuna->listar();
			$contenido['regiones'] = $this->objRegion->listar();

			$this->layout->view('agregar', $contenido);
		}
	//}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('rut', 'Rut','required|numeric|min_length[7]|max_length[8]');
			$this->form_validation->set_rules('dv', 'Digito verificador','required|min_length[1]|max_length[1]');
			$this->form_validation->set_rules('nombre', 'Nombre','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellidop', 'apellidop','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellidom', 'apellidom','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('correo', 'Correo Electronico','max_length[50]|trim|valid_email');
			$this->form_validation->set_rules('telefono', 'Telefono','max_length[9]|trim|numeric');

			$this->form_validation->set_message('valid_email', '* %s invalido');
			$this->form_validation->set_message('numeric', '* %s debe ingresar un numero no caracteres');
			$this->form_validation->set_message('max_length', '* %s excedido en caracteres');
			$this->form_validation->set_message('min_length', '* %s no tiene el minimo de caracteres');
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$fecha_nacimiento = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha1'))));

			$datos = array(
				'rut' => $this->input->post('rut'),
				'codigo_paciente' => $this->input->post('codigo_paciente'),
				'dv' => $this->input->post('dv'),
				'nombre' => strtoupper($this->input->post('nombre')),
				'apellido_paterno' => strtoupper($this->input->post('apellidop')),
				'apellido_materno' => strtoupper($this->input->post('apellidom')),
				'fecha_registro' => date('Y-m-d H:i:s'),
				'telefono' => $this->input->post('telefono'),
				'fecha_nacimiento' => $fecha_nacimiento,
				'estado' => 0,
				'direccion' => $this->input->post('direccion'),
				'nombre_padre' => strtoupper($this->input->post('nombre_padre')),
				'nombre_madre' => strtoupper($this->input->post('nombre_madre')),
				'id_escolaridad' => $this->input->post('id_escolaridad'),
				'ocupacion_actual' => $this->input->post('ocupacion_actual'),
				'sexo' => $this->input->post('sexo'),
				'correo' => $this->input->post('correo'),
				'id_etnia' => $this->input->post('etnia'),
				'hc' => $this->input->post('hc'),
				'pais' => $this->input->post('paises'),
				'comuna' => $this->input->post('comunas'),
				'region' => $this->input->post('regiones'),
				'alergias' => $this->input->post('alergias'),
				'enfermedades_cronicas' => $this->input->post('enfermedades_cronicas'),
				'farmacos_uso_habitual' => $this->input->post('farmacos'),
				'antecedentes_familiares' => $this->input->post('antecedentes_familiares'),
				'fumador' => $this->input->post('fumador'),
				'cantidad_cigarros' => $this->input->post('cant_cigarros')
			);

			//print_r($datos);die();
			if($this->objPacGeneral->actualizar($datos,array("id_paciente"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "paciente_general/");
			#js
			$this->layout->js('js/sistema/paciente_general/editar.js');

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

			#title
			$this->layout->title('Editar Paciente');

			#metas
			$this->layout->setMeta('title','Editar Paciente');
			$this->layout->setMeta('description','Editar Paciente');
			$this->layout->setMeta('keywords','Editar Paciente');

			#contenido
			if($contenido['pacientes'] = $this->objPacGeneral->obtener(array("id_paciente" => $codigo)));
			else show_error('');

			$contenido['escolaridades'] = $this->objEscolaridad->listar();
			$contenido['sexos'] = $this->objSexo->listar();
			$contenido['etnias'] = $this->objEtnia->listar();
			$contenido['paises'] = $this->objPais->listar();
			$contenido['comunas'] = $this->objComuna->listar();
			$contenido['regiones'] = $this->objRegion->listar();

			#nav
			$this->layout->nav(array("Paciente "=>"paciente_general", "Editar Paciente" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "paciente_general/");

			//buscando datos de elemento eliminado
			$paciente_eliminado = $this->objPacGeneral->obtener(array('id_paciente' => $codigo));

			//borrando el registro
			$this->objPacGeneral->eliminar($codigo);

			$contenido['datos'] = $this->objPacGeneral->listar($where, $pagina, $config['per_page']);

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

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objPacGeneral->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $paciente_eliminado->nombre." ".$paciente_eliminado->apellido." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['pacientes'] = $this->objPacGeneral->listar();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$query = $this->input->get('pacientes',true);

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

		$contenido['datos'] = $this->objPacGeneral->obtenerPaciente($query);

		$contenido['pacientes'] = $this->objPacGeneral->listar();

		$this->layout->view('index', $contenido);

	}

}
