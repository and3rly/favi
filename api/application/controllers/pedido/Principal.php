<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'pedido/Pedido_model',
			'pedido/Pedido_det_model',
			'stock/Stock_model'
		]);

		$this->output->set_content_type('application/json');
		$this->user = $this->session->userdata('usuario');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Pedido_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
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

	public function ObtenerStock()
	{
		$data = [
			'stock' => $this->Stock_model->ObtenerStock($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function guardar($id='') 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "bodega_id") &&
				verPropiedad($datos, "tipo_transaccion_id")) {

				$rec = new Pedido_model($id);

				$fecha = Hoy(true);
				$us = $this->user['id'];

				if (empty($id)) {
					$datos->fecha_agr = $fecha;
					$datos->usuario_agr = $us;
				}

				$datos->fecha_mod = $fecha;
				$datos->usuario_mod =  $us;

				if ($datos->motivo_anulacion_pedido_id === 'null') {
					$datos->motivo_anulacion_pedido_id = null;
				}

				if (!isset($datos->fecha_entrega)) {
					$datos->fecha_entrega = date('Y-m-d');
				}

				if (!isset($datos->hora_fin)) {
					$datos->hora_fin = date('H:i');
				}

				if ($rec->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Pedido guardado con éxito.":"Pedido actualizado.";

					$data['linea'] = $rec->_buscar([
						'id' => $rec->getPK(), 
						'uno' => true
					]);

				} else {
					$data['mensaje'] = $rec->getMensaje();
				}
				
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

	public function finalizarPedido($id)
	{
		$data = ['exito' => 0];
		$datos = ['estado' => "FINALIZADO"];

		$det = new Pedido_model($id);

		if ($det->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Pedido finalizado con éxito.";
		} else {
			$data['mensaje'] = $det->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/pedido/Principal.php */