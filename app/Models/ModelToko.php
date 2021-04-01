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

   

    public function ubahToko(){
        $id_toko = $this->request->getPost('edit_id_toko');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $toko = $this->request->getFile('logo_toko');
            $koperasi = $this->request->getFile('logo_koperasi');
            
            $cek_toko = $toko->getTempName();
            $cek_koperasi = $koperasi->getTempName();

            if(!$cek_toko){
                $path_logo_toko = FCPATH.'admin/assets/profile/default.png';
                $nama_logo_toko = 'default.png';
            }else{
                $nama_logo_toko = $toko->getName();
                $path_logo_toko = $toko->getTempName();
                
            }

            if(!$cek_koperasi){
                $path_logo_koperasi = FCPATH.'admin/assets/profile/default.png';
                $nama_logo_koperasi = 'default.png';
            }else{
                $nama_logo_koperasi = $koperasi->getName();
                $path_logo_koperasi = $koperasi->getTempName();
            }

            $respon_ambil_toko = $this->_client->request(
                'POST',
                'tempat/toko/ubah/'.$id_toko,
                // .'?_method='.'PUT'
                // .'&nama_toko=' . htmlspecialchars($this->request->getPost('nama_toko'), ENT_QUOTES)
                // .'&telepon_toko='. htmlspecialchars($this->request->getPost('telepon_toko'), ENT_QUOTES)
                // .'&email_toko='. htmlspecialchars($this->request->getPost('email_toko'), ENT_QUOTES)
                // .'&alamat_toko='.htmlspecialchars($this->request->getPost('alamat_toko'), ENT_QUOTES),
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    // 'multipart/form-data' => [
                    //     '_method' => 'PUT',
                    //     'nama_toko' => htmlspecialchars($this->request->getPost('nama_toko'), ENT_QUOTES),
                    //     'telepon_toko' => htmlspecialchars($this->request->getPost('telepon_toko'), ENT_QUOTES),
                    //     'email_toko' => htmlspecialchars($this->request->getPost('email_toko'), ENT_QUOTES),
                    //     'alamat_toko' => htmlspecialchars($this->request->getPost('alamat_toko'), ENT_QUOTES)
                    // ],
                    'multipart' => [
                        [
                            'name'     => '_method',
                            'contents' => 'PUT'
                        ],
                        [
                            'name'     => 'nama_toko',
                            'contents' => htmlspecialchars($this->request->getPost('nama_toko'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'telepon_toko',
                            'contents' => htmlspecialchars($this->request->getPost('telepon_toko'), ENT_QUOTES),
                        ],
                        [
                            'name'     => 'email_toko',
                            'contents' => htmlspecialchars($this->request->getPost('email_toko'), ENT_QUOTES),
                        ],
                        [
                            'name'     => 'alamat_toko',
                            'contents' => htmlspecialchars($this->request->getPost('alamat_toko'), ENT_QUOTES),
                        ],
                        [
                            'name'     => 'logo_toko',
                            'contents' => Psr7\Utils::tryFopen($path_logo_toko, 'r'),
                            'filename' => $nama_logo_toko
                        ],
                        [
                            'name'     => 'logo_koperasi',
                            'contents' => Psr7\Utils::tryFopen($path_logo_koperasi, 'r'),
                            'filename' => $nama_logo_koperasi
                        ]
                        
                    ],

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