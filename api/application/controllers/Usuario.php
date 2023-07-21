<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario_model']);
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function buscar()
	{
		$this->output->set_output(json_encode([
			'lista' => $this->Usuario_model->buscar($_GET)
		]));
	}

	public function guardar($id='')
	{
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {
			$datos = (object) $_POST;

			if (verPropiedad($datos, 'nombre') && 
				verPropiedad($datos, 'apellido')) {

				$us = new Usuario_model($id);

				if (empty($id)) {
					$datos->usuario = $_POST['correo'];
					$datos->clave = md5('123');
				}

				if (elemento($_FILES, 'foto') && 
					 elemento($_FILES['foto'], 'tmp_name')) {
					
					$foto = subirArchivo([
						'tmp_name' => $_FILES['foto']['tmp_name'],
						'type'     => $_FILES['foto']['type'],
						'name'     => $_FILES['foto']['name'],
						'carpeta'  => 'perfil'
					]);

					if ($foto) {
						$datos->foto = $foto->key;
						$datos->foto_enlace = $foto->link;
					} 
				}

				if ($us->guardar($datos)) {

					$data['exito'] = 1;
					$texto = empty($id) ? 'creado':'actualizado';
					$data['mensaje'] = "Usuario {$texto} con éxito.";
					$data['linea'] = $this->Usuario_model->buscar(["id" => $us->getPK(),'uno' => true]);

				} else {
					$data['mensaje'] = $us->getMensaje();
				}
			}
			
		}

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Usuario.php */
/* Location: ./application/controllers/Usuario.php */