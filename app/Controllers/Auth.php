<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use CodeIgniter\I18n\Time;
//use CodeIgniter\HTTP\RequestInterface;

class Auth extends BaseController
{
	public function __construct(){

		$this->model = new Model_all();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->email = \Config\Services::email();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
		
		
		$roleid = $this->session->get('role_id');

		if($roleid){
			 return redirect()->to(base_url('/pengguna'));
		}
	
		$email = set_value('email', '');
		
		$data = [
			'title' =>  ucfirst('Login'),
			'attr' => ['id' => 'login', 'name'=>'login'],
			'validation' => $this->validation,
			'session' => $this->session,
			'inputemail' => [
				'type' => 'text',
				'name' => 'email',
				'id' => 'email',
				'tabindex'=> '2',
				'value' => ''.$email.'',
				'class' => 'form-control',
				'autofocus' => ''
			],
			'inputsandi' => [
				'type' => 'password',
				'name' => 'sandi',
				'id' => 'sandi',
				'tabindex'=> '2',
				'class' => 'form-control'
			],
			
		];

		if($this->request->getMethod() == 'post'){
			$this->validation->setRules([
				'email' => [
					'label'  => 'Email',
					'rules'  => 'required|valid_email',
					'errors' => [
						'required' => 'Email harus diisi!',
						'valid_email' => 'Format email tidak benar!'
					]
				],
				'sandi' => [
					'label'  => 'Sandi',
					'rules'  => 'required|min_length[3]',
					'errors' => [
						'min_length' => 'Terlalu pendek!',
						'required' => 'Sandi harus diisi!'
					]
				]
			]);
		}

		if($this->validation->withRequest($this->request)->run() == FALSE){
			tampilan_login('user/user-login/v_login', 'user/user-login/v_js_login', $data);
		}else{
			
		$email = $this->request->getPost('email');
		$sandi = $this->request->getPost('sandi');
		$user  = $this->model->GetUserEmail($email);

		//jika usernya ada
		
		if($user){
			//jika usernya aktif
			if($user['is_active'] == 1){


				//cek password
				if(password_verify($sandi, $user['sandi'])){

					$data =[
					'email' => $user['email'],
					'role_id' => $user['role_id'],
					'id_user' => $user['id_user']

					];


					$this->session->set($data);
					if($user['role_id']==1){

						$this->session->setFlashdata('pesan', 'Selamat bekerja dan beraktivitas!');
						return redirect()->to(base_url('/dashboard'));

					}
					if($user['role_id']==2){
						$this->session->setFlashdata('pesan', 'Selamat bekerja dan beraktivitas!');
						return redirect()->to(base_url('/dashboard'));

					}
					
					if($user['role_id']==3){
						$this->session->setFlashdata('pesan', 'Selamat bekerja dan beraktivitas!');
						return redirect()->to(base_url('/pengguna'));

					}

					if($user['role_id']==6){
						$this->session->setFlashdata('pesan', 'Selamat bekerja dan beraktivitas!');
						return redirect()->to(base_url('/pengguna'));

					}

					// if($user['role_id']==4){
					// 	$this->session->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
					// 	<strong>Selamat datang kembali, '.$user['nama'].'</strong>
					// 	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					// 	  <span aria-hidden="true">&times;</span>
					// 	</button>
					//   </div>');
					// 	return redirect()->to(base_url('/'));
					// }

				}else{
					$this->session->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Kata sandi salah!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>');
					 //redirect(base_url('/'));
					 return redirect()->to(base_url('/'))->back()->withInput();
				}

			}else{
				//jika usernya tidak aktif
				$this->session->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Email belum diaktivasi!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>');
				 return redirect()->to(base_url('/'));
			}

			}else{
				$this->session->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>E-mail belum terdaftar!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>');
				return redirect()->to(base_url('/'))->back()->withInput();
			}
		}
		

	}

	// public function registrasi(){
		
		
	// 	$email = $this->session->get('email');

	// 	if($email){
	// 		 return redirect()->to(base_url('/pengguna'));
	// 	}
	
