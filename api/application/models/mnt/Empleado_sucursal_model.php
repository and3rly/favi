<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleado_sucursal_model extends General_model {

	public $sucursal_id;
	public $empleado_id;
	public $activo = 1;


	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

