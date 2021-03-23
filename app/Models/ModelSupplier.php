<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class ModelSupplier extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }


    public function ambilSupplier(){
        $ambil_token = get_cookie('jwt_token');
        $res_supplier = json_encode(['data' => '']);
        try {
            $respon_ambil_supplier = $this->_client->request(
                'GET',
                'suplai/supplier',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_supplier = $respon_ambil_supplier->getBody();
        } catch (ClientException $e) {
            
        }

        $merek = json_decode($res_supplier, true);
        return $merek['data'];
    }


    public function tambahSupplier(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_supplier = $this->_client->request(
                'POST',
                'suplai/supplier/tambah'
                .'?nama_supplier='. htmlspecialchars($this->request->getPost('nama_supplier'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_supplier, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahSupplier(){
        $id_supplier = $this->request->getPost('edit_id_supplier');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_supplier = $this->_client->request(
                'PUT',
                'suplai/supplier/ubah/'.$id_supplier
                .'?nama_supplier='. htmlspecialchars($this->request->getPost('edit_nama_supplier'), ENT_QUOTES),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_supplier, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusSupplier(){
        $id_supplier = $this->request->getPost('hapus_id_supplier');
        $ambil_token = get_cookie('jwt_token');

        $respon_ambil_supplier = $this->_client->request(
            'DELETE',
            'suplai/supplier/hapus/'.$id_supplier,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

}

?>