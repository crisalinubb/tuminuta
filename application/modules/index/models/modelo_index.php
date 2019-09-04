<?php
class Modelo_index extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	
	function Obtener_servicios(){
        $this->db->select('*');    
		$this->db->from('servicio_clinico');
		$query = $this->db->get();
		return $query;
    }

    function Obtener_salas($id_servicio){
        $this->db->select('*');    
		$this->db->from('salas');
		$this->db->where('CODSERV',$id_servicio);
		$query = $this->db->get();
		return $query;
    }

    function Obtener_camas($id_sala, $id_servicio){
        $this->db->select('*');    
		$this->db->from('camas');
		$this->db->where('codigo_sala',$id_sala);
        $this->db->where('codigo_servicio',$id_servicio);
		$query = $this->db->get();
        //die($this->db->last_query());
		return $query;
    }

    public function buscar_paciente_hospitalizado($id_cama){
    	$this->db->select('*');    
		$this->db->from('paciente_sistal');
		$this->db->where('codigo_cama',$id_cama);
		$this->db->where('estado',1);
		$query = $this->db->get();
		return $query->result();
    }

    public function agregar_alta($datos){
    	$this->db->insert('pacientes_egresados', $datos);
    }

    public function eliminar_paciente($codigo){
    	$this->db->where('id_paciente', $codigo);
		$this->db->delete('paciente_sistal');
    }

    public function eliminar_paciente_hospitalizado($codigo){
        $this->db->where('codigo_paciente', $codigo);
        $this->db->delete('paciente_sistal');
    }

    public function insertar_solicitud($datos){
    	$this->db->insert('solicitud', $datos);
    }

    public function join_insumo_receta($id_receta){
    	$result= $this->db->query("SELECT SUM(`aporte_insumo`.`cantidad`) AS cantidad_aporte, `id_aporte` FROM (`aporte_insumo`) INNER JOIN `insumos_por_receta` ON `insumos_por_receta`.`id_insumo` = `aporte_insumo`.`id_insumo` WHERE `id_receta` = $id_receta GROUP BY `id_aporte`");
    	//die($this->db->last_query());
    	return $result;
    }

    public function agregar_servicio_asociado($datos){
        $this->db->insert('servicios_asociados', $datos);
    }

    public function obtener_servicios_asociados($id_usuario){
        $this->db->select('*');    
        $this->db->from('servicios_asociados');
        $this->db->where('id_usuario',$id_usuario);
        $query = $this->db->get();
        return $query;
    }

    public function validar_servicios($id_usuario, $id_servicio){
        $this->db->select('*');    
        $this->db->from('servicios_asociados');
        $this->db->where('id_usuario',$id_usuario);
        $this->db->where('id_servicio',$id_servicio);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->num_rows();
    }

    public function desvincular_servicio_asociado($id_usuario, $id_servicio){
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('id_servicio', $id_servicio);
        $this->db->delete('servicios_asociados');
    }

    public function multiple_unidad($login){
        $this->db->select('*');    
        $this->db->from('usuario');
        $this->db->like('login',$login);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->num_rows();
    }

    public function unidades_usuario($login){
        $this->db->select('*');    
        $this->db->from('usuario');
        $this->db->like('login',$login);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query;
    }

    public function buscar_solicitud($id_paciente, $id_unidad){
    	$fecha_inicial = date("Y-m-d 00:00:00", strtotime("-1 day"));
    	$fecha_final = date("Y-m-d 23:59:59", strtotime("-1 day"));
    	$this->db->select('*');    
        $this->db->from('solicitud');
        $this->db->where('id_paciente',$id_paciente);
        $this->db->where('id_unidad',$id_unidad);
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->row();
    }

    public function editar_solicitud($datos, $id_solicitud){
        $this->db->where('id_solicitud', $id_solicitud);
        return $this->db->update('solicitud', $datos);
    }

    public function buscar_solicitud_dia_actual($id_paciente, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final = date("Y-m-d 23:59:59");
        $this->db->select('*');    
        $this->db->from('solicitud');
        $this->db->where('id_paciente',$id_paciente);
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('formula_extra', 0);
        $this->db->where('id_unidad',$id_unidad);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->row();
    }

    public function solicitud_desayunos($id_receta){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_desayuno`, recet.nombre, serv.nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_desayuno = recet.id_receta LEFT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio where sol.id_desayuno = '.$id_receta.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_servicioclinico`,`id_desayuno`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function solicitud_onces($id_receta){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_once`, recet.nombre, serv.nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_once = recet.id_receta LEFT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio where sol.id_once = '.$id_receta.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_servicioclinico`,`id_once`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function solicitud_col10($id_receta){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_col10`, recet.nombre, serv.nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col10 = recet.id_receta LEFT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio where sol.id_col10 = '.$id_receta.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_servicioclinico`,`id_col10`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function solicitud_col20($id_receta){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_col20`, recet.nombre, serv.nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col20 = recet.id_receta LEFT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio where sol.id_col20 = '.$id_receta.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_servicioclinico`,`id_col20`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function solicitud_almuerzo($id_regimen){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_almuerzo`, reg.nombre, serv.nombre_servicio FROM `solicitud` as sol INNER JOIN regimenes as reg ON sol.id_almuerzo = reg.id_regimen LEFT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio where sol.id_almuerzo = '.$id_regimen.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_servicioclinico`,`id_almuerzo`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function solicitud_cena($id_regimen){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_cena`, reg.nombre, serv.nombre_servicio FROM `solicitud` as sol INNER JOIN regimenes as reg ON sol.id_cena = reg.id_regimen LEFT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio where sol.id_cena = '.$id_regimen.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_servicioclinico`,`id_cena`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function multiple_unidad_usuario($login){
        $this->db->select('*');    
        $this->db->from('usuario');
        $this->db->like('login',$login);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function solicitud_formula_lactea($codigo_servicio){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $this->db->select('id_sala,id_cama,id_paciente,id_formula,id_complemento1,id_complemento2,id_complemento3,volumen,frecuencia, bajada, h9, h14, h18, h22');    
        $this->db->from('recetas');
        $this->db->join('solicitud', 'solicitud.id_formula = recetas.id_receta', 'inner');
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_tipo_receta', 9);
        $this->db->where('id_servicioclinico', $codigo_servicio);
        $this->db->where('id_formula !=', 0);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function solicitud_formula_enterales($codigo_servicio){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final= date("Y-m-d 23:59:59");
        $this->db->select('id_sala,id_cama,id_paciente,id_formula,id_complemento1,id_complemento2,id_complemento3,volumen,frecuencia, bajada, h9, h14, h18, h22');    
        $this->db->from('recetas');
        $this->db->join('solicitud', 'solicitud.id_formula = recetas.id_receta', 'inner');
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_tipo_receta', 10);
        $this->db->where('id_servicioclinico', $codigo_servicio);
        $this->db->where('id_formula !=', 0);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function Informacion_nutricional_por_receta($receta, $id_aporte){
        $result= $this->db->query('SELECT aportes_nutricionales.id_aporte_nutricional ,aportes_nutricionales.nombre, SUM((insumos_por_receta.cantidad * aporte_insumo.cantidad )/aporte_insumo.cantidadAporte) As Total, aportes_nutricionales.id_unidad_medida FROM insumos_por_receta RIGHT JOIN aporte_insumo ON insumos_por_receta.id_insumo = aporte_insumo.id_insumo LEFT JOIN aportes_nutricionales ON aporte_insumo.id_aporte = aportes_nutricionales.id_aporte_nutricional WHERE insumos_por_receta.id_receta IN ('.$receta.') and aportes_nutricionales.id_aporte_nutricional = '.$id_aporte.' GROUP BY nombre, aportes_nutricionales.id_unidad_medida ORDER BY `aportes_nutricionales`.`id_aporte_nutricional`');
        //die($this->db->last_query());
        return $result->result();
    }

    public function Informacion_nutricional_Total($desayuno, $once, $col10, $col20, $id_aporte){
        $result= $this->db->query('SELECT aportes_nutricionales.nombre, SUM((insumos_por_receta.cantidad * aporte_insumo.cantidad )/aporte_insumo.cantidadAporte) As Total, aportes_nutricionales.id_unidad_medida FROM insumos_por_receta RIGHT JOIN aporte_insumo ON insumos_por_receta.id_insumo = aporte_insumo.id_insumo LEFT JOIN aportes_nutricionales ON aporte_insumo.id_aporte = aportes_nutricionales.id_aporte_nutricional WHERE insumos_por_receta.id_receta IN ('.$desayuno.','.$once.','.$col10.','.$col20.' ) and aportes_nutricionales.id_aporte_nutricional IN ('.$id_aporte.') GROUP BY nombre, aportes_nutricionales.id_unidad_medida');
        //die($this->db->last_query());
        return $result->row();
    }

    public function Informacion_nutricional_Total_Formula($formula, $comp1, $comp2, $comp3, $id_aporte){
        $result= $this->db->query('SELECT aportes_nutricionales.nombre, SUM((insumos_por_receta.cantidad * aporte_insumo.cantidad )/aporte_insumo.cantidadAporte) As Total, aportes_nutricionales.id_unidad_medida FROM insumos_por_receta RIGHT JOIN aporte_insumo ON insumos_por_receta.id_insumo = aporte_insumo.id_insumo LEFT JOIN aportes_nutricionales ON aporte_insumo.id_aporte = aportes_nutricionales.id_aporte_nutricional WHERE insumos_por_receta.id_receta IN ('.$formula.','.$comp1.','.$comp2.','.$comp3.' ) and aportes_nutricionales.id_aporte_nutricional IN ('.$id_aporte.') GROUP BY nombre, aportes_nutricionales.id_unidad_medida');
        //die($this->db->last_query());
        return $result->row();
    }

    public function Informacion_nutricional_Total_sum($desayuno, $once, $col10, $col20, $formula, $comp1, $comp2, $comp3, $id_aporte){
        $result= $this->db->query('SELECT aportes_nutricionales.nombre, SUM((insumos_por_receta.cantidad * aporte_insumo.cantidad )/aporte_insumo.cantidadAporte) As Total, aportes_nutricionales.id_unidad_medida FROM insumos_por_receta RIGHT JOIN aporte_insumo ON insumos_por_receta.id_insumo = aporte_insumo.id_insumo LEFT JOIN aportes_nutricionales ON aporte_insumo.id_aporte = aportes_nutricionales.id_aporte_nutricional WHERE insumos_por_receta.id_receta IN ('.$desayuno.','.$once.','.$col10.','.$col20.','.$formula.','.$comp1.','.$comp2.','.$comp3.' ) and aportes_nutricionales.id_aporte_nutricional IN ('.$id_aporte.') GROUP BY nombre, aportes_nutricionales.id_unidad_medida');
        //die($this->db->last_query());
        return $result->row();
    }

    public function buscar_listado_distribucion($id_servicio, $fecha){
        $fecha_inicial = date("Y-m-d 00:00:00",strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $result= $this->db->query('SELECT * FROM (`solicitud`) WHERE `id_servicioclinico` = '.$id_servicio.' AND `fecha_registro` BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND (`id_desayuno` != 0 OR `id_almuerzo` != 0 OR `id_once` != 0 OR `id_cena` != 0 OR `id_col10` != 0 OR `id_col20` != 0) ORDER BY `id_sala` asc');
        //die($this->db->last_query());
        return $result->result();
    }

    public function buscar_listado_distribucion_por_sala($id_servicio, $id_sala, $fecha){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $result= $this->db->query('SELECT * FROM (`solicitud`) WHERE `id_servicioclinico` = '.$id_servicio.' AND id_sala = '.$id_sala.' AND `fecha_registro` BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND (`id_desayuno` != 0 OR `id_almuerzo` != 0 OR `id_once` != 0 OR `id_cena` != 0 OR `id_col10` != 0 OR `id_col20` != 0) ORDER BY `id_sala` asc');
        //die($this->db->last_query());
        return $result->result();
    }

    public function solicitud_formula_enterales_por_sala($codigo_servicio, $id_sala, $fecha){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $this->db->select('id_sala,id_cama,id_paciente,id_formula,id_complemento1,id_complemento2,id_complemento3,volumen,frecuencia, bajada, h9, h14, h18, h22');    
        $this->db->from('recetas');
        $this->db->join('solicitud', 'solicitud.id_formula = recetas.id_receta', 'inner');
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_tipo_receta', 10);
        $this->db->where('id_servicioclinico', $codigo_servicio);
        $this->db->where('id_sala', $id_sala);
        $this->db->where('id_formula !=', 0);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function solicitud_formula_enterales_por_fecha($codigo_servicio, $fecha){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $this->db->select('id_sala,id_cama,id_paciente,id_formula,id_complemento1,id_complemento2,id_complemento3,volumen,frecuencia, bajada, h9, h14, h18, h22');    
        $this->db->from('recetas');
        $this->db->join('solicitud', 'solicitud.id_formula = recetas.id_receta', 'inner');
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_tipo_receta', 10);
        $this->db->where('id_servicioclinico', $codigo_servicio);
        $this->db->where('id_formula !=', 0);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }


    public function solicitud_formula_lactea_por_sala($codigo_servicio, $id_sala, $fecha){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $this->db->select('id_sala,id_cama,id_paciente,id_formula,id_complemento1,id_complemento2,id_complemento3,volumen,frecuencia, bajada, h9, h14, h18, h22');    
        $this->db->from('recetas');
        $this->db->join('solicitud', 'solicitud.id_formula = recetas.id_receta', 'inner');
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_tipo_receta', 9);
        $this->db->where('id_servicioclinico', $codigo_servicio);
        $this->db->where('id_sala', $id_sala);
        $this->db->where('id_formula !=', 0);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function solicitud_formula_lactea_por_fecha($codigo_servicio,$fecha){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $this->db->select('id_sala,id_cama,id_paciente,id_formula,id_complemento1,id_complemento2,id_complemento3,volumen,frecuencia, bajada, h9, h14, h18, h22');    
        $this->db->from('recetas');
        $this->db->join('solicitud', 'solicitud.id_formula = recetas.id_receta', 'inner');
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_tipo_receta', 9);
        $this->db->where('id_servicioclinico', $codigo_servicio);
        $this->db->where('id_formula !=', 0);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function buscar_solicitud_por_id($id_solicitud){
        $this->db->select('*');    
        $this->db->from('solicitud');
        $this->db->where('id_solicitud',$id_solicitud);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->row();
    }

    public function editar_solicitud_por_listado($id_solicitud, $desayuno, $almuerzo, $once, $cena, $col10, $col20, $id_usuario){
        $fecha_edicion = date("Y-m-d H:i:s");
        $this->db->set('id_desayuno', $desayuno);
        $this->db->set('id_almuerzo',$almuerzo);
        $this->db->set('id_once',$once);
        $this->db->set('id_cena',$cena);
        $this->db->set('id_col10',$col10);
        $this->db->set('id_col20',$col20);
        $this->db->set('id_usuario',$id_usuario);
        $this->db->set('fecha_registro',$fecha_edicion);
        $this->db->where('id_solicitud', $id_solicitud);
        $this->db->update('solicitud'); 
    }

    public function eliminar_solicitud($id_solicitud){
        $this->db->where('id_solicitud', $id_solicitud);
        $this->db->delete('solicitud');
        //$this->db->truncate('tabpaso_trazabilidad');
    }

    public function obtenerPlanicacion($servicio_alim){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final = date("Y-m-d 23:59:59");
        $this->db->select('planificacion.id_receta, recetas.nombre as nombre_receta,planificacion.id_regimen, regimenes.nombre as nombre_regimen');    
        $this->db->from('planificacion');
        $this->db->join('recetas', 'recetas.id_receta = planificacion.id_receta', 'inner');
        $this->db->join('regimenes', 'regimenes.id_regimen = recetas.id_regimen', 'inner left');
        $this->db->where('fecha BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('id_servicio_alimentacion', $servicio_alim);
        $this->db->where('id_destino', 3);
        $this->db->order_by('id_regimen', 'asc');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function obtenerInsumos($id_receta){
        $this->db->select('insumos_por_receta.id_insumo, insumos.nombre as nombre_insumo');
        $this->db->from('insumos');
        $this->db->join('insumos_por_receta', 'insumos_por_receta.id_insumo = insumos.id_insumo', 'inner');
        $this->db->where('insumos_por_receta.id_receta', $id_receta);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function Obtener_bases(){
        $result= $this->db->query('SELECT DISTINCT`base` FROM regimenes ORDER BY `regimenes`.`base` ASC');
        //die($this->db->last_query());
        return $result->result();
    }    

    public function informe_almuerzo($fecha, $base, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_almuerzo`, reg.nombre FROM `solicitud` as sol INNER JOIN regimenes as reg ON sol.id_almuerzo = reg.id_regimen where reg.base = '.$base.' and sol.id_unidad = '.$id_unidad.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_almuerzo`');
        //die($this->db->last_query());
        return $result->result();
    }  

    public function informe_cena($fecha, $base, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime($fecha));
        $fecha_final = date("Y-m-d 23:59:59", strtotime($fecha));
        $result= $this->db->query('SELECT COUNT(1) as Total, `id_cena`, reg.nombre FROM `solicitud` as sol INNER JOIN regimenes as reg ON sol.id_cena = reg.id_regimen where reg.base = '.$base.' and sol.id_unidad = '.$id_unidad.' and sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" GROUP BY `id_cena`');
        //die($this->db->last_query());
        return $result->result();
    }   

    public function agregar_ingesta_real($codigo_solicitud, $porcentaje){
        $this->db->set('porcentaje_ingesta',$porcentaje);
        $this->db->where('id_solicitud', $codigo_solicitud);
        $this->db->update('solicitud'); 
    } 

    public function buscar_egresos($id_paciente, $id_unidad){
        $this->db->select('*');
        $this->db->from('pacientes_egresados');
        $this->db->where('codigo_paciente', $id_paciente);
        $this->db->where('egresado_unidad', $id_unidad);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result();
    }

    public function consulta_solicitud_dia_actual($id_paciente, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00");
        $fecha_final = date("Y-m-d 23:59:59");
        $this->db->select('*');    
        $this->db->from('solicitud');
        $this->db->where('id_paciente',$id_paciente);
        $this->db->where('fecha_registro BETWEEN "'. $fecha_inicial. '" and "'. $fecha_final.'"');
        $this->db->where('formula_extra', 0);
        $this->db->where('id_unidad',$id_unidad);
        $this->db->where('porcentaje_ingesta !=', 'NULL');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->row();
    }

    public function liberar_clinica($id_unidad){
        $this->db->where('id_unidad', $id_unidad);
        $this->db->delete('paciente_sistal');
    }

    public function desmarcar_estado_indicepaciente($id_paciente){
        $this->db->set('estado', 1);
        $this->db->where('id_paciente', $id_paciente);
        $this->db->update('paciente_general'); 
    }

    public function resumen_solicitudes($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_desayuno = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto) 

UNION ALL (SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_once = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)

UNION ALL (SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col10 = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)

UNION ALL (SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col20 = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)

UNION ALL (SELECT (sol.volumen*sol.frecuencia) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_formula = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_formula AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)

UNION ALL
(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN regimenes as reg ON reg.id_regimen = sol.id_cena RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)

UNION ALL (SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN regimenes as reg ON reg.id_regimen = sol.id_almuerzo RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)
');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_desayuno($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_desayuno = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_almuerzo($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN regimenes as reg ON reg.id_regimen = sol.id_almuerzo RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_once($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_once = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_cena($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN regimenes as reg ON reg.id_regimen = sol.id_cena RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_col10($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col10 = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_col20($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT COUNT(1) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col20 = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_solicitudes_formulas($id_producto, $id_servicio,$fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT (sol.volumen*sol.frecuencia) as Total, reg.nombre, prod.nombre_producto as nombre_producto, serv.nombre_servicio as nombre_servicio FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_formula = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" AND prod.id_producto = '.$id_producto.' AND serv.id_servicio = '.$id_servicio.' AND sol.id_formula AND sol.id_unidad = '.$id_unidad.' GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_desayunos($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_desayuno = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_almuerzos($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN regimenes as reg ON reg.id_regimen = sol.id_almuerzo RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_onces($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_once = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto  where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_cenas($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN regimenes as reg ON reg.id_regimen = sol.id_cena RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_col10($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col10 = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_col20($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_col20 = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function productos_formula($fecha_desde, $fecha_hasta, $id_unidad){
        $fecha_inicial = date("Y-m-d 00:00:00", strtotime(str_replace("/", "-", $fecha_desde)));
        $fecha_final = date("Y-m-d 23:59:59", strtotime(str_replace("/", "-", $fecha_hasta)));

        $result= $this->db->query('(SELECT DISTINCT prod.id_producto as id_producto, prod.nombre_producto as nombre_producto FROM `solicitud` as sol INNER JOIN recetas as recet ON sol.id_formula = recet.id_receta LEFT JOIN regimenes as reg ON recet.id_regimen = reg.id_regimen RIGHT JOIN servicio_clinico as serv ON sol.id_servicioclinico = serv.id_servicio LEFT JOIN producto as prod ON reg.producto = prod.id_producto where sol.id_unidad = '.$id_unidad.' AND sol.fecha_registro BETWEEN "'.$fecha_inicial.'" and "'.$fecha_final.'" and prod.id_producto GROUP BY serv.id_servicio, prod.id_producto)');
        //die($this->db->last_query());
        return $result->result();
    }

    public function inf_nutri($id_receta, $id_aporte){
        $result= $this->db->query('SELECT aportes_nutricionales.nombre, SUM((insumos_por_receta.cantidad * aporte_insumo.cantidad )/aporte_insumo.cantidadAporte) As Total, aportes_nutricionales.id_unidad_medida FROM insumos_por_receta RIGHT JOIN aporte_insumo ON insumos_por_receta.id_insumo = aporte_insumo.id_insumo LEFT JOIN aportes_nutricionales ON aporte_insumo.id_aporte = aportes_nutricionales.id_aporte_nutricional WHERE insumos_por_receta.id_receta IN ('.$id_receta.') and aportes_nutricionales.id_aporte_nutricional IN ('.$id_aporte.') GROUP BY nombre, aportes_nutricionales.id_unidad_medida');
        //die($this->db->last_query());
        return $result->row();
    }

}