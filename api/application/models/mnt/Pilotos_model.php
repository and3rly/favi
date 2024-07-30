<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pilotos_model extends General_model{

	public $nombres;
	public $apellidos;
	public $telefono;
	public $email;
	public $no_licencia;
    public $no_dpi;
    public $fecha_expira_licencia;
    public $direccion;
    public $foto;
    public $fecha_nacimiento;
    public $tipo_licencia;
    public $activo;


public function __construct($id="")
{
parent::__construct();
if (!empty($id)) {				
$this->cargar($id);
}		
}





public function buscar($args=[]){
	if (elemento($args,'id')) {
	$this->db->where('a.id',$args['id']);
	}

	$tmp = $this->db->select("a.*")
	->where("a.activo",1)
	->get("$this->_tabla a");
	return verConsulta($tmp, $args);
	}




public function existe($args=[]) {
	if ($this->getPK()) {
		$this->db->where("id <>", $this->getPK());
	}

	$tmp = $this->db
				->where("no_licencia", $args->no_licencia)
                ->where("no_dpi", $args->no_dpi)
				->where("activo",1)
				->get("$this->_tabla");


	if ($tmp->num_rows() > 0) {
		return true;
	}

	return false;
}	

}

