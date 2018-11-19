<?php
class Modelo_trazabilidad extends CI_Model {
	
	function __construct(){
		$this->tabla = "trazabilidad";
		$this->prefijo = "tr_";
		$this->load->model("medicos/modelo_medicos", "objMedico");
		parent::__construct();
	}
	
	function insertTrazabilidad($data)
    {
        return $this->db->insert('trazabilidad', $data);
   }

    public function getTrazabilidad()
		{
			$result= $this->db->get('trazabilidad');
			return $result->row();
	}

	public function jointablas(){
		$this->db->select('*');    
		$this->db->from('trazabilidad_hhcc');
		$this->db->join('paciente', 'paciente.pa_codigo = trazabilidad_hhcc.pa_codigo', 'inner');
		$this->db->join('trazabilidad', 'trazabilidad_hhcc.tr_codigo=trazabilidad.tr_codigo', 'inner');
		$query = $this->db->get();
		return $query;
	}

	
	public function jointablasHistorial($query){
		$this->db->select('*');    
		$this->db->from('trazabilidad_hhcc');
		$this->db->join('paciente', 'paciente.pa_codigo = trazabilidad_hhcc.pa_codigo', 'inner');
		$this->db->join('trazabilidad', 'trazabilidad_hhcc.tr_codigo=trazabilidad.tr_codigo', 'inner');
		$this->db->like('pa_hhcc', $query);
		$this->db->or_like('pa_rut', $query);
		$query = $this->db->get();
		return $query;
	}

	public function obtenerReciente($query){
		$this->db->select('*');    
		$this->db->from('trazabilidad_hhcc');
		$this->db->join('paciente', 'paciente.pa_codigo = trazabilidad_hhcc.pa_codigo', 'inner');
		$this->db->join('trazabilidad', 'trazabilidad_hhcc.tr_codigo=trazabilidad.tr_codigo', 'inner');
		$this->db->like('pa_hhcc', $query);
		$this->db->or_like('pa_rut', $query);
		$this->db->order_by("tr_fecha", "desc");
		$query = $this->db->get();
		return $query;
	}
	
	public function buscarnomina($query){
		$this->db->select('*');    
		$this->db->from('agenda');
		$this->db->join('nomina_agenda', 'nomina_agenda.ag_codigo = agenda.ag_codigo', 'inner');
		$this->db->join('paciente', 'agenda.pa_codigo=paciente.pa_codigo', 'inner');
		$this->db->where('no_codigo', $query);
		$query = $this->db->get();
		return $query;
	}

	public function jointablasconhhcc($query){
		$this->db->select('*');    
		$this->db->from('paciente');
		$this->db->like('pa_hhcc', $query);
		$query = $this->db->get();
		return $query;
	}

	public function buscarnom($query){
		$this->db->select('*');    
		$this->db->from('agenda');
		$this->db->join('nomina_agenda', 'nomina_agenda.ag_codigo = agenda.ag_codigo', 'inner');
		$this->db->join('paciente', 'agenda.pa_codigo=paciente.pa_codigo', 'inner');
		$this->db->where('no_codigo', $query);
		$query = $this->db->get();
		return $query;
	}

	public function agregartabpaso($tab){
		$this->db->insert('tabpaso_trazabilidad', $tab); 
	}

	public function gettabpaso(){
		$result = $this->db->get('tabpaso_trazabilidad');
		return $result;
	}

	public function borrartab(){
		$this->db->truncate('tabpaso_trazabilidad');
	}

	public function jointablasdespachar(){
		$this->db->select('*');    
		$this->db->from('trazabilidad_hhcc');
		$this->db->join('paciente', 'paciente.pa_codigo = trazabilidad_hhcc.pa_codigo', 'inner');
		$this->db->join('trazabilidad', 'trazabilidad_hhcc.tr_codigo=trazabilidad.tr_codigo', 'inner');
		$this->db->like('et_codigo', 2);
		$query = $this->db->get();
		return $query;
	}

	public function agregartabpasodes($des){
		$this->db->insert('tabpaso_trazabilidaddes', $des); 
	}

	public function gettabpasodes(){
		$this->db->select('*');    
		$this->db->from('tabpaso_trazabilidaddes');
		$this->db->order_by("des_nocodigo", "desc");
		$result = $this->db->get();
		return $result;
	}

