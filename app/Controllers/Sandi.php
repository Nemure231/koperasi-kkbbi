<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class Sandi extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function __construct(){
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->modelUser = new ModelUser();
		$this->modelMenu =  new ModelMenu();
	}


	public function index(){

		$data = [
			'title' => ucfirst('Ubah Sandi'),
			'nama_menu_utama' => ucfirst('Profil'),
			'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
			'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
			'session' => $this->session,
			'validation' => $this->validation,
			'attr' => ['id' => 'katasandi', 'name'=>'katasandi']
		];
		tampilan_admin('admin/admin-katasandi/v_katasandi', 'admin/admin-katasandi/v_js_katasandi', $data);
	}



	public function ubah(){

		$data = $this->modelUser->ambilSatuSandi();
		$pass_sebelum = $this->request->getPost('password_lama');
		$pass_baru = $this->request->getPost('password');
		if (!password_verify($pass_sebelum, $data['password'])) {
			$this->session->setFlashdata('salah', 'Kata sandi sebelumnya salah!');
			return redirect()->to(base_url('/akun/sandi'));
		}else{
			if ($pass_sebelum == $pass_baru) {
				$this->session->setFlashdata('sama', 'Kata sandi baru tidak boleh sama dengan kata sandi sebelumnya!');
				return redirect()->to(base_url('/akun/sandi'));
			}else{
				$validasi = $this->modelUser->ubahSandi();
				if($validasi){
					$this->session->setFlashdata('pesan_validasi_edit_sandi',  $validasi);
					return redirect()->to(base_url('/akun/sandi'));
				}else{
					$this->session->setFlashdata('pesan', 'Kata sandi berhasil diubah!');
					return redirect()->to(base_url('/akun/sandi'));
				}
			}
		}
	}
}
