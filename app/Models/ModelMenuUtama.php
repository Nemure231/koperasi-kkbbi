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
        $res_menu_utama = json_encode(['data' => '']);
        try {
            $respon_ambil_menu_utama = $this->_client->request(
                'GET',
                'pengaturan/menu_utama/untuk-sidebar/'.$menu_id,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_menu_utama = $respon_ambil_menu_utama->getBody();
        } catch (ClientException $e) {
            
        }

        $menu_utama = json_decode($res_menu_utama, true);
        return $menu_utama['data'];
    }



    
}

?>