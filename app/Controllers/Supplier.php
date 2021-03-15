<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_pengirim_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class Supplier extends BaseController
{
	
	public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_pengirim_barang = new Model_pengirim_barang();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];



    public function index(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
        

        $data = [
            'title' => ucfirst('Daftar Supplier'),
            'nama_menu_utama' => ucfirst('Barang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'supplier'=>$this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')
                        ->findAll(),
            'validation' => $this->validation,
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

        
       
            if(!$this->validate([
                'nama_supplier' => [
                    'label'  => 'Nama Supplier',
                    'rules'  => 'required|is_unique[pengirim_barang.nama_pengirim_barang]',
                    'errors' => [
                    'required' => 'Nama supplier harus diisi!',
                    'is_unique' => 'Nama supplier sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/suplai/supplier'))->withInput();

            }

                $data = array(
                    'nama_pengirim_barang' => htmlspecialchars($this->request->getPost('nama_supplier'), ENT_QUOTES)
                );

                $this->model_pengirim_barang->insert($data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
                return redirect()->to(base_url('/suplai/supplier'));
                
       
        
    }

    public function ubah(){

        $old = $this->request->getPost('edit_nama_supplier');
        $new = $this->request->getPost('old_nama_supplier');

        $nama = 'required';

        if($old != $new){
            $nama =  'required|is_unique[pengirim_barang.nama_pengirim_barang]';
        }

            if(!$this->validate([
                'edit_nama_supplier' => [
                    'label'  => 'Nama Supplier',
                    'rules'  => $nama,
                    'errors' => [
                    'required' => 'Nama supplier harus diisi!',
                    'is_unique' => 'Nama supplier sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/suplai/supplier'))->withInput();

            }
                $id = $this->request->getPost('id_supplierE');
                $data = array(
                    'nama_pengirim_barang' => htmlspecialchars($this->request->getPost('edit_nama_supplier'), ENT_QUOTES)
                );

                $this->model_pengirim_barang->update($id, $data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil diedit!');
                return redirect()->to(base_url('/suplai/supplier'));

        
    }


    public function hapus(){

        $id_supplier = $this->request->getPost('id_supplierH');
        $this->model_pengirim_barang->delete($id_supplier);
        $this->session->setFlashdata('pesan_hapus_supplier', 'Supplier berhasil dihapus!');
        return redirect()->to(base_url('/supali/supplier'));
        
    
    }

}
