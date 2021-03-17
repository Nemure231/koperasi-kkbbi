<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelMenuUtama extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }


    // public function tambahMenuUtamaDariSubmenu($nama_menu_utama, $menu_id, $ikon_menu_utama){
       
    //         $ambil_token = get_cookie('jwt_token');
    //         $respon_ambil_menu_utama = $this->_client->request(
    //             'POST',
    //             'pengaturan/menu_utama/tambah/dari-submenu'
    //             .'?menu_id='.$menu_id
    //             .'&nama_menu_utama='. htmlspecialchars($nama_menu_utama, ENT_QUOTES)
    //             .'&ikon_menu_utama='. htmlspecialchars($ikon_menu_utama, ENT_QUOTES),
    //             ['headers' => 
    //                 [
    //                 'Authorization' => "Bearer {$ambil_token}"
    //                 ]
    //             ],
    //         )->getBody();
    //         $menu_utama = json_decode($respon_ambil_menu_utama, true);
            
    //     $result = $menu_utama['data'];
    //     return $result;

    // }

    public function tambahMenuUtamaDariSubmenu($nama_menu_utama, $menu_id, $ikon_menu_utama){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_menu_utama = $this->_client->request(
                'POST',
                'pengaturan/menu_utama/tambah/dari-submenu'
                .'?menu_id='.$menu_id
                .'&nama_menu_utama='. htmlspecialchars($nama_menu_utama, ENT_QUOTES)
                .'&ikon_menu_utama='. htmlspecialchars($ikon_menu_utama, ENT_QUOTES),
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

    
}

?>