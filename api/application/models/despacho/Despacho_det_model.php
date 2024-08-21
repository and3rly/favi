<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despacho_det_model extends General_model {

	public $despacho_enc_id;
	public $no_linea;
	public $codigo_producto = null;
	public $nombre_producto = null;
	public $nombre_estado_producto = null;
	public $cantidad_despachada = null;
	public $peso_despachado = null;
	public $usuario_agr;
	public $usuario_mod = null;
	public $fecha_mod = null;
	public $activo = 1;
	public $pedido_enc_id;
	public $pedido_det_id;
	public $producto_bodega_id;
	public $presentacion_producto_id;
	public $unidad_medida_id;
	public $estado_producto_id;

	public function __construct($id="")
	{
		parent::__construct();
		
		if (!empty($id)) {
			$this->cargar($id);
		}
	}

}

/* End of file Despacho_det_model.php */
/* Location: ./application/models/Despacho_det_model.php */