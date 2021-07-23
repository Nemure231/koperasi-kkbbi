<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;

class Pendaftaran extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model_user =  new Model_user();
		$this->model_pendaftaran = new Model_pendaftaran();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->email = \Config\Services::email();
		$this->db = \Config\Database::connect();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		
		$data = [
			'title' => 'Pendaftaran',
			'user' => $this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
				->join('role', 'role.id = user.role_id')
				->where('surel', $email)
				->first(),	
			'validation' => $this->validation,
			'session' => $this->session,
			'role_log' => $role,
			
		];
		
		tampilan_user('user/user-pendaftaran/v_pendaftaran', 'user/user-pendaftaran/v_js_pendaftaran', $data);
		

	}

	public function tambah(){

		$angka = str_replace(":", "", $this->request->getPost('waktu_sampai'));

		if(!$this->validate([
			'nama' => [
				// 'label'  => 'Nama Pendaftaran',
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				]
			],
			'telepon' => [
				// 'label'  => 'Nomor Telepon',
				'rules'  => 'required|numeric|is_unique[penyuplai.telepon]',
				'errors' => [
				'required' => 'Harus diisi!',
				'numeric' => 'Harus angka!',
				'is_unique' => 'Nomor itu sudah pernah didaftarkan!'
				]
			],
			'surel' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required|valid_email|is_unique[penyuplai.surel]',
				'errors' => [
					'required' => 'Harus disi!',
					'valid_emsil' => 'Harus berformat surel!',
					'is_unique' => 'Surel itu sudah pernah didaftarkan!'
				
				]
			],
			'pekerjaan' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				
				]
			],
			'no_ktp' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				
				]
			],
			'bank' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required_with[atas_nama,no_rekening]|permit_empty',
				'errors' => [
				'numeric' => 'Harus angka!',
				'required_with' => 'Harus diisi saat Atas Nama atau No Rekening ikut diisi!'
				
				]
			],
			'atas_nama' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required_with[no_rekening,bank]|permit_empty',
				'errors' => [
				'numeric' => 'Harus angka!',
				'required_with' => 'Harus diisi saat No Rekening atau Bank ikut diisi!'
				
				]
			],
			'no_rekening' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required_with[atas_nama,bank]|numeric|permit_empty',
				'errors' => [
				'numeric' => 'Harus angka!',
				'required_with' => 'Harus diisi saat Atas Nama atau Bank ikut diisi!'
				
				]
			],
			'alamat' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				
				]
			],
			'tanggal' => [
				// 'label'  => '',
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus diisi!'
				
				]
			],
			'waktu_awal' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required|differs[waktu_akhir]',
				'errors' => [
					'required' => 'Harus diisi!',
					'differs' => 'Tidak boleh sama!'
				
				]
			],
			'waktu_akhir' => [
				// 'label'  => 'Alamat',
				'rules'  => 'required|differs[waktu_awal]',
				'errors' => [
				'required' => 'Harus diisi!',
				'differs' => 'Tidak boleh sama!'
				
				]
			],
				
				

		])) {
			return redirect()->to(base_url('pendaftaran'))->withInput();

		}


			
			$penyuplai = [
				'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
				'role_id' => 5,
				'telepon' => $this->request->getPost('telepon'),
				'surel' => $this->request->getPost('surel'),
				'no_ktp' => $this->request->getPost('no_ktp'),
				'pekerjaan' => htmlspecialchars($this->request->getPost('pekerjaan'), ENT_QUOTES),
				'no_rekening' => $this->request->getPost('no_rekening'),
				'bank' => htmlspecialchars($this->request->getPost('bank'), ENT_QUOTES),
				'atas_nama' => htmlspecialchars($this->request->getPost('atas_nama'), ENT_QUOTES),
				'status' => 2,
				'alamat' =>  htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES),				
			];

			$this->db->table('penyuplai')->insert($penyuplai);
			$penyuplai_id = $this->db->insertID();

			$pendaftaran = [
				'penyuplai_id'=> $penyuplai_id,
				'user_id' => 0,
				'kode' => 'PDN'.rand(100000, 999999),
				'biaya' => 0,
				'waktu_awal' => $this->request->getPost('waktu_awal'),
				'waktu_akhir' => $this->request->getPost('waktu_akhir'),
				'tanggal' => $this->request->getPost('tanggal'),
			];

			$this->model_pendaftaran->insert($pendaftaran);
			$this->session->setFlashdata('pesan_pendaftaran', '<div class="alert alert-success">Pendaftaran berhasil! Silakan cek surel anda!</div>');
			$this->_sendEmail($penyuplai, $pendaftaran);
			return redirect()->to(base_url('pendaftaran'));
	
	}

	public function _sendEmail($penyuplai, $pendaftaran){

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
        $this->email->setTo($penyuplai['surel']);

            $this->email->setSubject('Konfirmasi Pendaftaran KKBBI');
			$this->email->setMessage(html_email($penyuplai, $pendaftaran));
      
       
        if ($this->email->send()) {
            return true;
		}else{
            echo $this->email->printDebugger();
            die;
        }
    }
	

}
