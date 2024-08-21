<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despacho_enc_model extends General_model {

	public $bodega_id = null;
	public $vehiculos_id = null;
	public $pilotos_id = null;
	public $ruta_id = null;
	public $observacion = null;
	public $hora_inicio = null;
	public $hora_fin = null;
	public $marchamo = null;
	public $usuario_agr;
	public $fecha_agr;
	public $usuario_mod = null;
	public $activo = 1;
	public $tipo_transaccion_id = null;
	public $estado_despacho_id;


	public function __construct($id="")
	{
		parent::__construct();
		
		if (!empty($id)) {
			$this->cargar($id);		
		}	
	}

}

/* End of file Despacho_enc_model.php */
/* Location: ./application/models/Despacho_enc_model.php */