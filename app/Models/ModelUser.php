<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelUser extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function login($email, $sandi){
        $res_token = json_encode(['access_token' => '']);
			try {
				$respon_token = $this->_client->request(
				'POST',
				'auth/login',
				[
                    'form_params' => [
						'email' => $email,
						'password' => $sandi,
					]
					
					],
			);
			$res_token = $respon_token->getBody();
			} catch (ClientException $e) {
			
			}
        $token = json_decode($res_token, true);

        return $token;
    }

    public function ambilSatuUserUntukLogin($ambil_token){

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


    ///////PROFIL /////////////////

    public function ambilSatuUser(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'profil/'.$id_user,
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
        return $user['data'];
    }

    public function ambilSatuUserBuatProfil(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'profil/untuk-profil/'.$id_user,
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
        return $user['data'];
    }

    public function ambilSatuUserJoinRole(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'profil/dengan-role/'.$id_user,
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
        return $user['data'];
    }

    public function ubahUser(){
    
        $id_user = $this->session->get('id_user');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_user = $this->_client->request(
                'PUT',
                'profil/'.$id_user,
                    [
                        'headers' => [
                            'Authorization' => "Bearer {$ambil_token}"
                        ],
                        'form_params' => [
                            'name' => htmlspecialchars($this->request->getPost('name'), ENT_QUOTES),
                            'telepon' => htmlspecialchars($this->request->getPost('telepon'), ENT_QUOTES),
                            'alamat' => htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES)
                        ]
                ],
            )->getBody();
            json_decode($respon_ambil_user, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
                

    }

    /////////////////////////////////////////////Sandi///////////////////////


    public function ambilSatuSandi(){
        $ambil_token = get_cookie('jwt_token');
        $id_user = $this->session->get('id_user');
        $res_sandi = json_encode(['users' => '']);
        try {
            $respon_ambil_sandi = $this->_client->request(
                'GET',
                'sandi/'.$id_user,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_sandi = $respon_ambil_sandi->getBody();
        } catch (ClientException $e) {
            
        }
        $user = json_decode($res_sandi, true);
        return $user['data'];
    }


    public function ubahSandi(){

        $id_user = $this->session->get('id_user');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_sandi = $this->_client->request(
                'PUT',
                'sandi/'.$id_user
                .'?sandi_lama='. $this->request->getPost('katasandi_sebelum').
                '&sandi_baru='. $this->request->getPost('katasandi_baru'),
                    ['headers' => 
                        [
                        'Authorization' => "Bearer {$ambil_token}"
                        ]
                    ],
            )->getBody();
            json_decode($respon_ambil_sandi, true);
        } catch (ClientException $e) {
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
                

    }

}

?>