	// 	$email = set_value('email', '');
		
		
	// 	$data = [
	// 		'title' =>  ucfirst('Registrasi'),
	// 		'validation' => $this->validation,
	// 		'session' => $this->session,
	// 		'form_registrasi' =>  ['id' => 'formRegistrasi', 'name'=>'formRegistrasi']

			
	// 	];

	// 	tampilan_login('user/user-registrasi/v_registrasi', 'user/user-registrasi/v_js_registrasi', $data);
	
	// }

	// public function tambahregis(){
		
	// 	$role = $this->session->get('role_id');
		
    //     if(!$role){
    //         if(!$this->validate([
    //             'nama' => [
    //                 'label'  => 'Nama',
    //                 'rules'  => 'required',
    //                 'errors' => [
    //                 'required' => 'Nama harus diisi!'
    //                 ]
    //             ],
    //             'email' => [
    //                 'label'  => 'E-mail',
    //                 'rules'  => 'required|valid_email|is_unique[user.email]',
    //                 'errors' => [
    //                 'required' => 'E-mail harus diisi!',
	// 				'valid_email' => 'Format e-mail salah!',
	// 				'is_unique' => 'E-mail tersebut sudah ada!'
    //                 ]
	// 			],
    //             'sandi' => [
    //                 'label'  => 'Kata sandi',
    //                 'rules'  => 'required',
    //                 'errors' => [
    //                 'required' => 'Kata sandi harus diisi!'
                    
    //                 ]
    //             ],
    //             'ulang_sandi' => [
    //                 'label'  => 'Ulangi kata sandi',
    //                 'rules'  => 'matches[sandi]',
    //                 'errors' => [
    //                 'matches' => 'Kata sandi harus sama!'
    //                 ]
    //             ]

    //         ])) {
    //             return redirect()->to(base_url('/registrasi'))->withInput();

    //         }else{

	// 			$email = $this->request->getPost('email');
	// 			$token = base64_encode(random_bytes(32));
    //             $tambah = [
    //                 'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
    //                 'email' => $email,
    //                 'sandi' => password_hash($this->request->getPost('sandi'), PASSWORD_DEFAULT),
    //                 'role_id' => '4',
    //                 'is_active' => '2'
	// 			];
				
	// 			$user_token = [
	// 				'email_token' => $email,
	// 				'kode_token' => $token
	
	// 			];
                
	// 			$this->model->TambahRegis($tambah);
	// 			$this->model->TambahToken($user_token);
	// 			$this->_sendEmail($token, 'verify');
	// 			//if($this->request->getMethod() == 'post'){
    //                 $this->session->setFlashdata('pesan_regis', '<div class="alert alert-success alert-dismissible fade show" role="alert">
	// 				<strong>Akun anda berhasil dibuat, silakan periksa email untuk aktifasi akun!</strong>
	// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	// 				<span aria-hidden="true">&times;</span>
	// 				</button>
	// 			</div>');
    //                 return redirect()->to(base_url('/registrasi'));
    //           //  }
    //         }
    //     }elseif ($role){
    //         return redirect()->to(base_url('/'));
        
    //     }
	// }

	// public function _sendEmail($token, $type){

	// 	$id_log = $this->session->get('id_user');

	// 	if($id_log){
	// 		 return redirect()->to(base_url('/'));
	// 	}

	// 	$config =[
    //         'protocol'  => 'smtp',
    //         'SMTPHost' => 'smtp.gmail.com',
    //         'SMTPUser' => 'karol.web980@gmail.com',
    //         'SMTPPass' => '95h:*351dj',
    //         'SMTPPort' => 465,
    //         'mailType'  => 'html',
    //         'charset'   => 'utf-8',
	// 		'newline'   => "\r\n",
	// 		'SMTPCrypto' => 'ssl'
	// 	];
		
	// 	$this->email->initialize($config);

	// 	$email = $this->request->getPost('email');
    //     $this->email->setFrom('karol.web980@gmail.com', 'Karol Web');
    //     $this->email->setTo($email);

