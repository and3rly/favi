<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recepcion_model extends General_model {

	public $fecha_recepcion;
	public $hora_inicio;
	public $hora_fin;
	public $observacion;
	public $no_guia;
	public $anulada = 0;
	public $ingresa_stock = 0;
	public $no_marchamo;
	public $usuario_agr;
	public $fecha_agr;
	public $usuario_mod;
	public $fecha_mod;
	public $activo = 1;
	public $vehiculos_id;
	public $bodega_id;
	public $pilotos_id;
	public $tipo_transaccion_id;
	public $estado_recepcion_id;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("recepcion_enc");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}	
	}

	public function _buscar($args=[])
	{
		// code...
	}
}

/* End of file Recepcion_model.php */
/* Location: ./application/models/Recepcion_model.php */