<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends General_model {

	public $codigo;
	public $nombre_comercial;
	public $telefono;
	public $nit;
	public $direccion;
	public $email ;
	public $activo = 1;
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
		->select("a.*,b.nombre ncliente,")
		->join("favi.cliente_tipo b", "a.cliente_tipo_id=b.id")
		->get('cliente a');

		return verConsulta($tmp, $args);
	}
}
