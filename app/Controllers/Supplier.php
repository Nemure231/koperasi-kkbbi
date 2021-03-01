<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_pengirim_barang;
use App\Models\Model_all;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Supplier extends BaseController
{
	
	public function __construct(){
        $this->model = new Model_all();
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_pengirim_barang = new Model_pengirim_barang();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	

     

     /////////////////////////////////////////SUPPLIER//////////////////////////////////


     public function index(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $data = [
            'title' => ucfirst('Daftar Supplier'),
            'user' 	=>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')
                        ->join('user_role', 'user_role.id_role = user.role_id')
                        ->where('email', $email)
                        ->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                        ->where('user_access_menu.role_id =', $role)
                        ->orderBy('user_access_menu.menu_id', 'ASC')
                        ->orderBy('user_access_menu.role_id', 'ASC')
                        ->findAll(),
            'supplier'=>$this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_supplier' => ['id' => 'formTambahSupplier', 'name'=>'formTambahSupplier'],
            'form_edit_supplier' =>  ['id' => 'formEditSupplier', 'name'=>'formEditSupplier'],
            'hidden_id_supplier' => ['name' => 'id_supplierE', 'id'=>'id_supplierE', 'type'=> 'hidden'],
            'hidden_old_nama_supplier' => [
                'type' => 'hidden',
                'name' => 'old_nama_supplier',
                'id' => 'old_nama_supplier',
                'class' => 'form-control'
                
            ]

            
        ];
        tampilan_admin('admin/admin-supplier/v_supplier', 'admin/admin-supplier/v_js_supplier', $data);
     
    }

    public function tambahsupplier(){

        
       
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
                
                return redirect()->to(base_url('/barang/daftarsupplier'))->withInput();

            }

                $data = array(
                    'nama_pengirim_barang' => htmlspecialchars($this->request->getPost('nama_supplier'), ENT_QUOTES)
                );

                $this->model_pengirim_barang->insert($data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
                return redirect()->to(base_url('/barang/daftarsupplier'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function editsupplier(){

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
                
                return redirect()->to(base_url('/barang/daftarsupplier'))->withInput();

            }
                $id = $this->request->getPost('id_supplierE');
                $data = array(
                    'nama_pengirim_barang' => htmlspecialchars($this->request->getPost('edit_nama_supplier'), ENT_QUOTES)
                );

                $this->model_pengirim_barang->update($id, $data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil diedit!');
                return redirect()->to(base_url('/barang/daftarsupplier'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }



    public function kecohhapussupplier(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapussupplier($id_supplier){
           
            
            $this->model_pengirim_barang->delete($id_supplier);
            $this->session->setFlashdata('pesan_hapus_supplier', 'Supplier berhasil dihapus!');
            return redirect()->to(base_url('/barang/daftarsupplier'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }

}
