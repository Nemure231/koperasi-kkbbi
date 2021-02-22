<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;

class Keluar extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
		$this->request = \Config\Services::request();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	
    public function index(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }

        $tanggal = $this->request->getPost('cari_tanggal');

        $hari = $this->model->GetAllBarangKeluarHariCari();
        $tanggal_ini = date('Y-m-d');
        $pesan =  '';

        if($tanggal){
            $hari = $this->model->GetAllBarangKeluarHariCari($tanggal);
            $tanggal_ini = $tanggal;
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

        $body = 'admin/admin-laporan-keluar-hari/v_laporan_keluar_hari';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-keluar-hari/v_laporan_keluar_hari_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-keluar-hari/v_laporan_keluar_hari';
        }

        if($gaya == 3){
            $body = 'admin/admin-laporan-keluar-hari/v_laporan_keluar_hari_list_supplier';
            $hari = $this->model->GetAllBarangKeluarHariCariTambah($tanggal);
        }
    
    
        $data = [
           
           'title' => ucfirst('Laporan Barang Keluar Harian'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
           'hari' => $hari,
           'pesan_hari' => $pesan,
           'tanggal_ini' => $tanggal_ini,
           'form_hari' =>  ['id' => 'formHari', 'name'=>'formHari'],
           'input_tanggal' => [
            'type' => 'text',
            'name' => 'cari_tanggal',
            'id' => 'cari_tanggal',
            'placeholder' => 'Cari tanggal ....',
            'class' => 'form-control',
            'required' => ''
           ],
           
        ];

    
        //dd();
        tampilan_admin($body, 'admin/admin-laporan-keluar-hari/v_js_laporan_keluar_hari', $data);
    }

    public function barangkeluarminggu(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        date_default_timezone_set("Asia/Jakarta");

        $awal_minggu = $this->request->getPost('cari_awal_minggu');
        $akhir_minggu = $this->request->getPost('cari_akhir_minggu');

        $minggu = '';
        $minggu_ini = '';
        $pesan =  '';

        if($awal_minggu && $akhir_minggu){
            $minggu = $this->model->GetAllBarangKeluarMingguCari($awal_minggu, $akhir_minggu);
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

        $body = 'admin/admin-laporan-keluar-minggu/v_laporan_keluar_minggu';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-keluar-minggu/v_laporan_keluar_minggu_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-keluar-minggu/v_laporan_keluar_minggu';
        }
        
         
        if($gaya == 3){
            $body = 'admin/admin-laporan-keluar-minggu/v_laporan_keluar_minggu_list_supplier';
            $minggu = $this->model->GetAllBarangKeluarMingguCariTambah($awal_minggu, $akhir_minggu);
        }
        
        $data = [
           
           'title' => ucfirst('Laporan Barang Keluar Mingguan'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
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
        tampilan_admin($body, 'admin/admin-laporan-keluar-minggu/v_js_laporan_keluar_minggu', $data);
    }


    public function barangkeluarbulan(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
        date_default_timezone_set("Asia/Jakarta");

        $month = $this->request->getPost('cari_bulan');
        $year = $this->request->getPost('cari_tahun');

        $bulan = $this->model->GetAllBarangKeluarBulanCari();
        $tanggal_ini = date('Y-m');
        $pesan =  '';
        if($month && $year){
            $bulan = $this->model->GetAllBarangKeluarBulanCari($month, $year);
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

        $body = 'admin/admin-laporan-keluar-bulan/v_laporan_keluar_bulan';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-keluar-bulan/v_laporan_keluar_bulan_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-keluar-bulan/v_laporan_keluar_bulan';
        }


        if($gaya == 3){
            $body = 'admin/admin-laporan-keluar-bulan/v_laporan_keluar_bulan_list_supplier';
            $bulan = $this->model->GetAllBarangKeluarBulanCariTambah($month, $year);
        }
        
        $data = [
           
           'title' => ucfirst('Laporan Barang Keluar Bulanan'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
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
        tampilan_admin($body, 'admin/admin-laporan-keluar-bulan/v_js_laporan_keluar_bulan', $data);
    }

    public function barangkeluartahun(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
        date_default_timezone_set("Asia/Jakarta");

        $cari_tahun = $this->request->getPost('cari_tahun');

        $tahun = $this->model->GetAllBarangKeluarTahunCari();
        $tahun_ini = date('Y');
        $pesan =  '';

        if($cari_tahun){
            $tahun = $this->model->GetAllBarangKeluarTahunCari($cari_tahun);
            $tahun_ini = $cari_tahun;
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

        $body = 'admin/admin-laporan-keluar-tahun/v_laporan_keluar_tahun';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-keluar-tahun/v_laporan_keluar_tahun_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-keluar-tahun/v_laporan_keluar_tahun';
        }

        if($gaya == 3){
            $body = 'admin/admin-laporan-keluar-tahun/v_laporan_keluar_tahun_list_supplier';
            $tahun = $this->model->GetAllBarangKeluarTahunCariTambah($cari_tahun);
        }
        
    
        $data = [
           
           'title' => ucfirst('Laporan Barang Keluar Tahunan'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'test' => $this->model->Trop(),
           'toko' => $this->model->GetRowTokoForLaporan(),
           'tahun' => $tahun,
           'tahun_masuk' => $this->model->GetAllBarangMasukTahunCari(),
           'pesan_tahun' => $pesan,
           'tahun_ini' => $tahun_ini,
           'form_tahun' =>  ['id' => 'formTahun', 'name'=>'formTahun'],
           'input_tahun' => [
            'type' => 'text',
            'name' => 'cari_tahun',
            'id' => 'cari_tahun',
            'placeholder' => 'Cari tahun ....',
            'class' => 'form-control',
            'required' => ''
           ],
           
        ];

        tampilan_admin($body, 'admin/admin-laporan-keluar-tahun/v_js_laporan_keluar_tahun', $data);
    }




}
?>
