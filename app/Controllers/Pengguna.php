<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;

class Pengguna extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function __construct(){

		$this->model = new Model_all();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	public function index(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
	
		$user = $this->model->UserLogin();

		$data = [
			'title' => ucfirst('Profile'),
			'user' => $user,
			'validation' => $this->validation,
			'menu' => $this->model->MenuAll(),
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


	public function editpengguna(){

       
        
            if(!$this->validate([
                'nama' => [
                    'label'  => 'Nama',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Nama harus diisi!'
                    ]
                ],
                'telepon' => [
                    'label'  => 'Nomor Telepon',
                    'rules'  => 'required|numeric',
                    'errors' => [
					'required' => 'Nomor telepon harus diisi!',
					'numeric' => 'Nomor telepon harus dengan angka!'
                    ]
				],
                'alamat' => [
                    'label'  => 'Alamat',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'ALamat harus diisi!'
                    
                    ]
                ]

            ])) {
                return redirect()->to(base_url('/pengguna'))->withInput();

            }

				$id = $this->session->get('id_user');
                $edit = [
                    'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
					'telepon' => $this->request->getPost('telepon'),
					'alamat' =>  htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES)
				];
			
				//dd($id);
				$this->model->EditPengguna($edit, $id);
				
                $this->session->setFlashdata('pesan_pengguna', 'Profil berhasil diperbarui');
				return redirect()->to(base_url('/pengguna'));
		
				$role = $this->session->get('role_id');
		
				if (!$role){
					return redirect()->to(base_url('/'));
				}
					$userAccess = $this->model->Tendang();
					if ($userAccess < 1) {
						return redirect()->to(base_url('blokir'));
					}
                
            
        
	}



	public function katasandi(){
		
	
		
		$role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }

			$user = $this->model->UserLogin();
			$data = [
				'title' => ucfirst('Ubah Kata Sandi'),
				'user' => $this->model->UserLogin(),
				'menu' => $this->model->MenuAll(),
				'session' => $this->session,
				'validation' => $this->validation,
				'attr' => ['id' => 'katasandi', 'name'=>'katasandi']
			];
			tampilan_admin('admin/admin-katasandi/v_katasandi', 'admin/admin-katasandi/v_js_katasandi', $data);	
	}



	public function editkatasandi(){

       
        
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
			return redirect()->to(base_url('/pengguna/katasandi'))->withInput();

		}

		$data = $this->model->UserLoginSandi();
		$pass_sebelum = $this->request->getPost('katasandi_sebelum');
                $pass_baru = $this->request->getPost('katasandi_baru');
                if (!password_verify($pass_sebelum, $data['sandi'])) {
                    $this->session->setFlashdata('salah', 'Kata sandi sebelumnya salah!');
                    return redirect()->to(base_url('/pengguna/katasandi'));
                }else{
                    if ($pass_sebelum == $pass_baru) {
                        $this->session->setFlashdata('sama', 'Kata sandi baru tidak boleh sama dengan kata sandi sebelumnya!');
                        return redirect()->to(base_url('/pengguna/katasandi'));
                    }else{
                        $password_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
                        $this->model->EditKataSandi($password_hash);
                        $this->session->setFlashdata('pesan', 'Kata sandi berhasil diubah!');
                        return redirect()->to(base_url('/pengguna/katasandi'));
                    }
				}
				
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
