<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;

class Masuk extends BaseController{

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

        $hari = $this->model->GetAllBarangMasukHariCari();
        $tanggal_ini = date('Y-m-d');
        $pesan =  '';

        if($tanggal){
            $hari = $this->model->GetAllBarangMasukHariCari($tanggal);
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

        $body = 'admin/admin-laporan-masuk-hari/v_laporan_masuk_hari';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-masuk-hari/v_laporan_masuk_hari_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-masuk-hari/v_laporan_masuk_hari';
        }
        
    
        $data = [
           
           'title' => ucfirst('Laporan Barang Masuk Harian'),
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
        tampilan_admin($body, 'admin/admin-laporan-masuk-hari/v_js_laporan_masuk_hari', $data);
    }

    public function barangmasukminggu(){
		
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
            $minggu = $this->model->GetAllBarangMasukMingguCari($awal_minggu, $akhir_minggu);
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


        $body = 'admin/admin-laporan-masuk-minggu/v_laporan_masuk_minggu';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-masuk-minggu/v_laporan_masuk_minggu_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-masuk-minggu/v_laporan_masuk_minggu';
        }
    
    
        $data = [
           
           'title' => ucfirst('Laporan Barang Masuk Mingguan'),
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
        tampilan_admin($body, 'admin/admin-laporan-masuk-minggu/v_js_laporan_masuk_minggu', $data);
    }


    public function barangmasukbulan(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
    


        $bulan= $this->request->getPost('cari_bulan');
        $tahun = $this->request->getPost('cari_tahun');

        $bulan1 = $this->model->GetAllBarangMasukBulanCari();
        $tanggal_ini = date('Y-m');
        $pesan =  '';
        if($bulan && $tahun){
            $bulan1 = $this->model->GetAllBarangMasukBulanCari($bulan, $tahun);
            $tanggal_ini = $tahun.'-'.$bulan;
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

        $body = 'admin/admin-laporan-masuk-bulan/v_laporan_masuk_bulan';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-masuk-bulan/v_laporan_masuk_bulan_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-masuk-bulan/v_laporan_masuk_bulan';
        }

        $data = [
           
           'title' => ucfirst('Laporan Barang Masuk Bulanan'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
           'bulan' => $bulan1,
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

    
        //dd();
        tampilan_admin($body, 'admin/admin-laporan-masuk-bulan/v_js_laporan_masuk_bulan', $data);
    }

    public function barangmasuktahun(){
		
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

        $tahun = $this->model->GetAllBarangMasukTahunCari();
        $tahun_ini = date('Y');
        $pesan =  '';

        if($cari_tahun){
            $tahun = $this->model->GetAllBarangMasukTahunCari($cari_tahun);
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

        $body = 'admin/admin-laporan-masuk-tahun/v_laporan_masuk_tahun';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-masuk-tahun/v_laporan_masuk_tahun_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-masuk-tahun/v_laporan_masuk_tahun';
        }
        
        $data = [
           
           'title' => ucfirst('Laporan Barang Masuk Tahunan'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
           'tahun' => $tahun,
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

    
        //dd();
        tampilan_admin($body, 'admin/admin-laporan-masuk-tahun/v_js_laporan_masuk_tahun', $data);
    }



	

}
?>
