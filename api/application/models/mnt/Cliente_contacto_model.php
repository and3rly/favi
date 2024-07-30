<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_contacto_model extends General_model {

	public $nombre;
	public $telefono;
	public $email;
	public $activo = 1;
	public $cliente_id;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("cliente_contacto");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function _buscar($args=[])
	{
		
		if (elemento($args, 'id')) {
			$this->db->where("id", $args['id']);
		}

		if (elemento($args, 'cliente_id')) {
			$this->db->where("cliente_id", $args['cliente_id']);
		}

		$tmp = $this->db->get("$this->_tabla");

		return verConsulta($tmp, $args);
	}
}
