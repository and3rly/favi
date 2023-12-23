<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Motivo_anulacion_pedido extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Motivo_anulacion_pedido_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Motivo_anulacion_pedido_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "nombre")) {

				$Mt_anulacion_pedido = new Motivo_anulacion_pedido_model($id);

				if ($Mt_anulacion_pedido->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if ($Mt_anulacion_pedido->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $Mt_anulacion_pedido->buscar(['id' => $Mt_anulacion_pedido->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $Mt_anulacion_pedido->getMensaje();
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
}


/* End of file Mt_anulacion_pedido.php */
/* Location: ./application/controllers/Mt_anulacion_pedido.php */