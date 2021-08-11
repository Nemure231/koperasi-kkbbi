<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_penyuplai;
use App\Models\Model_barang;
use App\Models\Model_user;
use App\Models\Model_toko;

class Produk extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model_merek = new Model_merek();
		$this->model_kategori = new Model_kategori();
		$this->model_penyuplai = new Model_penyuplai();
		$this->model_user = new Model_user();
		$this->model_toko = new Model_toko();
		$this->model_barang = new Model_barang();
		$this->request = \Config\Services::request();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$kunci = $this->request->getPost('kunci');

		if($kunci){
			$barang = $this->model_barang->select('barang.nama as nama, kode, gambar')->asArray()
			->where('barang.status', 1)
			->like('barang.nama', $kunci)->orLike('kategori.nama', $kunci)->orLike('deskripsi', $kunci)
			->orLike('merek.nama', $kunci)
			->join('kategori', 'kategori.id = barang.kategori_id')
			->join('merek', 'merek.id = barang.merek_id')
			->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
			->groupBy('barang.id')->paginate(8, 'beranda');
		}else{
			$barang = $this->model_barang->select('barang.nama as nama, gambar, kode')->asArray()
			->where('barang.status', 1)
			->join('kategori', 'kategori.id = barang.kategori_id')
			->join('merek', 'merek.id = barang.merek_id')
			->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
			->groupBy('barang.id')->paginate(8, 'beranda');
		}

		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();
	
		$data = [
			'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
				->where('surel', $email)
				->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'title' => ucfirst('Produk'),
			'barang' => $barang,
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'pager' => $this->model_barang->pager,
			'role_log' => $role,
			'form_beranda' => ['id' => 'formBeranda', 'name'=>'formBeranda'],
			'form_item' => ['id' => 'formItem', 'name'=>'formItem'],
			'form_cari' => ['id' => 'formCari', 'name'=>'formCari', 'class' => 'form-inline flex-nowrap form-domainSearch'],
		
		];
		tampilan_user('user/user-produk/v_produk', 'user/user-produk/v_js_produk', $data);
	}

	public function detail_produk($uri){

		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $surel)
		->first();

		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
			->where('surel', $surel)
			->first(),
			'title' => ucfirst('Detail Produk'),
			'barang' => $this->model_barang->select('barang.stok as stok_barang, barang.nama as nama_barang, barang.gambar as nama_gambar,
				kategori.nama as nama_kategori, satuan.nama as nama_satuan, merek.nama as nama_merek,
				user.nama as nama_penyuplai, harga_anggota, harga_konsumen, deskripsi, stok, kategori_id, satuan_id, merek_id, penyuplai_id')
				->asArray()
				->where('barang.status', 1)
				->join('satuan', 'satuan.id = barang.satuan_id')
				->join('kategori', 'kategori.id = barang.kategori_id')
				->join('merek', 'merek.id = barang.merek_id')
				->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
				->join('user', 'user.id = penyuplai.user_id')
				->where('kode', $uri)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'session' => $this->session,
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'role_log' => $role,
			'form_detail' => ['id' => 'formDetail', 'name'=>'formDetail']
			
		];
		tampilan_user('user/user-detail-produk/v_detail_produk', 'user/user-detail-produk/v_js_detail_produk', $data);
	}

	public function kategori(){
		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
			->where('surel', $surel)
			->first(),
			'title' => ucfirst('Kategori Produk'),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'jenis' => $this->model_kategori->select('nama, id')->asArray()->findAll(),
			'role_log' => $role
		];
		tampilan_user('user/user-kategori/v_kategori', 'user/user-kategori/v_js_kategori', $data);
	}


	public function detail_kategori($uri){
		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');

		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
				->where('surel', $surel)
				->first(),
			'title' => ucfirst('Detail Kategori'),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'judul' => $this->model_kategori->select('nama')->asArray()->where('id', $uri)->first(),
			'jenisuri' => $this->model_barang->select('nama, gambar, kode')->asArray()
					->where('barang.status', 1)
					->where('kategori_id', $uri)
					->findAll(),
			'role_log' => $role
		];
		tampilan_user('user/user-detail-kategori/v_detail_kategori', 'user/user-detail-kategori/v_js_detail_kategori', $data);
	}

	public function merek(){
		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
			->where('surel', $surel)
			->first(),
			'title' => ucfirst('Merek Produk'),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'merek' => $this->model_merek->select('nama, id')->asArray()->findAll(),
			'role_log' => $role
		];
		tampilan_user('user/user-merek/v_merek', 'user/user-merek/v_js_merek', $data);
	}


	public function detail_merek($uri){
		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');

		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
				->where('surel', $surel)
				->first(),
			'title' => ucfirst('Detail Merek'),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'judul' => $this->model_merek->select('nama')->asArray()->where('id', $uri)->first(),
			'merek' => $this->model_barang->select('nama, gambar, kode')->asArray()
						->where('merek_id', $uri)
						->where('barang.status', 1)
						->findAll(),
			'role_log' => $role
		];
		tampilan_user('user/user-detail-merek/v_detail_merek', 'user/user-detail-merek/v_js_detail_merek', $data);
	}



	public function penyuplai(){
		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
			->where('surel', $surel)
			->first(),
			'title' => ucfirst('penyuplai Produk'),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'penyuplai' => $this->model_penyuplai->select('user.nama as nama, penyuplai.id as id')->asArray()
				->where('user.role_id', 5)
				->where('user.status', 1)
				->join('user', 'user.id = penyuplai.user_id')
				->findAll(),
			'role_log' => $role
		];
		tampilan_user('user/user-penyuplai/v_penyuplai', 'user/user-penyuplai/v_js_penyuplai', $data);
	}


	public function detail_penyuplai($uri){
		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');

		$konfirm = $this->model_user->select('status')->asArray()
			->where('surel', $surel)
			->first();
		$data = [
			'user' => $this->model_user->select('user.nama as nama')->asArray()
				->where('surel', $surel)
				->first(),
			'title' => ucfirst('Detail penyuplai'),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'judul' => $this->model_penyuplai->select('user.nama as nama')->asArray()
				->where('penyuplai.id', $uri)
				->join('user', 'user.id = penyuplai.user_id')
				->first(),
			'penyuplai' => $this->model_barang->select('nama, gambar, kode')->asArray()
				->where('barang.status', 1)
				->where('penyuplai_id', $uri)
				->findAll(),
			'role_log' => $role
		];
		tampilan_user('user/user-detail-penyuplai/v_detail_penyuplai', 'user/user-detail-penyuplai/v_js_detail_penyuplai', $data);
	}	

}
