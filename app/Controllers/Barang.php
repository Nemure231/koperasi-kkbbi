<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_satuan;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_pengirim_barang;

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
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function index(){
		
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        $email = $this->session->get('email');

        
    
        //$auto = $this->model->AutoID();
        //var_dump($um); die;
        $kode_barang = $this->model_barang->AutoKodeBarang();
        $nama_barang = set_value('nama_barang', '');
        $harga_konsumen = set_value('harga_konsumen', '');
        $harga_anggota = set_value('harga_anggota', '');
        $stok_barang = set_value('stok_barang', '');
        $deskripsi_barang = set_value('deskripsi_barang', '');
        $harga_pokok = set_value('harga_pokok', '');
        $data = [
            'title' => ucfirst('Daftar Barang'),
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
            'barang' => $this->model_barang->select('id_barang, deskripsi_barang, harga_pokok, 
                        nama_barang, nama_pengirim_barang, pengirim_barang_id, nama_kategori, kode_barang,
                        stok_barang, tanggal, tanggal_update,nama_merek, nama_satuan, kategori_id, satuan_id, 
                        merek_id, harga_anggota, harga_konsumen')->asArray()
                        ->join('kategori', 'kategori.id_kategori = barang.kategori_id')
                        ->join('satuan', 'satuan.id_satuan = barang.satuan_id')
                        ->join('merek', 'merek.id_merek = barang.merek_id')
                        ->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id')
                        ->findAll(),
            'satuan' => $this->model_satuan->select('id_satuan, nama_satuan')->asArray()
                        ->findAll(),
            'merek' =>  $this->model_merek->select('id_merek, nama_merek')->asArray()
                        ->findAll(),
            'kategori'=>$this->model_kategori->select('id_kategori, nama_kategori')->asArray()
                        ->findAll(),
            'supplier'=>$this->model_pengirim_barang->select('id_pengirim_barang, nama_pengirim_barang')->asArray()
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_barang' => ['id' => 'formTambahBarang', 'name'=>'formTambahBarang'],
            'form_edit_barang' =>  ['id' => 'formEditBarang', 'name'=>'formEditBarang'],
            'form_hapus_barang' =>  ['id' => 'formHapusBarang', 'name'=>'formHapusBarang', 'class' => 'btn btn-block'],
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
                
                return redirect()->to(base_url('/suplai/barang'))->withInput();

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
                return redirect()->to(base_url('/suplai/barang'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function ubah(){

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
                
                return redirect()->to(base_url('/suplai/barang'))->withInput();

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
                return redirect()->to(base_url('/suplai/barang'));
                
        $role = $this->session->get('role_id');    
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }
        
    }

    

    // public function kecoh(){
    //     $role = $this->session->get('role_id');

    //     if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
    //     if ($role > 0) {
    //         return redirect()->to(base_url('blokir'));
    //     }
    // }

    
    public function hapus(){     
            $id_barang = $this->request->getPost('id_barangH');  
            $this->model_barang->delete($id_barang);
            $this->session->setFlashdata('hapus_barang', 'Barang berhasil dihapus!');
            return redirect()->to(base_url('/suplai/barang'));

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