	public function encontrardes($query){
    	$result= $this->db->query("SELECT * FROM tabpaso_trazabilidaddes WHERE des_hhcc = '" .$query."'");
    	if($result->num_rows()>0){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function borrartabpasodes(){
    	$this->db->truncate('tabpaso_trazabilidaddes');
    }

    public function jointablasencasillar(){
		$this->db->select('*');    
		$this->db->from('trazabilidad_hhcc');
		$this->db->join('paciente', 'paciente.pa_codigo = trazabilidad_hhcc.pa_codigo', 'inner');
		$this->db->join('trazabilidad', 'trazabilidad_hhcc.tr_codigo=trazabilidad.tr_codigo', 'inner');
		$this->db->where('et_codigo', 1);

		$query = $this->db->get();
		return $query;
	}

	public function gettabpasoen(){
		$result = $this->db->get('tabpaso_trazabilidaden');
		return $result;
	}

	public function agregartabpasoen($des){
		$this->db->insert('tabpaso_trazabilidaden', $des); 
	}

	public function encontraren($query){
    	$result= $this->db->query("SELECT * FROM tabpaso_trazabilidaden WHERE en_hhcc = '" .$query."'");
    	if($result->num_rows()>0){
    		return true;
    	}else{
    		return false;
    	}
    }

     public function borrartabpasoen(){
    	$this->db->truncate('tabpaso_trazabilidaden');
    }

    public function encontrardatosmedicos($query){
    	$this->db->select('*');    
		$this->db->from('agenda');
		$this->db->join('medico', 'medico.me_codigo = agenda.me_codigo', 'inner');
		$this->db->join('paciente', 'agenda.pa_codigo=paciente.pa_codigo', 'inner');
		$this->db->like('pa_hhcc', $query);
		$query = $this->db->get();
		return $query->row();
    }

    public function gettabpasocon(){
		$result = $this->db->get('tabpaso_trazabilidadcon');
		return $result;
	}

	public function agregartabpasocon($des){
		$this->db->insert('tabpaso_trazabilidadcon', $des); 
	}

	public function borrartabcon(){
    	$this->db->truncate('tabpaso_trazabilidadcon');
    }

    public function gettabpasonom(){
		$result = $this->db->get('tabpaso_trazabilidadnom');
		return $result;
	}

	public function agregartabpasonom($des){
		$this->db->insert('tabpaso_trazabilidadnom', $des); 
	}

	public function borrartabnom(){
    	$this->db->truncate('tabpaso_trazabilidadnom');
    }

    public function cambiapaciente($query){
    	$this->db->set('pa_traza', 0);
		$this->db->where('pa_codigo', $query);
		$this->db->update('paciente'); 
    }

    public function agregartabpasosinre($des){
		$this->db->insert('tabpaso_sinrecepcion', $des); 
	}

	public function gettabpasore(){
		$result = $this->db->get('tabpaso_sinrecepcion');
		return $result;
	}

	public function buscarnomdes($query){
		$this->db->select('*');    
		$this->db->from('agenda');
		$this->db->join('nomina_agenda', 'nomina_agenda.ag_codigo = agenda.ag_codigo', 'inner');
		$this->db->like('pa_codigo', $query);
		$query = $this->db->get();
		return $query->row();
	}

	public function cambiatabpasosinrecepcion($motivo,$query){
    	$this->db->set('id_motivo', $motivo);
		$this->db->where('re_hhcc', $query);
		$this->db->update('tabpaso_sinrecepcion'); 
    }

	 public function buscaridsinrecepcionar($query){
    	$result= $this->db->query("SELECT * FROM tabpaso_sinrecepcion WHERE id = '" .$query."'");
    	return $result->row();
    }

    public function anidarespecialidad($query){
    	$this->db->select('*');    
		$this->db->from('especialidad');
		$this->db->join('medico_especialidad', 'medico_especialidad.es_codigo = especialidad.es_codigo', 'inner');
		$this->db->like('me_codigo', $query);
		$query = $this->db->get();
		return $query->row();
    }

    public function comprobar($query){
    	$result= $this->db->query("SELECT * FROM tabpaso_trazabilidadnom WHERE nom_hhcc = '" .$query."'");
    	return $result->row();
    }

    public function setearpatraza($query){
    	$this->db->set('pa_traza', 1);
		$this->db->where('pa_hhcc', $query);
		$this->db->update('paciente'); 
    }

    public function buscaragcodigo($query){
    	$this->db->from('agenda');
		$this->db->join('nomina_agenda', 'nomina_agenda.ag_codigo = agenda.ag_codigo', 'inner');
		$this->db->join('paciente', 'agenda.pa_codigo=paciente.pa_codigo', 'inner');
		$this->db->where('no_codigo', $query);
		$query = $this->db->get();
		return $query->row();
    }

    public function buscarrepetidas($query){
    	$result= $this->db->query("SELECT * FROM tabpaso_trazabilidadcon WHERE con_hhcc = '" .$query."'");
    	if($result->num_rows()>0){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function buscarnommedico($query){
    	$this->db->select('*');    
		$this->db->from('medico');
		$this->db->where('me_codigo', $query);
		$query = $this->db->get();
		return $query->row();
    }
}