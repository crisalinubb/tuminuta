<?php
class Modelo_Salas extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "salas";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_sala","maximo");
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
    	$this->db->where('id_sala', $codigo);
		$this->db->delete($this->tabla);
    }

    public function buscar_sala_por_servicio($id_servicio){
    	$this->db->select('*');
    	$this->db->from('salas');
    	$this->db->where('CODSERV', $id_servicio);
    	$resultado = $this->db->get();
    	return $resultado;
    }

    public function obtenerSala($servicio, $sala){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->where('CODSERV',$servicio);
    	$this->db->where('CODSALA',$sala);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result->result();
    }

    public function obtenerServicio($servicio){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->where('CODSERV',$servicio);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result->result();
    }
}