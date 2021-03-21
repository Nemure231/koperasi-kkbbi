<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_satuan;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_pengirim_barang;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSatuan;
use App\Models\ModelKategori;
use App\Models\ModelMerek;
use App\Models\ModelSupplier;
use App\Models\ModelBarang;
class Barang extends BaseController{

	public function __construct(){
        $this->model_barang = new Model_barang();
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_satuan = new Model_satuan();
        $this->model_merek = new Model_merek();
        $this->model_kategori = new Model_kategori();
        $this->model_pengirim_barang = new Model_pengirim_barang();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->db = \Config\Database::connect();
        $this->modelUser = new modelUser();
        $this->modelMenu = new modelMenu();
        $this->modelSatuan = new modelSatuan();
        $this->modelKategori = new modelKategori();
        $this->modelMerek = new modelMerek();
        $this->modelSupplier = new modelSupplier();
        $this->modelBarang = new ModelBarang();
	}
	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];

	public function index(){
        
        // $kode_barang = $this->model_barang->AutoKodeBarang();
        $nama_barang = set_value('nama_barang', '');
        $harga_konsumen = set_value('harga_konsumen', '');
        $harga_anggota = set_value('harga_anggota', '');
        $stok_barang = set_value('stok_barang', '');
        $harga_pokok = set_value('harga_pokok', '');
        $data = [
            'title' => ucfirst('Daftar Barang'),
            'nama_menu_utama' => ucfirst('Gudang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
			'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'barang' => $this->modelBarang->ambilBarang(),
            'satuan' => $this->modelSatuan->ambilSatuan(),
            'merek' =>  $this->modelMerek->ambilMerek(),
            'kategori'=>$this->modelKategori->ambilKategori(),
            'supplier'=>$this->modelSupplier->ambilSupplier(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_barang' => ['id' => 'formTambahBarang', 'name'=>'formTambahBarang'],
            'form_edit_barang' =>  ['id' => 'formEditBarang', 'name'=>'formEditBarang'],
            'form_hapus_barang' =>  ['id' => 'formHapusBarang', 'name'=>'formHapusBarang', 'class' => 'btn btn-block'],
            'input_nama_barang' => [
                'type' => 'text',
                'name' => 'nama_barang',
                'id' => 'nama_barang',
                'value' => ''.$nama_barang.'',
                'class' => 'form-control',
                'autofocus' => ''
            ],
            'input_harga_pokok' => [
                'type' => 'number',
                'name' => 'harga_pokok',
                'id' => 'harga_pokok',
                'value' => ''.$harga_pokok.'',
                'class' => 'form-control'
            
            ],
            'input_harga_konsumen' => [
                'type' => 'number',
                'name' => 'harga_konsumen',
                'id' => 'harga_konsumen',
                'value' => ''.$harga_konsumen.'',
                'class' => 'form-control'
            
            ],
            'input_harga_anggota' => [
                'type' => 'number',
                'name' => 'harga_anggota',
                'id' => 'harga_anggota',
                'value' => ''.$harga_anggota.'',
                'class' => 'form-control'
                
            ],
            'input_stok' => [
                'type' => 'number',
                'name' => 'stok_barang',
                'id' => 'stok_barang',
                'value' => ''.$stok_barang.'',
                'class' => 'form-control'
            ],
            'hidden_id_barangE' => [
                'type' => 'hidden',
                'name' => 'id_barangE',
                'id' => 'id_barangE',
                'class' => 'form-control',
                'autofocus' => ''
            ],
            'input_nama_barangE' => [
                'type' => 'text',
                'name' => 'nama_barangE',
                'id' => 'nama_barangE',
                'class' => 'form-control nama_barangE',
                'autofocus' => ''
            ],
            'hidden_nama_barang_old' => [
                'type' => 'hidden',
                'name' => 'nama_barang_old',
                'id' => 'nama_barang_old',
                'class' => 'form-control',
                'autofocus' => ''
            ],
            'input_harga_pokokE' => [
                'type' => 'number',
                'name' => 'harga_pokokE',
                'id' => 'harga_pokokE',
                'class' => 'form-control'
            
            ],
            'input_harga_konsumenE' => [
                'type' => 'number',
                'name' => 'harga_konsumenE',
                'id' => 'harga_konsumenE',
                'class' => 'form-control'
            
            ],
            'input_harga_anggotaE' => [
                'type' => 'number',
                'name' => 'harga_anggotaE',
                'id' => 'harga_anggotaE',
                'class' => 'form-control'
                
            ],
            'input_stokE' => [
                'type' => 'number',
                'name' => 'stok_barangE',
                'id' => 'stok_barangE',
                'class' => 'form-control'
            ],
            'hidden_id_barangH' => [
                'type' => 'hidden',
                'name' => 'id_barangH',
                'id' => 'id_barangH',
                'class' => 'form-control',
                'autofocus' => ''
            ],
        ];
        tampilan_admin('admin/admin-barang/v_barang', 'admin/admin-barang/v_js_barang', $data);
     
    }

    public function tambah(){

           
        $validasi = $this->modelBarang->tambahBarang();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_barang',  $validasi);
            return redirect()->to(base_url('/suplai/barang'));
        }else{
            $this->session->setFlashdata('pesan_barang', 'Barang baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/barang'));
        }
        
    }

    public function ubah(){
                
        $validasi = $this->modelBarang->ubahBarang();

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_barang',  $validasi);
            return redirect()->to(base_url('/suplai/barang'));
        }else{
            $this->session->setFlashdata('pesan_barang', 'Barang berhasil diubah!');
            return redirect()->to(base_url('/suplai/barang'));
        }
    }

    
    public function hapus(){     
        $this->modelBarang->hapusBarang();
        $this->session->setFlashdata('hapus_barang', 'Barang berhasil dihapus!');
        return redirect()->to(base_url('/suplai/barang'));

        
    
    }   
}
?>
