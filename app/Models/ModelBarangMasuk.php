<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class ModelBarangMasuk extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }

    public function ambilBarangDanSupplier(){
        $ambil_token = get_cookie('jwt_token');
        $res_barang = json_encode(['data' => '']);
        try {
            $respon_ambil_barang = $this->_client->request(
                'GET',
                'barang_masuk/ambil-barang-dan-supplier',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_barang = $respon_ambil_barang->getBody();
        } catch (ClientException $e) {
    
        }

        $barang = json_decode($res_barang, true);
        return $barang;
    }

    public function ambilHarga(){
        $id_barang = $this->request->getPost('barang_id');
        $ambil_token = get_cookie('jwt_token');
        $res_barang = json_encode(['data' => '']);
        try {
            $respon_ambil_barang = $this->_client->request(
                'GET',
                'barang_masuk/ambil-harga/'.$id_barang,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                ]
            );
            $res_barang = $respon_ambil_barang->getBody();
        } catch (ClientException $e) {
    
        }

        $barang = json_decode($res_barang, true);
        return $barang;
    }


    public function ambilBarangUntukBarangMasuk(){
        $ambil_token = get_cookie('jwt_token');
        $res_barang = json_encode(['data' => '']);
        try {
            $respon_ambil_barang = $this->_client->request(
                'GET',
                'barang_masuk/untuk-barang-masuk',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_barang = $respon_ambil_barang->getBody();
        } catch (ClientException $e) {
            
        }

        $barang = json_decode($res_barang, true);
        return $barang['data'];
    }

    public function tambahBarangDariBarangMasuk(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_barang = $this->_client->request(
                'POST',
                'barang_masuk/tambah/dari-barang-masuk',
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'nama_barang' => htmlspecialchars($this->request->getPost('nama_barang'), ENT_QUOTES),
                        'satuan_id' => htmlspecialchars($this->request->getPost('satuan_id'), ENT_QUOTES),
                        'merek_id' => htmlspecialchars($this->request->getPost('merek_id'), ENT_QUOTES),
                        'kategori_id' => htmlspecialchars($this->request->getPost('kategori_id'), ENT_QUOTES),
                        'nama_supplier' => htmlspecialchars($this->request->getPost('nama_supplier'), ENT_QUOTES)
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_barang, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function tambahBarangMasuk(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_barang = $this->_client->request(
                'POST',
                'barang_masuk',
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'form_params' => [
                        'barang_id' => $this->request->getPost('barang_id'),
                        'supplier_id' => $this->request->getPost('pengirim_barang_id'),
                        'kuantitas' => $this->request->getPost('jumlah_barang_masuk'),
                        'harga_pokok' => $this->request->getPost('harga_pokok')
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_barang, true);
        } catch (ServerException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
        }

        return $result = $validasi['data'];
    }

}

?>