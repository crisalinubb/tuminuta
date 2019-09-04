<?php
class Modelo_insumoreceta extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "insumos_por_receta";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_insumo_receta","maximo");
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
    	$this->db->where('id_insumo_receta', $codigo);
		$this->db->delete($this->tabla);
    }

    public function obtener_InsumoReceta($id_receta){
    	$resultado= $this->db->query('SELECT * FROM insumos_por_receta RIGHT JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo WHERE insumos_por_receta.id_receta = '.$id_receta.'');
    	//die($this->db->last_query());
		return $resultado->result();
    }

    public function busquedaPorRubro($id_receta, $id_rubro){
    	$resultado= $this->db->query('SELECT * FROM insumos_por_receta RIGHT JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo WHERE insumos_por_receta.id_receta = '.$id_receta.' AND insumos.id_rubro = '.$id_rubro.'');
    	//die($this->db->last_query());
		return $resultado->result();
    }

    public function join_insumo_receta($id_receta){
    	$result= $this->db->query('SELECT aportes_nutricionales.nombre, SUM((insumos_por_receta.cantidad * aporte_insumo.cantidad )/aporte_insumo.cantidadAporte) As Total, aportes_nutricionales.id_unidad_medida FROM insumos_por_receta RIGHT JOIN aporte_insumo ON insumos_por_receta.id_insumo = aporte_insumo.id_insumo LEFT JOIN aportes_nutricionales ON aporte_insumo.id_aporte = aportes_nutricionales.id_aporte_nutricional WHERE insumos_por_receta.id_receta = '.$id_receta.' GROUP BY nombre, aportes_nutricionales.id_unidad_medida');
    	//die($this->db->last_query());
    	return $result;
    }

    public function costo_receta($id_receta){
    	$result= $this->db->query("SELECT 'Costo Directo' as Item , SUM(insumos_por_receta.cantidad * insumos.costo / insumos.factor_costo) AS SubTotal FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo WHERE id_receta = '".$id_receta."'");
    	//die($this->db->last_query());
    	return $result->row();
    }
}