<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_toko;
use App\Models\Model_user;
use App\Models\Model_transaksi_total;
use App\Models\Model_barang_masuk;

class LaporanSummary extends BaseController{

    public function __construct(){

	
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_transaksi_total = new Model_transaksi_total();
		$this->request = \Config\Services::request();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    
    public function index(){

        // for($i =1; $i <= date('t'); $i++){
        //     $dates[] = date('Y') . "-". date('m'). "-".str_pad($i, 2, '0', STR_PAD_LEFT);
        // }

        // dd($dates);
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        date_default_timezone_set("Asia/Jakarta");

        $bulan = $this->request->getPost('cari_bulan');
        $tahun = $this->request->getPost('cari_tahun');

        $tanggal_keluar = $this->model_transaksi_total->GetAllSummaryTanggalKeluar();
        $tanggal_masuk = $this->model_barang_masuk->GetAllSummaryTanggalMasuk();
        $tanggal_ini = '';
        $pesan =  '';

        if($bulan && $tahun){
            $tanggal_keluar = $this->model_transaksi_total->GetAllSummaryTanggalKeluar($bulan, $tahun);
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
            'title' => ucfirst('Summary Tanggal'),
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


    public function bulan(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        date_default_timezone_set("Asia/Jakarta");

        $tahun = $this->request->getPost('cari_tahun');

        $bulan_keluar = $this->model_transaksi_total->GetAllSummaryBulanKeluar();
        $bulan_masuk = $this->model_barang_masuk->GetAllSummaryBulanMasuk();
        $bulan_ini = date('Y');
        $pesan =  '';

        if($tahun){
            $bulan_keluar = $this->model_transaksi_total->GetAllSummaryBulanKeluar($tahun);
            $bulan_masuk = $this->model_barang_masuk->GetAllSummaryBulanMasuk($tahun);
            $bulan_ini = $tahun;
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
            'title' => ucfirst('Summary Bulan'),
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
            'toko'  =>$this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
            'bulan_keluar' => $bulan_keluar,
            'bulan_masuk' => $bulan_masuk,
            'pesan_bulan' => $pesan,
            'form_bulan' =>  ['id' => 'formBulan', 'name'=>'formBulan'],
            'bulan_ini' => $bulan_ini,
            'input_tahun' => [
                'type' => 'text',
                'name' => 'cari_tahun',
                'id' => 'cari_tahun',
                'placeholder' => 'Cari tahun ....',
                'class' => 'form-control',
                'required' => ''
            ]
        ];
        tampilan_admin('admin/admin-laporan-summary-bulan/v_laporan_summary_bulan', 'admin/admin-laporan-summary-bulan/v_js_laporan_summary_bulan', $data);
    }



    public function tahun(){

		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        date_default_timezone_set("Asia/Jakarta");

        $awal = $this->request->getPost('cari_awal');
        $akhir = $this->request->getPost('cari_akhir');

        $tahun_keluar = '';
        $tahun_masuk = '';
        $tahun_ini = '';
        $pesan =  '';

        if($awal && $akhir){
            $tahun_keluar = $this->model_transaksi_total->GetAllSummaryTahunKeluar($awal, $akhir);
            $tahun_masuk = $this->model_barang_masuk->GetAllSummaryTahunMasuk($awal, $akhir);
            $tahun_ini = $awal.' ~ '.$akhir;
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
           
            'title' => ucfirst('Summary Tahun'),
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
            'tahun_keluar' => $tahun_keluar,
            'tahun_masuk' => $tahun_masuk,
            'pesan_tahun' => $pesan,
            'form_tahun' =>  ['id' => 'formTahun', 'name'=>'formTahun'],
            'tahun_ini' => $tahun_ini,
            'input_awal' => [
                'type' => 'text',
                'name' => 'cari_awal',
                'id' => 'cari_awal',
                'placeholder' => 'Cari tahun awal ....',
                'class' => 'form-control',
                'required' => ''
            ],
            'input_akhir' => [
                'type' => 'text',
                'name' => 'cari_akhir',
                'id' => 'cari_akhir',
                'placeholder' => 'Cari tahunakhir ....',
                'class' => 'form-control',
                'required' => ''
            ]
        ];
        tampilan_admin('admin/admin-laporan-summary-tahun/v_laporan_summary_tahun', 'admin/admin-laporan-summary-tahun/v_js_laporan_summary_tahun', $data);
    }


    

}
?>
