<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{
	private $secret_key = 'favi';
    private $encrypt = 'HS256';

	public function set_token($data=[])
	{
        $config = array(
            'iat'  => time(),
            'exp'  => time() + 7200,
            'data' => $data
        );

        return JWT::encode($config, $this->secret_key, $this->encrypt);
	}

	public function token_valido($token)
	{
		if (is_string($token) && !empty($token)) {
			try {
                $decoded = JWT::decode($token, new Key($this->secret_key, $this->encrypt));
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
