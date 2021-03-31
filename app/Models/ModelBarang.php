<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class ModelBarang extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }


    public function ambilBarang(){
        $ambil_token = get_cookie('jwt_token');
        $res_barang = json_encode(['data' => '']);
        try {
            $respon_ambil_barang = $this->_client->request(
                'GET',
                'suplai/barang',
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


    public function tambahBarang(){
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_barang = $this->_client->request(
                'POST',
                'suplai/barang/tambah'
                .'?nama_barang='. htmlspecialchars($this->request->getPost('nama_barang'), ENT_QUOTES)
                .'&kategori_id='.$this->request->getPost('kategori_id')
                .'&satuan_id='.$this->request->getPost('satuan_id')
                .'&merek_id='.$this->request->getPost('merek_id')
                .'&supplier_id='.$this->request->getPost('supplier_id')
                .'&harga_pokok='.$this->request->getPost('harga_pokok')
                .'&harga_konsumen='.$this->request->getPost('harga_konsumen')
                .'&harga_anggota='.$this->request->getPost('harga_anggota')
                .'&stok_barang='.$this->request->getPost('stok_barang'),

                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
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


    public function ubahBarang(){
        $id_barang =$this->request->getPost('edit_id_barang');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_merek = $this->_client->request(
                'PUT',
                'suplai/barang/ubah/'.$id_barang
                .'?nama_barang='. htmlspecialchars($this->request->getPost('edit_nama_barang'), ENT_QUOTES)
                .'&kategori_id='.$this->request->getPost('edit_kategori_id')
                .'&satuan_id='.$this->request->getPost('edit_satuan_id')
                .'&merek_id='.$this->request->getPost('edit_merek_id')
                .'&supplier_id='.$this->request->getPost('edit_supplier_id')
                .'&harga_pokok='.$this->request->getPost('edit_harga_pokok')
                .'&harga_konsumen='.$this->request->getPost('edit_harga_konsumen')
                .'&harga_anggota='.$this->request->getPost('edit_harga_anggota')
                .'&stok_barang='.$this->request->getPost('edit_stok_barang'),
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

    public function hapusBarang(){
        $id_barang = $this->request->getPost('hapus_id_barang');  
        $ambil_token = get_cookie('jwt_token');
       
        $respon_ambil_merek = $this->_client->request(
            'DELETE',
            'suplai/barang/hapus/'.$id_barang,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );
    }

    public function cariStok($min_stok){
        $ambil_token = get_cookie('jwt_token');
        $res_barang = json_encode(['data' => '']);
        try {
            $respon_ambil_barang = $this->_client->request(
                'GET',
                'suplai/stok/cari/'.$min_stok,
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

}

?>