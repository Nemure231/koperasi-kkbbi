<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelSatuan extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function ambilSatuan(){
        $ambil_token = get_cookie('jwt_token');
        $res_satuan = json_encode(['data' => '']);
        try {
            $respon_ambil_satuan = $this->_client->request(
                'GET',
                'satuan',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_satuan = $respon_ambil_satuan->getBody();
        } catch (ClientException $e) {
            
        }

        $satuan = json_decode($res_satuan, true);
        return $satuan['data'];
    }


    public function tambahSatuan(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_satuan = $this->_client->request(
                'POST',
                'satuan',
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_satuan' => htmlspecialchars($this->request->getPost('nama_satuan'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_satuan, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahSatuan(){
        $id_satuan = $this->request->getPost('edit_id_satuan');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_satuan = $this->_client->request(
                'PUT',
                'satuan/'.$id_satuan,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_satuan' => htmlspecialchars($this->request->getPost('edit_nama_satuan'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_satuan, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusSatuan(){
        $id_satuan = $this->request->getPost('hapus_id_satuan');
        $ambil_token = get_cookie('jwt_token');

        $respon_ambil_satuan = $this->_client->request(
            'DELETE',
            'satuan/'.$id_satuan,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>