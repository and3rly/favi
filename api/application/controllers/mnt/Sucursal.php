<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sucursal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['mnt/Sucursal_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{	
		$data = [
			'lista' => $this->Sucursal_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function guardar($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			
			$datos = json_decode(file_get_contents('php://input'));


			if (verPropiedad($datos, 'nombre') 
				&& verPropiedad($datos, 'empresa_id')) {

				$sucursal = new Sucursal_model($id);

				if (!$sucursal->existe_sucursal(['nombre' => $datos->nombre, 'empresa_id' => $datos->empresa_id])) {
					$data['mensaje'] = "La sucursal ya está registrada.";
				} else {
					if ($sucursal->guardar($datos)) {
						$data['exito'] = 1;
						$termino = empty($id) ? 'guardada':'actualizada';
						$data['mensaje'] = "Sucursal {$termino} con éxito";

						$data['linea'] = $sucursal->buscar(['id' => $sucursal->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $sucursal->getMensaje();
					}
				}
			}
		} else {
			$data['mensaje'] = "Método de envio incorrecto";
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Sucursal.php */
/* Location: ./application/controllers/Sucursal.php */