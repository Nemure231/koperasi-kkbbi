<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_satuan;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_penyuplai;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Barang extends BaseController{

	public function __construct(){
        $this->model_barang = new Model_barang();
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_satuan = new Model_satuan();
        $this->model_merek = new Model_merek();
        $this->model_kategori = new Model_kategori();
        $this->model_penyuplai = new Model_penyuplai();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->db = \Config\Database::connect();
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function index(){
		
		
		$role = $this->session->get('role_id');
		

        $email = $this->session->get('email');

      
        $nama_barang = set_value('nama_barang', '');
        $harga_konsumen = set_value('harga_konsumen', '');
        $harga_anggota = set_value('harga_anggota', '');
        $stok_barang = set_value('stok_barang', '');
        $deskripsi_barang = set_value('deskripsi_barang', '');
        $harga_pokok = set_value('harga_pokok', '');
        $data = [
            'title' => 'Daftar Barang',
            'nama_menu_utama' => 'Gudang',
            'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
						->where('surel', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
            'barang' => $this->model_barang->select('qr, barang.gambar as nama_gambar, barang.id as id_barang, deskripsi as deskripsi_barang, harga_pokok,
                        barang.nama as nama_barang, user.nama as nama_pengirim_barang, penyuplai.id as pengirim_barang_id,
                        kategori.nama as nama_kategori, kode as kode_barang, stok as stok_barang, barang.tanggal as tanggal,
                        tanggal_update, merek.nama as nama_merek, satuan.nama as nama_satuan, kategori_id, satuan_id, 
                        merek_id, harga_anggota, harga_konsumen')->asArray()
                        ->where('user.role_id', 5)
                        ->where('user.status', 1)
                        ->join('kategori', 'kategori.id = barang.kategori_id')
                        ->join('satuan', 'satuan.id = barang.satuan_id')
                        ->join('merek', 'merek.id = barang.merek_id')
                        ->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
                        ->join('user', 'user.id = penyuplai.user_id')
                        ->findAll(),
            'satuan' => $this->model_satuan->select('id as id_satuan, nama as nama_satuan')->asArray()
                        ->findAll(),
            'merek' =>  $this->model_merek->select('id as id_merek, nama as nama_merek')->asArray()
                        ->findAll(),
            'kategori'=>$this->model_kategori->select('id as id_kategori, nama as nama_kategori')->asArray()
                        ->findAll(),
            'supplier'=>$this->model_penyuplai->select('penyuplai.id as id_pengirim_barang, user.nama as nama_pengirim_barang')
                        ->where('user.role_id', 5)
                        ->where('user.status', 1)
                        ->join('user', 'user.id = penyuplai.user_id') 
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'req_gambar' => $this->request,
            'form_tambah_barang' => ['id' => 'formTambahBarang', 'name'=>'formTambahBarang'],
            'form_edit_barang' =>  ['id' => 'formEditBarang', 'name'=>'formEditBarang'],
            'form_hapus_barang' =>  ['id' => 'formHapusBarang', 'name'=>'formHapusBarang', 'class' => 'btn btn-block'],
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
                    'rules'  => 'required|is_unique[barang.nama]',
                    'errors' => [
                    'required' => 'Nama barang harus diisi!',
                    'is_unique' => 'Nama barang sudah ada!'
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
                    'required' => 'Deskripsi barang harus diisi!'
                    ]
                ],
                'gambar' => [
                    'rules'  => 'max_size[gambar,3072]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                    'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Format file yang anda upload bukan gambar!',
                    'mime_in' => 'Format gambar yang diperbolehkan JPG, JPEG, dan PNG!'
                    ]
			],

            ])) {
                
                return redirect()->to(base_url('/suplai/barang'))->withInput();

            }

                $sap = $this->request->getPost('satuan_id');

                if (is_numeric($sap)){
                    $sem = $sap;
                }else{
                    $this->model_satuan->set('nama', $sap)->insert();
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

                $sop = $this->request->getPost('supplier_id');

                if (is_numeric($sop)){
                    $sup = $sop;
                }else{
                    $this->model_penyuplai->set('nama', $sop)->insert();
                    $sup = $this->db->insertID(); 
                }

                date_default_timezone_set("Asia/Jakarta");


                $gambar = $this->request->getFile('gambar');
                if($gambar->getError() == 4){
                    $nama_gambar = 'default.jpg';
                }else{
                    $nama_gambar = time().'.'.$gambar->guessExtension();
			        $gambar->move('admin/assets/barang/', $nama_gambar);
                }


                $kode_br = auto_kode_barang();
                $nama_barang = htmlspecialchars($this->request->getPost('nama_barang'), ENT_QUOTES);
                $data = array(
                    'kode' => $kode_br,
                    'nama' => $nama_barang,
                    'kategori_id' => htmlspecialchars($ket, ENT_QUOTES),
                    'satuan_id' => htmlspecialchars($sem, ENT_QUOTES),
                    'merek_id' => htmlspecialchars($mar, ENT_QUOTES),
                    'penyuplai_id' => htmlspecialchars($sup, ENT_QUOTES),
                    'harga_pokok' => $this->request->getPost('harga_pokok'),
                    'harga_konsumen' => $this->request->getPost('harga_konsumen'),
                    'harga_anggota' => $this->request->getPost('harga_anggota'),
                    'stok' => $this->request->getPost('stok_barang'),
                    'deskripsi' => htmlspecialchars($this->request->getPost('deskripsi_barang'), ENT_QUOTES),
                    'gambar' => $nama_gambar,
                    'qr' => $kode_br.'.png',
                    'tanggal' => date('Y-m-d H:i:s')
                );

                $writer = new PngWriter();
                $qrCode = QrCode::create('BR-00004')
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(300)
                    ->setMargin(10)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));
                $label = Label::create('BR-00004')
                    ->setTextColor(new Color(0, 0, 0));
                $result = $writer->write($qrCode, null, $label);
                $result->saveToFile(FCPATH.'/admin/assets/qr/'.'BR-00004'.'.png');

                $this->model_barang->insert($data);
                $this->session->setFlashdata('pesan_barang', 'Barang baru berhasil ditambahkan!');
                return redirect()->to(base_url('/suplai/barang'));
       
    }

    public function ubah(){


        $id = $this->request->getPost('id_barangE');


            if(!$this->validate([
                'nama_barangE' => [
                    'label'  => 'Nama Barang',
                    'rules'  =>  'required|is_unique[barang.nama,id,'.$id.']',
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
                'edit_gambar' => [
                    'rules'  => 'max_size[edit_gambar,3072]|is_image[edit_gambar]|mime_in[edit_gambar,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                    'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Format file yang anda upload bukan gambar!',
                    'mime_in' => 'Format gambar yang diperbolehkan JPG, JPEG, dan PNG!'
                    ]
                ]
            ])) {
                
                return redirect()->to(base_url('/suplai/barang'))->withInput();

            }


                date_default_timezone_set("Asia/Jakarta");
              
                $nama_barang = htmlspecialchars($this->request->getPost('nama_barangE'), ENT_QUOTES);
                
                
                $sap = $this->request->getPost('satuan_idE');

                if (is_numeric($sap)){
                    $sem = $sap;
                }else{
                    $this->model_satuan->set('nama', $sap)->insert();
                    $sem = $this->db->insertID();
                }

                $kat = $this->request->getPost('kategori_idE');

                if (is_numeric($kat)){
                    $ket = $kat;
                }else{
                    $this->model_kategori->set('nama', $kat)->insert();
                    $ket = $this->db->insertID();   
                }

                $mer = $this->request->getPost('merek_idE');

                if (is_numeric($mer)){
                    $mar = $mer;
                }else{
                    $this->model_merek->set('nama', $mer)->insert();
                    $mar = $this->db->insertID();
                }

                $sop = $this->request->getPost('supplier_idE');

                if (is_numeric($sop)){
                    $sup = $sop;
                }else{
                    $this->model_penyuplai->set('nama', $sop)->insert();
                    $sup = $this->db->insertID(); 
                }

                $edit_gambar = $this->request->getFile('edit_gambar');

                if($edit_gambar->getError() == 4){
                    $nama_gambar = $this->request->getPost('gambar_lama');
                }else{
                    $nama_gambar = time().'.'.$edit_gambar->guessExtension();
			        $edit_gambar->move('admin/assets/barang/', $nama_gambar);
                    unlink('admin/assets/barang/'. $this->request->getPost('gambar_lama'));
                }
                
                $data = array(
                    'nama' => $nama_barang,
                    'kategori_id' => htmlspecialchars($ket, ENT_QUOTES),
                    'satuan_id' => htmlspecialchars($sem, ENT_QUOTES),
                    'merek_id' => htmlspecialchars($mar, ENT_QUOTES),
                    'penyuplai_id' => htmlspecialchars($sup, ENT_QUOTES),
                    'harga_pokok' => $this->request->getPost('harga_pokokE'),
                    'harga_konsumen' => $this->request->getPost('harga_konsumenE'),
                    'harga_anggota' => $this->request->getPost('harga_anggotaE'),
                    'stok' => $this->request->getPost('stok_barangE'),
                    'deskripsi' => $this->request->getPost('deskripsi_barangE'),
                    'gambar' => $nama_gambar,
                    'tanggal_update' => date('Y-m-d H:i:s')
                );
                
                // $this->model->EditBarang($data, $id);
                $this->model_barang->update($id, $data);

                $this->session->setFlashdata('pesan_barang', 'Barang berhasil diedit!');
                return redirect()->to(base_url('/suplai/barang'));
    }

    public function hapus(){
            $id_barang = $this->request->getPost('id_barangH');  

            $hapus = $this->model_barang->select('gambar, qr')->asArray()->where('id', $id_barang)->first();

            if($hapus['gambar'] != 'default.jpg'){
                unlink('admin/assets/barang/'. $hapus['gambar']);
            }
            if($hapus['qr']){
                unlink('admin/assets/qr/'. $hapus['qr']);
            }
            $this->model_barang->delete($id_barang);
            $this->session->setFlashdata('hapus_barang', 'Barang berhasil dihapus!');
            return redirect()->to(base_url('/suplai/barang'));

        
    
    }   
}
?>
