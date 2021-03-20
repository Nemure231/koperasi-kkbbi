<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelMerek;
class Merek extends BaseController
{
	
	public function __construct(){
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelMerek = new ModelMerek();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];


    public function index(){
		
        $data = [
            'title' => ucfirst('Daftar Merek'),
            'nama_menu_utama' => ucfirst('Barang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'merek' =>  $this->modelMerek->ambilMerek(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_merek' => ['id' => 'formTambahMerek', 'name'=>'formTambahMerek'],
            'form_edit_merek' =>  ['id' => 'formEditMerek', 'name'=>'formEditMerek'],
            'form_hapus_merek' =>  ['id' => 'formHapusMerek', 'name'=>'formHapusMerek', 'class' => 'btn btn-block'],
            'hidden_id_merek' => ['name' => 'id_merekE', 'id'=>'id_merekE', 'type'=> 'hidden'],
            'hidden_id_merekH' => ['name' => 'id_merekH', 'id'=>'id_merekH', 'type'=> 'hidden'],
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
        tampilan_admin('admin/admin-merek/v_merek', 'admin/admin-merek/v_js_merek', $data);
     
    }

    public function tambah(){

        $validasi = $this->modelMerek->tambahMerek();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_merek',  $validasi);
            return redirect()->to(base_url('/suplai/merek'));
        }else{
            $this->session->setFlashdata('pesan_merek', 'Merek baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/merek'));
        }
    }

    public function ubah(){

        $id = $this->request->getPost('id_merekE');
        $validasi = $this->modelMerek->ubahMerek($id);
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_merek',  $validasi);
            return redirect()->to(base_url('/suplai/merek'));
        }else{
            $this->session->setFlashdata('pesan_merek', 'Merek berhasil diubah!');
            return redirect()->to(base_url('/suplai/merek'));
        }
    }


    public function hapus(){
        $id_merek = $this->request->getPost('id_merekH'); 
        $this->modelMerek->hapusMerek($id_merek);
        $this->session->setFlashdata('pesan_hapus_merek', 'Merek berhasil dihapus!');
        return redirect()->to(base_url('/suplai/merek'));
    }

}
