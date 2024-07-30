<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompra_model extends General_model {

	public $no_documento;
	public $procedencia;
	public $referencia;
	public $observacion;
	public $activo;
	public $proveedor_bodega_id;
	public $orden_compra_estado_id;
	public $orden_compra_tipo_id;
	public $motivo_devolucion_id;
	public $bodega_id;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("orden_compra_enc");
		$this->setLlave("id");
		if (!empty($id)) {
			$this->cargar($id);
		}
		
	}

	public function buscar($args=[])
	{	
		if (elemento($args, 'id')) {
			$this->db->where('oce.id', $args['id']);
		} else {

			if (elemento($args, "bodega_id")) {
				$this->db->where("b.id", $args['bodega_id']);
			}

			if (elemento($args, 'criterio')) {

				$termino = trim($args['criterio']);

				$campos = [
					'oce.no_documento',
					'oce.procedencia',
					'oce.referencia',
					'oce.observacion'
				];

				$where = implode(" like '%{$termino}%' or ", $campos);

				$this->db->where("({$where} like '%{$termino}%')", null, false);

			} else {
				if (elemento($args, 'fdel') && elemento($args, 'fal')) {
					$this->db
					->where("CAST(oce.fecha_creacion as date) >=", $args["fdel"])
					->where("CAST(oce.fecha_creacion as date) <=", $args["fal"]);
				}
			}
		}

		$tmp = $this->db
					->select("oce.*, p.nombre as nombre_proveedor, b.nombre as nombre_bodega, oce2.nombre as nombre_estado_oc, oct2.nombre as nombre_tipo_oc, md.nombre as nombre_motivo_dev")
					->join("proveedor_bodega pb","oce.proveedor_bodega_id = pb.id")
					->join("proveedor p","pb.proveedor_id = p.id")
					->join("bodega b","pb.bodega_id = b.id")
					->join("orden_compra_estado oce2","oce.orden_compra_estado_id = oce2.id")
					->join("orden_compra_tipo oct2","oce.orden_compra_tipo_id = oct2.id")
					->join("motivo_devolucion md","oce.motivo_devolucion_id = md.id", "left")
					->get("orden_compra_enc oce");
					
		return verConsulta($tmp, $args);
	}

	public function existe($args=[]) {
		if ($this->getPK()) {
			$this->db->where("id <>", $this->getPK());
		}

		$tmp = $this->db
					->where("no_documento", $args->no_documento)
					->get("orden_compra_enc oce");

		if ($tmp->num_rows() > 0) {
			return true;
		}

		return false;
	}

}

/* End of file OrdenCompra_model.php */
/* Location: ./application/models/OrdenCompra_model.php */