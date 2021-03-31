<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelRole;
class Role extends BaseController{

    public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelRole = new ModelRole();
        
	}

	protected $helpers = ['form', 'url', 'kpos', 'cookie'];

	public function index(){
		
		
        $data = [
            'title' => ucfirst('Role'),
            'nama_menu_utama' => ucfirst('Role'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'role' => $this->modelRole->ambilRole(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-role'],
            'form_edit' => ['id' => 'form-edit-role'],
            'form_hapus' => ['id' => 'form-hapus-role', 'class' => 'btn btn-block'],
            'hapus_id_role' => ['name' => 'hapus_id_role', 'id'=>'hapus_id_role', 'type'=> 'hidden']
        ];
		
        tampilan_admin('admin/admin-role/v_role', 'admin/admin-role/v_js_role', $data);
    }
    
    public function tambah(){

        $validasi = $this->modelRole->tambahRole();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_role',  $validasi);
            return redirect()->to(base_url('/pengaturan/role'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_role', 'Role baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/role'));
        }
            
    }

    public function ubah(){
       
        $validasi = $this->modelRole->ubahRole();
        $old = [
            'id_role' => $this->request->getPost('edit_id_role')
        ];
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_role',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/pengaturan/role'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_edit_role', 'Role berhasil diubah!');
            return redirect()->to(base_url('/pengaturan/role'));
        }
    }


    public function hapus(){
        $this->modelRole->hapusRole();
        $this->session->setFlashdata('pesan_hapus_role', 'Role berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/role'));
    }

}
