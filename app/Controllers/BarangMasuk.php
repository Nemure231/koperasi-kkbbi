<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_barang_masuk;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_satuan;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_pengirim_barang;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelBarang;
use App\Models\ModelBarangMasuk;
use App\Models\ModelSatuan;
use App\Models\ModelKategori;
use App\Models\ModelMerek;
use App\Models\ModelSupplier;

class BarangMasuk extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_satuan = new Model_satuan();
        $this->model_merek = new Model_merek();
        $this->model_kategori = new Model_kategori();
        $this->model_pengirim_barang = new Model_pengirim_barang();
        $this->model_barang = new Model_barang();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelBarang = new ModelBarang();
        $this->modelBarangMasuk = new ModelBarangMasuk();
        $this->modelSatuan = new modelSatuan();
        $this->modelKategori = new modelKategori();
        $this->modelMerek = new modelMerek();
        $this->modelSupplier = new modelSupplier();
	}

	protected $helpers = ['url','form', 'kpos', 'cookie'];

    public function index(){
		
        $kode_barang = $this->model_barang->AutoKodeBarang();
        $data = [
           
            'title'     => ucfirst('Barang Masuk'),
            'nama_menu_utama' => ucfirst('Pembelian'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'session'   =>  $this->session,
            'validation'=>  $this->validation,
            'barang'    =>  $this->modelBarangMasuk->ambilBarangUntukBarangMasuk(),
            'satuan'    =>  $this->modelSatuan->ambilSatuan(),
            'merek'     =>  $this->modelMerek->ambilMerek(),
            'kategori'=>    $this->modelKategori->ambilKategori(),
            'supplier'=>    $this->modelSupplier->ambilSupplier(),
            'form_tambah_barang' => ['id' => 'form-tambah-barang'],
            'form_tambah_supplier' => ['id' => 'form-tambah-supplier'],
            'form_tambah_barang_masuk' => ['id' => 'form-tambah-barang_masuk'],
            'form_pengirim' => ['id' => 'formPengirim', 'name'=>'formPengirim', 'autocomplete' => 'on' ],
            'input_jumlah_barang_masuk' => [
                'type' => 'number',
                'name' => 'jumlah_barang_masuk[]',
                'id' => 'jumlah_barang_masuk',
                //'value' => ''.$stok.'',
                'class' => 'form-control jumlah_barang_masuk',
                'autofocus' => '',
                'required' => ''
            ],
            'hidden_kode_barang' => [
                'type' => 'hidden',
                'name' => 'kode_barang',
                'id' => 'kode_barang',
                'value' => ''.$kode_barang.'',
                'class' => 'form-control',
                'autofocus' => ''
            ],
            'input_nama_pengirim' => [
                'type' => 'text',
                'name' => 'nama_pengirim_barang',
                'id' => 'nama_pengirim_barang',
                'class' => 'form-control nama_pengirim_barang',
                'autofocus' => '',
                'placeholder' => 'Nama supplier ....',
                'required' => ''
            ],
            'input_nama_barang' => [
                'type' => 'text',
                'name' => 'nama_barang',
                'id' => 'nama_barang',
                'class' => 'form-control',
                'autofocus' => ''
            ],
            'input_harga_pokok' => [
             'type' => 'number',
             'name' => 'harga_pokok[]',
             'id' => 'harga_pokok',
             'class' => 'form-control harga_pokok',
             'required' => ''
            ],
            'input_harga_anggota' => [
             'type' => 'number',
             'name' => 'harga_anggota[]',
             'id' => 'harga_anggota',
             'class' => 'form-control harga_anggota',
            'required' => ''
            ],
            'input_harga_konsumen' => [
                'type' => 'number',
                'name' => 'harga_konsumen[]',
                'id' => 'harga_konsumen',
                'class' => 'form-control harga_konsumen',
                'required' => ''
            ],
            'input_persen' => [
             'type' => 'number',
             'id' => 'persen',
             'class' => 'form-control persen'
            ],
            'input_persen_konsumen' => [
             'type' => 'number',
             'id' => 'persen_konsumen',
             'class' => 'form-control persen_konsumen'
            ]
            
        ];
        tampilan_admin('admin/admin-barang-masuk/v_barang_masuk', 'admin/admin-barang-masuk/v_js_barang_masuk', $data);
    }

    public function tambah_barang(){

        $validasi = $this->modelBarangMasuk->tambahBarangDariBarangMasuk();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_barang',  $validasi);
            return redirect()->to(base_url('/fitur/barang_masuk'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_barangL', 'Barang baru berhasil ditambahkan!');
            return redirect()->to(base_url('/fitur/barang_masuk'));
        }
        
    }

    public function tambah_supplier(){
        $validasi = $this->modelSupplier->tambahSupplier();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_supplier',  $validasi);
            return redirect()->to(base_url('/fitur/barang_masuk'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_pengirim', 'Supplier baru berhasil ditambahkan!');
            return redirect()->to(base_url('/fitur/barang_masuk'));
        }
    }


    public function ambil_detail(){


        $data = $this->model_barang->select('nama_barang, id_barang')->asArray()
                ->where('id_barang>', 0)->findAll();
        $data1= $this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')
                ->asArray()->findAll();
        $dataArray  = array('response' => false, 'data' => '', 'data1' => '');

        if($data && $data1){
            $dataArray = array('response' => true, 'data' => ['barang' => $data, 'pengirim' => $data1, 'csrf_hash' => csrf_hash()]);
        }
        echo json_encode($dataArray);

    }

    public function ambil_harga(){


        $id_barang = $this->request->getPost('barang_id');
        $data = $this->model_barang->select('harga_pokok, harga_anggota, harga_konsumen')->asArray()
                ->where('id_barang', $id_barang)
                ->findAll();
        $arr = array('response' => false, 'data' => '');

        if($data){
            $arr = array('response' => true, 'data' => ['harga' => $data, 'csrf_hash' => csrf_hash()]);
        }
        echo json_encode($arr);

    }

     public function tambah(){
        ////////PERLU VALIDASI NATI AJA///////

        if(!$this->validate([
            'barang_id' => [
                'label'  => 'Nama Barang',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Barang harus dipilih!',
                'numeric' => 'Barang harus dipilih!'
                ]
            ],
            'pengirim_barang_id' => [
                'label'  => 'Nama Pengirim Barang',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Supplier harus dipilih!',
                'numeric' => 'Supplier harus dipilih!'
                ]
            ]
          
            
        ])) {
            
            return redirect()->to(base_url('/barang/masuk'))->withInput();
        }

        
        for ($i= 0; $i < count($this->request->getPost('barang_id')); $i++ ){

            $data[] = array(
            'barang_id' => $this->request->getPost('barang_id')[$i],
            'pengirim_barang_id' => $this->request->getPost('pengirim_barang_id')[$i],
            'jumlah_barang_masuk' => $this->request->getPost('jumlah_barang_masuk')[$i],
            'harga_pokok_pb' => $this->request->getPost('harga_pokok')[$i],
            'total_harga_pokok' => ($this->request->getPost('harga_pokok')[$i] * $this->request->getPost('jumlah_barang_masuk')[$i])
            );

            
            $data2[] = array(
                'barang_id' => $this->request->getPost('barang_id')[$i],
                'harga_pokok_pb' => $this->request->getPost('harga_pokok')[$i],
                'jumlah_barang_masuk' => $this->request->getPost('jumlah_barang_masuk')[$i],
                'pengirim_barang_id' => $this->request->getPost('pengirim_barang_id')[$i],
                'harga_konsumen' => $this->request->getPost('harga_konsumen')[$i],
                'harga_anggota' => $this->request->getPost('harga_anggota')[$i]
                );
        }

        $this->model_barang_masuk->TambahBarangMasuk($data, $data2);
        $this->session->setFlashdata('pesan_barang_masuk', 'Barang masuk berhasil ditambahkan!');
        return redirect()->to(base_url('/fitur/barang_masuk'));

    

    }
}
