<?php namespace App\Controllers;

//require ROOTPATH. 'vendor/autoload.php';

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_transaksi_sementara;
use App\Models\ModelUser;
use App\Models\ModelMenu;


class Utang extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	
    public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');


        $data = [
            'title' => ucfirst('Daftar Utang'),
            'nama_menu_utama' => ucfirst('Penjualan'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
           'utang' => $this->model_transaksi_sementara->select('ts_kode_transaksi, DATEDIFF(CURDATE(), 
                    ts_tanggal_sementara)  as waktu,ts_uri ,ts_nama_pengutang, ts_nomor_pengutang, 
                    ts_tanggal_sementara')->asArray()
                    ->where('ts_status_transaksi', 2)
                    ->groupBy('ts_kode_transaksi')
                    ->orderBy('ts_tanggal_sementara')
                    ->findAll(),
           'session' => $this->session,

        ];
        tampilan_admin('admin/admin-utang/v_utang', 'admin/admin-utang/v_js_utang', $data);
    }


}
?>
