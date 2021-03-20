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
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }


    public function ambilMerek(){
        $ambil_token = get_cookie('jwt_token');
        $res_merek = json_encode(['data' => '']);
        try {
            $respon_ambil_merek = $this->_client->request(
                'GET',
                'suplai/merek',
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
                'suplai/merek/tambah'
                .'?nama_merek='. htmlspecialchars($this->request->getPost('nama_merek'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
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


    public function ubahMerek($id_merek){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_merek = $this->_client->request(
                'PUT',
                'suplai/merek/ubah/'.$id_merek
                .'?nama_merek='. htmlspecialchars($this->request->getPost('edit_nama_merek'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
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

    public function hapusMerek($id_merek){
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_merek = $this->_client->request(
            'DELETE',
            'suplai/merek/hapus/'.$id_merek,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>