<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movimientos_model extends General_model {

	public $id;
	public $lote = null;
	public $fechaVence = null;
	public $cantidad = null;
	public $cantidad_presentacion = null;
	public $cantHist = null;
	public $peso = null;
	public $pesoHist = null;
	public $fechaOperacion = null;
	public $producto_bodega_id;
	public $bodega_id;
	public $estado_producto_id_origen;
	public $nombre_estado_origen;
	public $estado_producto_id_destino;
	public $nombre_estado_destino;
	public $presentacion_producto_id = null;
	public $nombre_presentacion = null;
	public $unidad_medida_id;
	public $nombre_um;
	public $ubic_destino;
	public $ubic_origen;
	public $recepcion_enc_id = null;
	public $despacho_enc_id = null;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("movimientos_bodega");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function ObtenerMovimientos($args='')
	{
		$sql = "SELECT mov.id,mov.cantidad,mov.peso,mov.lote,mov.fechaVence,mov.cantHist,mov.pesoHist,mov.fechaOperacion,
				mov.tipo_transaccion_id,tp.nombre as nombre_transacion_tipo,mov.producto_bodega_id,pd.id as id_producto,
				pd.codigo as codigo_producto,pd.nombre as nombre_producto,
				um.nombre as nombre_um,
				mov.presentacion_producto_id,mov.unidad_medida_id,
				CASE 
				WHEN mov.presentacion_producto_id is not null and mov.presentacion_producto_id > 0 
				THEN psp.nombre 
				ELSE ''
				END AS nombre_presentacion,
				CASE 
				WHEN mov.presentacion_producto_id is not null and mov.presentacion_producto_id > 0 
				THEN FLOOR(IFNULL(mov.cantidad, 0) / psp.factor) 
				ELSE 0
				END AS cantidad_presentacion,
				mov.estado_producto_id_origen,estorigen.nombre as nombre_estado_origen, mov.estado_producto_id_destino, estdestino.nombre as nombe_estado_destino,
				concat('B:',bodegadest.nombre,'- A:',areadest.descripcion,'-S:',sectordest.descripcion,'-T:',tramodest.descripcion,'-U:',ubicdest.descripcion) as ubic_destino,
				concat('B:',bodegaorigen.nombre,'-A:',areaorigen.descripcion,'-S:',sectororigen.descripcion,'-T:',tramoorigen.descripcion,'-U:',ubicorigen.descripcion) as ubic_origen,
				mov.recepcion_enc_id,mov.despacho_enc_id
				FROM movimientos_bodega mov
				INNER JOIN tipo_transaccion tp ON tp.id	= mov.tipo_transaccion_id
				INNER JOIN producto_bodega pb ON pb.id = mov.producto_bodega_id and pb.bodega_id = mov.bodega_id_destino
				inner join producto pd ON pd.id = pb.producto_id
				inner join unidad_medida um ON um.id = pd.unidad_medida_id
				left join presentacion_producto psp ON psp.producto_id = pd.id  and psp.id = mov.presentacion_producto_id
				INNER JOIN bodega_ubicacion ubicdest ON ubicdest.id	 = mov.bodega_ubicacion_id_destino
				INNER JOIN bodega_tramo tramodest ON tramodest.id = ubicdest.bodega_tramo_id
				INNER JOIN bodega_sector sectordest ON sectordest.id = tramodest.bodega_sector_id
				INNER JOIN bodega_area areadest ON areadest.id= sectordest.bodega_area_id
				INNER JOIN bodega bodegadest ON bodegadest.id = areadest.bodega_id and bodegadest.id = mov.bodega_id_destino
				INNER JOIN bodega_ubicacion ubicorigen ON ubicorigen.id = mov.bodega_ubicacion_id_origen
				INNER JOIN bodega_tramo tramoorigen ON tramoorigen.id = ubicorigen.bodega_tramo_id
				INNER JOIN bodega_sector sectororigen ON sectororigen.id = tramoorigen.bodega_sector_id
				INNER JOIN bodega_area areaorigen ON areaorigen.id= sectororigen.bodega_area_id
				INNER JOIN bodega bodegaorigen ON bodegaorigen.id = areaorigen.bodega_id and bodegaorigen.id = mov.bodega_id_origen
				INNER JOIN estado_producto estorigen ON estorigen.id = mov.estado_producto_id_origen
				INNER JOIN estado_producto estdestino ON estdestino.id = mov.estado_producto_id_destino";

		 $condiciones = [];

		if (elemento($args, 'bodega_id')) {
		    $condiciones[] = " mov.bodega_id_destino = " . $this->db->escape($args['bodega_id']);
		}

		
		if (elemento($args, 'criterio')) {
		    $termino = trim($args['criterio']);

		    $campos = [
		        'pd.codigo',
		        'pd.nombre',
		        'mov.lote',
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


		$sql .= ' ORDER BY mov.id DESC';

		$query = $this->db->query($sql, array(2));

		return verConsulta($query, $args);
	}

}

/* End of file Movimientos_model.php */
/* Location: ./application/models/Movimientos_model.php */