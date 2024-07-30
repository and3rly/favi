<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');								


class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'stock_res/Stock_res_model'
		]);

		$this->output->set_content_type('application/json');
		$this->user = $this->session->userdata('usuario');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function guardar($id='') 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "pedido_enc_id") &&
				verPropiedad($datos, "tipo_transaccion_id")
				&& verPropiedad($datos, "pedido_det_id")
				&& verPropiedad($datos, "stock_bodega_id")
				&& verPropiedad($datos, "producto_bodega_id")
				&& verPropiedad($datos, "estado_producto_id")
				&& verPropiedad($datos, "presentacion_producto_id")
				&& verPropiedad($datos, "unidad_medida_id")
				&& verPropiedad($datos, "bodega_ubicacion_id")
				&& verPropiedad($datos, "pedido_det_id")
				&& verPropiedad($datos, "bodega_id")) {

				$res = new Stock_res_model($id);

				$fecha = Hoy(true);
				$us = $this->user['id'];

				if (empty($id)) {
					$datos->fecha_agr = $fecha;
					$datos->usuario_agr = $us;
				}

				$datos->fecha_mod = $fecha;
				$datos->usuario_mod =  $us;

				if ($res->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Despacho guardado con éxito.":"Despacho actualizado.";

					$data['linea'] = $res->_buscar([
						'id' => $res->getPK(), 
						'uno' => true
					]);

				} else {
					$data['mensaje'] = $res->getMensaje();
				}
				
			} else {
				$data['mensaje'] = "No se completaron los campos obligatorios, por favor verificar.";
			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

}