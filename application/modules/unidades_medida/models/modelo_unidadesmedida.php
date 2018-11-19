<?php
class Modelo_unidadesmedida extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "unidades_medida";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_unidad_medidad","maximo");
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
    	$this->db->where('id_unidad_medidad', $codigo);
		$this->db->delete($this->tabla);
    }

    public function obtenerUnidadMedida($nombre_unidad){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->like('nombre',$nombre_unidad);
    	$result = $this->db->get();

		return $result->result();
    }
}