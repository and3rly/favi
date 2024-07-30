<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_Pilotos_model extends General_model {

	public $vehiculos_id;
	public $pilotos_id;
	public $activo = 1;


	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

