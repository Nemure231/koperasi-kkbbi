<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelAksesRole extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }


    public function cekCentangAksesRole($role_id, $menu_id){
        $ambil_token = get_cookie('jwt_token');
        $res_akses = json_encode(['data' => '']);
        try {
            $respon_ambil_akses = $this->_client->request(
                'GET',
                'pengaturan/role/akses/cek-centang/'.$role_id.'/'.$menu_id,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_akses = $respon_ambil_akses->getBody();
        } catch (ClientException $e) {
            
        }

        $akses = json_decode($res_akses, true);
        return $akses['data'];
    }

    public function ubahAksesRole($role_id, $menu_id){
        // $result = '';
        // $validasi = array('data' => '');
        // try {
            $ambil_token = get_cookie('jwt_token');
            $respon_akses_role = $this->_client->request(
                'POST',
                'pengaturan/role/akses/ubah/'.$role_id.'/'.$menu_id
                .'?role_id='.$this->request->getPost('roleId')
                .'&menu_id='.$this->request->getPost('menuId'),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            );
            // ->getBody();
        //     json_decode($respon_akses_role, true);
        // } catch (ClientException $e) {
        //     // echo Psr7\Message::toString($e->getRequest());
        //     $validasi = json_decode($e->getResponse()->getBody(), true);
        // }

        // return $result = $validasi['data'];
    }

}

?>