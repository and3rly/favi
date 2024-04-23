<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_det_model extends General_model {

	public $pedido_enc_id;
	public $no_linea;
    public $cantidad;
    public $peso;
    public $precio;
    public $cantidad_despachada;
    public $codigo_producto;
    public $nombre_producto;
    public $nombre_presentacion;
    public $nombre_unidad_medida;
    public $nombre_estado_producto;
    public $producto_bodega_id;
    public $presentacion_producto_id;
    public $unidad_medida_id;
    public $estado_producto_id;

	public function __construct($id='')
	{
		parent::__construct();
		$this->setTabla("pedido_det");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}	
	}

	public function existe($args=[])
	{
		if ($this->getPK()) {
			$this->db->where('id <> ', $this->getPK());
		}

		$tmp = $this->db
		->where("pedido_enc_id", $args->pedido_enc_id)
		->where("activo", 1)
		->get("$this->_tabla");


		return $tmp->num_rows() > 0;
	}

	public function setNoLinea($args=[])
	{
		$tmp = $this->db->select("count(*) + 1 as numero")
		->where("pedido_enc_id", $args['pedido'])
		->get("$this->_tabla")
		->row();

		return $tmp->numero;
	}

	public function _buscar($args='')
	{	
		if (elemento($args, 'id')) {
			$this->db->where("a.id", $args['id']);
		} else {
			if (elemento($args, 'pedido_enc_id')) {
				$this->db->where("a.pedido_enc_id", $args['pedido_enc_id']);
			}
		}

		$tmp = $this->db
		->select("a.*")
		->order_by("a.no_linea")
		->get("$this->_tabla a");

		return verConsulta($tmp, $args);
	}

}

/* End of file Pedido_det_model.php */
/* Location: ./application/models/Pedido_det_model.php */