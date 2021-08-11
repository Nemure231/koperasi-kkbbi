<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_toko;
use App\Models\Model_user;


class Profil extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->request = \Config\Services::request();
        $this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
		$this->validation = \Config\Services::validation();
	}

	public function index(){

		$role = $this->session->get('role_id');
        $surel = $this->session->get('email');
        $id_user = $this->session->get('id_user');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$role = $this->session->get('role_id');
		$data = [
			'title' => ucfirst('Profil'),
			'session' => $this->session,
            'konfirmasi' => $konfirm['status'] ?? NULL,
			'user' => $this->model_user->select('user.nama as nama, surel as email, telepon, alamat')->asArray()
				->where('id', $id_user)
				->first(),
			'form_profil' => ['id' => 'formProfil', 'name'=>'formProfil'],
			'role_log' => $role,
            'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'validation' => $this->validation,
			'id_user_hidden' => ['name' => 'user_id', 'id'=>'user_id', 'type'=> 'hidden', 'value' => ''.$id_user.''],
			
		];
		tampilan_user('user/user-profil/v_profil', 'user/user-profil/v_js_profil', $data);
		
	}

	
	
	

	
   
	

}