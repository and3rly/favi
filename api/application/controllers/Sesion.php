<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Usuario_model', 
							'mnt/Empresa_model', 
							'mnt/Sucursal_model'
		]);

		$this->load->library('token');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}

	public function login()
	{
	
		$data = ['exito' => 0];

		if ($this->input->method() === 'post') {

			$headers = array_change_key_case($this->input->request_headers());

			if (elemento($headers, 'usuario') && 
				elemento($headers, 'clave')) {

				$us = new Usuario_model();

				if ($us->login($headers)) {	

					$us->id = $us->getPK();

					$uSucursal = $this->catalogo->ver_usuario_sucursal(['usuario_id' => $us->id, 'uno' => true]);

					if ($uSucursal) {
						$rusuario = $this->catalogo->ver_rol_usuario(["usuario" => $us->id, "uno" => true]);

						$sucursal = new Sucursal_model($uSucursal->sucursal_id);
						$empresa_id = $sucursal->empresa_id;
						$empresa = new Empresa_model($empresa_id);

						$us->empresa_id = $empresa->getPK();
						$us->empresa = $empresa->nombre;
						$us->sucursal_id = $uSucursal->sucursal_id;
						$us->sucursal = $sucursal->nombre;
						$us->rol_id = $rusuario->rol_id;

						$usuario = var_session($us);

						$JWT = new Token();
						$data['token'] = $JWT->set_token($usuario);

						$this->session->set_userdata(["usuario" => $usuario]);

						$data["usuario"] = $usuario;
						$data["mensaje"] = "Bienvenido {$us->nombre} a Favi.";
						$data["exito"]   = 1;

					} else {
						$data['mensaje'] = 'El usuario no está asignado a ninguna sucursal';
					}
				} else {
					$data["mensaje"] = "Usuario o clave incorrecta, intente de nuevo.";
				}
			} else {
				$data["mensaje"] = "Ingrese las credenciales.";
			}
		} else {
			$data['mensaje'] = 'Método de envío incorrecto';
		}

		$this->output->set_output(json_encode($data));
	}

	public function logout()
	{
		$data = ['exito' => 0];

		$this->session->sess_destroy();
		$data['exito'] = 1;
		$data['mensaje'] = "Sesión finalizada.";
	
		$this->output->set_output(json_encode($data));
	}

	public function validar_token()
	{
		$datos = json_decode(file_get_contents('php://input'));
		$data  = ['valido' => 0];

		$JWT = new Token();

		if (is_null($datos->token)){
			$data['mensaje'] = 'Tiempo agotado de sesion.';
		}else{
			if ($JWT->token_valido($datos->token)) {
			$data['valido'] = 1;
			$data['mensaje'] = "Token válido";
			} else {
				http_response_code(401);
				$data['mensaje'] = 'Acceso denegado.';
			}
		}
		

		$this->output->set_output(json_encode($data));
	}

}

/* End of file Sesion.php */
/* Location: ./application/controllers/Sesion.php */