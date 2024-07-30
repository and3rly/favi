<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_usuario_model extends General_model {

	public $usuario_id;
	public $rol_id;
	public $activo = 1;

	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Rol_usuario_model.php */
/* Location: ./application/models/Rol_usuario_model.php */