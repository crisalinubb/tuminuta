<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Usuarios_organizacion extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("usuarios/modelo_usuario", "objUsuario");
		$this->load->model("hospital/modelo_hospital", "objHospital");
		#current
		$this->layout->current = 2;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Usuarios');

		#Metas
		$this->layout->setMeta('title','Usuarios');
		$this->layout->setMeta('description','Usuarios');
		$this->layout->setMeta('keywords','Usuarios');

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
		$config['base_url'] = base_url() . 'usuarios/';
		$config['total_rows'] = count($this->objUsuario->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/usuarios'.$url;

		$this->pagination->initialize($config);

		$contenido['usuarios'] = $this->objUsuario->listar(array("id_perfil" =>2 ));

		$contenido['datos'] = $this->objUsuario->listar(array("id_perfil" =>2 ), $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar($codigo = false){
		if (($this->objUsuario->buscar_usuario_rut($this->input->post('rut'))->num_rows() == 1) || ($this->objUsuario->buscar_usuario_login($this->input->post('login'))->num_rows() == 1)) {
			
			echo json_encode(array("result"=>false,"msg"=>"Usuario ya registrado en el sistema"));
				exit;
			
		}else{
		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('rut', 'rut', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'id_usuario' => null,
				'rut' => $this->input->post('rut'),
				'dv' => $this->input->post('dv'),
				'nombre' => $this->input->post('nombre'),
				'apellidoPaterno' => $this->input->post('apellidoP'),
				'apellidoMaterno' => $this->input->post('apellidoM'),
				'login' => $this->input->post('login'),
				'clave' => md5($this->input->post('password')),
				'id_perfil' => 2, 
				'id_unidad' => $this->input->post('id_hospital')

			);

			if($this->objUsuario->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Usuario');

			#metas
			$this->layout->setMeta('title','Agregar Usuario');
			$this->layout->setMeta('description','Agregar Usuario');
			$this->layout->setMeta('keywords','Agregar Usuario');

			#js
			$this->layout->js('js/sistema/usuarios_organizacion/agregar.js');

			#nav
			$this->layout->nav(array("Usuarios "=> "usuarios_organizacion", "Agregar Usuarios" =>"/"));

			$contenido['hospitales'] = $this->objHospital->listar();

			$this->layout->view('agregar', $contenido);
		}
	}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'rut' => $this->input->post('rut'),
				'dv' => $this->input->post('dv'),
				'nombre' => $this->input->post('nombre'),
				'apellidoPaterno' => $this->input->post('apellidoP'),
				'apellidoMaterno' => $this->input->post('apellidoM'),
				'login' => $this->input->post('login'),
				'clave' => md5($this->input->post('password')),
				'id_perfil' => 2
			);

			if($this->objUsuario->actualizar($datos,array("id_usuario"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "usuarios/");
			#js
			$this->layout->js('js/sistema/usuarios_organizacion/editar.js');

			#title
			$this->layout->title('Editar Usuario');

			#metas
			$this->layout->setMeta('title','Editar Usuario');
			$this->layout->setMeta('description','Editar Usuario');
			$this->layout->setMeta('keywords','Editar Usuario');

			#contenido
			if($contenido['usuarios'] = $this->objUsuario->obtener(array("id_usuario" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Usuarios "=>"usuarios_organizacion", "Editar Usuarios" =>"/"));
			$contenido['hospitales'] = $this->objHospital->listar();

			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "usuarios/");
			//buscando datos de elemento eliminado
			$usuario_eliminado = $this->objUsuario->obtener(array('id_usuario' => $codigo));

			//borrando el registro
			$this->objUsuario->eliminar($codigo);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');


			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'usuarios_organizacion/';
			$config['total_rows'] = count($this->objUsuario->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/usuarios_organizacion'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objUsuario->listar(array("id_perfil" =>2 ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $usuario_eliminado->nombre." ".$usuario_eliminado->apellidoPaterno." ".$usuario_eliminado->apellidoMaterno." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['usuarios'] = $this->objUsuario->listar(array("id_perfil" =>2 ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$rut = $this->input->get('usuarios',true);

		#Title
		$this->layout->title('Usuarios');

		#Metas
		$this->layout->setMeta('title','Usuarios');
		$this->layout->setMeta('description','Usuarios');
		$this->layout->setMeta('keywords','Usuarios');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		//$nombre_completo = explode(" ", $query);

		$contenido['datos'] = $this->objUsuario->obtenerUsuario_organizacion($rut );

		//$contenido['datos'] = $this->objUsuario->obtener(array('id_usuario' => $this->input->post('usuarios')));

		$contenido['usuarios'] = $this->objUsuario->listar(array("id_perfil" =>2 ));

		$this->layout->view('index', $contenido);

	}

}
