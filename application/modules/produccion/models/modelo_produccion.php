<?php
class Modelo_Produccion extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		parent::__construct();
	}

	public function consulta_solicitudes_desayuno($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));
    	$result= $this->db->query('SELECT desayuno.id_receta, desayuno.receta_nombre AS Producto, COUNT(solicitud.id_solicitud) AS total FROM solicitud INNER JOIN desayuno ON solicitud.id_desayuno = desayuno.id_receta WHERE solicitud.id_unidad = '.$unidad.' AND (desayuno.id_receta > 0) AND( solicitud.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'" )  GROUP BY desayuno.receta_nombre, desayuno.id_receta ORDER BY Producto');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_desayuno($total, $receta){
		$result= $this->db->query('SELECT insumos.nombre, (insumos_por_receta.cantidad * '.$total.') as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo where insumos_por_receta.id_receta = '.$receta.'');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_almuerzo($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$result= $this->db->query('SELECT regimenes.base AS Regimen, COUNT(1) AS total FROM solicitud AS S INNER JOIN regimenes ON S.id_almuerzo = regimenes.id_regimen WHERE S.id_unidad = '.$unidad.' AND(regimenes.base > 0) AND S.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'" GROUP BY regimenes.base');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_planificacion_almuerzo($unidad, $total, $regimen, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$result= $this->db->query('SELECT p.fecha, p.id_regimen, p.id_receta, recetas.nombre, IFNULL(c.volumen_produccion, 0) AS volumen_produccion, ( IFNULL(c.volumen_produccion, 0) + '.$total.' ) AS volumen, '.$total.' AS total FROM planificacion AS p INNER JOIN recetas ON p.id_receta = recetas.id_receta AND( p.id_destino <> 6 AND p.id_servicio_alimentacion = 2 ) LEFT JOIN planificacion AS c ON p.id_receta = c.id_receta AND c.id_destino = 6 AND p.fecha = c.fecha WHERE (p.id_regimen = '.$regimen.') AND( p.fecha BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") AND (p.id_unidad = '.$unidad.')');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_almuerzo($receta, $total){	
    	$result= $this->db->query('SELECT insumos.nombre,(insumos_por_receta.cantidad * '.$total.' ) as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo WHERE insumos_por_receta.id_receta = '.$receta.'');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_once($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));
    	$result= $this->db->query('SELECT once.id_receta, once.receta_nombre AS Producto, COUNT(solicitud.id_solicitud) AS total FROM solicitud INNER JOIN once ON solicitud.id_once = once.id_receta WHERE solicitud.id_unidad = '.$unidad.' AND (once.id_receta > 0) AND( solicitud.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'" )  GROUP BY once.receta_nombre, once.id_receta ORDER BY Producto');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_once($total, $receta){
		$result= $this->db->query('SELECT insumos.nombre, (insumos_por_receta.cantidad * '.$total.') as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo where insumos_por_receta.id_receta = '.$receta.'');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_cena($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$result= $this->db->query('SELECT regimenes.base AS Regimen, COUNT(1) AS total FROM solicitud AS S INNER JOIN regimenes ON S.id_cena = regimenes.id_regimen WHERE S.id_unidad = '.$unidad.' AND(regimenes.base > 0) AND S.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'" GROUP BY regimenes.base');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_planificacion_cena($unidad, $total, $regimen, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));
    	$result= $this->db->query('SELECT p.fecha, p.id_regimen, p.id_receta, recetas.nombre, IFNULL(c.volumen_produccion, 0) AS volumen_produccion, ( IFNULL(c.volumen_produccion, 0) + '.$total.' ) AS volumen, '.$total.' AS total FROM planificacion AS p INNER JOIN recetas ON p.id_receta = recetas.id_receta AND( p.id_destino <> 6 AND p.id_servicio_alimentacion = 4 ) LEFT JOIN planificacion AS c ON p.id_receta = c.id_receta AND c.id_destino = 6 AND p.fecha = c.fecha WHERE (p.id_regimen = '.$regimen.') AND( p.fecha BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") AND (p.id_unidad = '.$unidad.')');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_cena($receta, $total){	
    	$result= $this->db->query('SELECT insumos.nombre,(insumos_por_receta.cantidad * '.$total.' ) as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo WHERE insumos_por_receta.id_receta = '.$receta.'');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_col10($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));
    	$result= $this->db->query('SELECT recetas.id_receta, recetas.nombre AS Producto, COUNT(solicitud.id_solicitud) AS total FROM solicitud INNER JOIN recetas ON solicitud.id_col10 = recetas.id_receta WHERE (recetas.id_receta > 0) AND solicitud.id_unidad = '.$unidad.' AND ( solicitud.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") GROUP BY recetas.id_receta, recetas.nombre ORDER BY Producto');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_col10($total, $receta){
		$result= $this->db->query('SELECT insumos.nombre, (insumos_por_receta.cantidad * '.$total.') as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo where insumos_por_receta.id_receta = '.$receta.'');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_col20($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));
    	$result= $this->db->query('SELECT recetas.id_receta, recetas.nombre AS Producto, COUNT(solicitud.id_solicitud) AS total FROM solicitud INNER JOIN recetas ON solicitud.id_col20 = recetas.id_receta WHERE (recetas.id_receta > 0) AND solicitud.id_unidad = '.$unidad.' AND ( solicitud.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") GROUP BY recetas.id_receta, recetas.nombre ORDER BY Producto');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_col20($total, $receta){
		$result= $this->db->query('SELECT insumos.nombre, (insumos_por_receta.cantidad * '.$total.') as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo where insumos_por_receta.id_receta = '.$receta.'');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_lacteas($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));
    	$result= $this->db->query('SELECT SUM( solicitud.volumen * solicitud.frecuencia ) AS Total, COUNT(`id_solicitud`) AS total, `id_formula`, `id_complemento1`, `id_complemento2`, `id_complemento3` FROM `solicitud` INNER JOIN recetas ON solicitud.id_formula = recetas.id_receta LEFT JOIN regimenes ON recetas.id_regimen = regimenes.id_regimen WHERE solicitud.id_formula > 0 AND regimenes.producto = 10 AND ( solicitud.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") AND solicitud.id_unidad = '.$unidad.' GROUP BY `id_formula`, `id_complemento1`,`id_complemento2`, `id_complemento3`');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_formula_lactea($total, $formula, $comp1, $comp2, $comp3){
		$result= $this->db->query('SELECT insumos.nombre, (insumos_por_receta.cantidad * '.$total.') as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo where insumos_por_receta.id_receta IN ('.$formula.','.$comp1.','.$comp2.','.$comp3.')');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function consulta_solicitudes_enterales($unidad, $fecha){
		$fecha_inicio = date("Y-m-d 00:00:00", strtotime($fecha));
		$fecha_fin = date("Y-m-d 23:59:59", strtotime($fecha));	
    	$result= $this->db->query('SELECT SUM( solicitud.volumen * solicitud.frecuencia ) AS Total, COUNT(`id_solicitud`) AS total, `id_formula`, `id_complemento1`, `id_complemento2`, `id_complemento3` FROM `solicitud` INNER JOIN recetas ON solicitud.id_formula = recetas.id_receta LEFT JOIN regimenes ON recetas.id_regimen = regimenes.id_regimen WHERE solicitud.id_formula > 0 AND regimenes.producto = 9 AND ( solicitud.fecha_registro BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_fin.'") AND solicitud.id_unidad = '.$unidad.' GROUP BY `id_formula`, `id_complemento1`,`id_complemento2`, `id_complemento3`');
    	//die($this->db->last_query());
    	return $result->result();
	}

	public function obtener_insumos_formula_enteral($total, $formula, $comp1, $comp2, $comp3){
		$result= $this->db->query('SELECT insumos.nombre, (insumos_por_receta.cantidad * '.$total.') as Total, insumos.id_unidad_medida, insumos.unidad_compra AS unidad_compra FROM insumos_por_receta INNER JOIN insumos ON insumos_por_receta.id_insumo = insumos.id_insumo where insumos_por_receta.id_receta IN ('.$formula.','.$comp1.','.$comp2.','.$comp3.')');
    	//die($this->db->last_query());
    	return $result->result();
	}
}