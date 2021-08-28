<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelRole extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


   
    public function ambilRole(){
        $ambil_token = get_cookie('jwt_token');
        $res_role = json_encode(['data' => '']);
        try {
            $respon_ambil_role = $this->_client->request(
                'GET',
                'role',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_role = $respon_ambil_role->getBody();
        } catch (ClientException $e) {
            
        }

        $role = json_decode($res_role, true);
        return $role['data'];
    }


    public function ambilRoleUntukCekCentang(){
        $id_role = $this->session->get('role_id');
        $ambil_token = get_cookie('jwt_token');
        $res_role = json_encode(['data' => '']);
        try {
            $respon_ambil_role = $this->_client->request(
                'GET',
                'role/cek-centang/'.$id_role,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_role = $respon_ambil_role->getBody();
        } catch (ClientException $e) {
            
        }

        $role = json_decode($res_role, true);
        return $role['data'];
    }

    public function tambahRole(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_role = $this->_client->request(
                'POST',
                'role',
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_role' =>  htmlspecialchars($this->request->getPost('nama_role'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_role, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

   
    public function ubahRole(){
        $id_role = $this->request->getPost('edit_id_role');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_role = $this->_client->request(
                'PUT',
                'role/'.$id_role,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_role' => htmlspecialchars($this->request->getPost('edit_nama_role'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_role, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusRole(){
        $id_role =  $this->request->getPost('hapus_id_role');
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_user = $this->_client->request(
            'DELETE',
            'role/'.$id_role,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>