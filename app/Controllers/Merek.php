<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_merek;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Merek extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_merek = new Model_merek();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];


     public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $data = [
            'title' => ucfirst('Daftar Merek'),
            'user' 	=>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
                        ->join('user_role', 'user_role.id_role = user.role_id')
                        ->where('email', $email)
                        ->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                        ->where('user_access_menu.role_id =', $role)
                        ->orderBy('user_access_menu.menu_id', 'ASC')
                        ->orderBy('user_access_menu.role_id', 'ASC')
                        ->findAll(),
            'merek' =>  $this->model_merek->select('id_merek, nama_merek')->asArray()
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_merek' => ['id' => 'formTambahMerek', 'name'=>'formTambahMerek'],
            'form_edit_merek' =>  ['id' => 'formEditMerek', 'name'=>'formEditMerek'],
            'hidden_id_merek' => ['name' => 'id_merekE', 'id'=>'id_merekE', 'type'=> 'hidden'],
            'input_nama_merek' => [
                'type' => 'text',
                'name' => 'nama_merek',
                'class' => 'form-control'
                
            ],
            'input_nama_merekE' => [
                'type' => 'text',
                'name' => 'edit_nama_merek',
                'id' => 'edit_nama_merek',
                'class' => 'form-control'
                
            ],
            'hidden_nama_merek' => [
                'type' => 'hidden',
                'name' => 'old_nama_merek',
                'id' => 'old_nama_merek',
                'class' => 'form-control'
                
            ],
            
        ];
        tampilan_admin('admin/admin-merek/v_merek', 'admin/admin-merek/v_js_merek', $data);
     
    }

    public function tambahmerek(){

       

            if(!$this->validate([
                'nama_merek' => [
                    'label'  => 'Nama Merek',
                    'rules'  => 'required|is_unique[merek.nama_merek]',
                    'errors' => [
                    'required' => 'Nama merek harus diisi!',
                    'is_unique' => 'Nama merek sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarmerek'))->withInput();

            }

                $data = array(
                    'nama_merek' => htmlspecialchars($this->request->getPost('nama_merek'), ENT_QUOTES)
                );

                $this->model_merek->insert($data);
            
                $this->session->setFlashdata('pesan_merek', 'Merek baru berhasil ditambahkan!');
                return redirect()->to(base_url('/barang/daftarmerek'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function editmerek(){

        $old = $this->request->getPost('edit_nama_merek');
        $new = $this->request->getPost('old_nama_merek');
        
        $nama = 'required';

        if($old != $new){
            $nama =  'required|is_unique[merek.nama_merek]';
        } 

            if(!$this->validate([
                'edit_nama_merek' => [
                    'label'  => 'Nama Merek',
                    'rules'  => $nama,
                    'errors' => [
                    'required' => 'Nama merek harus diisi!',
                    'is_unique' => 'Nama merek sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarmerek'))->withInput();

            }
                $id = $this->request->getPost('id_merekE');
                $data = array(
                    'nama_merek' => htmlspecialchars($this->request->getPost('edit_nama_merek'), ENT_QUOTES)
                );

                $this->model_merek->update($id, $data);
            
                $this->session->setFlashdata('pesan_merek', 'Merek baru berhasil diedit!');
                return redirect()->to(base_url('/barang/daftarmerek'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }



    public function kecohhapusmerek(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusmerek($id_merek){
           
            
            $this->model_merek->delete($id_merek);
            $this->session->setFlashdata('pesan_hapus_merek', 'Merek berhasil dihapus!');
            return redirect()->to(base_url('/barang/daftarmerek'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }

}
