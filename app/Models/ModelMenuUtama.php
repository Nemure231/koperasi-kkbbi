<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelMenuUtama extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }

    public function ambilMenuUtamaUntukSidebar($menu_id){
        $ambil_token = get_cookie('jwt_token');
        $res_menu_utama_utama = json_encode(['data' => '']);
        try {
            $respon_ambil_menu_utama_utama = $this->_client->request(
                'GET',
                'pengaturan/menu_utama/untuk-sidebar/'.$menu_id,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_menu_utama_utama = $respon_ambil_menu_utama_utama->getBody();
        } catch (ClientException $e) {
            
        }

        $menu_utama = json_decode($res_menu_utama_utama, true);
        return $menu_utama['data'];
    }

    public function ambilMenuUtama(){
        $ambil_token = get_cookie('jwt_token');
        $res_menu_utama = json_encode(['data' => '']);
        try {
            $respon_ambil_menu_utama = $this->_client->request(
                'GET',
                'pengaturan/menu_utama',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_menu_utama = $respon_ambil_menu_utama->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_menu_utama, true);
        return $user['data'];
    }

    public function ambilMenuUtamaUntukSubmenu(){
        $ambil_token = get_cookie('jwt_token');
        $res_menu_utama = json_encode(['data' => '']);
        try {
            $respon_ambil_menu_utama = $this->_client->request(
                'GET',
                'pengaturan/menu_utama/untuk-submenu',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_menu_utama = $respon_ambil_menu_utama->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_menu_utama, true);
        return $user['data'];
    }

    public function tambahMenuUtama(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_menu_utama = $this->_client->request(
                'POST',
                'pengaturan/menu_utama/tambah'
                .'?menu_id='. htmlspecialchars($this->request->getPost('menu_id'), ENT_QUOTES)
                .'&nama_menu_utama='. htmlspecialchars($this->request->getPost('nama_menu_utama'), ENT_QUOTES)
                .'&ikon_menu_utama='. htmlspecialchars($this->request->getPost('ikon_menu_utama'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            $menu = json_decode($respon_ambil_menu_utama, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahMenuUtama(){
        $id_menu_utama = $this->request->getPost('hidden_menu_utama_id');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_menu_utama = $this->_client->request(
                'PUT',
                'pengaturan/menu_utama/ubah/'.$id_menu_utama
                .'?menu_id='. htmlspecialchars($this->request->getPost('menu_idE'), ENT_QUOTES)
                .'&nama_menu_utama='. htmlspecialchars($this->request->getPost('nama_menu_utamaE'), ENT_QUOTES)
                .'&ikon_menu_utama='. htmlspecialchars($this->request->getPost('ikon_menu_utamaE'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_menu_utama, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusMenuUtama(){
        $id_menu_utama = $this->request->getPost('hidden_hapus_menu_utama_id');
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_user = $this->_client->request(
            'DELETE',
            'pengaturan/menu_utama/hapus/'.$id_menu_utama,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }



    
}

?>