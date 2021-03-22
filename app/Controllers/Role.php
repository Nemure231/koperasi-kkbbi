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
            'attr' => ['id' => 'formRole', 'name'=>'formRole'],
            'form_hapus_role' => ['id' => 'formHapusRole', 'name'=>'formHapusRole', 'class' => 'btn btn-block'],
            'hidden_role_id' => ['name' => 'role_id', 'id'=>'role_id', 'type'=> 'hidden'],
            'hidden_role_id_hapus' => ['name' => 'hidden_role_id_hapus', 'id'=>'hidden_role_id_hapus', 'type'=> 'hidden'],
            'hidden_old_role' => ['name' => 'old_role', 'id'=>'old_role', 'type'=> 'hidden'],
            'nama_role' => [
                'type' => 'text',
                'name' => 'role',
                'id' => 'role',
                'placeholder' => 'Nama role ....',
                'class' => 'form-control role'
            ],
            'roleE' => [
                'type' => 'text',
                'name' => 'roleE',
                'id' => 'roleE',
                'placeholder' => 'Nama role ....',
                'class' => 'form-control role'
            ],
        ];
		
        tampilan_admin('admin/admin-role/v_role', 'admin/admin-role/v_js_role', $data);
    }
    
    public function tambah(){

        $validasi = $this->modelRole->tambahRole();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_role',  $validasi);
            return redirect()->to(base_url('/pengaturan/role'));
        }else{
            $this->session->setFlashdata('pesan_role', 'Role baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/role'));
        }
            
    }

    public function ubah(){
       
        $validasi = $this->modelRole->ubahRole();

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_role',  $validasi);
            return redirect()->to(base_url('/pengaturan/role'));
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
