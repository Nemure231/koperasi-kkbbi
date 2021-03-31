<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelToko extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }


   
    public function ambilToko(){
        $ambil_token = get_cookie('jwt_token');
        $res_toko = json_encode(['data' => '']);
        try {
            $respon_ambil_toko = $this->_client->request(
                'GET',
                'tempat/toko',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_toko = $respon_ambil_toko->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_toko, true);
        return $user['data'];
    }

   

    public function ubahToko($nama_logo){
        $id_toko = $this->request->getPost('edit_id_toko');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_toko = $this->_client->request(
                'PUT',
                'tempat/toko/ubah/'.$id_toko
                .'?nama_toko='. htmlspecialchars($this->request->getPost('nama_toko'), ENT_QUOTES)
                .'&telepon_toko='. htmlspecialchars($this->request->getPost('telepon_toko'), ENT_QUOTES)
                .'&email_toko='. htmlspecialchars($this->request->getPost('email_toko'), ENT_QUOTES)
                .'&alamat_toko='. htmlspecialchars($this->request->getPost('alamat_toko'), ENT_QUOTES)
                .'&logo_toko='.$nama_logo,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_toko, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

}

?>