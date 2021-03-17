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




    
}
?>