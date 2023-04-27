<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\JWT\JWT;

class Token
{
	private $secret_key = 'favi';
    private $encrypt = ['HS256'];

    public function __construct()
    {
        $this->ci =& get_instance();
    }

	public function set_token($data=[])
	{
        $jwt = array(
            'iat'  => time(),
            'exp'  => time() + 7200,
            'data' => $data
        );

        return JWT::encode($jwt, $this->secret_key, 'HS256');
	}

	public function token_activo($token)
	{
		if (is_string($token) && !empty($token)) {
			try {
                $decoded = JWT::decode($token, $this->secret_key, $this->encrypt);
                return true;
            } catch (Exception $e) {
                return false;
            }
		}

		return false;
	}	
	
	public function get_data_token($token)
    {
        $tmp = JWT::decode($token,$this->secret_key,$this->encrypt);

        return $tmp->data;
    }

}

/* End of file Token.php */
/* Location: ./application/libraries/Token.php */
