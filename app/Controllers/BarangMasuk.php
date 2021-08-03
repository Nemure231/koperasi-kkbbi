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
use App\Models\Model_penyuplai;

class BarangMasuk extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_satuan = new Model_satuan();
        $this->model_merek = new Model_merek();
        $this->model_kategori = new Model_kategori();
        $this->model_penyuplai = new Model_penyuplai();
        $this->model_barang = new Model_barang();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];

    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        $kode_barang = $this->model_barang->AutoKodeBarang();
        $data = [
           
            'title'     => ucfirst('Barang Masuk'),
            'nama_menu_utama' => ucfirst('Pembelian'),
            'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
						->join('role', 'role.id = user.role_id')
						->where('surel', $email)
						->first(),
            'menu' 	    => 	$this->model_user_menu->select('id_menu, menu')->asArray()
                            ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                            ->where('user_access_menu.role_id =', $role)
                            ->orderBy('user_access_menu.menu_id', 'ASC')
                            ->orderBy('user_access_menu.role_id', 'ASC')
                            ->findAll(),
            'session'   =>  $this->session,
            'validation'=>  $this->validation,
            'barang'    =>  $this->model_barang->select('barang.id as id_barang, barang.nama as nama_barang')->asArray()
                            ->findAll(),
            'masuk'     =>  $this->model_barang_masuk->select('barang.nama as nama_barang, barang.tanggal as tanggal_masuk')->asArray()
                            ->join('barang', 'barang.id = barang_masuk.barang_id')
                            ->findAll(),
            'satuan'    =>  $this->model_satuan->select('satuan.id as id_satuan, satuan.nama as nama_satuan')->asArray()
                            ->findAll(),
            'merek'     =>  $this->model_merek->select('merek.id as id_merek, merek.nama as nama_merek')->asArray()
                            ->findAll(),
            'kategori'=>    $this->model_kategori->select('kategori.id as id_kategori, kategori.nama as nama_kategori')->asArray()
                            ->findAll(),
            'pengirim'=>    $this->model_penyuplai->select('penyuplai.id as id_pengirim_barang, user.nama as nama_pengirim_barang')->asArray()
                            ->join('user', 'user.id = penyuplai.user_id')
                            ->findAll(),
            'form_tambah_barang_masuk' => ['id' => 'formTambahBarangMasuk', 'name'=>'formTambahBarangMasuk'],
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
            ],
            'input_keterangan' => [
                'type' => 'text',
                'name' => 'keterangan',
                'id' => 'keterangan',
                'class' => 'form-control',
                'style' => 'min-height:145px;'
            ],
            
        ];
        tampilan_admin('admin/admin-laporan-barang-masuk/v_laporan_barang_masuk', 'admin/admin-laporan-barang-masuk/v_js_laporan_barang_masuk', $data);
    }
    
    public function tambah_pengirim(){
            $nama = $this->request->getPost('nama_pengirim_barang');
            
            $data = array(
            'nama_pengirim_barang' => htmlspecialchars($nama, ENT_QUOTES),
            );

            $this->session->setFlashdata('pesan_pengirim', 'Nama pengirim berhasil ditambahkan!');
            $this->model_penyuplai->insert($data);
            $this->db->insertID();
            $status = true;
            

            echo json_encode(array("status" => $status , 'data' => $data));
    }

    public function tambah_barang(){
        $kodeb = $this->request->getPost('kode_barang');
        

        $sop = $this->request->getPost('satuan_id');

        if (is_numeric($sop)){
            $sem = $sop;
        }else{
            $this->model_satuan->set('nama', $sop)->insert();
            $sem = $this->db->insertID();
        }

        $kat = $this->request->getPost('kategori_id');
        if (is_numeric($kat)){
            $ket = $kat;
        }else{
            $this->model_kategori->set('nama', $kat)->insert(); 
            $ket = $this->db->insertID(); 
        }

        $mer = $this->request->getPost('merek_id');

        if (is_numeric($mer)){
            $mar = $mer;
        }else{
            $this->model_merek->set('nama', $mer)->insert();
            $mar = $this->db->insertID();
        }
        


        $data = array(
            'nama_barang' => htmlspecialchars($this->request->getPost('nama_barang'), ENT_QUOTES),
            'kode_barang' => $kodeb, 
            'satuan_id' => htmlspecialchars($sem, ENT_QUOTES),
            'kategori_id' => htmlspecialchars($ket, ENT_QUOTES),
            'merek_id' => htmlspecialchars($mar, ENT_QUOTES),
            'deskripsi_barang' => htmlspecialchars($this->request->getPost('keterangan'), ENT_QUOTES),
            'tanggal' => date('Y-m-d H:i:s')
            );
    
        $this->session->setFlashdata('pesan_barangL', 'Barang berhasil ditambahkan!');
        $id = $this->model_barang->insert($data);
    

        echo json_encode(array('data' => $data));

        
    }

    public function ambil_detail(){


        $data = $this->model_barang->select('barang.nama as nama_barang, barang.id as id_barang')->asArray()
                ->findAll();
        $data1= $this->model_penyuplai->select('penyuplai.id as id_pengirim_barang, user.nama as nama_pengirim_barang')
                ->asArray()
                ->join('user', 'user.id = penyuplai.user_id')
                ->findAll();
        $dataArray  = array('response' => false, 'data' => '', 'data1' => '');

        if($data && $data1){
            $dataArray = array('response' => true, 'data' => $data, 'data1' => $data1);
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
            $arr = array('response' => true, 'data' => $data);
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
            'penyuplai_id' => $this->request->getPost('pengirim_barang_id')[$i],
            'jumlah' => $this->request->getPost('jumlah_barang_masuk')[$i],
            'harga_pokok' => $this->request->getPost('harga_pokok')[$i],
            'total_harga_pokok' => ($this->request->getPost('harga_pokok')[$i] * $this->request->getPost('jumlah_barang_masuk')[$i])
            );

            
            $data2[] = array(
                'barang_id' => $this->request->getPost('barang_id')[$i],
                'harga_pokok' => $this->request->getPost('harga_pokok')[$i],
                'jumlah' => $this->request->getPost('jumlah_barang_masuk')[$i],
                'penyuplai' => $this->request->getPost('pengirim_barang_id')[$i],
                'harga_konsumen' => $this->request->getPost('harga_konsumen')[$i],
                'harga_anggota' => $this->request->getPost('harga_anggota')[$i]
                );
        }

        $this->model_barang_masuk->TambahBarangMasuk($data, $data2);
        $this->session->setFlashdata('pesan_barang_masuk', 'Barang masuk berhasil ditambahkan!');
        return redirect()->to(base_url('/fitur/barang_masuk'));

    

    }
}
