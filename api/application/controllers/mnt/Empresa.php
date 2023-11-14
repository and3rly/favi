<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Empresa_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar(){

		$data = [
			'lista'=> $this->Empresa_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}


	public function guardar() 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = (object) $_POST;

			if (verPropiedad($datos, "nombre") && verPropiedad($datos, "razon_social")
				&& verPropiedad($datos, "representante") && verPropiedad($datos, "nit")) {

				$empresa = new Empresa_model($id);

				if ($empresa->existe($datos)) {
					$data['mensaje'] = "Los datos ya se encuentran almacenados.";
				} else {

					if (elemento($_FILES, 'imagen') && 
					 	elemento($_FILES['imagen'], 'tmp_name')) {
					
						$imagen = subirArchivo([
							'tmp_name' => $_FILES['imagen']['tmp_name'],
							'type'     => $_FILES['imagen']['type'],
							'name'     => $_FILES['imagen']['name'],
							'carpeta'  => 'empresa'
						]);

						if ($imagen) {
							$datos->logo        = $imagen->key;
							$datos->logo_enlace = $imagen->link;
						} 
					}

					if ($empresa->guardar($datos)) {
						$data['exito']   = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";
						$data['linea']   = $empresa->buscar(['id' => $empresa->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $empresa->getMensaje();
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


/* End of file Empresa.php */
/* Location: ./application/controllers/Empresa.php */