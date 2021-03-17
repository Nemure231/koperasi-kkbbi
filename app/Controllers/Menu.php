<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class Menu extends BaseController{

    public function __construct(){
        
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        $data = [
        
            'title' => ucfirst('Menu'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'mmenu' => $this->modelMenu->ambilMenu(),
            'validation' => $this->validation,
            'session' => $this->session,
            'attr' => ['id' => 'formMenu', 'name'=>'formMenu'],
            'form_edit_menu' => ['id' => 'formEditMenu', 'name'=>'formEditMenu'],
            'form_hapus_menu' => ['id' => 'formHapusMenu', 'name'=>'formHapusMenu', 'class' => 'btn btn-block'],
            'hidden_menu_id' => ['name' => 'hidden_menu_id', 'id'=>'hidden_menu_id', 'type'=> 'hidden'],
            'hidden_hapus_menu_id' => ['name' => 'hidden_hapus_menu_id', 'id'=>'hidden_hapus_menu_id', 'type'=> 'hidden'],
            'hidden_old_menu' => ['name' => 'old_menu', 'id'=>'old_menu', 'type'=> 'hidden'],
            'menunu' => [
                'type' => 'text',
                'name' => 'menu',
                'id' => 'menu',
                'placeholder' => 'Nama menu ....',
                'class' => 'form-control menu'
            ],
            'menuE' => [
                'type' => 'text',
                'name' => 'menuE',
                'id' => 'menuE',
                'placeholder' => 'Nama menu ....',
                'class' => 'form-control menu'
            ]

        ];
        tampilan_admin('admin/admin-menu/v_menu', 'admin/admin-menu/v_js_menu', $data);
    }
    

    public function tambah(){

        $validasi = $this->modelMenu->tambahMenu();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_menu',  '<div class="errors">'.$validasi['nama_menu'][0].'</div>');
            return redirect()->to(base_url('/pengaturan/menu'));
        }else{
            $this->session->setFlashdata('pesan_menu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu'));
        }
    }

    public function ubah(){
        $id_menu = $this->request->getPost('hidden_menu_id');
        $validasi = $this->modelMenu->ubahMenu($id_menu);

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_menu',  '<div class="errors">'.$validasi['nama_menu'][0].'</div>');
            return redirect()->to(base_url('/pengaturan/menu'));
        }else{
            $this->session->setFlashdata('pesan_edit_menu', 'Menu baru berhasil diubah!');
            return redirect()->to(base_url('/pengaturan/menu'));
        }
      
    }

    public function hapus(){
        $id_menu = $this->request->getPost('hidden_hapus_menu_id');
        $this->modelMenu->hapusMenu($id_menu);
        $this->session->setFlashdata('pesan_hapus_menu', 'Menu berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/menu'));
        
    
    }

	
}
?>
