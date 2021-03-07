<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_user_role;
use App\Models\Model_barang;
use App\Models\Model_transaksi;
use App\Models\Model_keranjang_retur;
use App\Models\Model_transaksi_total;
use App\Models\Model_transaksi_retur;
use App\Models\Model_transaksi_sementara_retur;
use App\Models\Model_transaksi_retur_total;


class Retur extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function __construct(){
        $this->model_barang = new Model_barang();
        $this->model_transaksi_retur = new Model_transaksi_retur();
        $this->model_transaksi = new Model_transaksi();
        $this->model_transaksi_total = new Model_transaksi_total();
        $this->model_transaksi_retur_sementara = new Model_transaksi_sementara_retur();
        $this->model_transaksi_retur_total = new Model_transaksi_retur_total();
        $this->model_user = new Model_user();
        $this->model_keranjang_retur = new Model_keranjang_retur();
        $this->model_user_role = new Model_user_role();
        $this->model_user_menu = new Model_user_menu();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		
	}

	public function index(){
        $email = $this->session->get('email');
		$role = $this->session->get('role_id');
        $id_user = $this->session->get('id_user');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
		
		$kode = $this->model_transaksi_total->AutoKodeTransaksi();

		$kode_cari = $this->request->getPost('kode_transaksi');
        
		$hasil_kode = '';
		$nama_kode= '';
        $pesan_retur = '';
        $barang = '';
        $nama_jenis_kasir = '';


        if($kode_cari){
			$nama_kode = $kode_cari;
			$hasil_kode=$this->model_transaksi->select('id_transaksi_total,t_harga, nama_barang, t_barang_id, t_qty, 
                        tt_total_harga, tt_total_qty, tt_role_id, 
                        harga_konsumen, harga_anggota')->asArray()
                        ->where('tt_kode_transaksi', $kode_cari)
                        ->join('transaksi_total', 'transaksi_total.id_transaksi_total = transaksi.t_transaksi_total_id')
                        ->join('barang', 'barang.id_barang = transaksi.t_barang_id')
                        ->findAll();
            $pesan_retur= 'Transaksi berhasil dicari.';
            $jenis_kasir=$this->model_transaksi_total->select('tt_role_id, role')
                        ->where('tt_kode_transaksi', $kode_cari)->asArray()
                        ->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id')
                        ->first();

            if($jenis_kasir['tt_role_id'] == 4){
                $barang=$this->model_barang->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan')
                        ->select('harga_konsumen as harga')->asArray()
                        ->where('id_barang >', 0)
                        ->where('harga_konsumen >', 0)
                        ->join('satuan', 'satuan.id_satuan = barang.satuan_id')
                        ->findAll();
            }
            if($jenis_kasir['tt_role_id'] == 5){
                $barang= $this->model_barang->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan')
                        ->select('harga_anggota as harga')->asArray()
                        ->where('id_barang >', 0)
                        ->where('harga_anggota >', 0)
                        ->join('satuan', 'satuan.id_satuan = barang.satuan_id')
                        ->findAll();
            }
            $nama_jenis_kasir = ': '.$jenis_kasir['role'];
        }

		$data = [
			'title' => ucfirst('Form Retur'),
            'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
						->join('user_role', 'user_role.id_role = user.role_id')
						->where('email', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
            'kode_retur'=> $this->model_transaksi_retur_total->AutoKodeRetur(),
			'validation'=> $this->validation,
			'session'   => $this->session,
			'nama_jenis_kasir' => $nama_jenis_kasir,
			'id_session'=> $this->session->get('id_user'),
            'role'      => $this->model_user_role->select('id_role, role')->asArray()
                        ->where('id_role!=', 1)->where('id_role!=', 2)
                        ->where('id_role!=', 3)->where('id_role!=', 6)
                        ->findAll(),
            'barang' => $barang,
            'nama_kode' => $nama_kode,
            'pesan_retur'=> $pesan_retur,
            'keranjang' => $this->model_keranjang_retur->select('id_keranjang_retur, kr_qty, kr_kode_keranjang,
                        nama_barang, kr_barang_id, COUNT(kr_qty) as to_qty')
                        ->select('kr_harga as harga')
                        ->selectSUM('kr_qty', 'tt_qty')->asArray()
                        ->where('kr_user_id', $id_user)
                        ->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id')
                        ->groupBy('kr_barang_id')->findAll(),
            'riwayat' => $hasil_kode,
            'validation' => $this->validation,
            'hidden_kode_transaksi' => [
                'name' => 'kode_transaksi', 
                'id'=>'kode_transaksi', 
                'type'=> 'hidden', 
                'value' => ''.$kode.''
            ],
            'form_retur' => [
                'id' => 'formRetur', 
                'name'=>'formRetur'
            ],
		    'form_hapus_barang' => [
                'id' => 'formHapusBarang', 
                'name'=>'formHapusBarang', 
                'class' => 'btn btn-block'
            ],
            'form_hapus_keranjang' => [
                'id' => 'formHapusKeranjang', 
                'name'=>'formHapusKeranjang', 
                'class' => 'btn btn-block'
            ],
		    'form_kode_transaksi' => [
                'id' => 'formKodeTransaksi', 
                'name'=>'formKodeTransaksi', 
                'class' => 'card-header-form'
            ],
		    'input_kode_transaksi' => [
            'type' => 'text',
            'name' => 'kode_transaksi',
            'id' => 'kode_transaksi',
            'placeholder' => 'Cari kode transaksi ....',
            'class' => 'form-control',
            'required' => ''
           ],
           'hidden_kode_hapus_barang' => [
            'type' => 'hidden',
            'name' => 'kode_hapus_barang',
            'id' => 'kode_hapus_barang',
           ],

		];
		tampilan_admin('admin/admin-form-retur/v_form_retur', 'admin/admin-form-retur/v_js_form_retur', $data);
		
	}

	

	public function tambah_keranjang(){
        $bu = $this->request->getPost('kr_barang_id');
        if ($bu == null) {
            return redirect()->to(base_url('blokir'));
        }
		
		$arr = $this->model_keranjang_retur->TambahKeranjangRetur();
        echo json_encode($arr);
        
        $role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
       
		
	}
	

    public function hapus_barang(){
        $kode = $this->request->getPost('kode_hapus_barang');
        $this->model_keranjang_retur->HapusKeranjangRetur($kode);
		$this->session->setFlashdata('pesan_hapus_keranjang_admin', 'Berhasil dihapus!');
        return redirect()->to(base_url('/fitur/retur'))->withInput();
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function hapus_keranjang(){
        $this->model_keranjang_retur->HapusAllKeranjangRetur();
		$this->session->setFlashdata('pesan_hapus_all_keranjang_admin', 'Semua barang berhasil dihapus!');
        return redirect()->to(base_url('/fitur/retur'))->withInput();
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        
    
    }

	public function ambil_kode(){
        $kode = $this->request->getPost('kode_transaksi');
        $data = $this->model_transaksi->select('id_transaksi_total, t_harga, nama_barang, t_barang_id, 
                t_qty, tt_total_harga, tt_total_qty, tt_role_id, harga_konsumen, harga_anggota')->asArray()
                ->where('tt_kode_transaksi', $kode_cari)
                ->join('transaksi_total', 'transaksi_total.id_transaksi_total = transaksi.t_transaksi_total_id')
                ->join('barang', 'barang.id_barang = transaksi.t_barang_id')
                ->findAll();
        $arr = array('response' => false, 'data' => '');

        if($data){
            $arr = array('response' => true, 'data' => $data);
        }
        echo json_encode($arr);

    }

    public function tambah_transaksi_sementara(){
        $id_user = $this->session->get('id_user');
        $bu = $this->request->getPost('barang_id_riwayat');
        if ($bu == null) {
            $this->session->setFlashdata('pesan_belum_ceklis', 'Anda belum memilih riwayat barang mana yang ingin diretur!');
            return redirect()->to(base_url('form'));
        }
        $retur=     $this->model_keranjang_retur->select('id_keranjang_retur, kr_qty, kr_kode_keranjang, nama_barang, 
                    kr_barang_id, COUNT(kr_qty) as to_qty')
                    ->select('kr_harga as harga')
                    ->selectSUM('kr_qty', 'tt_qty')->asArray()
                    ->where('kr_user_id', $id_user)
                    ->join('barang', 'barang.id_barang = keranjang_retur.kr_barang_id')
                    ->groupBy('kr_barang_id')
                    ->findAll();
        if ($retur == null) {
            $this->session->setFlashdata('pesan_belum_klik', 'Anda belum memilih barang baru mana yang ingin diretur!');
            return redirect()->to(base_url('form'));
        }
        $totbay = $this->request->getPost('total_bayar_k');
        if($totbay < 0){
            $totbay = 0;
        }

        foreach ($retur as  $r):
            $data[] = array(
                'tsr_transaksi_total_id' => $this->request->getPost('transaksi_total_id'),
                'tsr_role_id' => $this->request->getPost('role_id'),
                'tsr_user_id' => $id_user,
                'tsr_kode_retur' => $this->request->getPost('kode_retur'),
                'tsr_n_barang_id' => $r['kr_barang_id'],
                'tsr_n_qty' => $r['tt_qty'],
                'tsr_n_subtotal' => $r['tt_qty'] * $r['harga'],
                'tsr_kembalian_pl' => $this->request->getPost('kembalian_pl'),
                'tsr_total_bayar_k' => $totbay,
                'tsr_jumlah_uang_k' => $this->request->getPost('jumlah_uang_k'),
                'tsr_kembalian_k' => $this->request->getPost('kembalian_k')
            );
          
        endforeach;

        for ($i= 0; $i < count($this->request->getPost('barang_id_riwayat')); $i++ ){
            $data1[] = array(
                'tsr_transaksi_total_id' => $this->request->getPost('transaksi_total_id'),
                'tsr_role_id' => $this->request->getPost('role_id'),
                'tsr_user_id' => $id_user,
                'tsr_kode_retur' => $this->request->getPost('kode_retur'),
                'tsr_r_barang_id' => $this->request->getPost('barang_id_riwayat')[$i],
                'tsr_r_qty' => $this->request->getPost('qty_riwayat')[$i],
                'tsr_r_subtotal' => $this->request->getPost('subtotal_riwayat')[$i],
                'tsr_kembalian_pl' => $this->request->getPost('kembalian_pl'),
                'tsr_total_bayar_k' => $totbay,
                'tsr_jumlah_uang_k' => $this->request->getPost('jumlah_uang_k'),
                'tsr_kembalian_k' => $this->request->getPost('kembalian_k')
            );
        }
        $this->model_transaksi_retur_sementara->insertBatch($data);
        $this->model_transaksi_retur_sementara->insertBatch($data1);
        $this->model_keranjang_retur->where('kr_user_id', $id_user)->delete();
        $this->model_keranjang_retur->where('kr_user_id', $id_user)->delete();
        $this->session->setFlashdata('pesan_transaksi_sementara_retur', 'Transaksi retur berhasil disimpan ke dalam invoice!');
        return redirect()->to(base_url('fitur/retur/invoice'));

        $role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }


    }

    
}
?>
