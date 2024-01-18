<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_model extends General_model{

	public $tipo;
	public $placa;
	public $marca;
	public $modelo;
	public $peso;
    public $volumen;
    public $alto;
    public $largo;
    public $ancho;
    public $placa_comercial;
    public $es_contenedor;
    public $usuario_agr;
    public $fecha_agr;
    public $usuario_mod;
    public $fecha_mod;
    public $activo;


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
		$this->db->where('id',$args['id']);
	}
	$tmp = $this->db->get("$this->_tabla");

	return verConsulta($tmp, $args);
}







public function existe($args=[]) {
	if ($this->getPK()) {
		$this->db->where("id <>", $this->getPK());
	}

	$tmp = $this->db
				->where("placa", $args->placa)
				->where("activo",1)
				->get("$this->_tabla");


	if ($tmp->num_rows() > 0) {
		return true;
	}

	return false;
}	

}

