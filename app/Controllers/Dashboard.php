<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_barang_masuk;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_detail_transaksi;

class Dashboard extends BaseController{

	public function __construct(){
		$this->model_barang_masuk = new Model_barang_masuk();
		$this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
		$this->model_detail_transaksi = new Model_detail_transaksi();

		date_default_timezone_set("Asia/Jakarta");	
	}
	protected $helpers = ['url', 'array', 'kpos', 'date'];

	public function index(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$hari= date('d');
        $bulan= date('m');
        $tahun= date('Y');
		

		$data = [
			'title' => 	'Dashboard Masuk',
			'nama_menu_utama' => 'Dashboard',
			'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
						->join('role', 'role.id = user.role_id')
						->where('surel', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
			'session' => $this->session,
			'row_masuk_hari' => $this->model_barang_masuk->selectSUM('total_harga_pokok', 'total_bmh')
						->selectSUM('jumlah', 'total_jbm')->asArray()
						->groupBy('DAY(tanggal)')
						->where('DAY(tanggal)', $hari)
						->where('MONTH(tanggal)', $bulan)
						->where('YEAR(tanggal)', $tahun)
						->first(),
			'row_masuk_bulan' =>$this->model_barang_masuk->selectSUM('total_harga_pokok', 'total_bmb')
						->selectSUM('jumlah', 'total_jbm')->asArray()
						->groupBy('MONTH(tanggal)')
						->where('MONTH(tanggal)', $bulan)
						->where('YEAR(tanggal)', $tahun)
						->first(),
			'row_masuk_tahun' =>$this->model_barang_masuk->selectSUM('total_harga_pokok', 'total_bmt')
						->selectSUM('jumlah', 'total_jbm')->asArray()
						->groupBy('YEAR(tanggal)')
						->where('YEAR(tanggal)', $tahun)
						->first(),
			
			'chart_masuk_tanggal'=>	$this->model_barang_masuk->select('DATE(tanggal) AS tanggal')->asArray()
						->selectSUM('total_harga_pokok', 'thp')
						->where('MONTH(tanggal)', $bulan)
						->where('YEAR(tanggal)', $tahun)
						->groupBy('DATE(tanggal)')
						->orderBy('tanggal', 'ASC')
						->findAll(),
			'chart_masuk_bulan' =>$this->model_barang_masuk->select('MONTHNAME(tanggal) AS bulan')->asArray()
						->selectSUM('total_harga_pokok', 'tmb')
						->where('YEAR(tanggal)', $tahun)
						->groupBy('MONTH(tanggal)')
						->orderBy('MONTH(tanggal)', 'ASC')
						->findAll(),
			'chart_masuk_tahun'=>$builder = $this->model_barang_masuk->select('YEAR(tanggal) AS tahun')->asArray()
						->selectSUM('total_harga_pokok', 'thm')
						->groupBy('YEAR(tanggal)')
						->orderBy('YEAR(tanggal)', 'ASC')
						->findAll(),
			
		];
		tampilan_admin('admin/admin-dashboard/v_dashboard', 'admin/admin-dashboard/v_js_dashboard', $data);
	}

	public function keluar(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$hari= date('d');
        $bulan= date('m');
        $tahun= date('Y');
				
		$data = [
			'title' => 'Dashboard Keluar',
			'nama_menu_utama' => 'Dashboard',
			'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
						->join('role', 'role.id = user.role_id')
						->where('surel', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
			'session' => $this->session,
			'row_keluar_hari'=>	$this->model_detail_transaksi->selectSUM('total_harga', 'total_bkh')
								->selectSUM('total_qty', 'total_ttq')->asArray()
								->groupBy('DAY(tanggal)')
								//->where('id>', 0);
								->where('id>', 1)
								->where('DAY(tanggal)', $hari)
								->where('MONTH(tanggal)', $bulan)
								->where('YEAR(tanggal)', $tahun)
								->first(),
			'row_keluar_bulan' =>$this->model_detail_transaksi->selectSUM('total_harga', 'total_bkb')
								->selectSUM('total_qty', 'total_ttq')->asArray()
								->groupBy('MONTH(tanggal)')
								->where('id>', 1)
								->where('MONTH(tanggal)', $bulan)
								->where('YEAR(tanggal)', $tahun)
								->first(),
			'row_keluar_tahun'=>$this->model_detail_transaksi->selectSUM('total_harga', 'total_bkt')	
								->selectSUM('total_qty', 'total_ttq')->asArray()
								->groupBy('YEAR(tanggal)')
								->where('id>', 1)
								->where('YEAR(tanggal)', $tahun)
								->first(),
			'chart_keluar_tanggal' => $this->model_detail_transaksi->select('DATE(tanggal) AS tanggal')
								->selectSUM('total_harga', 'tck')->asArray()
								->where('id>', 0)
								->where('MONTH(tanggal)', $bulan)
								->where('YEAR(tanggal)', $tahun)
								->groupBy('DATE(tanggal)')
								->orderBy('tanggal', 'ASC')
								->findAll(),
			'chart_keluar_bulan'=>$this->model_detail_transaksi->select('MONTHNAME(tanggal) AS bulan')
								->selectSUM('total_harga', 'tkb')->asArray()
								->where('id>', 1)
								->where('YEAR(tanggal)', date('y'))
								->groupBy('MONTH(tanggal)')
								->orderBy('MONTH(tanggal)', 'ASC')
								->findAll(),
			'chart_keluar_tahun'=> $this->model_detail_transaksi->select('YEAR(tanggal) AS tahun')
								->selectSUM('total_harga', 'tkt')->asArray()
								->where('id>', 1)
								->groupBy('YEAR(tanggal)')
								->orderBy('YEAR(tanggal)', 'ASC')
								->findAll()
		];
		tampilan_admin('admin/admin-dashboard-keluar/v_dashboard_keluar', 'admin/admin-dashboard-keluar/v_js_dashboard_keluar', $data);
	}


}
