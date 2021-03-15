<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class Users extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
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

    public function ambilSatuUserUntukLogin($ambil_token){
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

    public function ambilSatuUser(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'akun/profil/'.$id_user,
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

    public function ambilSatuUserBuatProfil(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'akun/profil/untuk-profil/'.$id_user,
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

    public function ambilSatuUserJoinRole(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'akun/profil/dengan-role/'.$id_user,
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

    public function ubahUser(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
       
        $respon_ambil_user = $this->_client->request(
            'PUT',
            'akun/profil/ubah/'.$id_user
            .'?name='. $this->request->getPost('nama').
            '&telepon='. $this->request->getPost('telepon').
            '&alamat='. $this->request->getPost('alamat'),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
                // ['query' => 
                //     [
                //     'name' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
                //     'telepon' => $this->request->getPost('telepon'),
                //     'alamat' => htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES)
                //     ]
                // ],
        );
                

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