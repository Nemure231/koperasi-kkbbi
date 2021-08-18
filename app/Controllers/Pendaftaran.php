<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;
use App\Models\Model_user_token;
use App\Models\Model_penyuplai;
use App\Models\Model_toko;

class Pendaftaran extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model_user =  new Model_user();
		$this->model_toko =  new Model_toko();
		$this->model_penyuplai = new Model_penyuplai();
		$this->model_pendaftaran = new Model_pendaftaran();
		$this->model_user_token =  new Model_user_token();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->email = \Config\Services::email();
		$this->db = \Config\Database::connect();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();

		if($role){
			return redirect()->to(base_url('/'));
		}
		
		$data = [
			'title' => 'Pendaftaran',
			'user' => $this->model_user->select('user.nama as nama')->asArray()
				->where('surel', $email)
				->first(),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')
				->asArray()
				->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'validation' => $this->validation,
			'session' => $this->session,
			'role_log' => $role,
			
		];
		
		tampilan_user(
			'user/user-pendaftaran/v_pendaftaran',
			'user/user-pendaftaran/v_js_pendaftaran',
			$data
		);
	}

	public function tambah(){

		if(!$this->validate([
			'nama' => [
				'rules'  => 'required',
				'errors' => [
					'required' => 'Harus diisi!'
				]
			],
			'telepon' => [
				'rules'  => 'required|numeric|is_unique[user.telepon]|greater_than[0]',
				'errors' => [
					'required' => 'Harus diisi!',
					'numeric' => 'Harus angka!',
					'is_unique' => 'Sudah pernah terdaftar sebelumnya!',
					'greater_than' => 'Harus diisi!'
				]
			],
			'surel' => [
				'rules'  => 'required|valid_email|is_unique[user.surel]',
				'errors' => [
					'required' => 'Harus disi!',
					'valid_emsil' => 'Format surel tidak benar!',
					'is_unique' => 'Sudah pernah terdaftar sebelumnya!'
				
				]
			],
			'pekerjaan' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				
				]
			],
			'no_ktp' => [
				'rules'  => 'required|numeric|greater_than[0]',
				'errors' => [
				'required' => 'Harus diisi!',
				'numeric' => 'Harus angka!',
				'greater_than' => 'Harus diisi!'
				
				]
			],
			'bank' => [
				'rules'  => 'required_with[atas_nama,no_rekening]|permit_empty|in_list[BCA,BRI,MANDIRI]',
				'errors' => [
					'in_list' => 'Pilihan bank tidak sesuai!',
					'required_with' => 'Harus dipilih saat Atas Nama atau
						No Rekening ikut diisi!'
				
				]
			],
			'atas_nama' => [
				'rules'  => 'required_with[no_rekening,bank]|permit_empty',
				'errors' => [
					'required_with' => 'Harus diisi saat No Rekening atau Bank ikut diisi!'
				
				]
			],
			'no_rekening' => [
				'rules'  => 'numeric|required_with[atas_nama,bank]|greater_than[0]',
				'errors' => [
				'numeric' => 'Harus angka!',
				'greater_than' => 'Harus diisi!',
				'required_with' => 'Harus diisi saat Atas Nama atau Bank ikut diisi!'
				
				]
			],
			'alamat' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				
				]
			],
			'sandi' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Harus diisi!',
					'min_length' => 'Tidak boleh kurang dari 8 karakter!'
                    
            	]
            ],
            'ulang_sandi' => [
                'rules'  => 'matches[sandi]',
                'errors' => [
                    'matches' => 'Harus sama dengan sandi!'
                ]
            ]
				

		])) {
			return redirect()->to(base_url('pendaftaran'))->withInput();
		}

		$surel = $this->request->getPost('surel');

		$user = [
			'role_id' => 5,
			'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
			'surel' => $surel,
			'sandi' => password_hash($this->request->getPost('sandi'), PASSWORD_DEFAULT),
			'telepon' => $this->request->getPost('telepon'),
			'alamat' =>  htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES),		
			'status' => 3,		
		];
		$this->model_user->insert($user);
		$user_id = $this->db->insertID();

		$token = base64_encode(random_bytes(32));
		$user_token = [
			'email_token' => $surel,
			'kode_token' => $token,
			'date_created' => time()
		];
		$this->model_user_token->insert($user_token);

		$penyuplai = [
			'user_id' => $user_id,
			'no_ktp' => $this->request->getPost('no_ktp'),
			'pekerjaan' => htmlspecialchars($this->request->getPost('pekerjaan'), ENT_QUOTES),
			'no_rekening' => $this->request->getPost('no_rekening'),
			'bank' => htmlspecialchars($this->request->getPost('bank'), ENT_QUOTES),
			'atas_nama' => htmlspecialchars($this->request->getPost('atas_nama'), ENT_QUOTES)			
		];

		$this->model_penyuplai->insert($penyuplai);
		$penyuplai_id = $this->db->insertID();
		$pendaftaran = [
			'penyuplai_id'=> $penyuplai_id,
			'kode' => 'PND'.'5'.$user_id,
			'biaya' => 0,
			'status' => 0
		];
		$this->model_pendaftaran->insert($pendaftaran);
		$this->session->setFlashdata('pesan_pendaftaran',
		'<div class="alert alert-success">Pendaftaran berhasil! 
		Silakan periksa surel anda untuk melakukan verifikasi!</div>');
		$this->_sendEmail($user, $token, $pendaftaran, 'verify');
		return redirect()->to(base_url('pendaftaran'));
	}

	public function _sendEmail($user, $token, $pendaftaran, $tipe){

		$toko = $this->model_toko->select('nama_toko, telepon_toko, email_toko,
                alamat_toko')->asArray()
                ->where('id_toko', 1)->first();

		$config =[
            'protocol'  => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => 'karol.web980@gmail.com',
            'SMTPPass' => '95h:*351dj',
            'SMTPPort' => 465,
            'mailType'  => 'html',
            'charset'   => 'utf-8',
			'newline'   => "\r\n",
			'SMTPCrypto' => 'ssl'
		];
		
		$this->email->initialize($config);
        $this->email->setFrom('karol.web980@gmail.com', 'Karol Web');
        $this->email->setTo($user['surel']);


		if($tipe == 'verify'){
			$this->email->setSubject('KKBBI: Verifikasi');
			$this->email->setMessage(email_verify($user, $token, $toko));
		}else if($type == 'forgot'){
			$this->email->subject('Atur Ulang Kata Sandi');
			$this->email->message('Klik link ini untuk atur ulang kata sandi akunmu.:
			<a href="'.base_url(). 'login/aturulangpass?email='.
			$this->mall->PostEmail(). '&token='. urlencode($token). '">Atur Ulang</a>');
		}
      
        if ($this->email->send()) {
            return true;
		}else{
            echo $this->email->printDebugger();
            die;
        }
    }	

}
