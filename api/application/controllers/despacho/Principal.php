<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'despacho/Despacho_model',
			'despacho/Despacho_det_model',
			'stock/Stock_model',
			'stock_res/Stock_res_model'
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
			'lista' => $this->Despacho_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function get_datos() 
	{
		$data = [
			'cat' => [
				'productos'   => $this->catalogo->ver_productos_bodega(),
				'transaccion' => $this->catalogo->ver_tipo_transaccion(),
				'bodega'      => $this->catalogo->ver_bodega(),
				'vehiculo'    => $this->catalogo->ver_vehiculos(),
				'piloto'      => $this->catalogo->ver_pilotos(),
				'ruta'        => $this->catalogo->ver_ruta(),
				'presentacion'=> $this->catalogo->ver_presentacion(),
				'estado_prod' => $this->catalogo->ver_estado(),
				'um'          => $this->catalogo->ver_um(),
				'fecha' 	  => Hoy(),
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
				verPropiedad($datos, "tipo_transaccion_id")) {

				$rec = new Despacho_model($id);

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
					$data['mensaje'] = empty($id) ? "Despacho guardado con éxito.":"Despacho actualizado.";

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

	public function despachar() 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "detalle")) {

				$ubic = $this->catalogo->ver_ubicacion([
					"bodega_id" => $datos->bodega,
					"ubicacion_despacho" => 1,
					"uno" => true
				]);

				$realizados = 0;
				if ($ubic) {
					foreach($datos->detalle as $row) {
						$row->despacho_enc_id = $row->id;
						$row->bodega_ubicacion_id = $ubic->id;

						$stock = new Stock_model();

						$stock->guardar($row);
						$realizados++;
					}

					if ($realizados > 0) {
						$ddespacho = [
							"estado" => 'Finalizado'
						];

						$rec = new Despacho_model($datos->detalle[0]->despacho_enc_id);
						$rec->guardar($ddespacho);

						$data["exito"] = 1;
						$data["mensaje"] = "Despacho realizado con éxito.";
						$data["despacho"] = $rec->_buscar(["id" => $rec->getPK(), "uno" => true]);
					}

				} else {
					$data["mensaje"] = "No se tiene una ubicación de recepción";
				}
			}	
		} else {
			$data["mensaje"] = "Metodo de envio incorrecto";
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */