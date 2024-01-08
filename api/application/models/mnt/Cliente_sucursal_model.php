<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_sucursal_model extends General_model {

	public $sucursal_id;
	public $cliente_id;
	public $activo = 1;


	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

