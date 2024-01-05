<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'recepcion/Recepcion_model',
			'recepcion/Recepcion_det_model'
		]);

		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Recepcion_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function get_datos() 
	{
		$data = [
			'cat' => [
				'productos'   => $this->catalogo->ver_productos_bodega(),
				'estado'      => $this->catalogo->ver_estado_rec(),
				'transaccion' => $this->catalogo->ver_tipo_transaccion(),
				'bodega'      => $this->catalogo->ver_bodega(),
				'vehiculo'    => $this->catalogo->ver_vehiculos(),
				'piloto'      => $this->catalogo->ver_pilotos(),
				'presentacion'=> $this->catalogo->ver_presentacion()
			]
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id='') 
	{

	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */