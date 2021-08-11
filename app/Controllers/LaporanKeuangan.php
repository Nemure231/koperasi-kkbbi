<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_toko;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;
use App\Models\Model_pengeluaran;
use App\Models\Model_detail_transaksi;
use App\Models\Model_barang_masuk;

class LaporanKeuangan extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_pendaftaran = new Model_pendaftaran();
        $this->model_pengeluaran =  new Model_pengeluaran();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_detail_transaksi = new Model_detail_transaksi();
		$this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index(){

      
        $role = $this->session->get('role_id');
        $email = $this->session->get('email');
       
        $data = [
            'title' => ucfirst('Laporan Keuangan Bulanan'),
            'nama_menu_utama' => ucfirst('Keuangan'),
            'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
						->where('surel', $email)
						->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')
                ->asArray()
                ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                ->where('user_access_menu.role_id =', $role)
                ->orderBy('user_access_menu.menu_id', 'ASC')
                ->orderBy('user_access_menu.role_id', 'ASC')
                ->findAll(),
            'session' => $this->session,
            'validation' => $this->validation,
            'toko'  =>$this->model_toko->select('nama_toko, telepon_toko,
                alamat_toko, logo_toko, logo_koperasi_inter')
                ->asArray()->where('id_toko', 1)
                ->first(),
            'tanggal' => ['bulan' => '', 'tahun' => ''],
            'keuangan' =>  '',
            'pesan_bulan' => '',
            'form_bulan' =>  ['id' => 'formBulan', 'name'=>'formBulan'],
            'bulan_tahun' => '',
        
        ];
        tampilan_admin(
            'admin/admin-laporan-keuangan-bulanan/v_laporan_keuangan_bulanan',
            'admin/admin-laporan-keuangan-bulanan/v_js_laporan_keuangan_bulanan',
            $data
        );
    }

    public function cari(){
        if(!$this->validate([
            'cari_bulan' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Bulan harus disi!',
                    'numeric' => 'Bulan harus angka!'
                ]
            ],
            'cari_tahun' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Tahun harus diisi!',
                    'numeric' => 'Tahun harus angka!'
                ]
            ]
            ])) {
                return redirect()->to(base_url('/laporan/keuangan-bulanan'))->withInput();

        }
        date_default_timezone_set("Asia/Jakarta");
        $month = $this->request->getPost('cari_bulan');
        $year = $this->request->getPost('cari_tahun');
        

        $total_barang_masuk = $this->model_barang_masuk
            ->selectSUM('barang_masuk.total_harga_pokok',
            'total_barang_masuk')->asArray()
            ->where('MONTH(barang_masuk.tanggal)', $month)
            ->where('YEAR(barang_masuk.tanggal)', $year)
            ->groupBy('YEAR(barang_masuk.tanggal)')
            ->first();

        $total_barang_keluar = $this->model_detail_transaksi
            ->selectSUM('detail_transaksi.total_harga',
            'total_barang_keluar')->asArray()
            ->where('MONTH(detail_transaksi.tanggal)', $month)
            ->where('YEAR(detail_transaksi.tanggal)', $year)
            ->groupBy('YEAR(detail_transaksi.tanggal)')
            ->first();

        $total_pendaftaran = $this->model_pendaftaran
            ->selectSUM('pendaftaran.biaya',
            'total_pendaftaran')->asArray()
            ->where('MONTH(pendaftaran.tanggal)', $month)
            ->where('YEAR(pendaftaran.tanggal)', $year)
            ->groupBy('YEAR(pendaftaran.tanggal)')
            ->first();
        
        $daftar_pengeluaran = $this->model_pengeluaran
            ->select('nama, total')->asArray()
            ->where('bulan', $month)
            ->where('tahun', $year)
            ->findAll();

        
        $pengeluaran = $daftar_pengeluaran ?? array();
        $masuk = $total_barang_masuk['total_barang_masuk'] ?? 0;
        $keluar = $total_barang_keluar['total_barang_keluar']?? 0;
        $pendaftaran =$total_pendaftaran['total_pendaftaran']?? 0;
        $tahun_bulan  = $year.'-'.$month;
        $pesan = '<div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                Semua Transaksi berhasil dicari!
            </div>
            </div>';
        $data = [
            'total_barang_masuk' => $masuk,
            'total_barang_keluar' => $keluar,
            'total_pendaftaran' => $pendaftaran,
            'tahun_bulan' => $tahun_bulan,
            'pesan' => $pesan,
            'pengeluaran' => $pengeluaran
        ];

        //  dd($data);

        $this->session->setFlashdata('pesan_data', $data);
        return redirect()->to(base_url('/laporan/keuangan-bulanan'));        
    }

    public function tambah(){

        if(!$this->validate([
            'nama_pengeluaran' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama pengeluaran harus diisi!'
                ]
            ],
            'total_pengeluaran' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Total pengeluaran harus diisi!',
                    'numeric' => 'Total pengeluaran haruus angka!'
                ]
            ]
            ])) {
            return redirect()->to(base_url('/laporan/keuangan-bulanan'))->withInput();
            }
        
        $bulan_pengeluaran =   date('m');
        $tahun_pengeluaran =  date('Y');
        $nama_pengeluaran = $this->request->getPost('nama_pengeluaran');
        $total_pengeluaran = $this->request->getPost('total_pengeluaran');

        for ($i= 0; $i < count($this->request->getPost('total_pengeluaran')); $i++ ){

            $data[] = array(
            'nama' => $nama_pengeluaran[$i],
            'total' => $total_pengeluaran[$i],
            'bulan' => $bulan_pengeluaran,
            'tahun' => $tahun_pengeluaran
            );
        }   
        $this->model_pengeluaran->insertBatch($data);
        $this->session->setFlashdata('pesan_sukses', '<div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            Keuangan bulan ini berhasil disimpan!
        </div>
        </div>');
        return redirect()->to(base_url('/laporan/keuangan-bulanan'));
    }    

}
?>
