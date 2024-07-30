<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_bodega_model extends General_model {

	public $producto_id;
	public $bodega_id;
	public $activo = 1;
    

	public function __construct($id='')
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}
