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

	public function guardar($rec)
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			$guardados = 0;

			if (verPropiedad($datos, 'detalle')) {
				foreach ($datos->detalle as $value) {
					$det = new Recepcion_det_model();

					if (verPropiedad($value, 'id')) {
						$det->cargar($value->id);	
					} else {
						$det->limpiarGeneral();
					}

					if ($det->guardar($value)) {
						$guardados++;
					}
				}

				if ($guardados > 0) {
					$data['exito'] = 1;
					$data['mensaje'] = "Detalle guardado con éxito.";
					$data['lista'] = $det->_buscar(['recepcion_enc_id' => $rec]);
				} else {
					$data['mensaje'] = "No se logró guardar el detalle de la recepción.";
				}

			} else {
				$data['mensaje'] = "Debe agregar detalle a la recepción.";
			}
		} else {
			$data['menasje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Detalle.php */
/* Location: ./application/controllers/Detalle.php */