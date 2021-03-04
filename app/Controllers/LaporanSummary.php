<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;

class LaporanRetur extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
		$this->request = \Config\Services::request();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    
    public function summary_tanggal(){

        // for($i =1; $i <= date('t'); $i++){
        //     $dates[] = date('Y') . "-". date('m'). "-".str_pad($i, 2, '0', STR_PAD_LEFT);
        // }

        // dd($dates);
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        date_default_timezone_set("Asia/Jakarta");

        $bulan = $this->request->getPost('cari_bulan');
        $tahun = $this->request->getPost('cari_tahun');

        $tanggal_keluar = $this->model->GetAllSummaryTanggalKeluar();
        $tanggal_masuk = $this->model->GetAllSummaryTanggalMasuk();
        $tanggal_ini = '';
        $pesan =  '';

        if($bulan && $tahun){
            $tanggal_keluar = $this->model->GetAllSummaryTanggalKeluar($bulan, $tahun);
            $tanggal_masuk = $this->model->GetAllSummaryTanggalMasuk($bulan, $tahun);
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
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
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


    public function summary_bulan(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        date_default_timezone_set("Asia/Jakarta");

        $tahun = $this->request->getPost('cari_tahun');

        $bulan_keluar = $this->model->GetAllSummaryBulanKeluar();
        $bulan_masuk = $this->model->GetAllSummaryBulanMasuk();
        $bulan_ini = date('Y');
        $pesan =  '';

        if($tahun){
            $bulan_keluar = $this->model->GetAllSummaryBulanKeluar($tahun);
            $bulan_masuk = $this->model->GetAllSummaryBulanMasuk($tahun);
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
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
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



    public function summary_tahun(){

		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
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
            $tahun_keluar = $this->model->GetAllSummaryTahunKeluar($awal, $akhir);
            $tahun_masuk = $this->model->GetAllSummaryTahunMasuk($awal, $akhir);
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
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'toko' => $this->model->GetRowTokoForLaporan(),
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
