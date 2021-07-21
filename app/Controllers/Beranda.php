<?php namespace App\Controllers;

use CodeIgniter\Controller;
// use App\Models\Model_all;
use App\Models\Model_barang;
use App\Models\Model_kategori;
use App\Models\Model_user;

class Beranda extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		// $this->model = new Model_all();
		$this->model_barang = new Model_barang();
		$this->model_user =  new Model_user();
		$this->model_kategori = new Model_kategori();
		// $this->cart = \Config\Services::cart();
		$this->request = \Config\Services::request();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		
		$data = [
			'title' => ucfirst('Beranda'),
			'user' => $this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
			->join('role', 'role.id = user.role_id')
			->where('surel', $email)
			->first(),
			'session' => $this->session,
			'form_beranda' => ['id' => 'formBeranda', 'name'=>'formBeranda'],
			'lima_barang' => $this->model_barang->select('nama, kode')
							->asArray()->orderBy('id', 'DESC')->findAll(5),
			'kategori' => $this->model_kategori->select('kategori.id as id, kategori.nama as nama, COUNT(kategori_id) as nom')
							->join('barang', 'barang.kategori_id = kategori.id')->groupBy('kategori_id')
						->asArray()->findAll(),
			'role_log' => $role
			
		];

		
		tampilan_user('user/user-beranda/v_beranda', 'user/user-beranda/v_js_beranda', $data);
		

	}
	

}
