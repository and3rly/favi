			<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

			class Proveedor_model extends General_model{

			public $codigo;
			public $nombre;
			public $telefono;
			public $nit;
			public $direccion;
			public $email;
			public $contacto;
			public $muestra_precio =1;
			public $activo=1;
			public $empresa_id;

	public function __construct($id="")
	{
		parent::__construct();
		if (!empty($id)) {				
			$this->cargar($id);
		}		
	}
			public function buscar($args=[]){
			if (elemento($args,'id')) {
			$this->db->where('a.id',$args['id']);
			}

			$tmp = $this->db->select("a.*,
				b.nombre as Empresa")
			->join("empresa b","b.id= a.empresa_id")
			->where('a.activo', 1)
			->get("$this->_tabla a");
			return verConsulta($tmp, $args);
			}

			public function existe($args=[]) {
			if ($this->getPK()) {
$this->db->where("id <>", $this->getPK());
}

			$tmp = $this->db
			->where("nombre", $args->nombre)
			->where("nit", $args->nit)
			->where("email", $args->email)
			->where("contacto", $args->contacto)
			->get("$this->_tabla");

			if($tmp->num_rows()>0)
			{

			return true;
			}

			return false;
			}

			}

			