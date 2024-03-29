<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_stok;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Stok extends BaseController
{
	
	public function __construct(){
        
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_stok = new Model_stok();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];



    public function index(){
		

		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		

		
        $stok = $this->model_stok->select('min_stok, id_stok')->asArray()
                ->where('id_stok', 58)->first();
		$data = [
			'title' => ucfirst('Pengaturan Stok'),
            'nama_menu_utama' => ucfirst('Stok'),
            'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
						->join('user_role', 'user_role.id_role = user.role_id')
						->where('email', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
            'stok' => $stok,
            'habis' => $this->model_stok->GetAllStokHampirHabis(),
            'session' => $this->session,
            'validation' => $this->validation,
            'form_stok' => [
                'id' => 'formStok',
                'name'=>'formStok'
            ],
			'input_id_stokH' => [
				'name' => 'id_stok',
				'id'=> 'id_stok', 
				'value' => ''.$stok['id_stok'].'', 
				'type'=> 'hidden'
            ]
		];
		tampilan_admin('admin/admin-stok/v_stok', 'admin/admin-stok/v_js_stok', $data);
    }

    public function ubah(){
        if(!$this->validate([
            'min_stok' => [
                'label'  => 'Stok Minimal',
                'rules'  => 'required|numeric',
                'errors' => [
                'required' => 'Stok harus diisi!',
                'numeric' => 'Stok harus angka!'
                ]
            ]
        ])) {
        
            return redirect()->to(base_url('/pengaturan/stok'))->withInput();

        }

        $id_stok = $this->request->getPost('id_stok');
        $edit = [
            'min_stok' => $this->request->getPost('min_stok')
        ];

        $this->model_stok->update($id_stok, $edit);

        $this->session->setFlashdata('pesan_stok', 'Stok berhasil dicari!');
        return redirect()->to(base_url('/pengaturan/stok'));

    }
}
