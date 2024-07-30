<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompraDetalle_model extends General_model {

	public $orden_compra_enc_id;
	public $no_linea;
	public $codigo_producto;
	public $nombre_producto;
	public $nombre_presentacion;
	public $nombre_unidad_medida;
	public $cantidad;
	public $cantidad_recibida;
	public $costo;
	public $total_linea;
	public $peso;
	public $peso_recibido;
	public $activo;
	public $producto_bodega_id;
	public $presentacion_producto_id;
	public $unidad_medida_id;
	public $motivo_devolucion_id;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("orden_compra_det");
		$this->setLlave("id");
		if (!empty($id)) {
			$this->cargar($id);
		}
		
	}

	public function buscar($args=[])
	{
		
		if (elemento($args, 'id')) {
			$this->db->where('ocd.id', $args['id']);
		}
		
		if (elemento($args, 'orden_compra_enc_id')) {
			$this->db->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
		}
		
		if (elemento($args, 'no_linea')) {
			$this->db->where('ocd.no_linea >', $args['no_linea']);
		}

		$tmp = $this->db
					->select('ocd.id, ocd.orden_compra_enc_id, ocd.no_linea, ocd.codigo_producto, ocd.nombre_producto, IFNULL(ocd.nombre_presentacion, "Sin Presentacion") as nombre_presentacion, IFNULL(ocd.nombre_unidad_medida, "Sin Unidad de Medida") as nombre_unidad_medida, ocd.cantidad, ocd.cantidad_recibida, ocd.costo, ocd.total_linea, ocd.peso, ocd.peso_recibido, ocd.activo, ocd.producto_bodega_id, ocd.presentacion_producto_id, ocd.unidad_medida_id, IFNULL(ocd.motivo_devolucion_id, "Sin Motivo Devolucion") as motivo_devolucion_id, p.id AS id_producto_j, p.codigo AS codigo_producto_j, p.nombre AS nombre_producto_j, IFNULL(pp.codigo, "Sin Presentacion") AS codigo_presentacion_j, IFNULL(pp.nombre, "Sin Presentacion") AS nombre_presentacion_j, IFNULL(um.nombre, "Sin Unidad de Medida") AS nombre_unidad_medida_j, IFNULL(md.nombre, "Sin Motivo Devolucion") AS nombre_motivo_dev')
					->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
					->join('producto p', 'p.id = pb.producto_id')
					->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id ', 'left')
					->join('unidad_medida um', 'um.id = ocd.unidad_medida_id', 'left')
					->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id', 'left')
					->where('ocd.activo', 1)
					->get('orden_compra_det ocd');

		return verConsulta($tmp, $args);
	}

	public function getLast($args=[])
	{
		
		if (elemento($args, 'orden_compra_enc_id')) {
			$this->db->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
		}
		
		if (elemento($args, 'no_linea')) {
			$this->db->where('ocd.no_linea >', $args['no_linea']);
		}

		$tmp = $this->db
					->select('ocd.id, ocd.orden_compra_enc_id, ocd.no_linea, ocd.codigo_producto, ocd.nombre_producto, IFNULL(ocd.nombre_presentacion, "Sin Presentacion") as nombre_presentacion, IFNULL(ocd.nombre_unidad_medida, "Sin Unidad de Medida") as nombre_unidad_medida, ocd.cantidad, ocd.cantidad_recibida, ocd.costo, ocd.total_linea, ocd.peso, ocd.peso_recibido, ocd.activo, ocd.producto_bodega_id, ocd.presentacion_producto_id, ocd.unidad_medida_id, IFNULL(ocd.motivo_devolucion_id, "Sin Motivo Devolucion") as motivo_devolucion_id, p.id AS id_producto_j, p.codigo AS codigo_producto_j, p.nombre AS nombre_producto_j, IFNULL(pp.codigo, "Sin Presentacion") AS codigo_presentacion_j, IFNULL(pp.nombre, "Sin Presentacion") AS nombre_presentacion_j, IFNULL(um.nombre, "Sin Unidad de Medida") AS nombre_unidad_medida_j, IFNULL(md.nombre, "Sin Motivo Devolucion") AS nombre_motivo_dev')
					->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
					->join('producto p', 'p.id = pb.producto_id')
					->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id ', 'left')
					->join('unidad_medida um', 'um.id = ocd.unidad_medida_id', 'left')
					->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id', 'left')
					->where('ocd.activo', 1)
					->order_by('1', 'desc')
					->limit(1)
					->get('orden_compra_det ocd');

		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("no_linea", $args->no_linea)
                    ->where("orden_compra_enc_id", $args->orden_compra_enc_id)
                    ->where("activo", 1)
					->get("orden_compra_det ocd");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}

}

/* End of file OrdenCompraDetalle_model.php */
/* Location: ./application/models/orden/detalle/OrdenCompraDetalle_model.php */