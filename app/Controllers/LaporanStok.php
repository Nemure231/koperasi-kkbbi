<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_toko;
use App\Models\Model_user;
use App\Models\Model_barang;
use App\Models\Model_pendaftaran;
use App\Models\Model_pengeluaran;
use App\Models\Model_detail_transaksi;
use App\Models\Model_transaksi;
use App\Models\Model_barang_masuk;

class LaporanStok extends BaseController{

    public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_barang =  new Model_barang();
        $this->model_toko = new Model_toko();
        $this->model_pendaftaran = new Model_pendaftaran();
        $this->model_pengeluaran =  new Model_pengeluaran();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_detail_transaksi = new Model_detail_transaksi();
		$this->model_transaksi = new Model_transaksi();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index(){

      
        $role = $this->session->get('role_id');
        $email = $this->session->get('email');

        $data = $this->model_barang->select('barang.nama as nama, barang.id as id_barang')
        ->selectSUM('barang_masuk.jumlah', 'stok_sebelum')
        ->asArray()
        ->where('barang_masuk.status', 1)
        ->where('barang.status', 1)
        // ->where('DATE(barang_masuk.tanggal)>=', $awal_minggu)
        // ->where('DATE(barang_masuk.tanggal)<=', $akhir_minggu)
        ->join('barang_masuk', 'barang_masuk.barang_id = barang.id', 'left')
        ->groupBy('barang.id')
        ->orderBy('barang.id', 'ASC')
        ->findAll();

        $fill = $this->model_transaksi->select('barang.id as id_barang')
        ->selectSUM('transaksi.qty', 'stok_terjual')
        ->asArray()
        ->where('detail_transaksi.status', 1)
        ->where('barang.status', 1)
        // ->where('DATE(detail_transaksi.tanggal)>=', $awal_minggu)
        // ->where('DATE(detail_transaksi.tanggal)<=', $akhir_minggu)
        ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
        ->join('barang', 'barang.id = transaksi.barang_id')
        ->groupBy('barang.id')
        ->groupBy('MONTH(detail_transaksi.tanggal)')
        ->orderBy('barang.id', 'ASC')
        ->findAll();

        $combined = array();
        foreach($data as $arr){
            $comb = array('id_barang' => $arr['id_barang'], 'nama' => $arr['nama'], 'stok_sebelum'=> $arr['stok_sebelum'], 'stok_terjual' => '0');
            foreach($fill as $arr2){
                if($arr2['id_barang'] == $arr['id_barang']){
                    $comb['stok_terjual'] = $arr2['stok_terjual'];
                    break;
                }
            }
            $combined[] = $comb;
        }


        $data = [
            'title' => ucfirst('Laporan Stok'),
            'nama_menu_utama' => ucfirst('Stok'),
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
            'stok' => $combined,
            'session' => $this->session,
            'validation' => $this->validation,
            'toko'  =>$this->model_toko->select('nama_toko, telepon_toko,
                alamat_toko, logo_toko, logo_koperasi_inter')
                ->asArray()->where('id_toko', 1)
                ->first(),
            'pesan_minggu' => '',
            'form_minggu' =>  ['id' => 'formMinggu', 'name'=>'formMinggu'],
            'minggu_ini' => '',
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


        tampilan_admin(
            'admin/admin-laporan-stok/v_laporan_stok',
            'admin/admin-laporan-stok/v_js_laporan_stok',
            $data
        );
    }

    public function stok_masuk(){

        $id_barang = $this->request->getPost('id_barang');
        $barang=$this->model_barang_masuk->select('barang_masuk.tanggal as tanggal_masuk, barang_masuk.jumlah as stok_masuk')
            ->asArray()
            ->where('barang_masuk.barang_id', $id_barang)
			->where('barang_masuk.status', 1)
            ->orderBy('barang_masuk.tanggal', 'DESC')
            ->findAll();
        echo json_encode(['data' => $barang, 'csrf_hash' => csrf_hash()]);
    }

    public function stok_keluar(){

        $id_barang = $this->request->getPost('id_barang');
        $barang=$this->model_transaksi->select('detail_transaksi.tanggal as tanggal_keluar, qty as stok_keluar')
            ->asArray()
            ->where('barang_id', $id_barang)
			->where('status', 1)
            ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
            ->orderBy('tanggal', 'DESC')
            ->findAll();
        echo json_encode(['data' => $barang, 'csrf_hash' => csrf_hash()]);
    }

    public function cari(){
        if(!$this->validate([
            'cari_awal_minggu' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Harus diisi',
                ]
            ],
            'cari_akhir_minggu' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Harus diisi!',
                ]
            ]
            ])) {
                return redirect()->to(base_url('/laporan/stok'))->withInput();

        }
        date_default_timezone_set("Asia/Jakarta");
        $awal_minggu = $this->request->getPost('cari_awal_minggu');
        $akhir_minggu = $this->request->getPost('cari_akhir_minggu');
        

        $data = $this->model_barang->select('barang.nama as nama, barang.id as id_barang')
        ->selectSUM('barang_masuk.jumlah', 'stok_sebelum')
        ->asArray()
        ->where('barang_masuk.status', 1)
        ->where('barang.status', 1)
        ->where('DATE(barang_masuk.tanggal)>=', $awal_minggu)
        ->where('DATE(barang_masuk.tanggal)<=', $akhir_minggu)
        ->join('barang_masuk', 'barang_masuk.barang_id = barang.id', 'left')
        ->groupBy('barang.id')
        ->orderBy('barang.id', 'ASC')
        ->findAll();

        $fill = $this->model_transaksi->select('barang.id as id_barang')
        ->selectSUM('transaksi.qty', 'stok_terjual')
        ->asArray()
        ->where('detail_transaksi.status', 1)
        ->where('barang.status', 1)
        ->where('DATE(detail_transaksi.tanggal)>=', $awal_minggu)
        ->where('DATE(detail_transaksi.tanggal)<=', $akhir_minggu)
        ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
        ->join('barang', 'barang.id = transaksi.barang_id')
        ->groupBy('barang.id')
        ->groupBy('MONTH(detail_transaksi.tanggal)')
        ->orderBy('barang.id', 'ASC')
        ->findAll();

        $combined = array();
        foreach($data as $arr){
            $comb = array('id_barang' => $arr['id_barang'], 'nama' => $arr['nama'], 'stok_sebelum'=> $arr['stok_sebelum'], 'stok_terjual' => '0');
            foreach($fill as $arr2){
                if($arr2['id_barang'] == $arr['id_barang']){
                    $comb['stok_terjual'] = $arr2['stok_terjual'];
                    break;
                }
            }
            $combined[] = $comb;
        }


        $stok = $combined ?? array();
        // $masuk = $total_barang_masuk['total_barang_masuk'] ?? 0;
        // $keluar = $total_barang_keluar['total_barang_keluar']?? 0;
        // $pendaftaran =$total_pendaftaran['total_pendaftaran']?? 0;
        $minggu_ini  = $awal_minggu.'~'.$akhir_minggu;
        $pesan = '<div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                Semua Transaksi berhasil dicari!
            </div>
            </div>';
        $data = [
            'minggu_ini' => $minggu_ini,
            'pesan' => $pesan,
            'stok' => $stok
        ];

        //  dd($data);

        $this->session->setFlashdata('pesan_data', $data);
        return redirect()->to(base_url('/laporan/stok'));        
    }

   

}
?>
