<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Funcionario extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("control_casino/modelo_funcionario", "objFuncionario");
		$this->load->model("control_casino/modelo_tipo_contrato", "objTipoContrato");
		$this->load->model("servicio_clinico/modelo_servicioclinico", "objServicioclinico");
		$this->load->model("hospital/modelo_hospital", "objHospital");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Funcionarios');

		#Metas
		$this->layout->setMeta('title','Funcionarios');
		$this->layout->setMeta('description','Funcionarios');
		$this->layout->setMeta('keywords','Funcionarios');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objFuncionario->listar(array("fk_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('hospitales', 'Unidad', 'required');
			$this->form_validation->set_rules('codigo_servicio', 'Servicio', 'required');
			$this->form_validation->set_rules('tipo_contrato', 'Tipo de contrato', 'required');
			$this->form_validation->set_rules('rut', 'Rut','required|min_length[7]|max_length[8]|is_unique[funcionario.rut]');
			$this->form_validation->set_rules('nombre', 'Nombre','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellido_pat', 'apellido paterno','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellido_mat', 'apellido materno','required|min_length[1]|max_length[50]');

			$this->form_validation->set_message('is_unique', '* %s ya registrado en el sistema');
			$this->form_validation->set_message('max_length', '* %s excedido en caracteres');
			$this->form_validation->set_message('min_length', '* %s no tiene el minimo de caracteres');
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'id_funcionario' => null,
				'rut' => $this->input->post('rut'),
				'nombre' => $this->input->post('nombre'),
				'apellido_pat' => $this->input->post('apellido_pat'),
				'apellido_mat' => $this->input->post('apellido_mat'),
				'fk_servicio' => $this->input->post('codigo_servicio'),
				'fk_tipocontrato' => $this->input->post('tipo_contrato'),
				'fk_unidad' => $this->input->post('hospitales'),
				'activo' => 0,
				'observacion' => $this->input->post('observacion')

			);

			//print_r($datos);die();
			
			if($this->objFuncionario->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#Title
			$this->layout->title('Funcionarios');

			#Metas
			$this->layout->setMeta('title','Funcionarios');
			$this->layout->setMeta('description','Funcionarios');
			$this->layout->setMeta('keywords','Funcionarios');

			#js
			$this->layout->js('js/sistema/funcionario/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#nav
			$this->layout->nav(array("Funcionarios "=> "funcionario", "Agregar Funcionarios" =>"/"));

			$contenido['hospitales'] = $this->objHospital->listar();
			$contenido['tipo_contrato'] = $this->objTipoContrato->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('hospitales', 'Unidad', 'required');
			$this->form_validation->set_rules('codigo_servicio', 'Servicio', 'required');
			$this->form_validation->set_rules('tipo_contrato', 'Tipo de contrato', 'required');
			$this->form_validation->set_rules('rut', 'Rut','required|min_length[7]|max_length[8]');
			$this->form_validation->set_rules('nombre', 'Nombre','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellido_pat', 'apellido paterno','required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('apellido_mat', 'apellido materno','required|min_length[1]|max_length[50]');

			$this->form_validation->set_message('max_length', '* %s excedido en caracteres');
			$this->form_validation->set_message('min_length', '* %s no tiene el minimo de caracteres');
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'rut' => $this->input->post('rut'),
				'nombre' => $this->input->post('nombre'),
				'apellido_pat' => $this->input->post('apellido_pat'),
				'apellido_mat' => $this->input->post('apellido_mat'),
				'fk_servicio' => $this->input->post('codigo_servicio'),
				'fk_tipocontrato' => $this->input->post('tipo_contrato'),
				'fk_unidad' => $this->input->post('hospitales'),
				'observacion' => $this->input->post('observacion')

			);

			if($this->objFuncionario->actualizar($datos,array("id_funcionario"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "funcionario/");
			#js
			$this->layout->js('js/sistema/funcionario/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#Title
			$this->layout->title('Funcionarios');

			#Metas
			$this->layout->setMeta('title','Funcionarios');
			$this->layout->setMeta('description','Funcionarios');
			$this->layout->setMeta('keywords','Funcionarios');

			#contenido
			if($contenido['funcionarios'] = $this->objFuncionario->obtener(array("id_funcionario" => $codigo)));
			else show_error('');

			$contenido['hospitales'] = $this->objHospital->listar();
			$contenido['tipo_contrato'] = $this->objTipoContrato->listar();
			$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			#nav
			$this->layout->nav(array("Funcionarios "=>"funcionario", "Editar Funcionario" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "desayuno/");

			//buscando datos de elemento eliminado
			$desayuno_eliminado = $this->objDesayuno->obtener(array('id_desayuno' => $codigo));

			$receta_eliminada = $this->objRecetas->obtener(array('id_receta' => $desayuno_eliminado->id_receta));

			//borrando el registro
			$this->objDesayuno->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#paginacion
			$config['base_url'] = base_url() . 'desayuno/';
			$config['total_rows'] = count($this->objDesayuno->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/desayuno'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ), $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminada->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['desayunos'] = $this->objDesayuno->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$servicio = $this->input->post('servicios',true);

		#Title
		$this->layout->title('Funcionarios');

		#Metas
		$this->layout->setMeta('title','Funcionarios');
		$this->layout->setMeta('description','Funcionarios');
		$this->layout->setMeta('keywords','Funcionarios');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$contenido['datos'] = $this->objFuncionario->listar(array("fk_servicio" => $servicio ));

		$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);

	}

	public function buscarServicios(){
		$id_unidad = $this->input->post('unidad');
        if($id_unidad){
        	$servicios = $this->objServicioclinico->listar(array('id_unidad' => $id_unidad));
            foreach($servicios as $serv){
                echo '<option value="'. $serv->id_servicio .'">'. $serv->nombre_servicio .'</option>';
            }
        }  else {
            echo '<option value="0">Servicios</option>';
        }
	}

}
