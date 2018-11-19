<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Servicios_alimentacion extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_serviciosalimentacion", "objServiciosalimentacion");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Servicios de Alimentacion');

		#Metas
		$this->layout->setMeta('title','Servicios de Alimentacion');
		$this->layout->setMeta('description','Servicios de Alimentacion');
		$this->layout->setMeta('keywords','Servicios de Alimentacion');

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
		$config['base_url'] = base_url() . 'servicios_alimentacion/';
		$config['total_rows'] = count($this->objServiciosalimentacion->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/servicios_alimentacion'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objServiciosalimentacion->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

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
				'id_servicio_alimentacion' => $this->objServiciosalimentacion->getLastId(),
				'nombre' => $this->input->post('nombre')
			);
			
			if($this->objServiciosalimentacion->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Servicio de Alimentacion');

			#metas
			$this->layout->setMeta('title','Agregar Servicio de Alimentacion');
			$this->layout->setMeta('description','Agregar Servicio de Alimentacion');
			$this->layout->setMeta('keywords','Agregar Servicio de Alimentacion');

			#js
			$this->layout->js('js/sistema/servicios_alimentacion/agregar.js');

			#nav
			$this->layout->nav(array("Servicio de Alimentacion "=> "servicios_alimentacion", "Agregar Servicio de Alimentacion" =>"/"));

			$this->layout->view('agregar');
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
				'nombre' => $this->input->post('nombre')
			);

			if($this->objServiciosalimentacion->actualizar($datos,array("id_servicio_alimentacion"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "servicios_alimentacion/");
			#js
			$this->layout->js('js/sistema/servicios_alimentacion/editar.js');

			#title
			$this->layout->title('Editar Servicio de Alimentacion');

			#metas
			$this->layout->setMeta('title','Editar Servicio de Alimentacion');
			$this->layout->setMeta('description','Editar Servicio de Alimentacion');
			$this->layout->setMeta('keywords','Editar Servicio de Alimentacion');

			#contenido
			if($contenido['servicios_alimentacion'] = $this->objServiciosalimentacion->obtener(array("id_servicio_alimentacion" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Servicio de Alimentacion "=>"servicios_alimentacion", "Editar Servicio de Alimentacion" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "servicios_alimentacion/");

			//buscando datos de elemento eliminado
			$servicioalim_eliminado = $this->objServiciosalimentacion->obtener(array('id_servicio_alimentacion' => $codigo));

			//borrando el registro
			$this->objServiciosalimentacion->eliminar($codigo);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'servicios_alimentacion/';
			$config['total_rows'] = count($this->objServiciosalimentacion->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/servicios_alimentacion'.$url;

			$this->pagination->initialize($config);

			$contenido['datos'] = $this->objServiciosalimentacion->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $servicioalim_eliminado->nombre." registro eliminado";

			$contenido['pagination'] = $this->pagination->create_links();

			$this->layout->view('index', $contenido);
	}

}
