<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movimiento_model extends General_model {

	public $cantidad =  null;
	public $peso = null;
	public $lote = null;
	public $fechaVence = null;
	public $horaInicio = null;
	public $horaFinal = null;
	public $cantHist = null;
	public $pesoHist = null;
	public $fechaOperacion = null;
	public $usuario_agr = null;
	public $tipo_transaccion_id = null;
	public $producto_bodega_id = null;
	public $empresa_id;
	public $presentacion_producto_id = null;
	public $bodega_ubicacion_id_origen = null;
	public $bodega_ubicacion_id_destino = null;
	public $bodega_id_origen  = null;
	public $bodega_id_destino = null;
	public $estado_producto_id_origen = null;
	public $estado_producto_id_destino = null;
	public $unidad_medida_id = null;
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
}

/* End of file Movimiento_model.php */
/* Location: ./application/models/Movimiento_model.php */