<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_model extends General_model {

	public $nombre;
	public $razon_social = null;
	public $representante;
	public $nit;
	public $direccion = null;
	public $telefono = null;
	public $correo = null;
	public $logo = null;
	public $logo_enlace = null;
	public $eslogan = null;
	public $moneda_id;
	public $pais_id;
	public $pais_departamento_id;
	public $pais_municipio_id;
	public $activo = 1;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {				
			$this->cargar($id);
		}		
	}

	public function buscar($args=[])
	{
		if (elemento($args,'id')) { 
			$this->db->where('e.id',$args['id']);
		}

		$tmp = $this->db
					->select("e.*,d.nombre as departamento,m.nombre as municipio")
					->join("pais p","p.id = e.pais_id")
					->join("pais_departamento d", "d.id = e.pais_departamento_id")
					->join("pais_municipio m", "m.id = e.pais_municipio_id")
					->get('empresa e');	

		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("nit", $args->nit)
					->where("nombre", $args->nombre)
					->where("razon_social", $args->razon_social)
					->where("representante", $args->nit)
					->get("$this->_tabla");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}	

}

/* End of file Empresa_model.php */
/* Location: ./application/models/Empresa_model.php */