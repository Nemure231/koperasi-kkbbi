<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_user_menu;
use App\Models\Model_barang_masuk;

class LaporanMasuk extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_barang_masuk = new Model_barang_masuk();
		$this->request = \Config\Services::request();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	
    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
	

		$tanggal = $this->request->getPost('cari_tanggal');

        $hari = $this->model_barang_masuk->GetAllBarangMasukHariCari();
        $tanggal_ini = date('Y-m-d');
        $pesan =  '';

        if($tanggal){
            $hari = $this->model_barang_masuk->GetAllBarangMasukHariCari($tanggal);
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
           
            'title' => ucfirst('Masuk Harian'),
            'nama_menu_utama' => ucfirst('Barang Masuk'),
            'user' 	=>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
                    ->join('user_role', 'user_role.id_role = user.role_id')
                    ->where('email', $email)
                    ->first(),
            'menu'  =>$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
            'session' => $this->session,
            'toko' => $this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
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

    public function mingguan(){
		
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


        $body = 'admin/admin-laporan-masuk-minggu/v_laporan_masuk_minggu';
        $gaya = $this->request->getPost('gaya');

        if($gaya == 1){
            $body = 'admin/admin-laporan-masuk-minggu/v_laporan_masuk_minggu_list';
        }
        
        if($gaya == 2){
            $body = 'admin/admin-laporan-masuk-minggu/v_laporan_masuk_minggu';
        }
    
    
        $data = [
           
            'title' => ucfirst('Masuk Mingguan'),
            'nama_menu_utama' => ucfirst('Barang Masuk'),
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


    public function bulanan(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
	
    


        $bulan= $this->request->getPost('cari_bulan');
        $tahun = $this->request->getPost('cari_tahun');

        $bulan1 = $this->model_barang_masuk->GetAllBarangMasukBulanCari();
        $tanggal_ini = date('Y-m');
        $pesan =  '';
        if($bulan && $tahun){
            $bulan1 = $this->model_barang_masuk->GetAllBarangMasukBulanCari($bulan, $tahun);
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
            'title' => ucfirst('Masuk Bulanan'),
            'nama_menu_utama' => ucfirst('Barang Masuk'),
            'user' 	=>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
                    ->join('user_role', 'user_role.id_role = user.role_id')
                    ->where('email', $email)
                    ->first(),
            'menu'=> $this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
            'session'=> $this->session,
            'toko'  =>$this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
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
        tampilan_admin($body, 'admin/admin-laporan-masuk-bulan/v_js_laporan_masuk_bulan', $data);
    }

    public function tahunan(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
	
    
        date_default_timezone_set("Asia/Jakarta");

        $cari_tahun = $this->request->getPost('cari_tahun');

        $tahun = $this->model_barang_masuk->GetAllBarangMasukTahunCari();
        $tahun_ini = date('Y');
        $pesan =  '';

        if($cari_tahun){
            $tahun = $this->model_barang_masuk->GetAllBarangMasukTahunCari($cari_tahun);
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
            'title'  => ucfirst('Masuk Tahunan'),
            'nama_menu_utama' => ucfirst('Barang Masuk'),
            'user' 	=>$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
                    ->join('user_role', 'user_role.id_role = user.role_id')
                    ->where('email', $email)
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
        tampilan_admin($body, 'admin/admin-laporan-masuk-tahun/v_js_laporan_masuk_tahun', $data);
    }



	

}
?>
