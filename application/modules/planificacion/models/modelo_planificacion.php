<?php
class Modelo_Planificacion extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "planificacion";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
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
    	$this->db->where('id_planificacion', $codigo);
		$this->db->delete($this->tabla);
    }

    public function obtener_recetas_desayuno($id_regimen,$codigo_unidad){
    	$this->db->select('*');    
		$this->db->from('desayuno');
		$this->db->where('regimen',$id_regimen);
		$this->db->where('id_unidad',$codigo_unidad);
		$this->db->order_by('receta_nombre','asc');
		$query = $this->db->get();
		return $query->result();
    }

    public function obtener_recetas_colacion($id_regimen,$codigo_unidad){
    	$this->db->select('*');    
		$this->db->from('colacion');
		$this->db->where('regimen',$id_regimen);
		$this->db->where('id_unidad',$codigo_unidad);
		$this->db->order_by('receta_nombre','asc');
		$query = $this->db->get();
		return $query->result();
    }

    public function obtener_recetas_formulas($id_regimen){
    	$this->db->select('*');    
		$this->db->from('recetas');
		$this->db->where('id_regimen',$id_regimen);
		$this->db->where('formula',1);
		$this->db->order_by('receta_nombre','asc');
		$query = $this->db->get();
		return $query->result();
    }

    public function obtener_recetas_once($id_regimen,$codigo_unidad){
    	$this->db->select('*');    
		$this->db->from('once');
		$this->db->where('regimen',$id_regimen);
		$this->db->where('id_unidad',$codigo_unidad);
		$this->db->order_by('receta_nombre','asc');
		$query = $this->db->get();
		return $query->result();
    }

    public function obtener_recetas_por_regimen($id_regimen){
    	$this->db->select('*');    
		$this->db->from('recetas');
		$this->db->where('id_regimen',$id_regimen);
		$this->db->order_by('nombre','asc');
		$query = $this->db->get();
		return $query->result();
    }

    public function obtener_recetas_agregar($fecha, $destino, $servicios, $unidad, $regimen){
    	$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$this->db->select('id_receta,volumen_produccion,id_planificacion');    
		$this->db->from('planificacion');
		$this->db->where('id_destino',$destino);
		$this->db->where('id_regimen',$regimen);
		$this->db->where('id_servicio_alimentacion',$servicios);
		$this->db->where('id_unidad',$unidad);
		$this->db->where('fecha BETWEEN "'. $fecha_inicio. '" and "'. $fecha_fin.'"');
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
    }

    public function obtener_recetas_repeticion($fecha, $destino, $servicios, $unidad){
    	$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$this->db->select('id_receta,volumen_produccion,id_planificacion');    
		$this->db->from('planificacion');
		$this->db->where('id_destino',$destino);
		$this->db->where('id_servicio_alimentacion',$servicios);
		$this->db->where('id_unidad',$unidad);
		$this->db->where('fecha BETWEEN "'. $fecha_inicio. '" and "'. $fecha_fin.'"');
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
    }

    public function modificar_volumen($codigo_planificacion, $volumen){
    	$this->db->set('volumen_produccion', $volumen);
		$this->db->where('id_planificacion', $codigo_planificacion);
		$this->db->update('planificacion'); 
    }

    public function obtener_planificacion($fecha, $id_servicio_alimentacion, $id_destino, $id_unidad){

    	$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$this->db->select('*');    
		$this->db->from('planificacion');
		$this->db->where('id_destino',$id_destino);
		$this->db->where('id_servicio_alimentacion',$id_servicio_alimentacion);
		$this->db->where('id_unidad',$id_unidad);
		$this->db->where('fecha BETWEEN "'. $fecha_inicio. '" and "'. $fecha_fin.'"');
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
    }

    public function obtener_regimenes_planificacion(){
    	$result= $this->db->query('SELECT id_regimen, nombre FROM regimenes WHERE tipo = 1');
    	//die($this->db->last_query());
    	return $result->result();
    }
    
    public function obtener_receta_planificacion($fecha, $destino, $servicioAlimentacion, $regimen){
    	$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$result= $this->db->query('SELECT planificacion.id_servicio_alimentacion, planificacion.id_receta, recetas.nombre, planificacion.volumen_produccion FROM planificacion INNER JOIN recetas ON planificacion.id_receta = recetas.id_receta WHERE (planificacion.fecha BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") AND planificacion.id_destino = '.$destino.' AND planificacion.id_servicio_alimentacion = '.$servicioAlimentacion.' AND planificacion.id_regimen = '.$regimen.' order by recetas.id_tipo_receta');
    	//die($this->db->last_query());
    	return $result->result();
    }	

    public function obtener_insumos_planificacion($volumen, $id_receta){
    	$result= $this->db->query('SELECT insumos.nombre AS Insumo, insumos_por_receta.cantidad * '.$volumen.' AS Total, insumos.id_unidad_medida AS Um FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo WHERE (insumos_por_receta.id_receta = '.$id_receta.')');
    	//die($this->db->last_query());
    	return $result->result();
    }
}