<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogo_model extends General_model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_usuario_sucursal($args=[])
	{
		$tmp = $this->db
		->where('usuario_id', $args['usuario_id'])
		->where('activo', 1)
		->get('usuario_sucursal');

		return verConsulta($tmp, $args);
	}

}

/* End of file Catalogo_model.php */
/* Location: ./application/models/Catalogo_model.php */