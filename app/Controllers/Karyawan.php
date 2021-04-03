<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelRole;
use App\Models\ModelKaryawan;

class Karyawan extends BaseController{

	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelRole = new ModelRole();
        $this->modelKaryawan = new ModelKaryawan();
		
	}
	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

	public function index(){
	
        $karyawan = $this->modelKaryawan->ambilKaryawan();

        $data = [
            'title' => ucfirst('Daftar Karyawan'),
            'nama_menu_utama' => ucfirst('Karyawan'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'karyawan' => $karyawan,
            'role' => $this->modelRole->ambilRole(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-karyawan'],
            'form_edit' =>  ['id' => 'form-edit-karyawan'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_gambar' =>  ['id' => 'hapus_gambar', 'name' => 'hapus_gambar', 'type' => 'hidden'],
            'hapus_id_karyawan' => ['name' => 'hapus_id_karyawan', 'id'=>'hapus_id_karyawan', 'type'=> 'hidden'],
        ];
        tampilan_admin('admin/admin-karyawan/v_karyawan', 'admin/admin-karyawan/v_js_karyawan', $data);
    }


    public function tambah(){
        $validasi =  $this->modelKaryawan->tambahKaryawan();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_karyawan',  $validasi);
            return redirect()->to(base_url('/tempat/karyawan'))->withInput();
        }else{
            $this->session->setFlashdata('pesan', 'Karyawan baru berhasil ditambahkan!');
            return redirect()->to(base_url('/tempat/karyawan'));
        }
            
    }

    public function ubah(){
                
        $validasi = $this->modelKaryawan->ubahKaryawan();
        $old = [
            'id' => $this->request->getPost('edit_id_karyawan'),
            'role_id' => $this->request->getPost('edit_role_id'),
            'gambar'  => $this->request->getPost('edit_gambar_lama'),
            'url_gambar' => $this->request->getPost('edit_url_gambar'),
            'status' => $this->request->getPost('edit_status_lama')
        ];
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_karyawan',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/tempat/karyawan'))->withInput();
        }else{
            $this->session->setFlashdata('pesan', 'Karyawan berhasil diubah!');
            return redirect()->to(base_url('/tempat/karyawan'));
        }  
    }

    public function hapus(){ 
        $model = $this->modelKaryawan->hapusKaryawan();
        $this->session->setFlashdata('hapus_karyawan', 'Karyawan berhasil dihapus!');
        return redirect()->to(base_url('/tempat/karyawan'));


    
    }
}
?>