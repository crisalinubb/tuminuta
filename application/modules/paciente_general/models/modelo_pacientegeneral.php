<?php
class Modelo_Pacientegeneral extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "paciente_general";
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

     public function obtenerPaciente($rut, $codigo_paciente, $nombre_pac, $apellido_pat, $apellido_mat){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->like('rut',$rut);
    	$this->db->like('codigo_paciente',$codigo_paciente);
    	$this->db->like('nombre',$nombre_pac);
    	$this->db->like('apellido_paterno',$apellido_pat);
    	$this->db->like('apellido_materno',$apellido_mat);
    	$result = $this->db->get();

		return $result->result();
    }

    public function desactivar_paciente($id_paciente, $id_unidad, $id_usuario){
		$fecha = date('Y-m-d H:i:s');
		$this->db->set('activo', 1);
		$this->db->set('id_unidad', $id_unidad);
		$this->db->set('id_usuario', $id_usuario);
		$this->db->set('fecha_desactivacion', $fecha);
		$this->db->where('id_paciente', $id_paciente);
		$this->db->update($this->tabla); 
	}

	public function activar_paciente($id_paciente, $id_unidad, $id_usuario){
		$fecha = date('Y-m-d H:i:s');
		$this->db->set('activo', 0);
		$this->db->set('id_unidad', $id_unidad);
		$this->db->set('id_usuario', $id_usuario);
		$this->db->set('fecha_desactivacion', $fecha);
		$this->db->where('id_paciente', $id_paciente);
		$this->db->update($this->tabla); 
	}

	public function eliminarHospitalizacion($id_paciente){
		$this->db->where('codigo_paciente', $id_paciente);
		$this->db->delete('paciente_sistal');
	}

	public function obtener_paciente_sin_hospitalizacion($rut, $codigo_paciente, $nombre_pac, $apellido_pat, $apellido_mat){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->like('rut',$rut);
    	$this->db->like('codigo_paciente',$codigo_paciente);
    	$this->db->like('nombre',$nombre_pac);
    	$this->db->like('apellido_paterno',$apellido_pat);
    	$this->db->like('apellido_materno',$apellido_mat);
    	$this->db->where('estado', 0);
    	$this->db->where('activo', 0);
    	$result = $this->db->get();

		return $result->result();
    }
}