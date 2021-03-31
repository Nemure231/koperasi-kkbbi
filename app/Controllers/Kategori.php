<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelKategori;
class Kategori extends BaseController
{
	
	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelKategori = new ModelKategori();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];



    public function index(){

        $data = [
            'title' =>  ucfirst('Daftar Kategori'),
            'nama_menu_utama' => ucfirst('Gudang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'kategori'=>$this->modelKategori->ambilKategori(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-kategori'],
            'form_edit' =>  ['id' => 'form-edit-kategori'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_id_kategori' => ['name' => 'hapus_id_kategori', 'id'=>'hapus_id_kategori', 'type'=> 'hidden'],
        ];
        tampilan_admin('admin/admin-kategori/v_kategori', 'admin/admin-kategori/v_js_kategori', $data);
     
    }

    public function tambah(){

        $validasi = $this->modelKategori->tambahKategori();

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_kategori',  $validasi);
            return redirect()->to(base_url('/suplai/kategori'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_kategori', 'Kategori baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/kategori'));
        }

    }

    public function ubah(){
        
        
        $validasi = $this->modelKategori->ubahKategori();

        $old = [
            'id_kategori' => $this->request->getPost('edit_id_kategori')
        ];

                        
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_kategori',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/suplai/kategori'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_kategori', 'Kategori berhasil diubah!');
            return redirect()->to(base_url('/suplai/kategori'));
        }
    }


    public function hapus(){
        
            $this->modelKategori->hapusKategori();
            $this->session->setFlashdata('pesan_hapus_kategori', 'Kategori berhasil dihapus!');
            return redirect()->to(base_url('/suplai/kategori'));
        
        
        
    
    }

}
