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

			if (verPropiedad($datos, 'recepcion_enc_id') &&
				verPropiedad($datos, 'no_linea') &&
				verPropiedad($datos, 'cantidad_recibida') &&
				verPropiedad($datos, 'producto_bodega_id') &&
				verPropiedad($datos, 'unidad_medida_id') &&
				verPropiedad($datos, 'estado_producto_id')) {

				$det = new Recepcion_det_model($id);
				
				if (empty($id)) {
					$det->setNoLinea(['recepcion' => $datos->recepcion_enc_id]);
				}

				if ($det->existe($datos)) {
					$data['exito'] = 2;
					$data['mensaje'] = "El producto ya se encuentra agregado a está recepción.";
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
						$data['mensaje'] = "Producto agregrado con éxito.";
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