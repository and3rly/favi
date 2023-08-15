<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_sucursal_model extends General_model {

	public $activo = 1;
	public $producto_id;
	public $sucursal_id;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Producto_sucursal_model.php */
/* Location: ./application/models/Producto_sucursal_model.php */