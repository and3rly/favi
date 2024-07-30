<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_res_model extends General_model {

	public $tipo_transaccion_id = null;
	public $lote = null;
	public $fecha_vence = null;
	public $cantidad = null;
	public $peso = null;
	public $fecha_ingreso = null;
	public $producto_bodega_id;
	public $bodega_id;
	public $estado_producto_id;
	public $presentacion_producto_id = null;
	public $unidad_medida_id;
	public $bodega_ubicacion_id;
	public $bodega_ubicacion_id_anterior;
	public $recepcion_enc_id = null;
	//public $recepcion_det_id = null;
	public $pedido_enc_id = null;
	public $pedido_det_id = null;
	public $despacho_enc_id = null;
	public $stock_bodega_id = null;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("stock_bodega_res");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function ObtenerReservaExistente($args=[])
	{	

		$tmp = $this->db
		->select("a.id")
		->where("a.pedido_enc_id", $args['datos']->pedido_enc_id)
		->where("a.pedido_det_id", $args['datos']->pedido_det_id)
		->get("$this->_tabla a")
		->row();

		return $tmp->id ?? null;
	}

	public function EliminarReserva($id)
	{
		$this->db->delete("$this->_tabla", array('pedido_det_id' => $id));

		if ($this->db->affected_rows() > 0) { 
			return true;
		} else {
			$this->setMensaje("No elimino la reserva, por favor intente nuevamente.");
			return false;
		}
	}

}

/* End of file Stock_model.php */
/* Location: ./application/models/Stock_model.php */