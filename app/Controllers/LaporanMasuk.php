<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_user_menu;
use App\Models\Model_barang_masuk;
use App\Models\Users;

class LaporanMasuk extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_barang_masuk = new Model_barang_masuk();
		$this->request = \Config\Services::request();
        $this->user = new Users();
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
            $minggu = $this->model_barang_masuk->GetAllBarangMasukMingguCari($awal_minggu, $akhir_minggu);
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


        $body = 'admin/admin-laporan-masuk/v_laporan_masuk';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-masuk/v_laporan_masuk_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-masuk/v_laporan_masuk';
        }
    
    
        $data = [
           
            'title' => ucfirst('Masuk Mingguan'),
            'nama_menu_utama' => ucfirst('Barang Masuk'),
            'user' 	=> 	$this->user->ambilSatuUserBuatProfil()['users'],
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
            'session' => $this->session,
            'toko' => $this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
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

    
        //dd();
        tampilan_admin($body, 'admin/admin-laporan-masuk/v_js_laporan_masuk', $data);
    }


   



	

}
?>
