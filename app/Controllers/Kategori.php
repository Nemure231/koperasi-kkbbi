<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_kategori;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Kategori extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_kategori = new Model_kategori();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	/////////////////////////////////////////KATEGORI//////////////////////////////////


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
            'title' =>  ucfirst('Daftar Kategori'),
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
            'kategori'=>$this->model_kategori->select('id_kategori, nama_kategori')->asArray()
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_kategori' => ['id' => 'formTambahKategori', 'name'=>'formTambahKategori'],
            'form_edit_kategori' =>  ['id' => 'formEditKategori', 'name'=>'formEditKategori'],
            'hidden_id_kategori' => ['name' => 'id_kategoriE', 'id'=>'id_kategoriE', 'type'=> 'hidden'],
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

    public function tambahkategori(){

        
            if(!$this->validate([
                'nama_kategori' => [
                    'label'  => 'Nama Kategori',
                    'rules'  => 'required|is_unique[kategori.nama_kategori]',
                    'errors' => [
                    'required' => 'Nama kategori harus diisi!',
                    'is_unique' => 'Nama kategori sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarkategori'))->withInput();
            }
            
           // if($this->validation->withRequest($this->request)->run() == TRUE){
                $data = array(
                   // 'kode_kategori' => htmlspecialchars($this->request->getPost('kode_kategori'), ENT_QUOTES),
                    'nama_kategori' => htmlspecialchars($this->request->getPost('nama_kategori'), ENT_QUOTES)
                );
                $this->model_kategori->insert($data);
                $this->session->setFlashdata('pesan_kategori', 'Kategori baru berhasil ditambahkan!');
                return redirect()->to(base_url('/barang/daftarkategori'));
           // }


        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }
    
    }

    public function editkategori(){
       
        $old =  $this->request->getPost('old_nama_kategori');
        $new =  $this->request->getPost('edit_nama_kategori');

        // $old_k =  $this->request->getPost('old_kode_kategori');
        // $new_k =  $this->request->getPost('edit_kode_kategori');

        $rules = 'required';
        //$rules_k = 'required';

        if($old != $new){
            $rules =  'required|is_unique[kategori.nama_kategori]';
        }

        // if($old_k != $new_k){
        //     $rules_k =  'required|is_unique[kategori.kode_kategori]';
        // }

        
            if(!$this->validate([
                'edit_nama_kategori' => [
                    'label'  => 'Nama Kategori',
                    'rules'  => $rules,
                    'errors' => [
                    'required' => 'Nama kategori harus diisi!',
                    'is_unique' => 'Nama kategori sudah ada!'
                    ]
                ]
                // ,
                //     'edit_kode_kategori' => [
                //     'label'  => 'Kode Kategori',
                //     'rules'  => $rules_k,
                //     'errors' => [
                //     'required' => 'Kode kategori harus diisi!',
                //     'is_unique' => 'Kode kategori sudah ada!'
                //     ]
                // ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarkategori'))->withInput();

            }
                $id = $this->request->getPost('id_kategoriE');
                $data = array(
                    //'kode_kategori' => htmlspecialchars($this->request->getPost('edit_kode_kategori'), ENT_QUOTES),
                    'nama_kategori' => htmlspecialchars($this->request->getPost('edit_nama_kategori'), ENT_QUOTES)
                );

                $this->model_kategori->update($id, $data);
                $this->session->setFlashdata('pesan_kategori', 'Kategori baru berhasil diedit!');
                return redirect()->to(base_url('/barang/daftarkategori'));
                
                $role = $this->session->get('role_id');

                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                $userAccess = $this->model_user_menu->Tendang();
                if ($userAccess < 1) {
                    return redirect()->to(base_url('blokir'));
                }
                
    }

    public function kecohhapuskategori(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapuskategori($id_kategori){

        
            $this->model_kategori->delete($id_kategori);
            $this->session->setFlashdata('pesan_hapus_kategori', 'Kategori berhasil dihapus!');
            return redirect()->to(base_url('/barang/daftarkategori'));
        
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
