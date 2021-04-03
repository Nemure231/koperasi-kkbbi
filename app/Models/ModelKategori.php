<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelKategori extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function ambilKategori(){
        $ambil_token = get_cookie('jwt_token');
        $res_kategori = json_encode(['data' => '']);
        try {
            $respon_ambil_kategori = $this->_client->request(
                'GET',
                'kategori',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_kategori = $respon_ambil_kategori->getBody();
        } catch (ClientException $e) {
            
        }

        $kategori = json_decode($res_kategori, true);
        return $kategori['data'];
    }


    public function tambahKategori(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_kategori = $this->_client->request(
                'POST',
                'kategori',
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_kategori' => htmlspecialchars($this->request->getPost('nama_kategori'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_kategori, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahKategori(){
        $id_kategori = $this->request->getPost('edit_id_kategori');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_kategori = $this->_client->request(
                'PUT',
                'kategori/'.$id_kategori,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_kategori' => htmlspecialchars($this->request->getPost('edit_nama_kategori'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_kategori, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusKategori(){
        $id_kategori = $this->request->getPost('hapus_id_kategori');
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_kategori = $this->_client->request(
            'DELETE',
            'kategori/'.$id_kategori,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>