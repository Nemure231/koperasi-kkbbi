<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_user_menu;
use App\Models\Model_user_role;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelRole;
use App\Models\ModelKaryawan;

class Karyawan extends BaseController{

	public function __construct(){
        $this->model_user_role = new Model_user_role();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->modelRole = new ModelRole();
        $this->modelKaryawan = new ModelKaryawan();
		
	}
	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];

	public function index(){
	

        $data = [
            'title' => ucfirst('Daftar Karyawan'),
            'nama_menu_utama' => ucfirst('Karyawan'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'karyawan' => $this->modelKaryawan->ambilKaryawan(),
            'role' => $this->modelRole->ambilRole(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-karyawan'],
            'form_edit' =>  ['id' => 'form-edit-karyawan'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_id_karyawan' => ['name' => 'hapus_id_karyawan', 'id'=>'hapus_id_karyawan', 'type'=> 'hidden'],
        ];
        tampilan_admin('admin/admin-karyawan/v_karyawan', 'admin/admin-karyawan/v_js_karyawan', $data);
    }


    public function tambah(){

            $validasi_gambar = '';
            if(!$this->validate([
                'gambar' => [
                    'label'  => 'Gambar',
                    'rules'  => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        //'uploaded' => 'Sampul buku harus dipilih!',
                        'max_size' => 'Ukuran gambar tidak boleh lebih dari 1MB!',
                        'is_image' => 'Format file yang anda upload bukan gambar!',
                        'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
                    ]
                ]


            ])) {
                $validasi_gambar = $this->validation->getError('gambar');

            }

                $sampul_buku = $this->request->getFile('gambar');
                if($sampul_buku->getError() == 4){
                    $nama_gambar = 'default.png';
                }else{
                    ///pindahkan gambar
                    $nama_gambar = $sampul_buku->getRandomName();
                    $sampul_buku->move('admin/assets/profile/', $nama_gambar);
                    ///ambil namam gambar
                }
                
               
                $validasi =  $this->modelKaryawan->tambahKaryawan($nama_gambar);
                if($validasi){
                    $this->session->setFlashdata('pesan_validasi_tambah_karyawan',  $validasi);
                    $this->session->setFlashdata('pesan_validasi_tambah_karyawan_gambar',  $validasi_gambar);
                    return redirect()->to(base_url('/tempat/karyawan'))->withInput();
                }else{
                    $this->session->setFlashdata('pesan', 'Karyawan baru berhasil ditambahkan!');
                    return redirect()->to(base_url('/tempat/karyawan'));
                }
            
    }

    public function ubah(){
            $validasi_edit_gambar = '';
            if(!$this->validate([
                'edit_gambar' => [
                    'label'  => 'Gambar',
                    'rules'  => 'max_size[edit_gambar,1024]|is_image[edit_gambar]|mime_in[edit_gambar,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        //'uploaded' => 'Sampul buku harus dipilih!',
                        'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
                        'is_image' => 'Format file yang anda upload bukan gambar!',
                        'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
                    ]
                ]

            ])) {
                
                $validasi_edit_gambar = $this->validation->getError('edit_gambar');

            }

                $foto = $this->request->getFile('edit_gambar');

                //cek gambar aapakah tetap gambar lama
                if($foto->getError() == 4){
                    $nama_foto = $this->request->getPost('edit_gambar_lama');
                }else{
                    $nama_foto = $foto->getRandomName();
                    $foto->move('admin/assets/profile/', $nama_foto);
                    //hapus file lama
                    unlink('admin/assets/profile/'. $this->request->getPost('edit_gambar_lama'));
                }
                
                $validasi = $this->modelKaryawan->ubahKaryawan($nama_foto);
                $old = [
                    'id_karyawan' => $this->request->getPost('edit_id_karyawan'),
                    'role_id' => $this->request->getPost('edit_role_id'),
                ];
                if($validasi){
                    $this->session->setFlashdata('pesan_validasi_edit_karyawan',  $validasi);
                    $this->session->setFlashdata('old_edit_input',  $old);
                    $this->session->setFlashdata('pesan_validasi_edit_karyawan_gambar',  $validasi_edit_gambar);
                    return redirect()->to(base_url('/tempat/karyawan'))->withInput();
                }else{
                    $this->session->setFlashdata('pesan', 'Karyawan berhasil diubah!');
                    return redirect()->to(base_url('/tempat/karyawan'));
                }
             
    }

  
    public function hapus(){
        $user_id = $this->request->getPost('hidden_id_user');
            $hapus = $this->model_user->asArray()->find($user_id);
            if($hapus['gambar'] != 'default.png'){
                unlink('admin/assets/profile/'. $hapus['gambar']);
            }
            $this->model_user->HapusKaryawan($user_id);
            $this->session->setFlashdata('hapus_karyawan', 'Karyawan berhasil dihapus!');
            return redirect()->to(base_url('/tempat/karyawan'));


    
    }


   
}
?>