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
            'form_tambah_kategori' => ['id' => 'formTambahKategori', 'name'=>'formTambahKategori'],
            'form_edit_kategori' =>  ['id' => 'formEditKategori', 'name'=>'formEditKategori'],
            'form_hapus_kategori' =>  ['id' => 'formHapusKategori', 'name'=>'formHapusKategori', 'class' => 'btn btn-block'],
            'hidden_id_kategori' => ['name' => 'id_kategoriE', 'id'=>'id_kategoriE', 'type'=> 'hidden'],
            'hidden_id_kategoriH' => ['name' => 'id_kategoriH', 'id'=>'id_kategoriH', 'type'=> 'hidden'],
            'hidden_old_kategori' => ['name' => 'old_nama_kategori', 'id'=>'old_nama_kategori', 'type'=> 'hidden'],
            'hidden_old_kode_kategori' => ['name' => 'old_kode_kategori', 'id'=>'old_kode_kategori', 'type'=> 'hidden'],
            // 'edit_kode_kategori' => [
            //     'type' => 'text',
            //     'name' => 'edit_kode_kategori',
            //     'id' => 'edit_kode_kategori',
            //     'class' => 'form-control'
            // ],
            'input_kategori' => [
                'type' => 'text',
                'name' => 'nama_kategori',
                'class' => 'form-control'
                
            ],
            // 'input_kode_kategori' => [
            //     'type' => 'text',
            //     'name' => 'kode_kategori',
            //     'class' => 'form-control'
                
            // ],
            'input_kategoriE' => [
                'type' => 'text',
                'name' => 'edit_nama_kategori',
                'id' => 'edit_nama_kategori',
                'class' => 'form-control'
                
            ]

            
        ];
        tampilan_admin('admin/admin-kategori/v_kategori', 'admin/admin-kategori/v_js_kategori', $data);
     
    }

    public function tambah(){

    
        $validasi = $this->modelKategori->tambahKategori();

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_kategori',  $validasi);
            return redirect()->to(base_url('/suplai/kategori'));
        }else{
            $this->session->setFlashdata('pesan_kategori', 'Kategori baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/kategori'));
        }

        
    
    }

    public function ubah(){
        
        
        $validasi = $this->modelKategori->ubahKategori();
                        
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_kategori',  $validasi);
            return redirect()->to(base_url('/suplai/kategori'));
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
