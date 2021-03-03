<?php namespace App\Controllers;

//require ROOTPATH. 'vendor/autoload.php';

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_transaksi_sementara;


class Utang extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	
    public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');

		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }

        $data = [
            'title' => ucfirst('Daftar Utang'),
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
