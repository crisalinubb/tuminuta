<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Inicio extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("modelo_usuarios", "objUsuarios");
		$this->load->model("hospital/modelo_hospital", "objHospital");
		$this->load->model("index/modelo_index", "objIndex");
		//$this->load->model("modelo_email", "objEmail");
	}

	public function index(){
		if($this->session->userdata("usuario")) redirect("index");
		#title
		$this->layout->title('Sistema Alimentación');
		
		#metas
		$this->layout->setMeta('title','Sistema Alimentación');
		$this->layout->setMeta('description','Sistema Alimentación');
		$this->layout->setMeta('keywords','Sistema Alimentación');
		
		$contenido['home_indicador'] = true;

		$this->layout->js('js/sistema/index/login.js');
		
		$this->layout->view('inicio',$contenido);
	}
	
	public function recuperar(){
		if($this->input->post("email")){
			$newpass = md5(rand());
			$this->objEmail->recuperar($newpass);
		}else{
			redirect('/');
		}
	}
	
	public function login(){
		
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('login_user', 'Login', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('codigo_unidad', 'Organizacion', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			//$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
			}
			else
			{
				try{
					$where = array(
						"login" => $this->input->post('login_user'),
						"clave" => md5($this->input->post('password')),
						"id_unidad" => $this->input->post('codigo_unidad')
					);
					if($usuario = $this->objUsuarios->obtener($where)){
						$this->session->set_userdata('usuario',$usuario);
						echo json_encode(array("result"=>true));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Los datos ingresados no son validos."));
					}
				}
				catch(Exception $e){
					echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
				}
			}
		}else{
			redirect('/');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}

	public function reloj(){
		echo json_encode(array("result" => true, "html" => strftime("%A, %d de %B de %Y, %H:%M:%S", strtotime(date("Y-m-d H:i:s")))));
		exit;
	}
	
	public function buscar_unidades() {
        $login = $this->input->post('login');
        //print_r($login);
        if($login){

            $unidades_login = $this->objIndex->multiple_unidad_usuario($login);
            //echo '<option value="0">Salas</option>';
            foreach($unidades_login as $uni){
            	$unidad = $this->objHospital->obtener(array('id_hospital' => $uni->id_unidad)); 
                echo '<option value="'. $unidad->id_hospital .'">'. $unidad->hos_nombre .'</option>';
            }
        }  else {
            echo 'No se encuentra la Organizacion';
        }
    }
}