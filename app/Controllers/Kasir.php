<?php namespace App\Controllers;
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
     
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
    
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
        
        $data = [
            'title'  => 'Kasir',
            'nama_menu_utama' => 'Penjualan',
            'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
            ->where('surel', $email)
            ->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                ->where('user_access_menu.role_id =', $role)
                ->orderBy('user_access_menu.menu_id', 'ASC')
                ->orderBy('user_access_menu.role_id', 'ASC')
                ->findAll(),
            'session' => $this->session,
        
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
            
            'hidden_id_jenis_kasir' => ['name' => 'id_jenis_kasir',
                'id'=>'id_jenis_kasir', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['id_jenis_kasir'].''],
            'hidden_role_id' => ['name' => 'role_id',
                'id'=>'role_id', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['role_id'].''],
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

        tampilan_admin(
            'admin/admin-pembelian/v_pembelian',
            'admin/admin-pembelian/v_js_pembelian',
            $data
        );
        
    }
    


    public function ubah_jenis_kasir(){
    
        if(!$this->validate([
            'role_idE' => [
                'rules'  => 'required|numeric',
                'errors' => [
                'required' => 'Jenis kasir harus dipilih!',
                'numeric' => 'Harus angka!'
                ]
            ]
                
        ])) {

            return redirect()->to(base_url('/fitur/kasir'))->withInput();
        }
        $id_user = $this->session->get('id_user');
        $postRole = $this->request->getPost('role_idE');
        $this->model_jenis_kasir->where('user_id', $id_user)
            ->set('role_id', $postRole)->update();
        $this->session->setFlashdata('pesan_jenis_kasir',
        'Jenis kasir berhasil diubah!');
        return redirect()->to(base_url('/fitur/kasir'));
    }
    
    public function tambah_keranjang(){ 

        if(!$this->validate([
            'k_qty' => [
                'rules'  => 'required|numeric|alpha_numeric|greater_than[0]',
                'errors' => [
                'required' => 'Kuantitas harus diisi!',
                'numeric' => 'Kuantitas harus angka!',
                'alpha_numeric' => 'Kuantitas tidak boleh ada - atau +!',
                'greater_than' => 'Kuantitas tidak boleh nol!'
                ]
            ]
                
        ])) {

            return redirect()->to(base_url('/fitur/kasir'))->withInput();
        }



        $arr = $this->model_keranjang->TambahKeranjangAdmin();
        $this->session->setFlashdata('pesan_pembelian',
        'Produk berhasil ditambahkan ke keranjang!');
        return redirect()->to(base_url('/fitur/kasir'));
        
    }

    public function tambah_keranjang_qr(){ 
        $arr = $this->model_keranjang->TambahKeranjangAdminQr();
        $this->session->setFlashdata('pesan_pembelian',
        'Produk berhasil ditambahkan ke keranjang!');
        return redirect()->to(base_url('/fitur/kasir'));
        echo json_encode($arr);        
        
    }
    
    public function tambah_transaksi_sementara(){

        $role = $this->session->get('role_id');
        $id_user = $this->session->get('id_user');
        $total_harga = $this->request->getPost('total_harga');

        if(!$this->validate([
            'jumlah_uang' => [
                'rules'  => 'required|numeric|greater_than[0]|greater_than_equal_to['.$total_harga.']',
                'errors' => [
                'required' => 'Harus diisi!',
                'numeric' => 'Harus angka!',
                'greater_than_equal_to' => 'Jumlah uang kurang!'
                ]
            ],
            'kembalian' => [
                'rules'  => 'required|numeric|alpha_numeric',
                'errors' => [
                'required' => 'Harus diisi!',
                'numeric' => 'Harus angka!',
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
                ->groupBy('barang_id')
                ->findAll();

        $query_detail= $this->model_keranjang
        ->selectSUM('qty')
        ->selectSUM('harga', 't_harga')
        ->where('user_id', $id_user)
        ->groupBy('user_id')
        ->get()->getRowArray();

        $kode = $this->request->getPost('role_id_tambah_transaksi');

        $data_detail = [
            'user_id' => $id_user,
            'penyuplai_id' => '0',
            'kode' =>  auto_kode_transaksi($kode, $id_user),
            'total_harga' => $total_harga,
            'total_qty' => $this->request->getPost('total_qty'),
            'jumlah_uang' => $this->request->getPost('jumlah_uang'),
            'kembalian' => $this->request->getPost('kembalian'),
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
				);			
            endforeach;

        $this->model_transaksi->insertBatch($data);
        $this->model_keranjang->where('user_id', $id_user)->delete();
        $this->session->setFlashdata('pesan_transaksi_sementara',
        'Transaksi berhasil disimpan ke dalam invoice!');
        return redirect()->to(base_url('/fitur/kasir/invoice/'.$data_detail['kode'].''));
    }


    public function hapus_barang(){
        $kode = $this->request->getPost('kode_hapus_barang');
        $this->model_keranjang->HapusKeranjangAdmin($kode);
		$this->session->setFlashdata('pesan_hapus_keranjang_admin',
        'Berhasil dihapus!');
        return redirect()->to(base_url('/fitur/kasir'));
    }

    public function hapus_keranjang(){
        $this->model_keranjang->HapusAllKeranjangAdmin();
		$this->session->setFlashdata('pesan_hapus_all_keranjang_admin',
        'Semua barang berhasil dihapus!');
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
            $barang=$this->model_barang->select('barang.nama as nama_barang,
                barang.id as id_barang, barang.stok as stok_barang,
                satuan.nama as nama_satuan, merek.nama as nama_merek')
                ->select('harga_konsumen as harga')->asArray()
                // ->where('barang.id >', 0)
                ->where('barang.status', 1)
                ->where('harga_konsumen >', 0)
                ->where('kode', $kode_barang)
                ->join('satuan', 'satuan.id = barang.satuan_id')
                ->join('merek', 'merek.id = barang.merek_id')
                ->first();
        }else{
            $barang=$this->model_barang->select('barang.nama as nama_barang,
                barang.id as id_barang, barang.stok as stok_barang,
                satuan.nama as nama_satuan, merek.nama as nama_merek')
                ->select('harga_anggota as harga')->asArray()
                // ->where('barang.id >', 0)
                ->where('barang.status', 1)
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
