<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_penyuplai;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Penyuplai extends BaseController
{
	
	public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_penyuplai = new Model_penyuplai();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];



    public function index(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
        

        $data = [
            'title' => 'Daftar Supplier',
            'nama_menu_utama' => 'Gudang',
            'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
						->join('role', 'role.id = user.role_id')
						->where('surel', $email)
						->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                        ->where('user_access_menu.role_id =', $role)
                        ->orderBy('user_access_menu.menu_id', 'ASC')
                        ->orderBy('user_access_menu.role_id', 'ASC')
                        ->findAll(),
            'supplier'=>$this->model_penyuplai->select('id as id_pengirim_barang, nama as nama_pengirim_barang')
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
        tampilan_admin('admin/admin-penyuplai/v_penyuplai', 'admin/admin-penyuplai/v_js_penyuplai', $data);
     
    }

    public function tambah(){

        
       
            if(!$this->validate([
                'nama_supplier' => [
                    'label'  => 'Nama Supplier',
                    'rules'  => 'required|is_unique[penyuplai.nama]',
                    'errors' => [
                    'required' => 'Nama supplier harus diisi!',
                    'is_unique' => 'Nama supplier sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/suplai/penyuplai'))->withInput();

            }

                $data = array(
                    'nama' => htmlspecialchars($this->request->getPost('nama_supplier'), ENT_QUOTES)
                );

                $this->model_penyuplai->insert($data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
                return redirect()->to(base_url('/suplai/penyuplai'));
                
       
        
    }

    public function ubah(){

        $old = $this->request->getPost('edit_nama_supplier');
        $new = $this->request->getPost('old_nama_supplier');

        $nama = 'required';

        if($old != $new){
            $nama =  'required|is_unique[penyuplai.nama]';
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
                
                return redirect()->to(base_url('/suplai/penyuplai'))->withInput();

            }
                $id = $this->request->getPost('id_supplierE');
                $data = array(
                    'nama' => htmlspecialchars($this->request->getPost('edit_nama_supplier'), ENT_QUOTES)
                );

                $this->model_penyuplai->update($id, $data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil diedit!');
                return redirect()->to(base_url('/suplai/penyuplai'));

        
    }


    public function hapus(){

        $id_supplier = $this->request->getPost('id_supplierH');
        $this->model_penyuplai->delete($id_supplier);
        $this->session->setFlashdata('pesan_hapus_supplier', 'Supplier berhasil dihapus!');
        return redirect()->to(base_url('/suplai/penyuplai'));
        
    
    }

}
