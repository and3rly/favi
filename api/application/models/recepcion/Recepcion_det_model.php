<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recepcion_det_model extends General_model {

	public $recepcion_enc_id;
	public $codigo_producto;
	public $no_linea;
	public $cantidad_recibida;
	public $nombre_producto;
	public $nombre_presentacion;
	public $nombre_unidad_medida;
	public $nombre_producto_estado;
	public $lote;
	public $fecha_vence;
	public $peso;
	public $peso_minimo;
	public $peso_maximo;
	public $observacion;
	public $costo;
	public $costo_oc;
	public $activo = 1;
	public $producto_bodega_id;
	public $presentacion_producto_id;
	public $unidad_medida_id;
	public $estado_producto_id;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("recepcion_det");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
		
	}

}

/* End of file Recepcion_det_model.php */
/* Location: ./application/models/Recepcion_det_model.php */