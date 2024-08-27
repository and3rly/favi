<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_content_type('application/json');
		$this->load->model(['producto/Producto_model']);
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->Producto_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{	
		$this->load->library("drive/GoogleDrive");

		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "nombre") && verPropiedad($datos, "precio")) {

				$producto = new Producto_model($id);

				if ($producto->existe($datos)) {
					$data['mensaje'] = "Ya existe el producto que intenta guardar.";
				} else {

					if (elemento($_FILES, 'imagen') && 
					 	elemento($_FILES['imagen'], 'tmp_name')) {
					
						$imagen = subirArchivo([
							'tmp_name' => $_FILES['imagen']['tmp_name'],
							'type'     => $_FILES['imagen']['type'],
							'name'     => $_FILES['imagen']['name'],
							'carpeta'  => 'producto'
						]);

						if ($imagen) {
							$datos->imagen        = $imagen->key;
							$datos->img_enlace = $imagen->link;
						} 
					}
					
					if ($producto->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $producto->buscar(['id' => $producto->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $producto->getMensaje();
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

/* End of file Producto.php */
/* Location: ./application/controllers/Producto.php */