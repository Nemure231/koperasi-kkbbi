<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
// use App\Models\Model_buku;
use App\Models\Model_barang;
use App\Models\Model_user;

class Produk extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model = new Model_all();
		// $this->model2 = new Model_buku();
		$this->model_user = new Model_user();
		$this->model_barang = new Model_barang();
		$this->cart = \Config\Services::cart();
		$this->request = \Config\Services::request();
	}

	public function index(){

		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$kunci = $this->request->getPost('kunci');

		if($kunci){
			//$barang = $this->model2->cariBuku($kunci);
			$barang = $this->model_barang->select('barang.nama as nama, kode')->asArray()
			->like('barang.nama', $kunci)->orLike('kategori.nama', $kunci)->orLike('deskripsi', $kunci)
			->orLike('merek.nama', $kunci)
			->join('kategori', 'kategori.id = barang.kategori_id')
			->join('merek', 'merek.id = barang.merek_id')
			->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
			->groupBy('barang.id')->paginate(8, 'beranda');
		}else{
			$barang = $this->model_barang->select('barang.nama as nama, kode')->asArray()
			->join('kategori', 'kategori.id = barang.kategori_id')
			->join('merek', 'merek.id = barang.merek_id')
			->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
			->groupBy('barang.id')->paginate(8, 'beranda');
		}

		//dd($this->model->GetAllKeranjang());
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();
	
		$data = [
			'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as 
				email, telepon, gambar, alamat, role.nama as role')->asArray()
				->join('role', 'role.id = user.role_id')
				->where('surel', $email)
				->first(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'title' => ucfirst('Produk'),
			'barang' => $barang,
			'pager' => $this->model_barang->pager,
			'role_log' => $role,
			// 'keranjang' => $this->model->GetAllKeranjang()
			// 'cart' => $this->cart->contents(),
			'form_beranda' => ['id' => 'formBeranda', 'name'=>'formBeranda'],
			'form_item' => ['id' => 'formItem', 'name'=>'formItem'],
			'form_cari' => ['id' => 'formCari', 'name'=>'formCari', 'class' => 'form-inline flex-nowrap form-domainSearch'],
			// 'input_judul' => [
            //     'type' => 'text',
            //     'name' => 'judul_buku_beranda',
            //     'id' => 'judul_buku_beranda',
			// 	'class' => 'form-control-plaintext',
			// 	'readonly' => ''
			// ],
			// 'input_genre' => [
            //     'type' => 'text',
            //     'name' => 'genre_beranda',
            //     'id' => 'genre_beranda',
			// 	'class' => 'form-control-plaintext',
			// 	'readonly' => ''
			// ],
			// 'input_penulis' => [
            //     'type' => 'text',
            //     'name' => 'penulis_beranda',
            //     'id' => 'penulis_beranda',
			// 	'class' => 'form-control-plaintext',
			// 	'readonly' => ''
			// ],
			// 'input_penerbit' => [
            //     'type' => 'text',
            //     'name' => 'penerbit_beranda',
            //     'id' => 'penerbit_beranda',
			// 	'class' => 'form-control-plaintext',
			// 	'readonly' => ''
			// ],
			// 'input_jenis_buku' => [
            //     'type' => 'text',
            //     'name' => 'jenis_buku_beranda',
            //     'id' => 'jenis_buku_beranda',
			// 	'class' => 'form-control-plaintext',
			// 	'readonly' => ''
			// ],
			// 'input_blurb' => [
            //     'type' => 'text',
            //     // 'name' => 'blurb_beranda',
            //     'id' => 'blurb_beranda',
			// 	'class' => 'form-control-plaintext',
			// 	'readonly' => ''
            // ],
		];
		tampilan_user('user/user-produk/v_produk', 'user/user-produk/v_js_produk', $data);
		

	}

	public function tambahkeranjang(){ 
		

		$arr = $this->model->TambahKeranjang();
		echo json_encode($arr);
		
	}
	
	public function detail_produk($uri){

		$role = $this->session->get('role_id');
		$surel = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $surel)
		->first();

		$data = [
			'user' => $this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
			->join('role', 'role.id = user.role_id')
			->where('surel', $surel)
			->first(),
			'title' => ucfirst('Detail Produk'),
			'barang' => $this->model_barang->select('barang.nama as nama_barang, barang.gambar as nama_gambar,
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
			// 'genre' => $this->model->GetAllGenreDetailBuku($uri),
			// 'penerbit' => $this->model->GetAllPenerbitDetailBuku($uri),
			// 'penulis' => $this->model->GetAllPenulisDetailBuku($uri),
			// 'keranjang' => $this->model->GetAllKeranjang(),
			'role_log' => $role,
			'form_detail' => ['id' => 'formDetail', 'name'=>'formDetail']
			
		];
		tampilan_user('user/user-detail-produk/v_detail_produk', 'user/user-detail-produk/v_js_detail_produk', $data);
	}

	public function jenis(){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Jenis Produk'),
			'jenis' => $this->model->GetAllJenisBukuForUser(),
			'role_log' => $role
		];
		tampilan_user('user/user-jenis-produk/v_jenis_produk', 'user/user-jenis-produk/v_js_jenis_produk', $data);
	}


	public function detail_jenis($uri){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Detail Jenis Produk'),
			'judul' => $this->model->GetAllJenisBukuUriJudul($uri),
			'jenisuri' => $this->model->GetAllJenisBukuUri($uri),
			'role_log' => $role
			

		];
		tampilan_user('user/user-detail-jenis-produk/v_detail_jenis_produk', 'user/user-detail-jenis-produk/v_js_detail_jenis_produk', $data);
	}

	public function penerbit(){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Daftar Penerbit'),
			'penerbit' => $this->model->GetAllPenerbitForUser(),
			'role_log' => $role
		];
		tampilan_user('user/user-penerbit/v_penerbit', 'user/user-penerbit/v_js_penerbit', $data);
	}


	public function detail_penerbit($uri){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Detail Penerbit'),
			'judul' => $this->model->GetAllPenerbitUriJudul($uri),
			'penerbituri' => $this->model->GetAllPenerbitUri($uri),
			'role_log' => $role
			
		];
		tampilan_user('user/user-detail-penerbit/v_detail_penerbit','user/user-detail-penerbit/v_js_detail_penerbit', $data);
	}

	public function genre(){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Daftar Genre'),
			'genre' => $this->model->GetAllGenreForUser(),
			'role_log' => $role
		];
		tampilan_user('user/user-genre/v_genre', 'user/user-genre/v_js_genre', $data);
	}


	public function detail_genre($uri){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Detail Genre'),
			'judul' => $this->model->GetAllGenreUriJudul($uri),
			'genreuri' => $this->model->GetAllGenreUri($uri),
			'role_log' => $role
			
		];
		tampilan_user('user/user-detail-genre/v_detail_genre','user/user-detail-genre/v_js_detail_genre', $data);
	}

	public function penulis(){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Daftar Penulis'),
			'penulis' => $this->model->GetAllPenulisForUser(),
			'role_log' => $role
		];
		tampilan_user('user/user-penulis/v_penulis', 'user/user-penulis/v_js_penulis', $data);
	}


	public function detail_penulis($uri){
		$role = $this->session->get('role_id');
		$data = [
			'user' => $this->model->UserLogin(),
			'title' => ucfirst('Detail Penulis'),
			'judul' => $this->model->GetAllPenulisUriJudul($uri),
			'penulisuri' => $this->model->GetAllPenulisUri($uri),
			'role_log' => $role
			
		];
		tampilan_user('user/user-detail-penulis/v_detail_penulis','user/user-detail-penulis/v_js_detail_penulis', $data);
	}


	

	

}
