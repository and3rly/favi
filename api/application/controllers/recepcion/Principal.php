<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'recepcion/Recepcion_model',
			'recepcion/Recepcion_det_model',
			'stock/Stock_model',
			'Movimiento_model',
			'producto/Presentacion_model',
			'mnt/Empresa_model'
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
				'presentacion'=> $this->catalogo->ver_presentacion(),
				'estado_prod' => $this->catalogo->ver_estado(),
				'um'          => $this->catalogo->ver_um(),
				'fecha' 	  => Hoy(),
				'tipos'		  => $this->catalogo->ver_tipos_recepcion()
			]
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id='') 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "bodega_id") &&
				verPropiedad($datos, "tipo_transaccion_id") &&
				verPropiedad($datos, "estado_recepcion_id")) {

				$rec = new Recepcion_model($id);

				$fecha = Hoy(true);
				$us = $this->user['id'];

				if (empty($id)) {
					$datos->fecha_agr = $fecha;
					$datos->usuario_agr = $us;
				}

				$datos->fecha_mod = $fecha;
				$datos->usuario_mod =  $us;

				if ($rec->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Recepción guardada con éxito.":"Recepción actualizada.";

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

	public function recibir() 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "detalle")) {

				$ubic = $this->catalogo->ver_ubicacion([
					"bodega_id" => $datos->bodega,
					"ubicacion_recepcion" => 1,
					"uno" => true
				]);

				$realizados = 0;
				if ($ubic) {
					foreach($datos->detalle as $row) {

						if (!empty($row->presentacion_producto_id)) {
							$pres = $this->Presentacion_model->buscar([
								'id' => $row->presentacion_producto_id, 
								'uno' => true
							]);

							if ($pres) {
								$row->cantidad = $pres->factor * $row->cantidad_recibida;
							}
						} else {
							$row->cantidad  = $row->cantidad_recibida;
						}

						$row->bodega_id = $datos->bodega;
						$row->bodega_ubicacion_id = $ubic->id;
						$row->recepcion_det_id = $row->id;
						$row->bodega_ubicacion_id_anterior = $ubic->id;

						$stock = new Stock_model();
						$stock->guardar($row);

						$row->fechaVence = $row->fecha_vence;
						$row->cantHist = $row->cantidad;
						$row->pesoHist = $row->peso;
						$row->fechaOperacion = Hoy(true);
						$row->usuario_agr = $this->user['id'];
						$row->empresa_id =  $this->user['empresa_id'];
						$row->bodega_ubicacion_id_origen = $row->bodega_ubicacion_id;
						$row->bodega_ubicacion_id_destino = $row->bodega_ubicacion_id;
						$row->bodega_id_origen = $datos->bodega;
						$row->bodega_id_destino = $datos->bodega;
						$row->estado_producto_id_origen = $row->estado_producto_id;
						$row->estado_producto_id_destino = $row->estado_producto_id;
						$row->recepcion_enc_id = $datos->rec;
						$row->tipo_transaccion_id = $datos->transaccion;

						$mov = new Movimiento_model();
						$mov->guardar($row);
						$realizados++;
					}

					if ($realizados > 0) {
						$drecepcion = [
							"estado_recepcion_id" => 6
						];

						$rec = new Recepcion_model($datos->detalle[0]->recepcion_enc_id);
						$rec->guardar($drecepcion);

						$data["exito"] = 1;
						$data["mensaje"] = "Recepción realizada con éxito.";
						$data["recepcion"] = $rec->_buscar(["id" => $rec->getPK(), "uno" => true]);
					}

				} else {
					$data["mensaje"] = "No se tiene una ubicación de recepción";
				}
			} else {
				$data["mensaje"] = "No tiene productos que recibir";
			}
		} else {
			$data["mensaje"] = "Metodo de envio incorrecto";
		}

		$this->output->set_output(json_encode($data));
	}

	public function imprimir($id)
	{	

		$empresa = new Empresa_model($this->user["empresa_id"]);
		$encabezado = new Recepcion_model();
		$det = new Recepcion_det_model();
		
		$data = [
			"empresa"    => $empresa,
			"encabezado" => $encabezado->_buscar(["id" => $id, "uno" => true]),
			"detalle"    => $det->_buscar(["recepcion_enc_id" => $id])
		];

		$cuerpo = $this->load->view("recepcion/imprimir", $data, true);

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->setTitle("Recepción_#{$id}");
		$mpdf->SetFooter('
			<div style="border-top: 1px solid #555; padding-top: 10px; font-family: Gill Sans, sans-serif;">
			    <table width="100%" style="font-size: 9pt; color: #0000; font-family: Gill Sans, sans-serif;">
			        <tr>
			            <td width="33%" style="text-align: left; ">
			                &copy; {DATE Y} ' . $empresa->nombre . '
			            </td>
			            <td width="33%" style="text-align: right;">
			                Página {PAGENO} de {nbpg}
			            </td>
			        </tr>
			    </table>
			</div>
		');
		
		$mpdf->WriteHTML($cuerpo);
		$mpdf->debug = true;
		$mpdf->Output("Recepción_#{$id}.pdf","I");
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */