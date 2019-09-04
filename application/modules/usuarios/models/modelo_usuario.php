<?php
class Modelo_Usuario extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "usuario";
		//$this->prefijo = substr($this->tabla, 0, 2) . "_";
		parent::__construct();
	}

	public function getLastId(){
		$this->db->select_max("id_usuario","maximo");
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
    	$this->db->where('id_usuario', $codigo);
		$this->db->delete($this->tabla);
    }

    public function buscar_usuario_rut($rut){
    	$this->db->select('rut');
    	$this->db->from($this->tabla);
    	$this->db->where('rut',$rut);
    	$result = $this->db->get();
		return $result;
    }

    public function buscar_usuario_login($login){
    	$this->db->select('login');
    	$this->db->from($this->tabla);
    	$this->db->where('login',$login);
    	$result = $this->db->get();
		return $result;
    }

    public function obtenerUsuario_admin($rut){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
 		$this->db->where('rut',$rut);
    	$this->db->where('id_perfil',1);
    	$result = $this->db->get();

		return $result->result();
    }

    public function obtenerUsuario_organizacion($rut){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
 		$this->db->where('rut',$rut);
    	$this->db->where('id_perfil',2);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result->result();
    }

    public function obtenerUsuario_nutricionista($rut, $id_unidad){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->where('rut',$rut);
    	$this->db->where('id_perfil',3);
    	$this->db->where('id_unidad',$id_unidad);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result->result();
    }

    public function Obtenerlistado($id_unidad){
    	$this->db->select('*');
    	$this->db->distinct();
    	$this->db->from($this->tabla);
    	$this->db->where('id_unidad',$id_unidad);
    	$this->db->where('id_perfil',2);
    	$this->db->or_where('id_perfil',3);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result->result();
    }

    public function Obtenerlistado_2($id_unidad){
    	$this->db->select('*');
    	$this->db->from($this->tabla);
    	$this->db->where('id_unidad',$id_unidad);
    	$this->db->where('id_perfil',2);
    	$this->db->or_where('id_perfil',3);
    	$result = $this->db->get();
    	//die($this->db->last_query());
		return $result->result();
    }

    public function cambiar_clave($contraseña, $id_usuario){
    	$this->db->set('clave', $contraseña);
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuario');
    }
}