<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class Users extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }




    public function login($email, $sandi){
        $res_token = json_encode(['access_token' => '']);
			// $eror = null;
			try {
				$respon_token = $this->_client->request(
				'POST',
				'auth/login',
				// ['http_errors' => false],
				['form_params' => 
					[
						'email' => $email,
						'password' => $sandi,
					]
					
					],
			);
			$res_token = $respon_token->getBody();
			} catch (ClientException $e) {
				// $e->getRequest();
				// $eror =  $e->getResponse();
			}
        $token = json_decode($res_token, true);

        return $token;
    }

    public function ambilSatuUser($ambil_token){
        // $ambil_token = get_cookie('jwt_token');
        $res_user = json_encode(['id' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'auth/me',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_user = $respon_ambil_user->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_user, true);
        return $user;
    }

    public function logout(){
        $ambil_token = get_cookie('jwt_token');
		$respon_token = $this->_client->request(
		'POST',
		'auth/logout',
			['headers' => 
				[
					'Authorization' => "Bearer {$ambil_token}"
				]
			]
		);

        return $respon_token;
    }    
}

?>