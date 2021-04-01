<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class Menu extends BaseController{

    public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
	}

	protected $helpers = ['form', 'url', 'kpos', 'cookie'];

	public function index(){

        $data = [
        
            'title' => ucfirst('Menu'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'mmenu' => $this->modelMenu->ambilMenu(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-menu'],
            'form_edit' => ['id' => 'form-edit-menu'],
            'form_hapus' => ['class' => 'btn btn-block'],
            'hapus_id_menu' => ['name' => 'hapus_id_menu', 'id'=>'hapus_id_menu', 'type'=> 'hidden']

        ];
        tampilan_admin('admin/admin-menu/v_menu', 'admin/admin-menu/v_js_menu', $data);
    }
    

    public function tambah(){

        $validasi = $this->modelMenu->tambahMenu();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_menu',  $validasi);
            return redirect()->to(base_url('/pengaturan/menu'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_menu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu'));
        }
    }

    public function ubah(){
        $validasi = $this->modelMenu->ubahMenu();

        $old = [
            'id_menu' => $this->request->getPost('edit_id_menu')
        ];

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_menu',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/pengaturan/menu'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_edit_menu', 'Menu berhasil diubah!');
            return redirect()->to(base_url('/pengaturan/menu'));
        }
      
    }

    public function hapus(){
        $this->modelMenu->hapusMenu();
        $this->session->setFlashdata('pesan_hapus_menu', 'Menu berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/menu'));
        
    
    }

	
}
?>
