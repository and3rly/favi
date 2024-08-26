<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detalle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			"despacho/Despacho_enc_model",
			"despacho/Despacho_det_model",
			"pedido/Pedido_model",
			"Stock_res/Stock_res_model",
			"Movimiento_model"
		]);

		$this->user = $this->session->userdata('usuario');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		die;
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Despacho_det_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id='')
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "detalle") && verPropiedad($datos, "despacho")) {

				$contar = 0;
				foreach ($datos->detalle as $row) {
					$det = new Despacho_det_model();
					if ($det->guardar($row)) {

						$det->actCantPedDet([
							"pedido_det" => $row->pedido_det_id, 
							"cantidad" => $row->cantidad_despachada
						]);

						$stock = new Stock_res_model();
						$sres = $stock->_buscar([
							"producto_bodega_id"       => $row->producto_bodega_id, 
							"presentacion_producto_id" => $row->presentacion_producto_id,
							"unidad_medida_id"         => $row->unidad_medida_id, 
							"estado_producto_id"       => $row->estado_producto_id,
							"uno" => true
						]);

						if ($sres) {						
							$dmov =  [
								"cantidad"                    => $row->cantidad_despachada,
								"peso"                        => $row->peso_despachado,
								"lote"                        => $sres->lote,
								"fechaVence"                  => $sres->fecha_vence,
								"horaInicio"                  => null,
								"horaFinal"                   => null,
								"cantHist"                    => $row->cantidad_despachada,
								"pesoHist"                    => $row->peso_despachado,
								"fechaOperacion"              => Hoy(true),
								"usuario_agr"                 => $this->user['id'],
								"tipo_transaccion_id"         => $datos->despacho->tipo_transaccion_id,
								"producto_bodega_id"          => $row->producto_bodega_id,
								"empresa_id"                  => $this->user['empresa_id'],
								"presentacion_producto_id"    => $row->presentacion_producto_id,
								"bodega_ubicacion_id_origen"  => $sres->bodega_ubicacion_id,
								"bodega_ubicacion_id_destino" => $sres->bodega_ubicacion_id,
								"bodega_id_origen"            => $sres->bodega_id,
								"bodega_id_destino"           => $sres->bodega_id,
								"estado_producto_id_origen"   => $row->estado_producto_id,
								"estado_producto_id_destino"  => $row->estado_producto_id,
								"unidad_medida_id"            => $row->unidad_medida_id,
								"recepcion_enc_id"            => $sres->recepcion_enc_id,
								"despacho_enc_id"             => $datos->despacho->id,
								"pedido_enc_id"				  => $row->pedido_enc_id
							];

							$mov = new Movimiento_model();
							$mov->guardar($dmov);
						}
					}

					$contar++;
				}

				if ($contar > 0) {
					$des = new Despacho_enc_model($datos->despacho->id);
					$pedido = new Pedido_model($datos->detalle[0]->pedido_enc_id);
					$pdatos = ["estado_pedido_id" => 5];
					$pedido->guardar($pdatos);

					$data["exito"] = 1;
					$data["mensaje"] = "Despacho realizado con éxito.";

					$ddespacho = ["estado_despacho_id" => 4];
					$des->guardar($ddespacho);

					$data['despacho'] = $des->_buscar([
						'id' => $des->getPK(), 
						'uno' => true
					]);
				}

			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Detalle.php */
/* Location: ./application/controllers/Detalle.php */