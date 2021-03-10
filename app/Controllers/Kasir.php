<?php namespace App\Controllers;

//require ROOTPATH. 'vendor/autoload.php';

use CodeIgniter\Controller;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_keranjang;
use App\Models\Model_transaksi_total;
use App\Models\Model_jenis_kasir;
use App\Models\Model_user_role;
use App\Models\Model_transaksi_sementara;
// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\Printer;
// use Setruk\PrintConnectors\FilePrintConnector;
// use Printer\Escpos\Printer;

class Kasir extends BaseController{

    public function __construct(){


        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_user_role = new Model_user_role();
        $this->model_keranjang = new Model_keranjang();
        $this->model_barang = new Model_barang();
        $this->model_transaksi_total = new Model_transaksi_total();
        $this->model_jenis_kasir = new Model_jenis_kasir();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        // $this->connector = new FilePrintConnector();
        // $this->printer = new Printer($this->connector);
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
        //$session = \Config\Services::session();
        //$view = \Config\Services::renderer();
		
		$role = $this->session->get('role_id');
        $id_user = $this->session->get('id_user');
        $email = $this->session->get('email');
		
		
		// if (!$role){
        //     return redirect()->to(base_url('/'));
        // }
		// 	$userAccess = $this->model_user_menu->Tendang();
        //     if ($userAccess < 1) {
        //         return redirect()->to(base_url('blokir'));
        //     }
        


        $jenis_kasir= $this->model_jenis_kasir->select('id_jenis_kasir, role_id, role')->asArray()
                    ->where('user_id', $id_user)
                    ->join('user_role', 'user_role.id_role = jenis_kasir.role_id')
                    ->first();

        $barang=$this->model_barang->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan')
                ->select('harga_anggota as harga')->asArray()
                ->where('id_barang >', 0)
                ->where('harga_anggota >', 0)
                ->join('satuan', 'satuan.id_satuan = barang.satuan_id')
                ->findAll();
        if($jenis_kasir['role_id'] != 5){
            $barang=$this->model_barang->select('nama_barang, id_barang, stok_barang, kode_barang, nama_satuan')
                    ->select('harga_konsumen as harga')->asArray()
                    ->where('id_barang >', 0)
                    ->where('harga_konsumen >', 0)
                    ->join('satuan', 'satuan.id_satuan = barang.satuan_id')
                    ->findAll();
        }

        $kode = $this->model_transaksi_total->AutoKodeTransaksi(); 
        $data = [
           'title'  => ucfirst('Kasir'),
           'nama_menu_utama' => ucfirst('Penjualan'),
           'user'   => 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
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
           'kode' => $kode,
           'id_session' => $this->session->get('id_user'),
           'nama_jenis_kasir' => $jenis_kasir['role'],
           'role_id_jenis_kasir' => $jenis_kasir['role_id'],
           'role' => $this->model_user_role->select('id_role, role')
                    ->where('id_role!=', 1)->where('id_role!=', 2)
                    ->where('id_role!=', 3)->where('id_role!=', 6)
                    ->findAll(),
           'barang' => $barang,
           'validation' => $this->validation,
           'keranjang' => $this->model_keranjang->select('id_keranjang, k_qty, k_kode_keranjang,
                     nama_barang, k_barang_id, COUNT(k_qty) as to_qty')
                    ->select('k_harga as harga')
                    ->selectSUM('k_qty', 'tt_qty')->asArray()
                    ->where('k_user_id', $id_user)
                    ->join('barang', 'barang.id_barang = keranjang.k_barang_id')
                    ->groupBy('k_barang_id')
                    ->findAll(),
            'hidden_kode_transaksi' => ['name' => 'kode_transaksi', 'id'=>'kode_transaksi', 'type'=> 'hidden', 'value' => ''.$kode.''],
            'hidden_id_jenis_kasir' => ['name' => 'id_jenis_kasir', 'id'=>'id_jenis_kasir', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['id_jenis_kasir'].''],
            'hidden_role_id' => ['name' => 'role_id', 'id'=>'role_id', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['role_id'].''],
            'form_pembelian' => ['id' => 'formPembelian', 'name'=>'formPembelian', 'class' => 'formPembelian'],
            'form_jenis_kasir' => ['id' => 'formJenisKasir', 'name'=>'formJenisKasir'],
            'form_hapus_barang' => ['id' => 'formHapusBarang', 'name'=>'formHapusBarang', 'class' => 'btn btn-block'],
            'hidden_kode_hapus_barang' => [
                'name' => 'kode_hapus_barang', 
                'id'=>'kode_hapus_barang', 
                'type'=> 'hidden'
            ],
            'form_hapus_keranjang' => [
                'name' => 'formHapusKeranjang', 
                'id'=>'formHapusKeranjang', 
                'class'=> 'btn btn-block'
            ],
        ];
        tampilan_admin('admin/admin-pembelian/v_pembelian', 'admin/admin-pembelian/v_js_pembelian', $data);
    }

    public function ubah_jenis_kasir(){
    
        if(!$this->validate([
            'role_idE' => [
                'label'  => 'Nama Role',
                'rules'  => 'required|numeric',
                'errors' => [
                'required' => 'Jenis kasir harus dipilih!',
                'is_unique' => 'Harus angka!'
                ]
            ]
                
        ])) {

            return redirect()->to(base_url('/fitur/kasir'))->withInput();

        }
            $id_user = $this->session->get('id_user');
            $postRole = $this->request->getPost('role_idE');
            $this->model_jenis_kasir->where('user_id', $id_user)->set('role_id', $postRole)->update();
            $this->session->setFlashdata('pesan_jenis_kasir', 'Jenis kasir berhasil diubah!');
            return redirect()->to(base_url('/fitur/kasir'));

        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
    }
    
    public function tambah_keranjang(){ 
        $barang = $this->request->getPost('k_barang_id');
        if (!$barang) {
            return redirect()->to(base_url('blokir'));
        }

        $arr = $this->model_keranjang->TambahKeranjangAdmin();
        if (!$arr){
            return redirect()->to(base_url('/'));
        }
        echo json_encode($arr);        
        
    }
    
    public function tambah_transaksi_sementara(){

        $role = $this->session->get('role_id');
        $id_user = $this->session->get('id_user');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        

        if(!$this->validate([
            'jumlah_uang' => [
                'label'  => 'Nama Role',
                'rules'  => 'required|numeric',
                'errors' => [
                'required' => 'Jumlah uang harus diisi!',
                'numeric' => 'Jumlah uang harus angka!'
                //'is_natural_no_zero' => 'Jumlah uang tidak boleh nol!'
                ]
            ],
            'kembalian' => [
                'label'  => 'Nama Role',
                'rules'  => 'required|numeric|alpha_numeric',
                'errors' => [
                'required' => 'Kembalian harus diisi!',
                'numeric' => 'Kembalian harus angka!',
                'alpha_numeric' => 'Kembalian tidak boleh minus!'

                ]
            ]
                
        ])) {
            return redirect()->to(base_url('/fitur/kasir'))->withInput();

        }
        $loop = $this->model_keranjang->select('id_keranjang, k_qty, k_kode_keranjang, 
                nama_barang, k_barang_id, COUNT(k_qty) as to_qty')
                ->select('k_harga as harga')
                ->selectSUM('k_qty', 'tt_qty')->asArray()
                ->where('k_user_id', $id_user)
                ->join('barang', 'barang.id_barang = keranjang.k_barang_id')                    
                ->groupBy('k_barang_id')
                ->findAll();
        $kode =  $this->request->getPost('kode_transaksi');
        $status = $this->request->getPost('status_transaksi');

        if(!$status){
            $status = 1;
        }

        $nama = $this->request->getPost('nama_penghutang');
        $nomor = $this->request->getPost('nomor_telepon_hutang');

        if(!$nama && !$nomor){
            $nama = ''; 
            $nomor = 0;
        }
        $jumlah_uang = $this->request->getPost('jumlah_uang');
			foreach ($loop as  $item):
				$data[] = array(
                    'ts_barang_id' => $item['k_barang_id'],
					'ts_qty' => $item['tt_qty'],
                    'ts_harga' => $item['tt_qty'] * $item['harga'],
                    'ts_user_id' => $id_user,
                    'ts_role_id' => $this->request->getPost('role_id'),
                    'ts_kode_transaksi' => $kode,
                    'ts_jumlah_uang' => $jumlah_uang,
                    'ts_kembalian' => $this->request->getPost('kembalian'),
					'ts_uri' => url_title($kode, '', true),
                    'ts_nama_pengutang' => $nama,
                    'ts_nomor_pengutang' => $nomor,
                    'ts_status_transaksi' => $status
				);			
            endforeach;
		// $this->model_transaksi_sementara->TambahTransaksiSementara($data);
        $this->model_transaksi_sementara->insertBatch($data);
        $this->model_keranjang->where('k_user_id', $id_user)->delete();

        if($status != 2){
            $this->session->setFlashdata('pesan_transaksi_sementara', 'Transaksi berhasil disimpan ke dalam invoice!');
            return redirect()->to(base_url('/fitur/kasir/invoice/'.$kode.''));
        }else{
            $this->session->setFlashdata('pesan_transaksi_sementara_utang', 'Utang berhasil disimpan!');
            return redirect()->to(base_url('/fitur/kasir'));
        }

    }


    public function hapus_barang(){
        $kode = $this->request->getPost('kode_hapus_barang');
        $this->model_keranjang->HapusKeranjangAdmin($kode);
		$this->session->setFlashdata('pesan_hapus_keranjang_admin', 'Berhasil dihapus!');
        return redirect()->to(base_url('/fitur/kasir'));
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
        $this->model_keranjang->HapusAllKeranjangAdmin();
		$this->session->setFlashdata('pesan_hapus_all_keranjang_admin', 'Semua barang berhasil dihapus!');
        return redirect()->to(base_url('/fitur/kasir/'));
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }    
    }


  


}
?>
