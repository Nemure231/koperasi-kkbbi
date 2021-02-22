<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_buku;

class Beranda extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model = new Model_all();
		$this->model2 = new Model_buku();
		$this->cart = \Config\Services::cart();
		$this->request = \Config\Services::request();
	}

	public function index(){

		$role = $this->session->get('role_id');
		// $m = $this->cart->contents();
		// dd($m);
		

		

		//dd($this->model->GetAllKeranjang());
		$role = $this->session->get('role_id');
		$data = [
			'title' => ucfirst('Beranda'),
			'session' => $this->session,
			'user' => $this->model->UserLogin(),
			'keranjang' => $this->model->GetAllKeranjang(),
			'form_beranda' => ['id' => 'formBeranda', 'name'=>'formBeranda'],
			'fiv_buku' => $this->model->GetAllFivBukuBeranda(),
			'jenis' => $this->model->GetAllJenisBukuForUser(),
			'role_log' => $role
			
		];
		tampilan_user('user/user-beranda/v_beranda', 'user/user-beranda/v_js_beranda', $data);
		

	}
	

}
