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
            'attr' => ['id' => 'formSubMenu', 'name'=>'formSubMenu'],
            'form_hapus_submenu' => ['id' => 'formHapusSubmenu', 'name'=>'formHapusSubmenu', 'class' => 'btn btn-block'],
            'hidden_submenu_id' => ['name' => 'submenu_id', 'id'=>'submenu_id', 'type'=> 'hidden'],
            'hidden_hapus_id_submenu' => ['name' => 'hidden_hapus_id_submenu', 'id'=>'hidden_hapus_id_submenu', 'type'=> 'hidden'],
            'hidden_judul_old' => ['name' => 'judul_old', 'id'=>'judul_old', 'type'=> 'hidden'],
            'hidden_url_old' => ['name' => 'url_old', 'id'=>'url_old', 'type'=> 'hidden'],
            'cecc' =>[
                'name' => 'is_active',
                'id'=>'is_active',
                'type'=> 'checkbox',
                'value'=> '1',
                'class'=> 'form-check-input',
                'checked' => ''
            ],
            'judul' => [
                'type' => 'text',
                'name' => 'judul',
                'id' => 'judul',
                'class' => 'form-control judul'
            ],
            'url' => [
                'type' => 'text',
                'name' => 'url',
                'id' => 'url',
                'class' => 'form-control url'
            ],
            'icon' => [
                'type' => 'text',
                'name' => 'icon',
                'id' => 'icon',
                'class' => 'form-control'
            ],
            'ceccE' =>[
                'name' => 'is_activeE',
                'id'=>'is_activeE',
                'type'=> 'checkbox',
                'value'=> '1',
                'class'=> 'form-check-input is_activeE'
            ],
            'judulE' => [
                'type' => 'text',
                'name' => 'judulE',
                'id' => 'judulE',
                'class' => 'form-control'
            ],
            'urlE' => [
                'type' => 'text',
                'name' => 'urlE',
                'id' => 'urlE',
                'class' => 'form-control url'
            ],
            'iconE' => [
                'type' => 'text',
                'name' => 'iconE',
                'id' => 'iconE',
                'class' => 'form-control'
            ]
        ];
        
        tampilan_admin('admin/admin-submenu/v_submenu', 'admin/admin-submenu/v_js_submenu', $data);
    }
    

    public function tambah(){

        $validasi = $this->modelSubmenu->tambahSubmenu();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_submenu',  $validasi);
            return redirect()->to(base_url('/pengaturan/submenu'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_submenu', 'Submenu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/submenu'));
        }

    }

    public function ubah(){
        $validasi = $this->modelSubmenu->ubahSubmenu();

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_submenu',  $validasi);    
            return redirect()->to(base_url('/pengaturan/submenu'));
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
