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
public function buscar($args=[]){
if (elemento($args,'id')) {
$this->db->where('a.id',$args['id']);
}

$tmp = $this->db->select("a.*,
	b.nombre as tipos_clientes")
->join("cliente_tipo b","b.id= a.cliente_tipo_id")
->get("$this->_tabla a");
return verConsulta($tmp, $args);
}

public function existe($args=[]) {
if ($this->getPK()) {
$this->db->where("id <>", $this->getPK());
}

$tmp = $this->db
->where("nombre_comercial", $args->nombre)
->where("nit", $args->nit)
->where("email", $args->email)
->get("$this->_tabla");

if($tmp->num_rows()>0)
{

return true;
}

return false;
}

}

