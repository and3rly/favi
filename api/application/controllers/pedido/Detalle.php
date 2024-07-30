<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detalle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'pedido/Pedido_det_model',
			'Stock_res/Stock_res_model'
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
			'lista' => $this->Pedido_det_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id='')
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'pedido_enc_id') &&
				verPropiedad($datos, 'no_linea') &&
				verPropiedad($datos, 'cantidad') &&
				verPropiedad($datos, 'producto_bodega_id')) {

				$det = new Pedido_det_model($id);
				
				if (empty($id)) {
					$det->setNoLinea(['pedido' => $datos->pedido_enc_id]);
				}

				if ($det->existe($datos)) {
					$data['exito'] = 2;
					$data['mensaje'] = "El producto ya se encuentra agregado a este pedido.";
				} else {

					if ($det->guardar($datos)) {
						$data['exito'] = 1;
						$termino = empty($id) ? 'agregado':'actualizado';
						$data['mensaje'] = "Producto {$termino} con éxito.";

						$data['linea'] = $det->_buscar(['id' => $det->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $det->getMensaje();
					}
				}
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

	public function guardarDetalle()
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'pedido_enc_id') &&
				verPropiedad($datos, 'cantidad') &&
				verPropiedad($datos, 'producto_bodega_id')) {

				$det = new Pedido_det_model();

				$id =  $det->ObtenerDetalleExistente(['datos' => $datos]);

				if ($id) {
					$det = new Pedido_det_model($id);
					$datos->cantidad += $det->cantidad;
				}

				if (empty($det->no_linea)) {
					$datos->no_linea = $det->ObtenerUltimaLinea(['pedido' => $datos->pedido_enc_id]) ?? 1;	
				}else {
					$datos->no_linea = $det->no_linea;
				}

				if ($det->guardar($datos)) {
					$data['exito'] = 1;
					$termino = empty($id) ? 'agregado':'actualizado';
					$data['mensaje'] = "Producto {$termino} con éxito.";

					$data['linea'] = $det->_buscar(['id' => $det->getPK(), 'uno' => true]);

					$res = new Stock_res_model();
					$datos->pedido_det_id = $det->getPK();
					$idRes = $res->ObtenerReservaExistente(['datos' => $datos]);
					$datos->tipo_transaccion_id = 2;
					$datos->bodega_ubicacion_id_anterior = $datos->bodega_id;
					$datos->stock_bodega_id = $datos->stock_id;

					if ($idRes) {
						$res = new Stock_res_model($idRes);
					}

					if ($res->guardar($datos)) {
						$data['exito'] = 1;
						$termino = empty($idRes) ? 'agregada':'actualizada';
						$data['mensaje'] = $data['mensaje'] . " Y reserva {$termino} con éxito.";

					}
					else {
						$data['mensaje'] += $data['mensaje'] . " " . $det->getMensaje();
					}

				} else {
					$data['mensaje'] = $det->getMensaje();
				}
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

	public function eliminar_producto($id)
	{
		$data = ['exito' => 0];
		$datos = ['activo' => 0];

		$det = new Recepcion_det_model($id);

		if ($det->guardar($datos)) {
			$data['exito'] = 1;
			$data['mensaje'] = "Producto removido con éxito.";
		} else {
			$data['mensaje'] = $det->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

	public function eliminarDetalle($id)
	{
		$data = ['exito' => 0];

		$reserva = new Stock_res_model();

		if ($reserva->EliminarReserva($id)) {
			
			$det = new Pedido_det_model();

			if ($det->EliminarDetallePedido($id)) {
				$data['exito'] = 1;
				$data['mensaje'] = "Detalle removido con éxito.";
			} else {
				$data['mensaje'] = $det->getMensaje();
			}
		}
		else {
			$data['mensaje'] = $reserva->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Detalle.php */
/* Location: ./application/controllers/Detalle.php */