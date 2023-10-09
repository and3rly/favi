<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipo_producto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['producto/Tipo_producto_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Tipo_producto_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));

			if (verPropiedad($datos, "nombre")) {
				$tipo = new Tipo_producto_model($id);

				if ($tipo->existe_tipo($datos)) {
					$data['mensaje'] = "Ya existe el tipo de producto que intenta guardar.";
				} else {
					if ($tipo->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

						$data['linea'] = $tipo->buscar(['id' => $tipo->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $tipo->getMensaje();
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

/* End of file Tipo_producto.php */
/* Location: ./application/controllers/Tipo_producto.php */