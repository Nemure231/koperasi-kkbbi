<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;

class Dashboard extends BaseController{

	public function __construct(){
		$this->model = new Model_all();
		
	}
	protected $helpers = ['url', 'array', 'kpos'];

	public function index(){
		
		//$session = \Config\Services::session();
		
		$role = $this->session->get('role_id');
		
		//is_logged_in();
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
		
		
		
// dd($this->model->GetChartMasukBulan());
		$data = [
			'title' => ucfirst('Dashboard Masuk'),
			'user' => $this->model->UserLogin(),
			'menu' => $this->model->MenuAll(),
			'session' => $this->session,
			'row_masuk_hari' => $this->model->GetRowBarangMasukHari(),
			'row_masuk_bulan' => $this->model->GetRowBarangMasukBulan(),
			'row_masuk_tahun' => $this->model->GetRowBarangMasukTahun(),
			
			'chart_masuk_tanggal' => $this->model->GetChartMasukTanggal(),
			'chart_masuk_bulan' => $this->model->GetChartMasukBulan(),
			'chart_masuk_tahun' => $this->model->GetChartMasukTahun()
		];
		tampilan_admin('admin/admin-dashboard/v_dashboard', 'admin/admin-dashboard/v_js_dashboard', $data);
	}

	public function keluar(){
		
		//$session = \Config\Services::session();
		
		$role = $this->session->get('role_id');
		
		//is_logged_in();
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
		
		
		
// dd($this->model->GetChartMasukBulan());
		$data = [
			'title' => ucfirst('Dashboard Keluar'),
			'user' => $this->model->UserLogin(),
			'menu' => $this->model->MenuAll(),
			'session' => $this->session,
			'row_keluar_hari' => $this->model->GetRowBarangKeluarHari(),
			'row_keluar_bulan' => $this->model->GetRowBarangKeluarBulan(),
			'row_keluar_tahun' => $this->model->GetRowBarangKeluarTahun(),
			'chart_keluar_tanggal' => $this->model->GetChartKeluarTanggal(),
			'chart_keluar_bulan' => $this->model->GetChartKeluarBulan(),
			'chart_keluar_tahun' => $this->model->GetChartKeluarTahun()
		];
		tampilan_admin('admin/admin-dashboard-keluar/v_dashboard_keluar', 'admin/admin-dashboard-keluar/v_js_dashboard_keluar', $data);
	}

	// public function ambilcharttanggal(){ 
		
	// 	$arr = $this->model->GetChartTanggal();
	// 	echo json_encode(array("data" => $arr));

	// 	$role = $this->session->get('role_id');
		
	// 	//is_logged_in();
		
	// 	if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
	// 	$userAccess = $this->model->Tendang();
    //     if ($userAccess < 1) {
    //             return redirect()->to(base_url('blokir'));
    //     }

		
		
    // }

}
