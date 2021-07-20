<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Sandi extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function __construct(){

		$this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}


	public function index(){
		
	
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
	

		$data = [
		'title' => 'Ubah Sandi',
		'nama_menu_utama' => 'Profil',
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
		$id_user = $this->session->get('id_user');
		$email = $this->session->get('email');
		$data = $this->model_user->select('sandi')->asArray()
                ->where('surel', $email)->first();
		$pass_sebelum = $this->request->getPost('katasandi_sebelum');
		$pass_baru = $this->request->getPost('katasandi_baru');
		if (!password_verify($pass_sebelum, $data['sandi'])) {
			$this->session->setFlashdata('salah', 'Kata sandi sebelumnya salah!');
			return redirect()->to(base_url('/akun/sandi'));
		}else{
			if ($pass_sebelum == $pass_baru) {
				$this->session->setFlashdata('sama', 'Kata sandi baru tidak boleh sama dengan kata sandi sebelumnya!');
				return redirect()->to(base_url('/akun/sandi'));
			}else{
				$password_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
				$this->model_user->set('sandi', $password_hash)->where('id', $id_user)->update();
				$this->session->setFlashdata('pesan', 'Kata sandi berhasil diubah!');
				return redirect()->to(base_url('/akun/sandi'));
			}
		}

			
			
		
	
}

	


}
