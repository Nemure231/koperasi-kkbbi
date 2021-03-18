<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
 
class ModelSubmenu extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }

    public function ambilSubmenuUntukSidebar($menu_id, $menu_utama_id){
        $ambil_token = get_cookie('jwt_token');
        $role_id = $this->session->get('role_id');
        $res_submenu = json_encode(['data' => '']);
        try {
            $respon_ambil_submenu = $this->_client->request(
                'GET',
                'pengaturan/submenu/untuk-sidebar/'.$menu_id.'/'.$menu_utama_id,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_submenu = $respon_ambil_submenu->getBody();
        } catch (ClientException $e) {
            
        }

        $submenu = json_decode($res_submenu, true);
        return $submenu['data'];
    }

    public function ambilSubmenu(){
        $ambil_token = get_cookie('jwt_token');
        $res_submenu = json_encode(['data' => '']);
        try {
            $respon_ambil_submenu = $this->_client->request(
                'GET',
                'pengaturan/submenu',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_submenu = $respon_ambil_submenu->getBody();
        } catch (ClientException $e) {
            
        }

        $submenu = json_decode($res_submenu, true);
        return $submenu['data'];
    }

    public function tambahSubmenu(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_submenu = $this->_client->request(
                'POST',
                'pengaturan/submenu/tambah'
                .'?menu_id='.$this->request->getPost('menu_id')
                .'&menu_utama_id='.$this->request->getPost('menu_utama_id')
                .'&nama_submenu='. htmlspecialchars($this->request->getPost('judul'), ENT_QUOTES)
                .'&url_submenu='. htmlspecialchars($this->request->getPost('url'), ENT_QUOTES)
                .'&ikon_submenu='.  htmlspecialchars($this->request->getPost('icon'), ENT_QUOTES)
                .'&status_submenu='. htmlspecialchars($this->request->getPost('is_active'), ENT_QUOTES),

                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_submenu, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];

    }

    public function ubahSubmenu($id_submenu){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_submenu = $this->_client->request(
                'PUT',
                'pengaturan/submenu/ubah/'.$id_submenu
                .'?menu_id='.$this->request->getPost('menu_idE')
                .'&menu_utama_id='.$this->request->getPost('menu_utama_idE')
                .'&nama_submenu='. htmlspecialchars($this->request->getPost('judulE'), ENT_QUOTES)
                .'&url_submenu='. htmlspecialchars($this->request->getPost('urlE'), ENT_QUOTES)
                .'&ikon_submenu='.  htmlspecialchars($this->request->getPost('iconE'), ENT_QUOTES)
                .'&status_submenu='. htmlspecialchars($this->request->getPost('is_activeE'), ENT_QUOTES),

                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_submenu, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];

    }

    public function hapusSubmenu($id_submenu){
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_user = $this->_client->request(
            'DELETE',
            'pengaturan/submenu/hapus/'.$id_submenu,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }




    
}
?>