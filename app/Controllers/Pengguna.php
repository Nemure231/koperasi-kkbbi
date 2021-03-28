<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class Pengguna extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function __construct(){
		$this->modelUser = new ModelUser();
		$this->modelMenu = new ModelMenu();
		$this->validation = \Config\Services::validation();
	}

	public function index(){
		
		$user = $this->modelUser->ambilSatuUserJoinRole();

		$data = [
			'title' => ucfirst('Profil'),
			'nama_menu_utama' => ucfirst('Profil'),
			'user' 	=> 	$user,
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
			'validation' => $this->validation,
			'session' => $this->session,
			'form_pengguna' => ['id' => 'formPengguna', 'name'=>'formPengguna'],
			'email' => [
				'type' => 'email',
				'value'=> ''.$user['email'].'',
				'class' => 'form-control',
				'readonly' => ''
			]
		];
		tampilan_admin('admin/admin-pengguna/v_pengguna', 'admin/admin-pengguna/v_js_pengguna', $data);
	}


	public function ubah(){

		$validasi = $this->modelUser->ubahUser();	
		
		if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_pengguna',  $validasi);
            return redirect()->to(base_url('/akun/profil'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_pengguna', 'Profil berhasil diperbarui');
			return redirect()->to(base_url('/akun/profil'));
        }
	}



	

	


}
