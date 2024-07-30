<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompra extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['orden/OrdenCompra_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->OrdenCompra_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "no_documento") && verPropiedad($datos, "observacion")) {

				if($datos->motivo_devolucion_id == 'null' || $datos->motivo_devolucion_id == '' || $datos->motivo_devolucion_id == 'NULL'){
					$datos->motivo_devolucion_id = null;
				}

				$ordenCompra = new OrdenCompra_model($id);

				if ($ordenCompra->existe($datos)) {
					$data['mensaje'] = "Ya existe la orden que intenta guardar.";
				} else {

					if ($ordenCompra->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $ordenCompra->buscar(['id' => $ordenCompra->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $ordenCompra->getMensaje();
					}
				}
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['mensaje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file OrdenCompra.php */
/* Location: ./application/controllers/OrdenCompra.php */