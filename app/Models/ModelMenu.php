<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelMenu extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function ambilMenuUntukSidebar(){
        $ambil_token = get_cookie('jwt_token');
        $role_id = $this->session->get('role_id');
        $res_user = json_encode(['data' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'pengaturan/menu/untuk-sidebar/'.$role_id,
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

    public function ambilMenu(){
        $ambil_token = get_cookie('jwt_token');
        $res_menu = json_encode(['data' => '']);
        try {
            $respon_ambil_menu = $this->_client->request(
                'GET',
                'pengaturan/menu',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_menu = $respon_ambil_menu->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_menu, true);
        return $user['data'];
    }

    public function ambilMenuUntukDaftarRoleAkses(){
        $ambil_token = get_cookie('jwt_token');
        $res_menu = json_encode(['data' => '']);
        try {
            $respon_ambil_menu = $this->_client->request(
                'GET',
                'pengaturan/menu/untuk-role-akses',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_menu = $respon_ambil_menu->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_menu, true);
        return $user['data'];
    }

    public function tambahMenu(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_menu = $this->_client->request(
                'POST',
                'pengaturan/menu/tambah'
                .'?nama_menu='. htmlspecialchars($this->request->getPost('nama_menu'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            $menu = json_decode($respon_ambil_menu, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function ubahMenu(){
        $id_menu = $this->request->getPost('edit_id_menu');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_menu = $this->_client->request(
                'PUT',
                'pengaturan/menu/ubah/'.$id_menu
                .'?nama_menu='. htmlspecialchars($this->request->getPost('edit_nama_menu'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_menu, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusMenu(){
        $id_menu = $this->request->getPost('hapus_id_menu');
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_user = $this->_client->request(
            'DELETE',
            'pengaturan/menu/hapus/'.$id_menu,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>