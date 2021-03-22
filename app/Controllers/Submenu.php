<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSubmenu;
use App\Models\ModelMenuUtama;

class Submenu extends BaseController{

    public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelSubmenu = new ModelSubmenu();
        $this->modelMenuUtama= new ModelMenuUtama();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];


    public function index(){

        $data = [
            
            'title' => ucfirst('Submenu'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'mmenu' => $this->modelMenu->ambilMenu(),
            'menu_utama' => $this->modelMenuUtama->ambilMenuUtamaUntukSubmenu(),
            'submenu'=> $this->modelSubmenu->ambilSubmenu(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah'],
            'form_edit' => ['id' => 'form-edit'],
            'form_hapus' => ['id' => 'form-hapus', 'class' => 'btn btn-block'],
            'edit_id_submenu' => ['name' => 'edit_id_submenu', 'id'=>'edit_id_submenu', 'type'=> 'hidden'],
            'hapus_id_submenu' => ['name' => 'hapus_id_submenu', 'id'=>'hapus_id_submenu', 'type'=> 'hidden'],
        ];
        
        tampilan_admin('admin/admin-submenu/v_submenu', 'admin/admin-submenu/v_js_submenu', $data);
    }
    

    public function tambah(){

        $validasi = $this->modelSubmenu->tambahSubmenu();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_submenu',  $validasi);
            return redirect()->to(base_url('/pengaturan/submenu'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_submenu', 'Submenu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/submenu'));
        }

    }

    public function ubah(){
        $validasi = $this->modelSubmenu->ubahSubmenu();

        $old = [
            'id_submenu' => $this->request->getPost('edit_id_submenu'),
            'menu_id' => $this->request->getPost('edit_menu_id'),
            'menu_utama_id' => $this->request->getPost('edit_menu_utama_id')
        ];

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_submenu',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);        
            return redirect()->to(base_url('/pengaturan/submenu'))->withInput();;
        }else{
            $this->session->setFlashdata('pesan_submenu', 'Submenu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/submenu'));
        }       
    }


    public function hapus(){
        $this->modelSubmenu->hapusSubmenu();
        $this->session->setFlashdata('pesan_hapus_submenu', 'Submenu berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/submenu'));
    }
	
}
?>
