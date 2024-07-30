<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'bodega/Bodega_model', 
			'bodega/Area_model', 
			'bodega/Sector_model',
			'bodega/Tramo_model'
		]);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function get_datos() 
	{
		$data = [
			'cat' => [
				'empresas' => $this->catalogo->ver_empresa(),
				'areas'    => $this->Area_model->_buscar($_GET),
				'sectores' => $this->Sector_model->_buscar($_GET),
				'tramos'   => $this->Tramo_model->_buscar($_GET),
				'rotacion' => $this->catalogo->ver_rotacion(),
			]
		];
		$this->output->set_output(json_encode($data)); 
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->Bodega_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function guardar($id="") 
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));
			
			if (verPropiedad($datos, "codigo") &&
				verPropiedad($datos, "nombre")) {

				$bodega = new Bodega_model($id);

				if ($bodega->existe($datos)) {
					$data['mensaje'] = "Ya existe la bodega que intenta guardar.";
				} else {
					if ($bodega->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito.":"Registro actualizado.";

						$data['linea'] = $bodega->_buscar([
							'id'  => $bodega->getPK(), 
							'uno' => true
						]);

					} else {
						$data['mensaje'] = $bodega->getMensaje();
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

/* End of file Bodega.php */
/* Location: ./application/controllers/Bodega.php */