<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_satuan;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_pengirim_barang;

class Barang extends BaseController{

	public function __construct(){
        $this->model = new Model_all();
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
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function index(){
		
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        $email = $this->session->get('email');

        
    
        //$auto = $this->model->AutoID();
        //var_dump($um); die;
        $kode_barang = $this->model->AutoKodeBarang();
        $nama_barang = set_value('nama_barang', '');
        $harga_konsumen = set_value('harga_konsumen', '');
        $harga_anggota = set_value('harga_anggota', '');
        $stok_barang = set_value('stok_barang', '');
        $deskripsi_barang = set_value('deskripsi_barang', '');
        $harga_pokok = set_value('harga_pokok', '');
        $data = [
            'title' => ucfirst('Daftar Barang'),
            'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')
						->join('user_role', 'user_role.id_role = user.role_id')
						->where('email', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
            'barang' => $this->model_barang->select('id_barang, deskripsi_barang, harga_pokok, 
                        nama_barang, nama_pengirim_barang, pengirim_barang_id, nama_kategori, kode_barang,
                        stok_barang, tanggal, tanggal_update,nama_merek, nama_satuan, kategori_id, satuan_id, 
                        merek_id, harga_anggota, harga_konsumen')
                        ->join('kategori', 'kategori.id_kategori = barang.kategori_id')
                        ->join('satuan', 'satuan.id_satuan = barang.satuan_id')
                        ->join('merek', 'merek.id_merek = barang.merek_id')
                        ->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id')
                        ->findAll(),
            'satuan' => $this->model_satuan->select('id_satuan, nama_satuan')
                        ->findAll(),
            'merek' =>  $this->model_merek->select('id_merek, nama_merek')
                        ->findAll(),
            'kategori'=>$this->model_kategori->select('id_kategori, nama_kategori')
                        ->findAll(),
            'supplier'=>$this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_barang' => ['id' => 'formTambahBarang', 'name'=>'formTambahBarang'],
            'form_edit_barang' =>  ['id' => 'formEditBarang', 'name'=>'formEditBarang'],
            'hidden_kode_barang' => [
                'type' => 'hidden',
                'name' => 'kode_barang',
                'id' => 'kode_barang',
                'value' => ''.$kode_barang.'',
                'class' => 'form-control',
                'autofocus' => ''
            ],
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
            'input_deskripsi' => [
                'type' => 'number',
                'name' => 'deskripsi_barang',
                'id' => 'deskripsi_barang',
                'value' => ''.$deskripsi_barang.'',
                'class' => 'form-control',
                'style' => 'min-height:145px;'
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
            'input_deskripsiE' => [
                'type' => 'number',
                'name' => 'deskripsi_barangE',
                'id' => 'deskripsi_barangE',
                'class' => 'form-control',
                'style' => 'min-height:145px;'
            ]
        ];
        tampilan_admin('admin/admin-barang/v_barang', 'admin/admin-barang/v_js_barang', $data);
     
    }

    public function tambahbarang(){
        

            if(!$this->validate([
                'nama_barang' => [
                    'label'  => 'Nama Barang',
                    'rules'  => 'required|is_unique[barang.nama_barang]',
                    'errors' => [
                    'required' => 'Nama barang harus diisi!',
                    'is_unique' => 'Nama barang sudah ada!'
                    ]
                ],
                'kode_barang' => [
                    'label'  => 'Kode Barang',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Kode barang harus diisi!'
                    ]
                ],
                'kategori_id' => [
                    'label'  => 'Kategori',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Kategori harus dipilih!',
                    // 'numeric' => 'Kategori harus angka!'
                    ]
                ],
                'satuan_id' => [
                    'label'  => 'Satuan',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Satuan harus dipilih!'
                    // 'numeric' => 'Satuan harus angka!'
                    ]
                ],
                'merek_id' => [
                    'label'  => 'Merek',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Merek harus dipilih!',
                    // 'numeric' => 'Merek harus angka!'
                    ]
                ],
                'supplier_id' => [
                    'label'  => 'Supplier',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Supplier harus dipilih!'
                   // 'numeric' => 'Supplier harus angka!'
                    ]
                ],
                'harga_konsumen' => [
                    'label'  => 'Harga Konsumen',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harga konsumen harus diisi!',
                    'numeric' => 'Harga konsumen harus angka!'
                    ]
                ],
                'harga_pokok' => [
                    'label'  => 'Harga Pokok',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harga pokok harus diisi!',
                    'numeric' => 'Harga pokok harus angka!'
                    ]
                ],
                'harga_anggota' => [
                    'label'  => 'Harga Anggota',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harga anggota harus diisi!',
                    'numeric' => 'Harga anggota harus angka!'
                    ]
                ],
                'stok_barang' => [
                    'label'  => 'Stok Barang',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Stok barang harus diisi!',
                    'numeric' => 'Stok barang harus angka!'
                    ]
                ],
                'deskripsi_barang' => [
                    'label'  => 'Deskripsi Barang',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Dskripsi barang harus diisi!'
                    ]
                ]

            ])) {
                
                return redirect()->to(base_url('/barang'))->withInput();

            }

                $sap = $this->request->getPost('satuan_id');

                if (is_numeric($sap)){
                    $sem = $sap;
                }else{
                    $this->model_satuan->set('nama_satuan', $sap)->insert();
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

                $sop = $this->request->getPost('supplier_id');

                if (is_numeric($sop)){
                    $sup = $sop;
                }else{
                    $this->model_pengirim_barang->set('nama_pengirim_barang', $sop)->insert();
                    $sup = $this->db->insertID(); 
                }

                date_default_timezone_set("Asia/Jakarta");

                $nama_barang = htmlspecialchars($this->request->getPost('nama_barang'), ENT_QUOTES);
                $data = array(
                    'kode_barang' => htmlspecialchars($this->request->getPost('kode_barang'), ENT_QUOTES),
                    'nama_barang' => $nama_barang,
                    'kategori_id' => htmlspecialchars($ket, ENT_QUOTES),
                    'satuan_id' => htmlspecialchars($sem, ENT_QUOTES),
                    'merek_id' => htmlspecialchars($mar, ENT_QUOTES),
                    'pengirim_barang_id' => htmlspecialchars($sup, ENT_QUOTES),
                    'harga_pokok' => $this->request->getPost('harga_pokok'),
                    'harga_konsumen' => $this->request->getPost('harga_konsumen'),
                    'harga_anggota' => $this->request->getPost('harga_anggota'),
                    'stok_barang' => $this->request->getPost('stok_barang'),
                    'deskripsi_barang' => htmlspecialchars($this->request->getPost('deskripsi_barang'), ENT_QUOTES),
                    'tanggal' => date('Y-m-d H:i:s')
                );
    
                $this->model_barang->insert($data);
                
               
                $this->session->setFlashdata('pesan_barang', 'Barang baru berhasil ditambahkan!');
                return redirect()->to(base_url('/barang'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function editbarang(){

        $old = $this->request->getPost('nama_barang_old');
        $new = $this->request->getPost('nama_barangE');

        $rules_nama = 'required';

        if($old != $new){
            $rules_nama =  'required|is_unique[barang.nama_barang]';
        }

            if(!$this->validate([
                'nama_barangE' => [
                    'label'  => 'Nama Barang',
                    'rules'  => $rules_nama,
                    'errors' => [
                    'required' => 'Nama barang harus diisi!',
                    'is_unique' => 'Nama barang sudah ada!'
                
                    ]
                ],
                'kategori_idE' => [
                    'label'  => 'Penulis',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Kategori harus dipilih!'
                    //'numeric' => 'Kategori harus angka!'
                    ]
                ],
                'satuan_idE' => [
                    'label'  => 'Satuan',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Satuan harus dipilih!'
                    // 'numeric' => 'Satuan harus angka!'
                    ]
                ],
                'merek_idE' => [
                    'label'  => 'Merek',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Merek harus dipilih!',
                    //'numeric' => 'Merek harus angka!'
                    ]
                ],
                'supplier_idE' => [
                    'label'  => 'Supplier',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Supplier harus dipilih!',
                    // 'numeric' => 'Supplier harus angka!'
                    ]
                ],
                'harga_pokokE' => [
                    'label'  => 'Harga Pokok',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harga pokok harus diisi!',
                    'numeric' => 'Harga pokok harus angka!'
                    ]
                ],
                'harga_konsumenE' => [
                    'label'  => 'Harga Konsumen',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harga konsumen harus diisi!',
                    'numeric' => 'Harga konsumen harus angka!'
                    ]
                ],
                'harga_anggotaE' => [
                    'label'  => 'Harga Anggota',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harga anggota harus diisi!',
                    'numeric' => 'Harga anggota harus angka!'
                    ]
                ],
                'stok_barangE' => [
                    'label'  => 'Stok Barang',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Stok barang harus diisi!',
                    'numeric' => 'Stok barang harus angka!'
                    ]
                ],
                'deskripsi_barangE' => [
                    'label'  => 'Deskripsi Barang',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Dskripsi barang harus diisi!'
                    ]
                ]
            ])) {
                
                return redirect()->to(base_url('/barang'))->withInput();

            }


                date_default_timezone_set("Asia/Jakarta");
                $id = $this->request->getPost('id_barangE');
                $nama_barang = htmlspecialchars($this->request->getPost('nama_barangE'), ENT_QUOTES);
                
                
                $sap = $this->request->getPost('satuan_idE');

                if (is_numeric($sap)){
                    $sem = $sap;
                }else{
                    $this->model_satuan->set('nama_satuan', $sap)->insert();
                    $sem = $this->db->insertID();
                }

                $kat = $this->request->getPost('kategori_idE');

                if (is_numeric($kat)){
                    $ket = $kat;
                }else{
                    $this->model_kategori->set('nama_kategori', $kat)->insert();
                    $ket = $this->db->insertID();   
                }

                $mer = $this->request->getPost('merek_idE');

                if (is_numeric($mer)){
                    $mar = $mer;
                }else{
                    $this->model_merek->set('nama_merek', $mer)->insert();
                    $mar = $this->db->insertID();
                }

                $sop = $this->request->getPost('supplier_idE');

                if (is_numeric($sop)){
                    $sup = $sop;
                }else{
                    $this->model_pengirim_barang->set('nama_pengirim_barang', $sop)->insert();
                    $sup = $this->db->insertID(); 
                }
                
                
                
                $data = array(
                    'nama_barang' => $nama_barang,
                    'kategori_id' => htmlspecialchars($ket, ENT_QUOTES),
                    'satuan_id' => htmlspecialchars($sem, ENT_QUOTES),
                    'merek_id' => htmlspecialchars($mar, ENT_QUOTES),
                    'pengirim_barang_id' => htmlspecialchars($sup, ENT_QUOTES),
                    'harga_pokok' => $this->request->getPost('harga_pokokE'),
                    'harga_konsumen' => $this->request->getPost('harga_konsumenE'),
                    'harga_anggota' => $this->request->getPost('harga_anggotaE'),
                    'stok_barang' => $this->request->getPost('stok_barangE'),
                    'deskripsi_barang' => $this->request->getPost('deskripsi_barangE'),
                    'tanggal_update' => date('Y-m-d H:i:s')
                );
                
                // $this->model->EditBarang($data, $id);
                $this->model_barang->update($id, $data);

                $this->session->setFlashdata('pesan_barang', 'Barang berhasil diedit!');
                return redirect()->to(base_url('/barang'));
                
        $role = $this->session->get('role_id');    
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }
        
    }

    

    public function kecohhapusbarang(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
            return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusbarang($barang_id){

       
            $this->model_barang->delete($barang_id);
            $this->session->setFlashdata('hapus_barang', 'Barang berhasil dihapus!');
            return redirect()->to(base_url('/barang'));

        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        
    
    }



     

     /////////////////////////////////////////SUPPLIER//////////////////////////////////


     public function daftarsupplier(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $data = [
            'title' => ucfirst('Daftar Supplier'),
            'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'supplier' => $this->model->GetAllSupplier(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_supplier' => ['id' => 'formTambahSupplier', 'name'=>'formTambahSupplier'],
            'form_edit_supplier' =>  ['id' => 'formEditSupplier', 'name'=>'formEditSupplier'],
            'hidden_id_supplier' => ['name' => 'id_supplierE', 'id'=>'id_supplierE', 'type'=> 'hidden'],
            'hidden_old_nama_supplier' => [
                'type' => 'hidden',
                'name' => 'old_nama_supplier',
                'id' => 'old_nama_supplier',
                'class' => 'form-control'
                
            ]

            
        ];
        // $id_buku = $this->request->getPost('id_buku');
        // $data = $this->model->AmbilBukuByPenerbit($id_buku);
        // dd($data['id_buku']);
        tampilan_admin('admin/admin-supplier/v_supplier', 'admin/admin-supplier/v_js_supplier', $data);
     
    }

    public function tambahsupplier(){

        
       
            if(!$this->validate([
                'nama_supplier' => [
                    'label'  => 'Nama Supplier',
                    'rules'  => 'required|is_unique[pengirim_barang.nama_pengirim_barang]',
                    'errors' => [
                    'required' => 'Nama supplier harus diisi!',
                    'is_unique' => 'Nama supplier sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarsupplier'))->withInput();

            }

                $data = array(
                    'nama_pengirim_barang' => htmlspecialchars($this->request->getPost('nama_supplier'), ENT_QUOTES)
                );

                $this->model->TambahSupplier($data);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil ditambahkan!');
                return redirect()->to(base_url('/barang/daftarsupplier'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function editsupplier(){

        $old = $this->request->getPost('edit_nama_supplier');
        $new = $this->request->getPost('old_nama_supplier');

        $nama = 'required';

        if($old != $new){
            $nama =  'required|is_unique[pengirim_barang.nama_pengirim_barang]';
        }

            if(!$this->validate([
                'edit_nama_supplier' => [
                    'label'  => 'Nama Supplier',
                    'rules'  => $nama,
                    'errors' => [
                    'required' => 'Nama supplier harus diisi!',
                    'is_unique' => 'Nama supplier sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarsupplier'))->withInput();

            }
                $id = $this->request->getPost('id_supplierE');
                $data = array(
                    'nama_pengirim_barang' => htmlspecialchars($this->request->getPost('edit_nama_supplier'), ENT_QUOTES)
                );

                $this->model->EditSupplier($data, $id);
            
                $this->session->setFlashdata('pesan_supplier', 'Supplier baru berhasil diedit!');
                return redirect()->to(base_url('/barang/daftarsupplier'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }



    public function kecohhapussupplier(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapussupplier($id_supplier){
           
            
            $this->model->HapusSupplier($id_supplier);
            $this->session->setFlashdata('pesan_hapus_supplier', 'Supplier berhasil dihapus!');
            return redirect()->to(base_url('/barang/daftarsupplier'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }


    /////////////////////////////////////////MEREK//////////////////////////////////


    public function daftarmerek(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $data = [
            'title' => ucfirst('Daftar Merek'),
            'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'merek' => $this->model->GetAllMerek(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_merek' => ['id' => 'formTambahMerek', 'name'=>'formTambahMerek'],
            'form_edit_merek' =>  ['id' => 'formEditMerek', 'name'=>'formEditMerek'],
            'hidden_id_merek' => ['name' => 'id_merekE', 'id'=>'id_merekE', 'type'=> 'hidden'],
            'input_nama_merek' => [
                'type' => 'text',
                'name' => 'nama_merek',
                'class' => 'form-control'
                
            ],
            'input_nama_merekE' => [
                'type' => 'text',
                'name' => 'edit_nama_merek',
                'id' => 'edit_nama_merek',
                'class' => 'form-control'
                
            ],
            'hidden_nama_merek' => [
                'type' => 'hidden',
                'name' => 'old_nama_merek',
                'id' => 'old_nama_merek',
                'class' => 'form-control'
                
            ],
            
        ];
        // $id_buku = $this->request->getPost('id_buku');
        // $data = $this->model->AmbilBukuByPenerbit($id_buku);
        // dd($data['id_buku']);
        tampilan_admin('admin/admin-merek/v_merek', 'admin/admin-merek/v_js_merek', $data);
     
    }

    public function tambahmerek(){

       

            if(!$this->validate([
                'nama_merek' => [
                    'label'  => 'Nama Merek',
                    'rules'  => 'required|is_unique[merek.nama_merek]',
                    'errors' => [
                    'required' => 'Nama merek harus diisi!',
                    'is_unique' => 'Nama merek sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarmerek'))->withInput();

            }

                $data = array(
                    'nama_merek' => htmlspecialchars($this->request->getPost('nama_merek'), ENT_QUOTES)
                );

                $this->model->TambahMerek($data);
            
                $this->session->setFlashdata('pesan_merek', 'Merek baru berhasil ditambahkan!');
                return redirect()->to(base_url('/barang/daftarmerek'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function editmerek(){

        $old = $this->request->getPost('edit_nama_merek');
        $new = $this->request->getPost('old_nama_merek');
        
        $nama = 'required';

        if($old != $new){
            $nama =  'required|is_unique[merek.nama_merek]';
        } 

            if(!$this->validate([
                'edit_nama_merek' => [
                    'label'  => 'Nama Merek',
                    'rules'  => $nama,
                    'errors' => [
                    'required' => 'Nama merek harus diisi!',
                    'is_unique' => 'Nama merek sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/barang/daftarmerek'))->withInput();

            }
                $id = $this->request->getPost('id_merekE');
                $data = array(
                    'nama_merek' => htmlspecialchars($this->request->getPost('edit_nama_merek'), ENT_QUOTES)
                );

                $this->model->EditMerek($data, $id);
            
                $this->session->setFlashdata('pesan_merek', 'Merek baru berhasil diedit!');
                return redirect()->to(base_url('/barang/daftarmerek'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }



    public function kecohhapusmerek(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusmerek($id_merek){
           
            
            $this->model->HapusMerek($id_merek);
            $this->session->setFlashdata('pesan_hapus_merek', 'Merek berhasil dihapus!');
            return redirect()->to(base_url('/barang/daftarmerek'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }

    ////////////////////////////////////////////KODE BARANG//////////////////////////
    public function pengaturankodebarang(){
		
		$role = $this->session->get('role_id');
		

		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

		
        $kode = $this->model->GetRowTbKodeBarang();
        //$va = '$validation->hasError';

		$data = [
			'title' => ucfirst('Pengaturan Kode Barang'),
			'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'kode' => $kode,
            'session' => $this->session,
            'validation' => $this->validation,
            'form_kodebarang' => [
                'id' => 'formKodebarang',
                'name'=>'formKodebarang'
            ],
			'hidd_id_kode_barang' => [
				'name' => 'tb_kode_barang_id',
				'id'=> 'tb_kode_barang_id',
				'value' => ''.$kode['id_tb_kode_barang'].'', 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-kodebarang/v_kodebarang', 'admin/admin-kodebarang/v_js_kodebarang', $data);
    }
    

    public function editkodebarang(){
      
    
            if(!$this->validate([
                'huruf_kode_barang' => [
                    'label'  => 'Huruf kode Barang',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Huruf kode barang harus diisi!'
                    ]
                ],
                'jumlah_angka' => [
                    'label'  => 'Jumlah angka',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Jumlah angka harus diisi!'
                    ]
                ]

            ])) {
               
                return redirect()->to(base_url('/barang/pengaturankodebarang'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_barang_id');
                $ubah = [
                    'huruf_kode_barang' => htmlspecialchars($this->request->getPost('huruf_kode_barang'), ENT_QUOTES),
                    'jumlah_angka' => htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                    $this->model->UbahKodeBarang($ubah, $id);
                    $this->session->setFlashdata('pesan_kode_barang', 'Kode barang berhasil diubah!');
                    return redirect()->to(base_url('/barang/pengaturankodebarang'));
                        
                $role = $this->session->get('role_id');
                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                
                if ($userAccess = $this->model->Tendang() < 1) {
                        return redirect()->to(base_url('blokir'));
                }
        
    }

    ////////////////////////////////////////////KODE BARANG//////////////////////////
    public function pengaturankodetransaksi(){
		
		$role = $this->session->get('role_id');
		

		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        
        $kode = $this->model->GetRowTbKodetransaksi();
        //$va = '$validation->hasError';

		$data = [
			'title' => ucfirst('Pengaturan Kode Transaksi'),
			'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'kode' => $kode,
            'session' => $this->session,
            'validation' => $this->validation,
            'form_kodetransaksi' => [
                'id' => 'formKodetransaksi',
                'name'=>'formKodetransaksi'
            ],
			'hidd_id_kode_transaksi' => [
				'name' => 'tb_kode_transaksi_id',
				'id'=> 'tb_kode_transaksi_id', 
				'value' => ''.$kode['id_tb_kode_transaksi'].'', 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-kodetransaksi/v_kodetransaksi', 'admin/admin-kodetransaksi/v_js_kodetransaksi', $data);
    }
    

    public function editkodetransaksi(){

            if(!$this->validate([
                'huruf_kode_transaksi' => [
                    'label'  => 'Huruf kode transaksi',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Huruf kode transaksi harus diisi!'
                    ]
                ],
                'jumlah_angka' => [
                    'label'  => 'Jumlah angka',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Jumlah angka harus diisi!'
                    ]
                ]

            ])) {
               
                return redirect()->to(base_url('barang/pengaturankodetransaksi'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_transaksi_id');
                $ubah = [
                    'huruf_kode_transaksi' => htmlspecialchars($this->request->getPost('huruf_kode_transaksi'), ENT_QUOTES),
                    'jumlah_angka' => htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                $this->model->UbahKodeTransaksi($ubah, $id);            
                $this->session->setFlashdata('pesan_kode_transaksi', 'Kode transaksi berhasil diubah!');
                return redirect()->to(base_url('/barang/pengaturankodetransaksi'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }
        
    }

    /////////////////////////////////////////////KODE RETUR///////////////////////////////////

    public function pengaturankoderetur(){
		
		$role = $this->session->get('role_id');
		

		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        


        
        $kode = $this->model->GetRowTbKodeRetur();
        //$va = '$validation->hasError';

		$data = [
			'title' => ucfirst('Pengaturan Kode Retur'),
			'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'kode' => $kode,
            'session' => $this->session,
            'validation' => $this->validation,
            'form_koderetur' => [
                'id' => 'formKoderetur',
                'name'=>'formKoderetur'
            ],
			'hidd_id_kode_retur' => [
				'name' => 'tb_kode_retur_id',
				'id'=> 'tb_kode_retur_id', 
				'value' => ''.$kode['id_tb_kode_retur'].'', 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-koderetur/v_koderetur', 'admin/admin-koderetur/v_js_koderetur', $data);
    }
    

    public function editkoderetur(){
       
        
    
            if(!$this->validate([
                'huruf_kode_retur' => [
                    'label'  => 'Huruf kode retur',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Huruf kode retur harus diisi!'
                    ]
                ],
                'jumlah_angka' => [
                    'label'  => 'Jumlah angka',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Jumlah angka harus diisi!'
                    ]
                ]

            ])) {
               
                return redirect()->to(base_url('barang/pengaturankoderetur'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_retur_id');
                $ubah = [
                    'huruf_kode_retur' =>  htmlspecialchars($this->request->getPost('huruf_kode_retur'), ENT_QUOTES),
                    'jumlah_angka' =>  htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                $this->model->UbahKodeRetur($ubah, $id);
                
                $this->session->setFlashdata('pesan_kode_retur', 'Kode retur berhasil diubah!');
                return redirect()->to(base_url('/barang/pengaturankoderetur'));
                
            
        if (!$role){
            return redirect()->to(base_url('/'));
        
        }
        if ($userAccess = $this->model->Tendang() < 1) {
                return redirect()->to(base_url('blokir'));
        }
        
    }

    /////////////////////////////////////////////STOK//////////////////////////////////////////

    public function stok(){
		

		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

		
        $stok = $this->model->GetRowStok();
		$data = [
			'title' => ucfirst('Pengaturan Stok'),
			'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'stok' => $stok,
            'habis' => $this->model->GetAllStokHampirHabis(),
            'session' => $this->session,
            'validation' => $this->validation,
            'form_stok' => [
                'id' => 'formStok',
                'name'=>'formStok'
            ],
			'input_id_stokH' => [
				'name' => 'id_stok',
				'id'=> 'id_stok', 
				'value' => ''.$stok['id_stok'].'', 
				'type'=> 'hidden'
            ]
		];
		tampilan_admin('admin/admin-stok/v_stok', 'admin/admin-stok/v_js_stok', $data);
    }

    public function editstok(){
          
    
            if(!$this->validate([
                'min_stok' => [
                    'label'  => 'Stok Minimal',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Stok harus diisi!',
                    'numeric' => 'Stok harus angka!'
                    ]
                ]

            ])) {
               
                return redirect()->to(base_url('/barang/stok'))->withInput();

            }

            $id_stok = $this->request->getPost('id_stok');
            $edit = [
                'min_stok' => $this->request->getPost('min_stok')
            ];

            $this->model->EditStok($edit, $id_stok);
                
            $this->session->setFlashdata('pesan_stok', 'Stok berhasil dicari!');
            return redirect()->to(base_url('/barang/stok'));
                
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            $userAccess = $this->model->Tendang() ;
            if ($userAccess < 1) {
                    return redirect()->to(base_url('blokir'));
            }
        
    }

    /////////////////////////////////////////////BARANG MASUK////////////////////////////

    public function masuk(){
		
		$role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $kode_barang = $this->model->AutoKodeBarang();
        $data = [
           
           'title' => ucfirst('Tambah Barang Masuk'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'validation' => $this->validation,
           'pengirim' => $this->model->GetAllPengirimBarang(),
           'barang' => $this->model->GetAllBarangForLaporanMasuk(),
           'masuk' => $this->model->GetAllBarangMasuk(),
           'satuan' => $this->model->GetAllSatuan(),
           'merek' => $this->model->GetAllMerek(),
           'kategori' => $this->model->GetAllKategori(),
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
             //'value' => ''.$nama_barang.'',
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
                //'value' => ''.$keterangan.'',
                'class' => 'form-control',
                'style' => 'min-height:145px;'
            ],
            
        ];
        //dd();
        tampilan_admin('admin/admin-laporan-barang-masuk/v_laporan_barang_masuk', 'admin/admin-laporan-barang-masuk/v_js_laporan_barang_masuk', $data);
    }
    
    public function tambahpengirim(){
            $nama = $this->request->getPost('nama_pengirim_barang');

            if (!$nama) {
                return redirect()->to(base_url('blokir'));
            }
            
            $data = array(
            'nama_pengirim_barang' => htmlspecialchars($nama, ENT_QUOTES),
            );

            $status = false;
            $this->session->setFlashdata('pesan_pengirim', 'Nama pengirim berhasil ditambahkan!');
            $this->model->TambahPengirim($data);
            $status = true;
            
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            echo json_encode(array("status" => $status , 'data' => $data));
    }

    public function barangmasuk(){
        $kodeb = $this->request->getPost('kode_barang');
        
        // if (!$kodeb) {
        //     return redirect()->to(base_url('blokir'));
        // }

        $sop = $this->request->getPost('satuan_id');

        if (is_numeric($sop)){
            $sem = $sop;
        }else{
            $sem = $this->model->TambahSatuan1($sop);   
        }

        $kat = $this->request->getPost('kategori_id');

        if (is_numeric($kat)){
            $ket = $kat;
        }else{
            $ket = $this->model->TambahKategori1($kat);   
        }

        $mer = $this->request->getPost('merek_id');

        if (is_numeric($mer)){
            $mar = $mer;
        }else{
            $mar = $this->model->TambahMerek1($mer);   
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

            //dd($data);
    
        $this->session->setFlashdata('pesan_barangL', 'Barang berhasil ditambahkan!');
        $id = $this->model->TambahBarangForMasuk($data);
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }

        echo json_encode(array('data' => $data));

        
    }

    public function ambilbarang(){

        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }

        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }

        $data = $this->model->GetAllBarangForBarangMasuk();
        $data1 = $this->model->GetAllPengirimBarang();
        $arr = array('response' => false, 'data' => '', 'data1' => '');

        if($data && $data1){
            $arr = array('response' => true, 'data' => $data, 'data1' => $data1);
        }
        echo json_encode($arr);

    }

    public function ambilidbarang(){

        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }

        $id_barang = $this->request->getPost('barang_id');
        $data = $this->model->GetHargaPokokForBarangMasuk($id_barang);
        $arr = array('response' => false, 'data' => '');

        if($data){
            $arr = array('response' => true, 'data' => $data);
        }
        echo json_encode($arr);

    }

     public function tambahbarangmasuk(){
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

        //dd($data);

        $this->model->TambahBarangMasuk($data, $data2);
        $this->session->setFlashdata('pesan_barang_masuk', 'Barang masuk berhasil ditambahkan!');
        return redirect()->to(base_url('/barang/masuk'));


        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }
    

    }
}
?>
