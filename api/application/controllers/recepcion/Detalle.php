<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detalle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
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
			'lista' => $this->Recepcion_det_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id='')
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "recepcion") &&
				verPropiedad($datos, "detalle")) {
				$detalle = new Recepcion_det_model();

				
				$contar = 0;
				foreach ($datos->detalle as $row) {
					$det = new Recepcion_det_model($row->id);

					$det->guardar($row);

					$contar++;
				}

				if ($contar > 0) {
					$data["exito"] = 1;
					$data["mensaje"] = "Productos guardados con éxito.";
					$data["detalle"] = $detalle->_buscar(["recepcion_enc_id" => $datos->recepcion]);
				}

			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

	public function guardar_detalle()
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, 'detalle') && verPropiedad($datos, 'id')) {
				$det = new Recepcion_det_model();

				if ($det->existe_oc_rec(["oc" => $datos->oc, "rec" => $datos->id])) {
					$data["mensaje"] = "La orden de compra #{$datos->oc} ya esta relacionada a la recepción #{$datos->id}.";

				} else {
					$realizados = 0;
					foreach ($datos->detalle as $row) {
						$detg = new Recepcion_det_model();

						$row->recepcion_enc_id = $datos->id;
						$row->estado_producto_id = 1;
						$row->cantidad_recibida = $row->cantidad;
						$row->no_linea = $detg->setNoLinea(['recepcion' => $datos->id]);
						$detg->guardar($row);
						$realizados++;
					}

					$droc = [
						'orden_compra_enc_id' => $datos->oc,
						'recepcion_enc_id' => $datos->id
					];

					$det->insert_rec_oc($droc);

					if ($realizados > 0) {
						$data['exito'] = 1;
						$data['mensaje'] = "Productos agregrados con éxito.";
						$data["detalle"] = $det->_buscar(["recepcion_enc_id" => $datos->id]);
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
}

/* End of file Detalle.php */
/* Location: ./application/controllers/Detalle.php */