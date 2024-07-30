<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedor_bodega_model extends General_model {

	public $proveedor_id;
	public $bodega_id;
	public $usuario_agr;
    public $fecha_agr;
	public $activo = 1;
    

	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}
