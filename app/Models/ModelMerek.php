<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class ModelMerek extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function ambilMerek(){
        $ambil_token = get_cookie('jwt_token');
        $res_merek = json_encode(['data' => '']);
        try {
            $respon_ambil_merek = $this->_client->request(
                'GET',
                'merek',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_merek = $respon_ambil_merek->getBody();
        } catch (ClientException $e) {
            
        }

        $merek = json_decode($res_merek, true);
        return $merek['data'];
    }


    public function tambahMerek(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_merek = $this->_client->request(
                'POST',
                'merek',
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_merek' => htmlspecialchars($this->request->getPost('nama_merek'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_merek, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahMerek(){
        $id_merek = $this->request->getPost('edit_id_merek');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_merek = $this->_client->request(
                'PUT',
                'merek/'.$id_merek,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_merek' => htmlspecialchars($this->request->getPost('edit_nama_merek'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_merek, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusMerek(){
        $id_merek = $this->request->getPost('hapus_id_merek'); 
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_merek = $this->_client->request(
            'DELETE',
            'merek/'.$id_merek,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>