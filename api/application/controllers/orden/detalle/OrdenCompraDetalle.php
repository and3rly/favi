<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompraDetalle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['orden/detalle/OrdenCompraDetalle_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->OrdenCompraDetalle_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

            // print_r($datos);

			// if (verPropiedad($datos, "no_linea")) {

				$ordenCompraDetalle = new OrdenCompraDetalle_model($id);

				if ($ordenCompraDetalle->existe($datos)) {
					$data['mensaje'] = "Ya existe el detalle de la orden que intenta guardar.";
				} else {

					if ($ordenCompraDetalle->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $ordenCompraDetalle->buscar(['id' => $ordenCompraDetalle->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $ordenCompraDetalle->getMensaje();
					}
				}
			// } else {
			// 	$data['mensaje'] = "Complete todos los campos marcados con * Test.";
			// }
		} else {
			$data['mensaje'] = "Error en el envio de datos";
		}

		$this->output->set_output(json_encode($data));
	}

}

/* End of file OrdenCompra.php */
/* Location: ./application/controllers/OrdenCompra.php */