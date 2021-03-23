<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSatuan;
use App\Models\ModelKategori;
use App\Models\ModelMerek;
use App\Models\ModelSupplier;
use App\Models\ModelBarang;
class Barang extends BaseController{

	public function __construct(){
        $this->modelUser = new modelUser();
        $this->modelMenu = new modelMenu();
        $this->modelSatuan = new modelSatuan();
        $this->modelKategori = new modelKategori();
        $this->modelMerek = new modelMerek();
        $this->modelSupplier = new modelSupplier();
        $this->modelBarang = new ModelBarang();
	}
	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

	public function index(){
        
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
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-barang'],
            'form_edit' =>  ['id' => 'form-edit-barang'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_id_barang' => ['type' => 'hidden', 'name' => 'hapus_id_barang', 'id' => 'hapus_id_barang'],
        ];
        tampilan_admin('admin/admin-barang/v_barang', 'admin/admin-barang/v_js_barang', $data);
     
    }

    public function tambah(){

           
        $validasi = $this->modelBarang->tambahBarang();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_barang',  $validasi);
            return redirect()->to(base_url('/suplai/barang'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_barang', 'Barang baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/barang'));
        }
        
    }

    public function ubah(){
                
        $validasi = $this->modelBarang->ubahBarang();
        $old = [
            'id_barang' => $this->request->getPost('edit_id_barang'),
            'kategori_id' => $this->request->getPost('edit_kategori_id'),
            'satuan_id' => $this->request->getPost('edit_satuan_id'),
            'merek_id' => $this->request->getPost('edit_merek_id'),
            'supplier_id' => $this->request->getPost('edit_supplier_id'),
        ];

        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_barang',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);  
            return redirect()->to(base_url('/suplai/barang'))->withInput();
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
