<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;

class Konfirmasi extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model_user = new Model_user();
		$this->model_pendaftaran = new Model_pendaftaran();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$id_user = $this->session->get('id_user');
		$email = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();

		if($konfirm['status'] != 2){
			return redirect()->to(base_url('/'));
		}

		$data = [
			'title' => 'Konfirmasi',
			'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as 
				email, telepon, gambar, alamat, role.nama as role')->asArray()
				->join('role', 'role.id = user.role_id')
				->where('surel', $email)
				->first(),
			'status_pendaftaran' => $this->model_user->select('pendaftaran.status as status, pendaftaran.kode as kode, pendaftaran.bukti as bukti, pendaftaran.id as id_pendaftaran')->asArray()
				->join('penyuplai', 'penyuplai.user_id = user.id')
				->join('pendaftaran', 'pendaftaran.penyuplai_id = penyuplai.id')
				->where('user.id', $id_user)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'validation' => $this->validation,
			'session' => $this->session,
			'role_log' => $role,


		];
		
		tampilan_user('user/user-konfirmasi/v_konfirmasi', 'user/user-konfirmasi/v_js_konfirmasi', $data);
	}

	public function ubah(){

		if(!$this->validate([
			'status' => [
				'rules'  => 'required|numeric',
				'errors' => [
					'required' => 'Harus dipilih!',
					'valid_email' => 'Harus berformat e!'
				]
			]

		])) {
		   
			return redirect()->to(base_url('/konfirmasi'));

		}

		$status = $this->request->getPost('status');
		$id_user = $this->session->get('id_user');

		$id_penyuplai = $this->model_user->select('penyuplai.id as id_penyuplai')->asArray()
		->join('penyuplai', 'penyuplai.user_id = user.id')->where('user.id', $id_user)->first();
		
		$this->model_pendaftaran->where('penyuplai_id', $id_penyuplai)->set('status', $status)->update();
		$this->session->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Berhasil dipilih! Silakan lakukan prosedur berikutnya!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>');
		return redirect()->to(base_url('konfirmasi'));
	}

	public function unggah(){
		// $bukti = $this->request->getFile('bukti');
		// dd($bukti);
		if(!$this->validate([
			'bukti' => [
				'rules'  => 'uploaded[bukti]|max_size[bukti,1024]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]',
				'errors' => [
				'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
				'uploaded' => 'Harus diunggah!',
				'is_image' => 'Format file yang anda upload bukan gambar!',
				'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
				]
			]

		])) {
			
			return redirect()->to(base_url('/konfirmasi'))->withInput();
		}
		   
			$bukti = $this->request->getFile('bukti');
			$bukti_lama = $this->request->getPost('bukti_lama');
			//cek gambar aapakah tetap gambar lama
			if($bukti->getError() == 4){
				$nama_bukti = $this->request->getPost('bukti_lama');
			}else{
				$nama_bukti = time().'.'.$bukti->guessExtension();
				$bukti->move('admin/assets/bukti_transfer/', $nama_bukti);
				//hapus file lama
				if($bukti_lama){
					unlink('admin/assets/bukti_transfer/'. $bukti_lama);
				}
			}
			
			$id_pendaftaran = $this->request->getPost('id_pendaftaran');

			$edit = array(
				'_method' => 'PUT',
				'bukti' => $nama_bukti
			);

		

			$this->model_pendaftaran->update($id_pendaftaran, $edit);
			$this->session->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Foto berhasil diunggah!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>');
			return redirect()->to(base_url('/konfirmasi'));

}


	

}
