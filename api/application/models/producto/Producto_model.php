<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_model extends General_model {

	public $codigo;
	public $barra;
	public $nombre;
	public $descripcion;
	public $imagen;
	public $img_enlace;
	public $costo;
	public $peso;
	public $largo;
	public $altura;
	public $anchura;
	public $control_vence = 0;
	public $existencia_maxima;
	public $existencia_minima;
	public $activo = 1;
	public $unidad_medida_id;
	public $marca_id;
	public $clasificacion_id;
	public $estado_id;
	public $tipo_producto_id;
	public $presentacion_id;
	public $familia_producto_id;
	public $usuario_agr;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {
			$this->cargar($id);
		}
		
	}

}

/* End of file Producto_model.php */
/* Location: ./application/models/Producto_model.php */