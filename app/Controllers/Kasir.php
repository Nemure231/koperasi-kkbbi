<?php namespace App\Controllers;

//require ROOTPATH. 'vendor/autoload.php';

use CodeIgniter\Controller;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_keranjang;
use App\Models\Model_detail_transaksi;
use App\Models\Model_jenis_kasir;
use App\Models\Model_role;
use App\Models\Model_transaksi_sementara;
use App\Models\Model_transaksi;
// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\Printer;
// use Setruk\PrintConnectors\FilePrintConnector;
// use Printer\Escpos\Printer;

class Kasir extends BaseController{

    public function __construct(){


        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_role = new Model_role();
        $this->model_keranjang = new Model_keranjang();
        $this->model_barang = new Model_barang();
        $this->model_detail_transaksi = new Model_detail_transaksi();
        $this->model_jenis_kasir = new Model_jenis_kasir();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->model_transaksi = new Model_transaksi();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
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
		

        $jenis_kasir= $this->model_jenis_kasir->select('jenis_kasir.id as id_jenis_kasir, role_id, nama as role')->asArray()
                    ->where('user_id', $id_user)
                    ->join('role', 'role.id = jenis_kasir.role_id')
                    ->first();

        $barang=$this->model_barang->select('barang.nama as nama_barang, barang.id as id_barang, stok as stok_barang,
                kode as kode_barang, satuan.nama as nama_satuan')->select('harga_anggota as harga')->asArray()
                ->where('barang.id >', 0)
                ->where('harga_anggota >', 0)
                ->join('satuan', 'satuan.id = barang.satuan_id')
                ->findAll();
        if($jenis_kasir['role_id'] != 5){
            $barang=$this->model_barang->select('barang.nama as nama_barang, barang.id as id_barang, stok as stok_barang,
            kode as kode_barang, satuan.nama as nama_satuan')->select('harga_konsumen as harga')->asArray()
                ->where('barang.id >', 0)
                ->where('harga_konsumen >', 0)
                ->join('satuan', 'satuan.id = barang.satuan_id')
                ->findAll();
        }
        $kode_jenis_kasir = $jenis_kasir['role_id'];
        $kode = $this->model_detail_transaksi->AutoKodeTransaksi($kode_jenis_kasir);
        $data = [
           'title'  => 'Kasir',
           'nama_menu_utama' => 'Penjualan',
           'user' =>$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
					->join('role', 'role.id = user.role_id')
					->where('surel', $email)
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
           'role' => $this->model_role->select('id as id_role, nama as role')
                    ->where('id!=', 1)->where('id!=', 2)
                    ->where('id!=', 3)->where('id!=', 6)
                    ->findAll(),
           'barang' => $barang,
           'validation' => $this->validation,
           'keranjang' => $this->model_keranjang->select('keranjang.id as id_keranjang, qty as k_qty,
                    keranjang.kode as k_kode_keranjang, barang.nama as nama_barang, barang_id as k_barang_id,
                    COUNT(qty) as to_qty')->select('keranjang.harga as harga')
                    ->selectSUM('qty', 'tt_qty')->asArray()
                    ->where('user_id', $id_user)
                    ->join('barang', 'barang.id = keranjang.barang_id')
                    ->groupBy('barang_id')
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

    }
    
    public function tambah_keranjang(){ 
        // $barang = $this->request->getPost('k_barang_id');
        $arr = $this->model_keranjang->TambahKeranjangAdmin();
        $this->session->setFlashdata('pesan_pembelian', 'Produk berhasil ditambahkan ke keranjang!');
        return redirect()->to(base_url('/fitur/kasir'));
        // echo json_encode($arr);        
        
    }

    public function tambah_keranjang_qr(){ 
        $arr = $this->model_keranjang->TambahKeranjangAdminQr();
        $this->session->setFlashdata('pesan_pembelian', 'Produk berhasil ditambahkan ke keranjang!');
        return redirect()->to(base_url('/fitur/kasir'));
        echo json_encode($arr);        
        
    }
    
    public function tambah_transaksi_sementara(){

        $role = $this->session->get('role_id');
        $id_user = $this->session->get('id_user');
        $kode =  $this->request->getPost('kode_transaksi');
        

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
        $loop = $this->model_keranjang->select('barang_id')
                ->select('keranjang.harga as harga')
                ->selectSUM('qty', 'tt_qty')->asArray()
                ->where('user_id', $id_user)
                // ->join('barang', 'barang.id = keranjang.barang_id')                    
                ->groupBy('barang_id')
                ->findAll();


        $query_detail= $this->model_keranjang
        //->select('ts_kembalian, ts_jumlah_uang, ts_role_id')
        ->selectSUM('qty')
        ->selectSUM('harga', 't_harga')
        ->where('user_id', $id_user)
        ->groupBy('user_id')
        ->get()->getRowArray();

        $data_detail = [
            'user_id' => $id_user,
            'penyuplai_id' => '0',
            'kode' => $kode,
            'total_harga' => $this->request->getPost('total_harga'),
            'total_qty' => $this->request->getPost('total_qty'),
            'jumlah_uang' => $this->request->getPost('jumlah_uang'),
            'kembalian' => $this->request->getPost('kembalian'),
            'surel_konsumen' => '',
            'status' => '2'
        ];

        $this->db->table('detail_transaksi')
                ->insert($data_detail);
        $detail_id = $this->db->insertID();

			foreach ($loop as  $item):

				$data[] = array(
                    'detail_transaksi_id' => $detail_id,
                    'barang_id' => $item['barang_id'],
					'qty' => $item['tt_qty'],
                    'harga' => $item['tt_qty'] * $item['harga'],
                
                    // 'ts_user_id' => $id_user,
                    // 'ts_role_id' => $this->request->getPost('role_id'),
                    // 'ts_kode_transaksi' => $kode,
                    // 'ts_jumlah_uang' => $jumlah_uang,
                    // 'ts_kembalian' => $this->request->getPost('kembalian'),
					// 'ts_uri' => url_title($kode, '', true),
                    // 'ts_nama_pengutang' => $nama,
                    // 'ts_nomor_pengutang' => $nomor,
                    // 'ts_status_transaksi' => $status
				);			
            endforeach;

            // dd($data);
		
        $this->model_transaksi->insertBatch($data);
        $this->model_keranjang->where('user_id', $id_user)->delete();
        $this->session->setFlashdata('pesan_transaksi_sementara', 'Transaksi berhasil disimpan ke dalam invoice!');
        return redirect()->to(base_url('/fitur/kasir/invoice/'.$kode.''));
        
    }


    public function hapus_barang(){
        $kode = $this->request->getPost('kode_hapus_barang');
        $this->model_keranjang->HapusKeranjangAdmin($kode);
		$this->session->setFlashdata('pesan_hapus_keranjang_admin', 'Berhasil dihapus!');
        return redirect()->to(base_url('/fitur/kasir'));
        
    }

    public function hapus_keranjang(){
        $this->model_keranjang->HapusAllKeranjangAdmin();
		$this->session->setFlashdata('pesan_hapus_all_keranjang_admin', 'Semua barang berhasil dihapus!');
        return redirect()->to(base_url('/fitur/kasir/'));
       
    }

    public function reset_csrf(){

        $data = ['csrf_hash' => csrf_hash()];
        return json_encode($data);

    }



    public function ambil_barang(){

        $jenis_kasir = $this->request->getPost('jen_kas');
        $kode_barang = $this->request->getPost('qode_barang');

        if($jenis_kasir != 5){
            $barang=$this->model_barang->select('barang.nama as nama_barang, barang.id as id_barang, barang.stok as stok_barang,
            satuan.nama as nama_satuan, merek.nama as nama_merek')
                ->select('harga_konsumen as harga')->asArray()
                ->where('barang.id >', 0)
                ->where('harga_konsumen >', 0)
                ->where('kode', $kode_barang)
                ->join('satuan', 'satuan.id = barang.satuan_id')
                ->join('merek', 'merek.id = barang.merek_id')
                ->first();
        }else{
            $barang=$this->model_barang->select('barang.nama as nama_barang, barang.id as id_barang, barang.stok as stok_barang,
                satuan.nama as nama_satuan, merek.nama as nama_merek')
                ->select('harga_anggota as harga')->asArray()
                ->where('barang.id >', 0)
                ->where('harga_anggota >', 0)
                ->where('kode', $kode_barang)
                ->join('satuan', 'satuan.id = barang.satuan_id')
                ->join('merek', 'merek.id = barang.merek_id')
                ->first();
        }

        echo json_encode(['data' => $barang, 'csrf_hash' => csrf_hash()]);
    }


  


}
?>
