<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Tarjeta extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("control_casino/modelo_funcionario", "objFuncionario");
        $this->load->model("control_casino/modelo_tipo_tarjeta", "objTipoTarjeta");
        $this->load->model("control_casino/modelo_tipo_comida", "objTipoComida");
        $this->load->model("control_casino/modelo_tarjeta", "objTarjeta");
        $this->load->model("hospital/modelo_hospital", "objHospital");
		#current
		//$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Tarjeta');

		#Metas
		$this->layout->setMeta('title','Tarjeta');
		$this->layout->setMeta('description','Tarjeta');
		$this->layout->setMeta('keywords','Tarjeta');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objTarjeta->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		//$contenido['servicios'] = $this->objServicioclinico->listar(array("id_unidad" => $this->session->userdata("usuario")->id_unidad ));

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('numero_tarjeta', 'Numero tarjeta', 'required');
			$this->form_validation->set_rules('fecha_desde', 'Fecha desde', 'required');
			$this->form_validation->set_rules('fecha_hasta', 'Fecha hasta', 'required');
			$this->form_validation->set_rules('codigo_funcionario', 'Funcionario', 'required');
			$this->form_validation->set_rules('codigo_tipotarjeta', 'Tipo de tarjeta', 'required');
			$this->form_validation->set_rules('codigo_tipocomida', 'Tipo de comida', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if($this->objTarjeta->obtener(array("fk_funcionario" => $this->input->post('codigo_funcionario')))){
				echo json_encode(array("result"=>false,"msg"=>"Funcionario ya tiene tarjeta asignada"));
				exit;
			}

			$unidad_funcionario = $this->objFuncionario->obtener(array("id_funcionario" => $this->input->post('codigo_funcionario')));

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$desde = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha_desde'))));
			$hasta = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha_hasta'))));
			
			$datos = array(
				'numero_tarjeta' => $this->input->post('numero_tarjeta'),
				'vigencia_desde' => $desde,
				'vigencia_hasta' => $hasta,
				'fk_funcionario' => $this->input->post('codigo_funcionario'),
				'fk_tipotarjeta' => $this->input->post('codigo_tipotarjeta'),
				'fk_tipocomida' => $this->input->post('codigo_tipocomida'),
				'activo' => 0,
				'id_unidad' => $unidad_funcionario->fk_unidad

			);

			//print_r($datos);die();
			
			if($this->objTarjeta->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#Title
			$this->layout->title('Tarjeta');

			#Metas
			$this->layout->setMeta('title','Tarjeta');
			$this->layout->setMeta('description','Tarjeta');
			$this->layout->setMeta('keywords','Tarjeta');

			#js
			$this->layout->js('js/sistema/tarjeta/agregar.js');

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
			$this->layout->nav(array("Tarjetas "=> "tarjeta", "Agregar Tarjetas" =>"/"));

			$contenido['tipos_tarjetas'] = $this->objTipoTarjeta->listar();
			$contenido['funcionarios'] = $this->objFuncionario->listar(array("fk_unidad" => $this->session->userdata("usuario")->id_unidad, "activo" => 0));
			$contenido['tipos_comidas'] = $this->objTipoComida->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			//$this->form_validation->set_rules('numero_tarjeta', 'Numero tarjeta', 'required');
			$this->form_validation->set_rules('fecha_desde', 'Fecha desde', 'required');
			$this->form_validation->set_rules('fecha_hasta', 'Fecha hasta', 'required');
			$this->form_validation->set_rules('codigo_funcionario', 'Funcionario', 'required');
			$this->form_validation->set_rules('codigo_tipotarjeta', 'Tipo de tarjeta', 'required');
			$this->form_validation->set_rules('codigo_tipocomida', 'Tipo de comida', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			//aqui agregar validacion en caso de que un funcionario ya este vinculado a otra tarjeta 
			// if($this->objTarjeta->obtener(array("fk_funcionario" => $this->input->post('codigo_funcionario')))){
			// 	echo json_encode(array("result"=>false,"msg"=>"Funcionario ya tiene tarjeta asignada"));
			// 	exit;
			// }


			$desde = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha_desde'))));
			$hasta = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post('fecha_hasta'))));

			$datos = array(
				'vigencia_desde' => $desde,
				'vigencia_hasta' => $hasta,
				'fk_funcionario' => $this->input->post('codigo_funcionario'),
				'fk_tipotarjeta' => $this->input->post('codigo_tipotarjeta'),
				'fk_tipocomida' => $this->input->post('codigo_tipocomida'),
				'activo' => 0,
				'id_unidad' => $unidad_funcionario->fk_unidad

			);

			if($this->objTarjeta->actualizar($datos,array("numero_tarjeta"=>$codigo))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "tarjeta/");
			#js
			$this->layout->js('js/sistema/funcionario/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#Title
			$this->layout->title('Editar tarjeta');

			#Metas
			$this->layout->setMeta('title','Editar tarjeta');
			$this->layout->setMeta('description','Editar tarjeta');
			$this->layout->setMeta('keywords','Editar tarjeta');

			#contenido
			if($contenido['tarjetas'] = $this->objTarjeta->obtener(array("numero_tarjeta" => $codigo)));
			else show_error('');

			$contenido['tipos_tarjetas'] = $this->objTipoTarjeta->listar();
			$contenido['funcionarios'] = $this->objFuncionario->listar(array("fk_unidad" => $this->session->userdata("usuario")->id_unidad , "activo" => 0));
			$contenido['tipos_comidas'] = $this->objTipoComida->listar();

			#nav
			$this->layout->nav(array("Tarjetas "=>"tarjeta", "Editar Tarjeta" =>"/"));
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

	public function cambio_activo_desactivo(){
		$datos = $this->input->post('datos_tarjeta');
		$datos_tarjeta = explode("-", $datos);
		$num_tarjeta = $datos_tarjeta[0];
		$estado = $datos_tarjeta[1];
		//aqui se cambia el estado de la tarjeta
		if($this->objTarjeta->actualizar(array("activo"=>$estado),array("numero_tarjeta"=>$num_tarjeta))){	
			$msg = "Se cambio correctamente el estado de la tarjeta";
			$result = true;
		}else{
			$msg = "No se pudo cambiar el estado de la tarjeta";
			$result = false;
		}

		echo json_encode(array("result"=>$result,"msg"=>$msg));
		
	}

}
