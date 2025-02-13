<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			"despacho/Despacho_enc_model", 
			"pedido/Pedido_model", 
			"pedido/Pedido_det_model",
			'mnt/Empresa_model',
			'despacho/Despacho_det_model'
		]);
		$this->user = $this->session->userdata('usuario');

		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		die;
	}

	public function get_datos()
	{
		$data = [
			'cat' => [
				'bodega' => $this->catalogo->ver_bodega()
			]
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function get_catalogo() {
		$data = [
			"cat" => [
				"estado"      => $this->catalogo->ver_estado_despacho(),
				"transaccion" => $this->catalogo->ver_tipo_transaccion(),
				"bodega"      => $this->catalogo->ver_bodega(),
				"vehiculo"    => $this->catalogo->ver_vehiculos(),
				"piloto"      => $this->catalogo->ver_pilotos(),
				"ruta"        => $this->catalogo->ver_ruta()
			]
		];

		$this->output->set_output(json_encode($data)); 
	}

	public function buscar()
	{
		$data = [
			"lista" => $this->Despacho_enc_model->_buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}

	public function get_pedidos()
	{	
		$data = [];
		$pedido = $this->Pedido_model->_buscar(["estado_pedido_id" => 2]);

		if ($pedido) {
			foreach ($pedido as $row) {
				$row->detalle = $this->Pedido_det_model->_buscar(["pedido_enc_id" => $row->id]);
			}
		}

		$data["lista"] = $pedido;

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function guardar($id="")
	{
		$data = ["exito" => 0];

		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'));


			if (verPropiedad($datos, "tipo_transaccion_id") &&
				verPropiedad($datos, "bodega_id") &&
				verPropiedad($datos, "estado_despacho_id") &&
				verPropiedad($datos, "hora_inicio") &&
				verPropiedad($datos, "hora_fin")) {
				
				$des = new Despacho_enc_model($id);

				$fecha = Hoy(true);
				$us = $this->user['id'];

				if (empty($id)) {
					$datos->usuario_agr = $us;
				}

				$datos->fecha_mod   = $fecha;
				$datos->usuario_mod =  $us;

				if ($des->guardar($datos)) {
					$data["exito"] = 1;
					$data["mensaje"] = "Despacho guardado con éxito.";
					$data['linea'] = $des->_buscar([
						'id' => $des->getPK(), 
						'uno' => true
					]);
				}
			} else {
				$data["mensaje"] = "Complete los campos marcados con *.";
			}
		} else {
			$data["mensaje"] = "Método de envio incorrecto.";
		}

		$this->output->set_output(json_encode($data));
	}

	public function imprimir($id)
	{	

		$empresa = new Empresa_model($this->user["empresa_id"]);
		$enc = new Despacho_enc_model();
		$det = new Despacho_det_model();
		
		$data = [
			"empresa"    => $empresa,
			"encabezado" => $enc->_buscar(["id" => $id, "uno" => true]),
			"cliente" => $enc->_buscarCliente(["id" => $id, "uno" => true]),
			"detalle"    => $det->_buscar(["despacho_enc_id" => $id])
		];

		$cuerpo = $this->load->view("despacho/imprimir", $data, true);

		$mpdf = new \Mpdf\Mpdf([
							    'format' => [138, 215],
							    'margin_top' => 5,
							    'margin_bottom' => 5,
							    'margin_left' => 5,
							    'margin_right' => 5
							]);

		$mpdf->setTitle("Despacho_#{$id}");
		$mpdf->SetHTMLFooter('
		    <div style="position: absolute; width: 93%; border-top: 1px solid #555; font-family: Gill Sans, sans-serif;">
		        <table width="100%" style="font-size: 9pt; font-family: Gill Sans, sans-serif;">
		            <tr>
		                <td width="33%" style="text-align: left;">
		                    &copy; {DATE Y} ' . $empresa->nombre . '
		                </td>
		            </tr>
		        </table>
		    </div>
		');
		
		$mpdf->WriteHTML($cuerpo);
		$mpdf->debug = true;
		$mpdf->Output("Despacho_#{$id}.pdf","I");
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */