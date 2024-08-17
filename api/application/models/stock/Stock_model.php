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

	public function _buscar($args='')
	{	
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		} else {
			if (elemento($args, 'recepcion_enc_id')) {
				$this->db->where("a.recepcion_enc_id", $args['recepcion_enc_id']);
			}
		}

		$tmp = $this->db
		->select("a.*, c.id as id_producto, c.control_vence")
		->join("producto_bodega b","b.id = a.producto_bodega_id")
		->join("producto c","c.id = b.producto_id")
		->where("a.activo", 1)
		->order_by("a.no_linea")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

	public function ObtenerStock($args='')
	{
		$sql = "SELECT 
		        stock.*, 
		        /*CASE 
		            WHEN stock.factor = 0 
		            THEN FLOOR(stock.cantidad_stock - IFNULL(reserva.cantidad_reserva, 0))
		            ELSE FLOOR((stock.cantidad_stock - IFNULL(reserva.cantidad_reserva, 0)) - (FLOOR((stock.cantidad_stock - IFNULL(reserva.cantidad_reserva, 0)) / stock.factor) * stock.factor))
		        END AS cantidad_stock,*/
		        FLOOR(stock.cantidad_stock - IFNULL(reserva.cantidad_reserva, 0)) as cantidad_stock,
		        FLOOR((stock.cantidad_stock - IFNULL(reserva.cantidad_reserva, 0)) / stock.factor) as cantidad_presentacion
		    FROM (
		        SELECT 
		            SUM(sb.cantidad) AS cantidad_stock, 
		            IFNULL(pp.factor, 0) AS factor, 
		            sb.lote, 
		            sb.fecha_vence, 
		            sb.producto_bodega_id, 
		            sb.estado_producto_id, 
		            b.id AS bodega_id, 
		            b.codigo AS codigo_bodega, 
		            b.nombre AS nombre_bodega, 
		            p.id AS producto_id, 
		            p.codigo AS codigo_producto, 
		            p.nombre AS nombre_producto, 
		            p.descripcion AS descripcion_producto, 
		            p.peso, 
		            p.precio, 
		            pp.id AS presentacion_producto_id, 
		            pp.nombre AS nombre_presentacion, 
		            um.id AS unidad_medida_id, 
		            um.nombre AS nombre_unidad_medida, 
		            bu.id AS bodega_ubicacion_id, 
		            bu.codigo AS codigo_bodega_ubicacion, 
		            bu.descripcion AS descripcion_bodega_ubicacion, 
		            ep.nombre AS nombre_estado_producto 
		        FROM stock_bodega sb 
		        JOIN producto_bodega pb ON sb.producto_bodega_id = pb.id 
		        JOIN producto p ON pb.producto_id = p.id 
		        LEFT JOIN presentacion_producto pp ON sb.presentacion_producto_id = pp.id 
		        JOIN unidad_medida um ON sb.unidad_medida_id = um.id 
		        JOIN bodega_ubicacion bu ON sb.bodega_ubicacion_id = bu.id 
		        JOIN bodega b ON pb.bodega_id = b.id 
		        JOIN estado_producto ep ON sb.estado_producto_id = ep.id 
		        GROUP BY 
		            sb.lote, 
		            sb.fecha_vence, 
		            sb.producto_bodega_id, 
		            sb.estado_producto_id, 
		            b.id, 
		            b.codigo, 
		            b.nombre, 
		            p.id, 
		            p.codigo, 
		            p.nombre, 
		            p.descripcion, 
		            p.peso, 
		            p.precio, 
		            pp.id, 
		            pp.nombre, 
		            um.id, 
		            um.nombre, 
		            bu.id, 
		            bu.codigo, 
		            bu.descripcion, 
		            ep.nombre
		    ) AS stock
		    LEFT JOIN (
		        SELECT 
		            SUM(sbr.cantidad) AS cantidad_reserva, 
		            sbr.bodega_id, 
		            sbr.producto_bodega_id, 
		            sbr.estado_producto_id, 
		            sbr.presentacion_producto_id, 
		            sbr.unidad_medida_id, 
		            sbr.lote, 
		            sbr.fecha_vence 
		        FROM stock_bodega_res sbr 
		        WHERE sbr.tipo_transaccion_id = 2 
		        GROUP BY 
		            sbr.bodega_id, 
		            sbr.producto_bodega_id, 
		            sbr.estado_producto_id, 
		            sbr.presentacion_producto_id, 
		            sbr.unidad_medida_id, 
		            sbr.lote, 
		            sbr.fecha_vence
		    ) AS reserva 
		    ON 
		        stock.producto_bodega_id = reserva.producto_bodega_id 
		        AND stock.estado_producto_id = reserva.estado_producto_id 
		        AND (stock.presentacion_producto_id = reserva.presentacion_producto_id OR (stock.presentacion_producto_id IS NULL AND reserva.presentacion_producto_id IS NULL))
		        AND stock.unidad_medida_id = reserva.unidad_medida_id 
		        AND stock.bodega_id = reserva.bodega_id 
		        AND (stock.lote = reserva.lote OR (stock.lote IS NULL AND reserva.lote IS NULL)) 
		        AND (stock.fecha_vence = reserva.fecha_vence OR (stock.fecha_vence IS NULL AND reserva.fecha_vence IS NULL))";

		 $condiciones = [];

		if (elemento($args, 'bodega_id')) {
		    $condiciones[] = "stock.bodega_id = " . $this->db->escape($args['bodega_id']);
		}

		
		if (elemento($args, 'criterio')) {
		    $termino = trim($args['criterio']);

		    $campos = [
		        'stock.codigo_producto',
		        'stock.nombre_producto',
		        'stock.lote',
		    ];

		    $like_clauses = [];
		    foreach ($campos as $campo) {
		        $like_clauses[] = "$campo LIKE '%" . $this->db->escape_like_str($termino) . "%'";
		    }

		    $condiciones[] = '(' . implode(' OR ', $like_clauses) . ')';
		}

		if (!empty($condiciones)) {
		    $sql .= ' WHERE ' . implode(' AND ', $condiciones);
		}


		$sql .= ' ORDER BY stock.codigo_producto ASC';

		$query = $this->db->query($sql, array(2));

		return verConsulta($query, $args);
	}

}

/* End of file Stock_model.php */
/* Location: ./application/models/Stock_model.php */