<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;


class ModelKodeTransaksi extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function ambilKodeTransaksi(){
        $ambil_token = get_cookie('jwt_token');
        $res_kode = json_encode(['data' => '']);
        try {
            $respon_ambil_kode = $this->_client->request(
                'GET',
                'kode/transaksi',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_kode = $respon_ambil_kode->getBody();
        } catch (ClientException $e) {
            
        }

        $kode = json_decode($res_kode, true);
        return $kode['data'];
    }


    public function ubahKodeTransaksi(){
        $id_kode_transaksi = $this->request->getPost('edit_id_kode_transaksi');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_kode = $this->_client->request(
                'PUT',
                'kode/transaksi/'.$id_kode_transaksi,
                    [
                        'headers' => [
                            'Authorization' => "Bearer {$ambil_token}"
                        ],
                        'form_params' => [
                            'huruf_kode_transaksi' => htmlspecialchars($this->request->getPost('edit_huruf_kode_transaksi'), ENT_QUOTES),
                            'jumlah_kode_transaksi' => htmlspecialchars($this->request->getPost('edit_jumlah_kode_transaksi'), ENT_QUOTES)
                        ]
                ],
            )->getBody();
            json_decode($respon_ambil_kode, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
                

    }



}

?>