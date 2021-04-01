<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_user_menu;
use App\Models\Model_transaksi_total;
use App\Models\ModelUser;
use App\Models\ModelMenu;
class LaporanKeluar extends BaseController{

    public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_transaksi_total = new Model_transaksi_total();
		$this->request = \Config\Services::request();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	
    
    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        

        date_default_timezone_set("Asia/Jakarta");

        $awal_minggu = $this->request->getPost('cari_awal_minggu');
        $akhir_minggu = $this->request->getPost('cari_akhir_minggu');

        $minggu = '';
        $minggu_ini = '';
        $pesan =  '';

        if($awal_minggu && $akhir_minggu){
            $minggu = $this->model_transaksi_total->GetAllBarangKeluarMingguCari($awal_minggu, $akhir_minggu);
            $minggu_ini = $awal_minggu.' ~ '.$akhir_minggu;
            $pesan = '<div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                Transaksi berhasil dicari!
            </div>
            </div>
        ';
        }

        $body = 'admin/admin-laporan-keluar/v_laporan_keluar';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-keluar/v_laporan_keluar_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-keluar/v_laporan_keluar';
        }
        
         
        if($gaya == 3){
            $body = 'admin/admin-laporan-keluar/v_laporan_keluar_list_supplier';
            $minggu = $this->model_transaksi_total->GetAllBarangKeluarMingguCariTambah($awal_minggu, $akhir_minggu);
        }
        
        $data = [
           
            'title' => ucfirst('Laporan Keluar'),
            'nama_menu_utama' => ucfirst('Barang Keluar'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'session'=> $this->session,
            'toko'  =>$this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
           'minggu' => $minggu,
           'pesan_minggu' => $pesan,
           'form_minggu' =>  ['id' => 'formMinggu', 'name'=>'formMinggu'],
           'minggu_ini' => $minggu_ini,
           'input_awal_minggu' => [
            'type' => 'text',
            'name' => 'cari_awal_minggu',
            'id' => 'cari_awal_minggu',
            'placeholder' => 'Cari awal minggu ....',
            'class' => 'form-control',
            'required' => ''
           ],
           'input_akhir_minggu' => [
            'type' => 'text',
            'name' => 'cari_akhir_minggu',
            'id' => 'cari_akhir_minggu',
            'placeholder' => 'Cari akhir minggu....',
            'class' => 'form-control',
            'required' => ''
        ]
        ];
        tampilan_admin($body, 'admin/admin-laporan-keluar/v_js_laporan_keluar', $data);
    }




}
?>
