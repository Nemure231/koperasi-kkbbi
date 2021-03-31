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
			'base_uri' => 'http://localhost:8000/api/',
		]);
    }

    public function ambilKaryawan(){
        $ambil_token = get_cookie('jwt_token');
        $res_karyawan = json_encode(['data' => '']);
        try {
            $respon_ambil_karyawan = $this->_client->request(
                'GET',
                'tempat/karyawan',
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

    public function ambilGambarKaryawan($gambar){
        // $gam = pathinfo($gambar, PATHINFO_FILENAME);
        $ambil_token = get_cookie('jwt_token');
        $res_gambar = json_encode(['data' => '']);
        try {
            $respon_ambil_gambar = $this->_client->request(
                'GET',
                'tempat/karyawan/gambar/'.$gambar,
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
                    ]
                ]
            );
            $res_gambar = $respon_ambil_gambar->getBody();
        } catch (ClientException $e) {
            
        }

        $karyawan = json_decode($res_gambar, true);
        return $karyawan['data'];
        
    }


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
                'tempat/karyawan/tambah'
                .'?name='. htmlspecialchars($this->request->getPost('name'), ENT_QUOTES)
                .'&email='. htmlspecialchars($this->request->getPost('email'), ENT_QUOTES)
                .'&password='. $this->request->getPost('password')
                .'&password_confirmation='. $this->request->getPost('password_confirmation')
                .'&telepon='. $this->request->getPost('telepon')
                .'&alamat='. htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES)
                .'&status='. $this->request->getPost('status')
                .'&role_id='. $this->request->getPost('role_id'),
                [
                    'headers' => [
                            'Authorization' => "Bearer {$ambil_token}"
                    ],
                    'multipart' => [
                        [
                            'name'     => 'gambar',
                            // 'contents' => file_get_contents(FCPATH.'admin/assets/file_sementara/'.$gambar->getName()),
                            'contents' => Psr7\Utils::tryFopen($path, 'r'),
                            'filename' => $nama
                        ],
                        [
                            'name'     => 'FileInfo',
                            'contents' => json_encode(['jpg'])
                        ]
                    ]
                ],
            )->getBody();
            json_decode($respon_ambil_karyawan, true);
        } catch (ClientException $e) {
            $validasi = json_decode($e->getResponse()->getBody(), true);
        }

        return $result = $validasi['data'];
    }


    public function ubahKaryawan($nama_gambar){
        $id_karyawan = $this->request->getPost('edit_id_karyawan');
        $result = '';
        $validasi = array('data' => '');
        try {
            $ambil_token = get_cookie('jwt_token');
            $respon_ambil_karyawan = $this->_client->request(
                'PUT',
                'tempat/karyawan/ubah/'.$id_karyawan
                .'?name='. htmlspecialchars($this->request->getPost('edit_name'), ENT_QUOTES)
                .'&email='. htmlspecialchars($this->request->getPost('edit_email'), ENT_QUOTES)
                .'&telepon='. $this->request->getPost('edit_telepon')
                .'&alamat='. htmlspecialchars($this->request->getPost('edit_alamat'), ENT_QUOTES)
                .'&gambar='. $nama_gambar
                .'&role_id='. $this->request->getPost('edit_role_id')
                .'&status='. $this->request->getPost('edit_status'),
                ['headers' => 
                    [
                    'Authorization' => "Bearer {$ambil_token}"
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
            'tempat/karyawan/hapus/'.$id_karyawan,
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