<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSupplier;

class Supplier extends BaseController
{
	
	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelSupplier = new ModelSupplier();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];



    public function index(){
	
        $data = [
            'title' => ucfirst('Daftar Supplier'),
            'nama_menu_utama' => ucfirst('Gudang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'supplier'=>$this->modelSupplier->ambilSupplier(),
            'session' => $this->session,
            'form_tambah_supplier' => ['id' => 'formTambahSupplier', 'name'=>'formTambahSupplier'],
            'form_edit_supplier' =>  ['id' => 'formEditSupplier', 'name'=>'formEditSupplier'],
            'form_hapus_supplier' =>  ['id' => 'formHapusSupplier', 'name'=>'formHapusSupplier', 'class' => 'btn btn-block'],
            'hidden_id_supplier' => ['name' => 'id_supplierE', 'id'=>'id_supplierE', 'type'=> 'hidden'],
            'hidden_id_supplierH' => ['name' => 'id_supplierH', 'id'=>'id_supplierH', 'type'=> 'hidden'],
            'hidden_old_nama_supplier' => [
                'type' => 'hidden',
                'name' => 'old_nama_supplier',
                'id' => 'old_nama_supplier',
                'class' => 'form-control'
                
            ]
        ];
        tampilan_admin('admin/admin-supplier/v_supplier', 'admin/admin-supplier/v_js_supplier', $data);
     
    }

    public function tambah(){
        $validasi = $this->modelSupplier->tambahSupplier();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_supplier',  $validasi);
            return redirect()->to(base_url('/suplai/supplier'));
        }else{
            $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/supplier'));
        }
        
    }

    public function ubah(){
        $validasi = $this->modelSupplier->ubahSupplier();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_supplier',  $validasi);
            return redirect()->to(base_url('/suplai/supplier'));
        }else{
            $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/supplier'));
        }
    }


    public function hapus(){
        $this->modelSupplier->hapusSupplier();
        $this->session->setFlashdata('pesan_hapus_supplier', 'Supplier berhasil dihapus!');
        return redirect()->to(base_url('/suplai/supplier'));
        
    
    }

}
