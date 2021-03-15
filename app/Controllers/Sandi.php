<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class Sandi extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function __construct(){
		$this->model_user_menu = new Model_user_menu();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->modelUser = new ModelUser();
		$this->modelMenu =  new ModelMenu();
	}


	public function index(){
		$role = $this->session->get('role_id');

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

		if(!$this->validate([
			'katasandi_sebelum' => [
				'label'  => 'Kata sandi sebelum',
				'rules'  => 'required|trim',
				'errors' => [
					'required' => 'Harus diisi harus diisi!'

				]
			],
			'katasandi_baru' => [
				'label'  => 'Sandi Baru',
				'rules'  => 'required|trim|min_length[6]|matches[katasandi_baru1]',
				'errors' => [
					'required' => 'Harus diisi!',
					'matches' => '',
					'min_length' => 'Terlalu pendek!'
				]
			],
			'katasandi_baru1' => [
				'label'  => 'Sandi Ulangi',
				'rules'  => 'required|trim|min_length[6]|matches[katasandi_baru]',
				'errors' => [
					'required' => 'Harus diisi!',
					'matches' => 'Harus sesuai dengan kata sandi baru!',
					'min_length' => ''
				]
			]

		])) {
			return redirect()->to(base_url('/akun/sandi'))->withInput();
		}

		$data = $this->modelUser->ambilSatuSandi();
		$pass_sebelum = $this->request->getPost('katasandi_sebelum');
		$pass_baru = $this->request->getPost('katasandi_baru');
		if (!password_verify($pass_sebelum, $data['password'])) {
			$this->session->setFlashdata('salah', 'Kata sandi sebelumnya salah!');
			return redirect()->to(base_url('/akun/sandi'));

		}else{
			if ($pass_sebelum == $pass_baru) {
				$this->session->setFlashdata('sama', 'Kata sandi baru tidak boleh sama dengan kata sandi sebelumnya!');
				return redirect()->to(base_url('/akun/sandi'));
			}else{
				$this->modelUser->ubahSandi();
				$this->session->setFlashdata('pesan', 'Kata sandi berhasil diubah!');
				return redirect()->to(base_url('/akun/sandi'));
			}
		}
	}
}
