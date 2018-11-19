<?php
class Modelo_detallecodigo extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "detalle_codigo";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function insertar($datos){
		return $this->db->insert($this->tabla, $datos);
	}
	
	public function insertar_detalle_receta($datos){
		return $this->db->insert('receta_codigo', $datos);
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
    	$this->db->where('id_detallecodigo', $codigo);
		$this->db->delete($this->tabla);
    }

    public function obtener_recetas($detalle_codigo){
    	$this->db->select('*');
		$this->db->from('receta_codigo');
		$this->db->where('id_detallecodigo',$detalle_codigo);
		$resultado = $this->db->get();
		return $resultado->result();
    }

    public function obtener_recetas_por_regimen($id_regimen){
    	$this->db->select('id_receta, id_regimen, id_tipo_receta, nombre');
    	$this->db->from('recetas');
    	$this->db->like('id_regimen',$id_regimen);
    	$result = $this->db->get();

		return $result->result();

    }

    public function obtener_detalle_receta($codigo_receta, $codigo_detalle){
    	$this->db->select('*');
		$this->db->from('receta_codigo');
		$this->db->where('id_receta',$codigo_receta);
		$this->db->where('id_detallecodigo',$codigo_detalle);
		$resultado = $this->db->get();
		//die($this->db->last_query());
		return $resultado;
    }

    public function obtener_detalle_receta_por_reetadetalle($codigo_receta_detalle){
    	$this->db->select('*');
		$this->db->from('receta_codigo');
		$this->db->where('id_recetacodigo',$codigo_receta_detalle);
		$resultado = $this->db->get();
		//die($this->db->last_query());
		return $resultado->row();
    }

    public function eliminar_receta_codigo($codigo){
    	$this->db->where('id_recetacodigo', $codigo);
		$this->db->delete('receta_codigo');
    }

}