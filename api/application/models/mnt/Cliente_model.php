<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends General_model{

public $codigo;
public $nombre_comercial;
public $telefono;
public $nit;
public $direccion;
public $email;
public $activo=1;
public $cliente_tipo_id;

public function __construct($id="")
{
parent::__construct();
if (!empty($id)) {				
$this->cargar($id);
}		
}

public function buscar($args=[])
{

	if (elemento($args, 'id')) {
		$this->db->where("a.id", $args['id']);
	}

	$tmp = $this->db
				->select("a.*,b.nombre tipos_clientes")
				->join("cliente_tipo b","a.cliente_tipo_id=b.id")
				->where("a.activo", 1)
				->get("cliente a");

	return verConsulta($tmp, $args);
}


public function existe($args=[]) {
	if ($this->getPK()) {
		$this->db->where("id <>", $this->getPK());
	}

	$tmp = $this->db
	->where("codigo", $args->codigo)			
	->where("nombre_comercial", $args->nombre_comercial)

				->get("$this->_tabla");

	if ($tmp->num_rows() > 0) {
		return true;
	}

	return false;
}	



}

