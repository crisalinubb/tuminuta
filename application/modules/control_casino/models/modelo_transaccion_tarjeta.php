<?php
class Modelo_Transaccion_Tarjeta extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "transaccion_tarjeta";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_transaccion","maximo");
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
    	$this->db->where('id_transaccion', $codigo);
		$this->db->delete($this->tabla);
	}
	
	public function obtener_funcionario_dia_actual($codigo_tarjeta){
		$fecha_actual = date('Y-m-d');
		$fecha_inicial = date('Y-m-d 00:00:00', strtotime($fecha_actual));
		$fecha_final = date('Y-m-d 23:59:59', strtotime($fecha_actual));
		$this->db->select('fk_tarjeta');    
		$this->db->from('transaccion_tarjeta');
		$this->db->where('fk_tarjeta', $codigo_tarjeta);
		$this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
		$query = $this->db->get();
		//die($this->db->last_query());
		//return $query;
		if($query->num_rows() == 0){
    		return true;
    	}else{
    		return false;
    	} 
	}
	
}