    //     if($type == 'verify'){
    //         $this->email->setSubject('Verifikasi Akun');
    //         $this->email->setMessage('Klik link di bawah ini untuk verifikasi akunmu.:
    //         <a href="'.base_url(). '/verify?email='. $email. '&token='. urlencode($token). '">Aktifkan</a>');
	// 	}
	// 	//else if($type == 'forgot'){
    //     // 	$this->email->subject('Atur Ulang Kata Sandi');
    //     //     $this->email->message('Klik link ini untuk atur ulang kata sandi akunmu.:
    //     //     <a href="'.base_url(). 'login/aturulangpass?email='. $this->mall->PostEmail(). '&token='. urlencode($token). '">Atur Ulang</a>');
    //     // }
       
    //     if ($this->email->send()) {
    //         return true;
	// 	}else{
    //         echo $this->email->printDebugger();
    //         die;
    //     }
    // }

    // public function verify(){

	// 	$email = $this->session->get('email');

	// 	if($email){
	// 		 return redirect()->to(base_url('/'));
	// 	}

    // 	$email = $this->request->getGet('email');
	// 	$token = $this->request->getGet('token');
	// 	//$besok = Time::tomorrow('Asia/Jakarta', 'en_US');
    // 	$user = $this->model->GetUserEmailForVerify($email);
    // 	if($user){
    // 		$user_token = $this->model->GetUserTokenForVerify($token);

    // 		if ($user_token) {
    			
	// 			if (time() - $user_token['date_created'] < (60*60*24)) {

    // 				//update token menjadi active menjadi 1
    // 				$this->model->UpdateToken1($email);
    				
    // 				//hapus token yang telah diupdate
    // 				$this->model->DeleteToken($email);

	// 				$this->session->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
	// 				<strong>'. $email .' telah diaktivasi, silakan login.</strong>
	// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	// 				  <span aria-hidden="true">&times;</span>
	// 				</button>
	// 			  </div>');
	// 				return redirect()->to(base_url('/'));
    // 			}else{

    // 				$this->model->DeleteUser($email);
    // 				$this->model->DeleteToken($email);

    // 				$this->session->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	// 				<strong>AKtivasi akun gagal: token kadaluarsa!</strong>
	// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	// 				  <span aria-hidden="true">&times;</span>
	// 				</button>
	// 			  </div>');
	// 				return redirect()->to(base_url('/'));
    // 			}
    // 		}else{
    // 			$this->session->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	// 			<strong>AKtifasi akun gagal: token salah!</strong>
	// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	// 			  <span aria-hidden="true">&times;</span>
	// 			</button>
	// 		  </div>');
	// 			return redirect()->to(base_url('/'));

    // 		}
    // 	}else{
    // 		$this->session->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	// 		<strong>AKtifasi akun gagal: email salah!</strong>
	// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	// 		  <span aria-hidden="true">&times;</span>
	// 		</button>
	// 	  </div>');
	// 		return redirect()->to(base_url('/'));
    // 	}
    // }
	


	public function logout(){
		$role = $this->session->get('role_id');
		if(!$role){
            return redirect()->to(base_url('/'));
		}
		$this->session->remove('email');
		$this->session->remove('role_id');
		$this->session->remove('id_user');
		$this->session->remove('nama');
		if($role != 4){
			$this->session->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Anda berhasil keluar!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>');
				return redirect()->to(base_url('/'));
		}else{
			$this->session->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Anda berhasil keluar!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			return redirect()->to(base_url('/'));
		}
	}

	public function blokir(){
		
		$role = $this->session->get('role_id');
		if(!$role){
            return redirect()->to(base_url('/'));
		}
		
		$data['title'] = ucfirst('Blokir'); // Capitalize the first letter
		echo view('admin/admin-base-html/v_header', $data);
		echo view('admin/admin-blokir/v_blokir');
		echo view('admin/admin-base-html/v_js');
		echo view('admin/admin-blokir/v_js_blokir');


	}

}
