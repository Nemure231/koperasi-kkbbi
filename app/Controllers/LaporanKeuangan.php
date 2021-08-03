<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_toko;
use App\Models\Model_user;
use App\Models\Model_detail_transaksi;
use App\Models\Model_barang_masuk;

class LaporanKeuangan extends BaseController{

    public function __construct(){

	
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_detail_transaksi = new Model_detail_transaksi();
		$this->request = \Config\Services::request();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        date_default_timezone_set("Asia/Jakarta");

        $month = $this->request->getPost('cari_bulan');
        $year = $this->request->getPost('cari_tahun');

        // $bulan = $this->model_detail_transaksi->GetAllBarangKeluarBulanCari();
        $tanggal_ini = '';
        $pesan =  '';
        $bulan = '';
        if($month && $year){
            $bulan = $this->model_detail_transaksi->GetAllBarangKeluarBulanCari($month, $year);
            $tanggal_ini = $year.'-'.$month;
            
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
        
        $data = [
            'title' => ucfirst('Laporan Keuangan Bulanan'),
            'nama_menu_utama' => ucfirst('Keuangan'),
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
            'session'=> $this->session,
            'toko'  =>$this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
           'bulan' => $bulan,
           'pesan_bulan' => $pesan,
           'form_bulan' =>  ['id' => 'formBulan', 'name'=>'formBulan'],
           'tanggal' => $tanggal_ini,
           'input_bulan' => [
            'type' => 'text',
            'name' => 'cari_bulan',
            'id' => 'cari_bulan',
            'placeholder' => 'Cari cari bulan....',
            'class' => 'form-control',
            'required' => ''
           ],
           'input_tahun' => [
            'type' => 'text',
            'name' => 'cari_tahun',
            'id' => 'cari_tahun',
            'placeholder' => 'Cari tahun....',
            'class' => 'form-control',
            'required' => ''
        ]
        ];
        tampilan_admin('admin/admin-laporan-keuangan-bulanan/v_laporan_keuangan_bulanan', 'admin/admin-laporan-keuangan-bulanan/v_js_laporan_keuangan_bulanan', $data);
    }

    
    public function inde(){

      
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		

        

        date_default_timezone_set("Asia/Jakarta");

        $bulan = $this->request->getPost('cari_bulan');
        $tahun = $this->request->getPost('cari_tahun');

        $tanggal_keluar = $this->model_detail_transaksi->GetAllSummaryTanggalKeluar();
        $tanggal_masuk = $this->model_barang_masuk->GetAllSummaryTanggalMasuk();
        $tanggal_ini = '';
        $pesan =  '';

        if($bulan && $tahun){
            $tanggal_keluar = $this->model_detail_transaksi->GetAllSummaryTanggalKeluar($bulan, $tahun);
            $tanggal_masuk = $this->model_barang_masuk->GetAllSummaryTanggalMasuk($bulan, $tahun);
            $tanggal_ini = $bulan.'-'.$tahun;
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
        
        $data = [
            'title' => 'Summary Tanggal',
            'nama_menu_utama' => 'Summary',
            'user' 	=>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
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
            'toko' => $this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
            'tanggal_keluar' => $tanggal_keluar,
            'tanggal_masuk' => $tanggal_masuk,
            'pesan_tanggal' => $pesan,
            'form_tanggal' =>  ['id' => 'formTanggal', 'name'=>'formTanggal'],
            'tanggal_ini' => $tanggal_ini,
            'input_awal' => [
                'type' => 'text',
                'name' => 'cari_bulan',
                'id' => 'cari_bulan',
                'placeholder' => 'Cari bulan ....',
                'class' => 'form-control',
                'required' => ''
            ],
            'input_akhir' => [
                'type' => 'text',
                'name' => 'cari_tahun',
                'id' => 'cari_tahun',
                'placeholder' => 'Cari tahun ....',
                'class' => 'form-control',
                'required' => ''
        ]
        ];
        tampilan_admin('admin/admin-laporan-summary-tanggal/v_laporan_summary_tanggal', 'admin/admin-laporan-summary-tanggal/v_js_laporan_summary_tanggal', $data);
    }


  
    

}
?>
