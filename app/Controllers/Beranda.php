<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_barang;
use App\Models\Model_kategori;
use App\Models\Model_user;
use App\Models\Model_merek;
use App\Models\Model_toko;

class Beranda extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model_barang = new Model_barang();
		$this->model_user =  new Model_user();
		$this->model_toko = new Model_toko();
		$this->model_merek =  new Model_merek();
		$this->model_kategori = new Model_kategori();
		$this->request = \Config\Services::request();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();
		
		$data = [
			'title' => ucfirst('Beranda'),
			'user' => $this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, alamat, role.nama as role')->asArray()
			->join('role', 'role.id = user.role_id')
			->where('surel', $email)
			->first(),
			'session' => $this->session,
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'form_beranda' => ['id' => 'formBeranda', 'name'=>'formBeranda'],
			'lima_barang' => $this->model_barang->select('nama, kode, gambar')
							->where('barang.status', 1)	
							->asArray()->orderBy('id', 'DESC')->groupBy('id')
							->findAll(5),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'kategori' => $this->model_kategori->select('kategori.id as id, kategori.nama as nama, COUNT(kategori_id) as nom')
						->where('barang.status', 1)	
						->join('barang', 'barang.kategori_id = kategori.id')->groupBy('kategori_id')->asArray()				
						->orderBy('COUNT(merek_id)', 'DESC')		
						->findAll(4),
			'merek' => $this->model_merek->select('merek.id as id, merek.nama as nama, COUNT(merek_id) as nomer')->asArray()
						->where('barang.status', 1)	
						->join('barang', 'barang.merek_id = merek.id')->groupBy('merek_id')
						->orderBy('COUNT(merek_id)', 'DESC')		
						->findAll(4),
			'role_log' => $role
			
		];

		
		tampilan_user('user/user-beranda/v_beranda', 'user/user-beranda/v_js_beranda', $data);
		

	}
	

}
