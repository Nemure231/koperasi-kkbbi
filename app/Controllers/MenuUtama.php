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

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function index(){

        $data = [
            'title' => ucfirst('Menu Utama'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'mmenu' =>  $this->modelMenu->ambilMenu(),
            'menu_utama' => $this->modelMenuUtama->ambilMenuUtama(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'formMenuUtama'],
            'form_edit' => ['id' => 'formEditMenuUtama'],
            'form_hapus' => ['class' => 'btn btn-block'],
            'hidden_menu_utama_id' => ['name' => 'hidden_menu_utama_id', 'id'=>'hidden_menu_utama_id', 'type'=> 'hidden'],
            'hidden_hapus_menu_utama_id' => ['name' => 'hidden_hapus_menu_utama_id', 'id'=>'hidden_hapus_menu_utama_id', 'type'=> 'hidden'],
            'hidden_old_menu_utama' => ['name' => 'old_nama_menu_utama', 'id'=>'old_nama_menu_utama', 'type'=> 'hidden'],
            'nama_menu_utama' => [
                'type' => 'text',
                'name' => 'nama_menu_utama',
                'id' => 'nama_menu_utama',
                // 'placeholder' => 'Nama menu utama ....',
                'class' => 'form-control'
            ],
            'ikon_menu_utama' => [
                'type' => 'text',
                'name' => 'ikon_menu_utama',
                'id' => 'ikon_menu_utama',
                // 'placeholder' => 'Ikon menu utama ....',
                'class' => 'form-control'
            ],
            'nama_menu_utamaE' => [
                'type' => 'text',
                'name' => 'nama_menu_utamaE',
                'id' => 'nama_menu_utamaE',
                // 'placeholder' => 'Nama menu utama ....',
                'class' => 'form-control menu'
            ],
            'ikon_menu_utamaE' => [
                'type' => 'text',
                'name' => 'ikon_menu_utamaE',
                'id' => 'ikon_menu_utamaE',
                // 'placeholder' => 'Ikon menu utama ....',
                'class' => 'form-control'
         ],

        ];
        tampilan_admin('admin/admin-menu-utama/v_menu_utama', 'admin/admin-menu-utama/v_js_menu_utama', $data);
    }
    

    public function tambah(){
        $validasi = $this->modelMenuUtama->tambahMenuUtama();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_menu_utama',  $validasi);
            return redirect()->to(base_url('/pengaturan/menu_utama'));
        }else{
            $this->session->setFlashdata('pesan_menu_utama', 'Menu utama baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu_utama'));
        }
    }

    public function ubah(){

        $validasi = $this->modelMenuUtama->ubahMenuUtama();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_menu_utama',  $validasi);
            return redirect()->to(base_url('/pengaturan/menu_utama'));
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
