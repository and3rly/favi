<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_model extends General_model {

	public $lote = null;
	public $fecha_vence = null;
	public $cantidad = null;
	public $peso = null;
	public $fecha_ingreso = null;
	public $activo = 1;
	public $producto_bodega_id;
	public $bodega_id;
	public $estado_producto_id;
	public $presentacion_producto_id = null;
	public $unidad_medida_id;
	public $bodega_ubicacion_id;
	public $bodega_ubicacion_id_anterior;
	public $recepcion_enc_id = null;
	public $recepcion_det_id = null;
	public $pedido_enc_id = null;
	public $pedido_det_id = null;
	public $despacho_enc_id = null;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("stock_bodega");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Stock_model.php */
/* Location: ./application/models/Stock_model.php */