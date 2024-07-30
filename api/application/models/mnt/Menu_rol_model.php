<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_rol_model extends General_model {
    
	public $menu_modulo_id;
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

/* End of file Menu_rol_model.php */
/* Location: ./application/models/Menu_rol_model.php */