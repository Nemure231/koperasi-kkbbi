<?php namespace App\Models;
use CodeIgniter\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

 
class ModelKaryawan extends Model{

    public function __construct(){
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->_client = new Client([
			'base_uri' => getenv('restserver.url'),
		]);
    }

    public function ambilKaryawan(){
        $ambil_token = get_cookie('jwt_token');
        $res_karyawan = json_encode(['data' => '']);
        try {
            $respon_ambil_karyawan = $this->_client->request(
                'GET',
                'karyawan',
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_karyawan = $respon_ambil_karyawan->getBody();
        } catch (ClientException $e) {
            
        }

        $karyawan = json_decode($res_karyawan, true);
        return $karyawan['data'];
    }

    // public function ambilGambarKaryawan($gambar){
    //     // $gam = pathinfo($gambar, PATHINFO_FILENAME);
    //     $ambil_token = get_cookie('jwt_token');
    //     $res_gambar = json_encode(['data' => '']);
    //     try {
    //         $respon_ambil_gambar = $this->_client->request(
    //             'GET',
    //             'karyawan/gambar/'.$gambar,
    //             ['headers' => 
    //                 [
    //                 'Authorization' => "Bearer {$ambil_token}"
    //                 ]
    //             ]
    //         );
    //         $res_gambar = $respon_ambil_gambar->getBody();
    //     } catch (ClientException $e) {
            
    //     }

    //     $karyawan = json_decode($res_gambar, true);
    //     return $karyawan['data'];
        
    // }


    public function tambahKaryawan(){
        
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $gambar = $this->request->getFile('gambar');
            $cek_path = $gambar->getTempName();

            if(!$cek_path){
                $path = FCPATH.'admin/assets/profile/default.png';
                $nama = 'default.png';
            }else{
                $nama = $gambar->getName();
                $path = $gambar->getTempName();
            }

            $respon_ambil_karyawan = $this->_client->request(
                'POST',
                'karyawan',
                [
                    'headers' => [
                            'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'multipart' => [
                        [
                            'name'     => 'name',
                            'contents' => htmlspecialchars($this->request->getPost('name'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'email',
                            'contents' =>  htmlspecialchars($this->request->getPost('email'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'password',
                            'contents' =>  $this->request->getPost('password')
                        ],
                        [
                            'name'     => 'password_confirmation',
                            'contents' => $this->request->getPost('password_confirmation')
                        ],
                        [
                            'name'     => 'telepon',
                            'contents' => $this->request->getPost('telepon')
                        ],
                        [
                            'name'     => 'alamat',
                            'contents' =>  htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'status',
                            'contents' => $this->request->getPost('status')
                        ],
                        [
                            'name'     => 'role_id',
                            'contents' => $this->request->getPost('role_id')
                        ],
                        [
                            'name'     => 'gambar',
                            'contents' => Psr7\Utils::tryFopen($path, 'r'),
                            'filename' => $nama
                        ],
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_karyawan, true);
        } catch (ClientException $e) {
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahKaryawan(){
        $id_karyawan = $this->request->getPost('edit_id_karyawan');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $gambar = $this->request->getFile('edit_gambar');
            $cek_path = $gambar->getTempName();

            if(!$cek_path){
                $path = FCPATH.'admin/assets/profile/default.png';
                $nama = 'default.png';
            }else{
                $nama = $gambar->getName();
                $path = $gambar->getTempName();
            }
            $respon_ambil_karyawan = $this->_client->request(
                'POST',
                'karyawan/'.$id_karyawan,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'multipart' => [
                        [
                            'name'     => '_method',
                            'contents' => 'PUT'
                        ],
                        [
                            'name'     => 'name',
                            'contents' =>  htmlspecialchars($this->request->getPost('edit_name'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'email',
                            'contents' => htmlspecialchars($this->request->getPost('edit_email'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'telepon',
                            'contents' => $this->request->getPost('edit_telepon')
                        ],
                        [
                            'name'     => 'alamat',
                            'contents' => htmlspecialchars($this->request->getPost('edit_alamat'), ENT_QUOTES)
                        ],
                        [
                            'name'     => 'role_id',
                            'contents' => $this->request->getPost('edit_role_id')
                        ],
                        [
                            'name'     => 'status',
                            'contents' => $this->request->getPost('edit_status')
                        ],
                        [
                            'name'     => 'gambar',
                            'contents' => Psr7\Utils::tryFopen($path, 'r'),
                            'filename' => $nama
                        ]
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_karyawan, true);
        } catch (ClientException $e) {
            // echo Psr7\Message::toString($e->getRequest());
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }

    public function hapusKaryawan(){
        $id_karyawan = $this->request->getPost('hapus_id_karyawan');
        $ambil_token = get_cookie('jwt_token');
        $respon_ambil_user = $this->_client->request(
            'DELETE',
            'karyawan/'.$id_karyawan,
            ['headers' => 
                [
                'Authorization' => "Bearer {$ambil_token}"
                ]
            ],
        );

        return true;
    }



    
}

?>