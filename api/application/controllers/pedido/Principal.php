<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'pedido/Pedido_model',
			'pedido/Pedido_det_model',
			'stock/Stock_model',
			'producto/Presentacion_model',
			'Stock_res/Stock_res_model',
			'movimientos/Movimientos_model'
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
		$datos = ['estado_pedido_id' => 2];

		$ped = new Pedido_model($id);

		if ($ped->guardar($datos)) {

			$sRes = new Stock_res_model();
			$resDetalle = $sRes->ObtenerReservaExistente(["id" => $id]);
			$realizados = 0;

			foreach ($resDetalle as $row) {

				$row->fechaVence = $row->fecha_vence;
				$row->horaInicio = $ped->hora_inicio;
				$row->horaFinal = $ped->hora_fin;
				$row->cantHist = $row->cantidad;
				$row->pesoHist = $row->peso;
				$row->fechaOperacion = Hoy(true);
				$row->usuario_agr = $this->user['id'];
				$row->empresa_id =  $this->user['empresa_id'];
				$row->bodega_ubicacion_id_origen = $row->origen;
				$row->bodega_ubicacion_id_destino = $row->destino;
				$row->bodega_id_origen = $row->bodega_id;
				$row->bodega_id_destino = $row->bodega_id;
				$row->estado_producto_id_origen = $row->estado_producto_id;
				$row->estado_producto_id_destino = $row->estado_producto_id;
				$row->pedido_enc_id = $id;

				$mov = new Movimientos_model();
				$mov->guardar($row);
				$realizados++;
			}

			if ($realizados > 0) {
				$data['exito'] = 1;
				$data['mensaje'] = "Pedido finalizado con éxito.";
			}

		} else {
			$data['mensaje'] = $ped->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

	public function obtenerUltimoPedido(){
		$data = ['exito' => 0];

		$pedido = new Pedido_model();
		$correlativo = $pedido->obtenerUltimoId();

		if ($correlativo) {
			$data['exito'] = 1;
			$data['correlativo'] = $correlativo;
		}else {
			$data['mensaje'] = $det->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}

	public function anularPedido($id)
	{
		$data = ['exito' => 0];
		$datos = ['estado_pedido_id' => 3];

		$ped = new Pedido_model($id);

		if ($ped->guardar($datos)) {

			$mov = new Movimientos_model();

			if ($mov->eliminarMovimiento($id)) {

				$sRes = new Stock_res_model();
				if ($sRes->EliminarReserva(["pedido_enc_id" => $id])) {
					$data['exito'] = 1;
					$data['mensaje'] = "Pedido anulado con exito.";

				}else {
					$data['exito'] = 0;
					$data['mensaje'] = $det->getMensaje();
				}

			}else {
				$data['exito'] = 0;
				$data['mensaje'] = $det->getMensaje();
			}

		} else {
			$data['mensaje'] = $ped->getMensaje();
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/pedido/Principal.php */