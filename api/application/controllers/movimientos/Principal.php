<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'movimientos/Movimientos_model'
		]);

		$this->output->set_content_type('application/json');
		$this->user = $this->session->userdata('usuario');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function get_datos() 
	{
		$data = [
			'cat' => [
				'productos'   => $this->catalogo->ver_productos_bodega(),
				'cliente'      => $this->catalogo->ver_cliente(),
				'transaccion' => $this->catalogo->ver_tipo_transaccion(),
				'bodega'      => $this->catalogo->ver_bodega(),
				'pedido_tipo' => $this->catalogo->ver_pedido_tipo(),
				'motivo_anulacion_pedido' => $this->catalogo->ver_motivo_anulacion_pedido(),
				'presentacion'=> $this->catalogo->ver_presentacion(),
				'estado_prod' => $this->catalogo->ver_estado(),
				'um'          => $this->catalogo->ver_um(),
				'fecha' 	  => Hoy(),
			]
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function ObtenerMovimientos()
	{
		$data = [
			'movimientos' => $this->Movimientos_model->ObtenerMovimientos($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Principal.php */
/* Location: ./application/controllers/movimientos/Principal.php */