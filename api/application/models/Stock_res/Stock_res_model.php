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

	public function ObtenerStockSinReserva($args=[])
	{
		
		$this->db->select('*, (a.cantidad - (SELECT IFNULL(SUM(res.cantidad), 0) FROM stock_bodega_res res WHERE res.stock_bodega_id = a.id)) as CantidadStock');
						$this->db->from('stock_bodega a');
		$this->db->where('a.producto_bodega_id', $args['datos']->producto_bodega_id);
		$this->db->group_start();

		    	if (!isset($args['datos']->lote)) {
		    		$this->db->where('a.lote IS NULL');
		    	}else {
		    		$this->db->where('a.lote', $args['datos']->lote);
		    	}

		$this->db->group_end();
		$this->db->group_start();

				if (!isset($args['datos']->fecha_vence)) {
					$this->db->where('a.fecha_vence IS NULL');
				}else {
					$this->db->where('a.fecha_vence', $args['datos']->fecha_vence);
				}

		$this->db->group_end();
		$this->db->group_start();

				if (!isset($args['datos']->presentacion_producto_id)) {
					$this->db->where('a.presentacion_producto_id IS NULL');
				}else {
					$this->db->where('a.presentacion_producto_id', $args['datos']->presentacion_producto_id);
				}

		$this->db->group_end();
		$this->db->group_start();

				if (!isset($args['datos']->unidad_medida_id)) {
					$this->db->where('a.unidad_medida_id IS NULL');
				}else {
					$this->db->where('a.unidad_medida_id', $args['datos']->unidad_medida_id);
				}

		$this->db->group_end();

		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}

}

/* End of file Stock_model.php */
/* Location: ./application/models/Stock_model.php */