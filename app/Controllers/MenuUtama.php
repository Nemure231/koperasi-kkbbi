<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelMenuUtama;

class MenuUtama extends BaseController{

    public function __construct(){

        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelMenuUtama =  new ModelMenuUtama();
	}

	protected $helpers = ['form', 'url', 'kpos', 'cookie'];

	public function index(){

        $data = [
            'title' => ucfirst('Menu Utama'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'mmenu' =>  $this->modelMenu->ambilMenu(),
            'menu_utama' => $this->modelMenuUtama->ambilMenuUtama(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-menu-utama'],
            'form_edit' => ['id' => 'form-edit-menu-utama'],
            'form_hapus' => ['class' => 'btn btn-block'],
            'hapus_id_menu_utama' => ['name' => 'hapus_id_menu_utama', 'id'=>'hapus_id_menu_utama', 'type'=> 'hidden'],
        ];
        tampilan_admin('admin/admin-menu-utama/v_menu_utama', 'admin/admin-menu-utama/v_js_menu_utama', $data);
    }
    

    public function tambah(){
        $validasi = $this->modelMenuUtama->tambahMenuUtama();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_menu_utama',  $validasi);
            return redirect()->to(base_url('/pengaturan/menu_utama'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_menu_utama', 'Menu utama baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu_utama'));
        }
    }

    public function ubah(){

        $validasi = $this->modelMenuUtama->ubahMenuUtama();
        $old = [
            'id_menu_utama' => $this->request->getPost('edit_id_menu_utama'),
            'menu_id' => $this->request->getPost('edit_menu_id'),
        ];
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_menu_utama',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);  
            return redirect()->to(base_url('/pengaturan/menu_utama'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_edit_menu_utama', 'Menu utama baru berhasil diubah!');
            return redirect()->to(base_url('/pengaturan/menu_utama'));
        }
    
    }

    public function hapus(){

        $this->modelMenuUtama->hapusMenuUtama();
        $this->session->setFlashdata('pesan_hapus_menu_utama', 'Menu utama berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/menu_utama'));
        
    
    }

   

	
}
?>
