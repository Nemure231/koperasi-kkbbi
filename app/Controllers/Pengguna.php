<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Pengguna extends BaseController{

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
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
	
		$user = $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
				->join('user_role', 'user_role.id_role = user.role_id')
				->where('email', $email)
				->first();

		$data = [
			'title' => ucfirst('Profil'),
			'nama_menu_utama' => ucfirst('Profil'),
			'user' => $user,
			'validation' => $this->validation,
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
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
                return redirect()->to(base_url('akun/profil'))->withInput();

            }

				$id = $this->session->get('id_user');
                $edit = [
                    'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
					'telepon' => $this->request->getPost('telepon'),
					'alamat' =>  htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES)
				];
			
				//dd($id);
				$this->model_user->update($id, $edit);
				
                $this->session->setFlashdata('pesan_pengguna', 'Profil berhasil diperbarui');
				return redirect()->to(base_url('akun/profil'));
		
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
