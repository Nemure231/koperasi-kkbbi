<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelKodeBarang extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }


    public function ambilKodeBarang(){
        $ambil_token = get_cookie('jwt_token');
        $res_user = json_encode(['users' => '']);
        try {
            $respon_ambil_user = $this->_client->request(
                'GET',
                'kode/barang',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_user = $respon_ambil_user->getBody();
        } catch (ClientException $e) {
            
        }

        $user = json_decode($res_user, true);
        return $user['data'];
    }


    public function ubahKodeBarang(){
        $id_kode_barang = $this->request->getPost('edit_id_kode_barang');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_user = $this->_client->request(
                'PUT',
                'kode/barang/'.$id_kode_barang,
                    [
                        'headers' => [
                            'Authorization' => "Bearer {$ambil_token}"
                        ],
                        'form_params' => [
                            'huruf_kode_barang' => htmlspecialchars($this->request->getPost('edit_huruf_kode_barang'), ENT_QUOTES),
                            'jumlah_kode_barang' => htmlspecialchars($this->request->getPost('edit_jumlah_kode_barang'), ENT_QUOTES)
                        ]
                ],
            )->getBody();
            json_decode($respon_ambil_user, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
                

    }



}

?>