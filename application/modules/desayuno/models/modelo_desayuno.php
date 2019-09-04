<?php
class Modelo_Desayuno extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "desayuno";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_desayuno","maximo");
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
				->group_by('receta_nombre','asc')
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
    	$this->db->where('id_desayuno', $codigo);
		$this->db->delete($this->tabla);
    }

    public function obtenerDesayuno($nombre_desayuno){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->like('receta_nombre',$nombre_desayuno);
    	$result = $this->db->get();

		return $result->result();
    }

    public function obtener_recetas_por_regimen($id_regimen){
    	$this->db->select('id_receta, id_regimen, id_tipo_receta, nombre');
    	$this->db->from('recetas');
    	$this->db->like('id_regimen',$id_regimen);
    	$this->db->where('estado',0);
    	$result = $this->db->get();

		return $result->result();

    }

    public function activar($id_desayuno){
		$this->db->set('estado', 0);
		$this->db->where('id_desayuno', $id_desayuno);
		$this->db->update($this->tabla); 
	}

	public function desactivar($id_desayuno){
		$this->db->set('estado', 1);
		$this->db->where('id_desayuno', $id_desayuno);
		$this->db->update($this->tabla); 
	}
}