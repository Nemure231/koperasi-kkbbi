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

	protected $helpers = ['url', 'form', 'kpos', 'cookie'];



    public function index(){
	
        $data = [
            'title' => ucfirst('Daftar Supplier'),
            'nama_menu_utama' => ucfirst('Gudang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'supplier'=>$this->modelSupplier->ambilSupplier(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-supplier'],
            'form_edit' =>  ['id' => 'form-edit-supplier'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_id_supplier' => ['name' => 'hapus_id_supplier', 'id'=>'hapus_id_supplier', 'type'=> 'hidden']
        ];
        tampilan_admin('admin/admin-supplier/v_supplier', 'admin/admin-supplier/v_js_supplier', $data);
     
    }

    public function tambah(){
        $validasi = $this->modelSupplier->tambahSupplier();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_supplier',  $validasi);
            return redirect()->to(base_url('/suplai/supplier'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/supplier'));
        }
        
    }

    public function ubah(){
        $validasi = $this->modelSupplier->ubahSupplier();
        $old = [
            'id_supplier' => $this->request->getPost('edit_id_supplier')
        ];
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_supplier',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/suplai/supplier'))->withInput();
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
