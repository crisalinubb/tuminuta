<?php
class Modelo_Insumos extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "insumos";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_insumo","maximo");
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
    	$this->db->where('id_insumo', $codigo);
		$this->db->delete($this->tabla);
    }

    public function obtenerInsumos($nombre_insumo){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->like('nombre',$nombre_insumo);
    	$result = $this->db->get();

		return $result->result();
    }

    public function agregar_unidad_compra($id_insumo, $unidad_compra){
		$this->db->set('unidad_compra', $unidad_compra);
		$this->db->where('id_insumo', $id_insumo);
		$this->db->update($this->tabla); 
	}

	public function desactivar_insumos($id_insumo, $id_unidad, $id_usuario){
		$fecha = date('Y-m-d');
		$this->db->set('estado', 1);
		$this->db->set('id_unidad', $id_unidad);
		$this->db->set('id_usuario', $id_usuario);
		$this->db->set('fecha_desactivacion', $fecha);
		$this->db->where('id_insumo', $id_insumo);
		$this->db->update($this->tabla); 
	}

	public function activar_insumos($id_insumo, $id_unidad, $id_usuario){
		$fecha = date('Y-m-d');
		$this->db->set('estado', 0);
		$this->db->set('id_unidad', $id_unidad);
		$this->db->set('id_usuario', $id_usuario);
		$this->db->set('fecha_desactivacion', $fecha);
		$this->db->where('id_insumo', $id_insumo);
		$this->db->update($this->tabla); 
	}
}