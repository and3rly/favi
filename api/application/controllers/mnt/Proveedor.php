			<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			class Proveedor extends CI_Controller{
			
			public function __construct()
	{
		parent::__construct();
		$this->load->model('mnt/Proveedor_model');
		$this->output->set_content_type('application/json');
	}

	public function index()
	{
		$this->output->set_status_header('404');
	}
			public function buscar(){

		$data = [
			'lista'=> $this->Proveedor_model->buscar($_GET)
		];

		$this->output->set_output(json_encode($data));
	}
		




			public function guardar($id=''){
			$data =["exito"            =>0];
			if ($this->input->method() =="post") {
			$datos                     = (object) $_POST;
			if (verPropiedad($datos,"nombre")&& verPropiedad($datos,"activo")&& verPropiedad($datos,"empresa_id")) {
			$proveedor                 = new Proveedor_model($id);
			if ($proveedor->existe($datos)) {
			$data['mensaje']           ="los datos ya se encuentran almacenados.";}
			else{
			if ($proveedor->guardar($datos)) {
			$data['exito']             = 1;
			$data['mensaje']           = empty($id) ?"Registro guardado con éxito.":"Registro actualizado.";
			$data['linea']             = $proveedor->buscar(['id'=>$proveedor->getPK(),'uno'=> true]);
			}else{
			$data['mensaje']           =$proveedor->getMensaje();
			}
			}
			}
			else
			{
			$data['mensaje']           ="complete todos los campos marcados con *.";
			}
			}else
			{
				$data['mensaje']="Error en el envio de datos";
			}
				$this->output->set_output(json_encode($data));
			}
			}	

							/* End of file Proveedor.php */
							/* Location: ./application/controllers/Proveedor.php */	
			