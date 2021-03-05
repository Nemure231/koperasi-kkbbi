<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_barang_masuk;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_transaksi_total;

class Dashboard extends BaseController{

	public function __construct(){
		$this->model_barang_masuk = new Model_barang_masuk();
		$this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
		$this->model_transaksi_total = new Model_transaksi_total();

		date_default_timezone_set("Asia/Jakarta");

		
		
		
	}
	protected $helpers = ['url', 'array', 'kpos', 'date'];

	public function index(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$hari= date('d');
        $bulan= date('m');
        $tahun= date('Y');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model_user_menu->Tendang();
    	if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
    	}

		$data = [
			'title' => 	ucfirst('Dashboard Masuk'),
			'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
						->join('user_role', 'user_role.id_role = user.role_id')
						->where('email', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
			'session' => $this->session,
			'row_masuk_hari' => $this->model_barang_masuk->selectSUM('total_harga_pokok', 'total_bmh')
						->selectSUM('jumlah_barang_masuk', 'total_jbm')->asArray()
						->groupBy('DAY(tanggal_masuk)')
						->where('DAY(tanggal_masuk)', $hari)
						->where('MONTH(tanggal_masuk)', $bulan)
						->where('YEAR(tanggal_masuk)', $tahun)
						->first(),
			'row_masuk_bulan' =>$this->model_barang_masuk->selectSUM('total_harga_pokok', 'total_bmb')
						->selectSUM('jumlah_barang_masuk', 'total_jbm')->asArray()
						->groupBy('MONTH(tanggal_masuk)')
						->where('MONTH(tanggal_masuk)', $bulan)
						->where('YEAR(tanggal_masuk)', $tahun)
						->first(),
			'row_masuk_tahun' =>$this->model_barang_masuk->selectSUM('total_harga_pokok', 'total_bmt')
						->selectSUM('jumlah_barang_masuk', 'total_jbm')->asArray()
						->groupBy('YEAR(tanggal_masuk)')
						->where('YEAR(tanggal_masuk)', $tahun)
						->first(),
			'chart_masuk_tanggal'=>	$this->model_barang_masuk->select('DATE(tanggal_masuk) AS tanggal')->asArray()
						->selectSUM('total_harga_pokok', 'thp')
						->where('MONTH(tanggal_masuk)', $bulan)
						->where('YEAR(tanggal_masuk)', $tahun)
						->groupBy('DATE(tanggal_masuk)')
						->orderBy('tanggal', 'ASC')
						->findAll(),
			'chart_masuk_bulan' =>$this->model_barang_masuk->select('MONTHNAME(tanggal_masuk) AS bulan')->asArray()
						->selectSUM('total_harga_pokok', 'tmb')
						->where('YEAR(tanggal_masuk)', $tahun)
						->groupBy('MONTH(tanggal_masuk)')
						->orderBy('MONTH(tanggal_masuk)', 'ASC')
						->findAll(),
			'chart_masuk_tahun'=>$builder = $this->model_barang_masuk->select('YEAR(tanggal_masuk) AS tahun')->asArray()
						->selectSUM('total_harga_pokok', 'thm')
						->groupBy('YEAR(tanggal_masuk)')
						->orderBy('YEAR(tanggal_masuk)', 'ASC')
						->findAll()
		];
		tampilan_admin('admin/admin-dashboard/v_dashboard', 'admin/admin-dashboard/v_js_dashboard', $data);
	}

	public function keluar(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		$hari= date('d');
        $bulan= date('m');
        $tahun= date('Y');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
    	    return redirect()->to(base_url('blokir'));
        }
		
		
		
// dd($this->model->GetChartMasukBulan());
		$data = [
			'title' => ucfirst('Dashboard Keluar'),
			'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
						->join('user_role', 'user_role.id_role = user.role_id')
						->where('email', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
			'session' => $this->session,
			'row_keluar_hari'=>	$this->model_transaksi_total->selectSUM('tt_total_harga', 'total_bkh')
								->selectSUM('tt_total_qty', 'total_ttq')->asArray()
								->groupBy('DAY(tt_tanggal_beli)')
								//->where('id_transaksi_total>', 0);
								->where('id_transaksi_total>', 1)
								->where('DAY(tt_tanggal_beli)', $hari)
								->where('MONTH(tt_tanggal_beli)', $bulan)
								->where('YEAR(tt_tanggal_beli)', $tahun)
								->first(),
			'row_keluar_bulan' =>$this->model_transaksi_total->selectSUM('tt_total_harga', 'total_bkb')
								->selectSUM('tt_total_qty', 'total_ttq')->asArray()
								->groupBy('MONTH(tt_tanggal_beli)')
								->where('id_transaksi_total>', 1)
								->where('MONTH(tt_tanggal_beli)', $bulan)
								->where('YEAR(tt_tanggal_beli)', $tahun)
								->first(),
			'row_keluar_tahun'=>$this->model_transaksi_total->selectSUM('tt_total_harga', 'total_bkt')	
								->selectSUM('tt_total_qty', 'total_ttq')->asArray()
								->groupBy('YEAR(tt_tanggal_beli)')
								->where('id_transaksi_total>', 1)
								->where('YEAR(tt_tanggal_beli)', $tahun)
								->first(),
			'chart_keluar_tanggal' => $this->model_transaksi_total->select('DATE(tt_tanggal_beli) AS tanggal')
								->selectSUM('tt_total_harga', 'tck')->asArray()
								->where('id_transaksi_total>', 0)
								->where('MONTH(tt_tanggal_beli)', $bulan)
								->where('YEAR(tt_tanggal_beli)', $tahun)
								->groupBy('DATE(tt_tanggal_beli)')
								->orderBy('tanggal', 'ASC')
								->findAll(),
			'chart_keluar_bulan'=>$this->model_transaksi_total->select('MONTHNAME(tt_tanggal_beli) AS bulan')
								->selectSUM('tt_total_harga', 'tkb')->asArray()
								->where('id_transaksi_total>', 1)
								->where('YEAR(tt_tanggal_beli)', date('y'))
								->groupBy('MONTH(tt_tanggal_beli)')
								->orderBy('MONTH(tt_tanggal_beli)', 'ASC')
								->findAll(),
			'chart_keluar_tahun'=> $this->model_transaksi_total->select('YEAR(tt_tanggal_beli) AS tahun')
								->selectSUM('tt_total_harga', 'tkt')->asArray()
								->where('id_transaksi_total>', 1)
								->groupBy('YEAR(tt_tanggal_beli)')
								->orderBy('YEAR(tt_tanggal_beli)', 'ASC')
								->findAll()
		];
		tampilan_admin('admin/admin-dashboard-keluar/v_dashboard_keluar', 'admin/admin-dashboard-keluar/v_js_dashboard_keluar', $data);
	}


}
