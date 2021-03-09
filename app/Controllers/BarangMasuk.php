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
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];

    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		
		if(!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        
        $kode_barang = $this->model_barang->AutoKodeBarang();
        $data = [
           
            'title'     => ucfirst('Barang Masuk'),
            'nama_menu_utama' => ucfirst('Pembelian'),
            'user' 	    =>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
                            ->join('user_role', 'user_role.id_role = user.role_id')
                            ->where('email', $email)
                            ->first(),
            'menu' 	    => 	$this->model_user_menu->select('id_menu, menu')->asArray()
                            ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                            ->where('user_access_menu.role_id =', $role)
                            ->orderBy('user_access_menu.menu_id', 'ASC')
                            ->orderBy('user_access_menu.role_id', 'ASC')
                            ->findAll(),
            'session'   =>  $this->session,
            'validation'=>  $this->validation,
            'barang'    =>  $this->model_barang->select('id_barang, nama_barang')->asArray()
                            ->asArray()->where('id_barang>', 0)->findAll(),
            'masuk'     =>  $this->model_barang_masuk->select('nama_barang, tanggal_masuk')->asArray()
                            ->join('barang', 'barang.id_barang = barang_masuk.barang_id')
                            ->findAll(),
            'satuan'    =>  $this->model_satuan->select('id_satuan, nama_satuan')->asArray()
                            ->findAll(),
            'merek'     =>  $this->model_merek->select('id_merek, nama_merek')->asArray()
                            ->findAll(),
            'kategori'=>    $this->model_kategori->select('id_kategori, nama_kategori')->asArray()
                            ->findAll(),
            'pengirim'=>    $this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')->asArray()
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

            if (!$nama) {
                return redirect()->to(base_url('blokir'));
            }
            
            $data = array(
            'nama_pengirim_barang' => htmlspecialchars($nama, ENT_QUOTES),
            );

            $status = false;
            $this->session->setFlashdata('pesan_pengirim', 'Nama pengirim berhasil ditambahkan!');
            $this->model_pengirim_barang->insert($data);
            $this->db->insertID();
            $status = true;
            
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            echo json_encode(array("status" => $status , 'data' => $data));
    }

    public function tambah_barang(){
        $kodeb = $this->request->getPost('kode_barang');
        
        // if (!$kodeb) {
        //     return redirect()->to(base_url('blokir'));
        // }

        $sop = $this->request->getPost('satuan_id');

        if (is_numeric($sop)){
            $sem = $sop;
        }else{
            $this->model_satuan->set('nama_satuan', $sop)->insert();
            $sem = $this->db->insertID();
        }

        $kat = $this->request->getPost('kategori_id');
        if (is_numeric($kat)){
            $ket = $kat;
        }else{
            $this->model_kategori->set('nama_kategori', $kat)->insert(); 
            $ket = $this->db->insertID(); 
        }

        $mer = $this->request->getPost('merek_id');

        if (is_numeric($mer)){
            $mar = $mer;
        }else{
            $this->model_merek->set('nama_merek', $mer)->insert();
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
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }

        echo json_encode(array('data' => $data));

        
    }

    public function ambil_detail(){

        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }

        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }

        $data = $this->model_barang->select('nama_barang, id_barang')->asArray()
                ->where('id_barang>', 0)->findAll();
        $data1= $this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')
                ->asArray()->findAll();
        $dataArray  = array('response' => false, 'data' => '', 'data1' => '');

        if($data && $data1){
            $dataArray = array('response' => true, 'data' => $data, 'data1' => $data1);
        }
        echo json_encode($dataArray);

    }

    public function ambil_harga(){

        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }

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
