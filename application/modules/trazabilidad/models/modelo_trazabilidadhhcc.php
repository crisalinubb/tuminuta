<?php
class Modelo_trazabilidadhhcc extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	
	function insertTrazabilidadhhcc($data2)
    {
        $this->db->insert('trazabilidad_hhcc', $data2);
    }
}