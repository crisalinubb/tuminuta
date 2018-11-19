<?php
class Modelo_Paciente extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "paciente_sistal";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_paciente","maximo");
		$sql = $this->db->get($this->tabla);
		return $sql->row()->maximo+1;
	}
	
	public function insertar($datos){
		return $this->db->insert($this->tabla, $datos);
	}
	
	public function actualizar($datos, $where){
		$this->db->where($where);
		return $this->db->update($this->tabla, $datos);
	}
	
	public function obtener($where){
		$sql = $this->db->select('*')
				->from($this->tabla)
				->where($where)
				->limit(1)
				->get();
				
        $resultado = $sql->row();
		
        if($resultado){
			$obj = new stdClass();
			foreach(get_object_vars($resultado) as $key => $val){
				$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
			}
			return $obj;
        }else{
			return false;
        }
	}
	
	public function listar($where = false, $pagina = false, $cantidad = false){

		if($pagina && $cantidad){
			$desde = ($pagina - 1) * $cantidad;
			$this->db->limit($cantidad, $desde);
		}

		if($cantidad){
			$this->db->limit($cantidad);
		}
		
		if($where) $this->db->where($where);
		$sql = $this->db->select('*')
				->from($this->tabla)
				->order_by('fecha_ingreso','desc')
				->get();
				
        $result = $sql->result();
        if($result){
			$listado = array();
			foreach($result as $resultado){
				$obj = new stdClass();
				foreach(get_object_vars($resultado) as $key => $val){
					$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
				}
				$listado[] = $obj;
			}
			return $listado;
        }else {
			return false;
        }
    }

    public function eliminar($codigo){
    	$this->db->where('id_paciente', $codigo);
		$this->db->delete($this->tabla);
    }

    public function buscar_paciente($rut){
    	$this->db->select('rut');
    	$this->db->from($this->tabla);
    	$this->db->where('rut',$rut);
    	$result = $this->db->get();
		return $result;
    }

    public function cambiar_estado_uno($rut){
    	$this->db->set('estado', 1);
		$this->db->where('rut', $rut);
		$this->db->update('paciente_general'); 
    }

    public function cambiar_estado_cero($rut){
    	$this->db->set('estado', 0);
		$this->db->where('rut', $rut);
		$this->db->update('paciente_general'); 
    }

    public function obtenerPacienteHospitalizado($id_hospitalizado, $id_unidad){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->like('id_paciente',$id_hospitalizado);
    	$this->db->like('id_unidad',$id_unidad);
    	$result = $this->db->get();

		return $result->result();
    }

    public function cama_ocupada_editar($codigo_paciente, $codigo_cama){
    	$this->db->select('codigo_cama');
    	$this->db->from($this->tabla);
    	$this->db->where('codigo_paciente !=',$codigo_paciente);
    	$this->db->where('codigo_cama',$codigo_cama);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result;
    }

    public function buscar_datos_hosp($codigo_servicio, $codigo_sala, $codigo_cama){
        $result= $this->db->query('SELECT servicio_clinico.id_servicio, salas.id_sala, camas.id_cama FROM servicio_clinico INNER JOIN salas ON servicio_clinico.id_servicio = salas.CODSERV LEFT JOIN camas ON salas.CODSALA =camas.codigo_sala WHERE servicio_clinico.codigo_servicio = '.$codigo_servicio.' and salas.CODSALA = "'.$codigo_sala.'" and camas.cama = "'.$codigo_cama.'"');
        //die($this->db->last_query());
        return $result->row();
    }

    public function updatePaciente($id_servicio, $id_sala, $id_cama, $id_paciente, $id_hosp){
    	$this->db->set('codigo_servicio', $id_servicio);
    	$this->db->set('codigo_sala', $id_sala);
    	$this->db->set('codigo_cama', $id_cama);
    	$this->db->set('codigo_paciente_general', $id_paciente);
		$this->db->where('id_paciente', $id_hosp);
		$this->db->update('paciente_sistal_prueba'); 
    }

    public function obtener_pacientes_prueba(){
    	$this->db->select('*');
    	$this->db->from('paciente_sistal_prueba');
    	$result = $this->db->get();
		return $result->result();
    }

    public function eliminar_pacientes_prueba($codigo){
    	$this->db->where('id_paciente', $codigo);
		$this->db->delete('paciente_sistal_prueba');
    }

    public function obtenerPacienteHospitalizado_Por_Salas($id_servicio){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->where('codigo_servicio',$id_servicio);
    	$result = $this->db->get();

		return $result->result();
    }
}