<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSatuan;

class Satuan extends BaseController
{
	
	public function __construct(){
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelSatuan = new ModelSatuan();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos', 'cookie'];

	public function index(){
		
        $data = [
            'title' => ucfirst('Daftar Satuan'),
            'nama_menu_utama' => ucfirst('Barang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'satuan' => $this->modelSatuan->ambilSatuan(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_satuan' => ['id' => 'formTambahSatuan', 'name'=>'formTambahSatuan'],
            'form_edit_satuan' =>  ['id' => 'formEditSatuan', 'name'=>'formEditSatuan'],
            'form_hapus_satuan' =>  ['id' => 'formHapusSatuan', 'name'=>'formHapusSatuan', 'class' => 'btn btn-block'],
            'hidden_id_satuan' => ['name' => 'id_satuanE', 'id'=>'id_satuanE', 'type'=> 'hidden'],
            'hidden_id_satuanH' => ['name' => 'id_satuanH', 'id'=>'id_satuanH', 'type'=> 'hidden', 'class' => 'id_satuanH'],
            'input_satuan' => [
                'type' => 'text',
                'name' => 'nama_satuan',
                'class' => 'form-control'
            ],
            'input_satuanE' => [
                'type' => 'text',
                'name' => 'edit_nama_satuan',
                'id' => 'edit_nama_satuan',
                'class' => 'form-control'
                
            ],
            'hidden_old_nama_satuan' => [
                'type' => 'hidden',
                'name' => 'old_nama_satuan',
                'id' => 'old_nama_satuan',
                'class' => 'form-control'
                
            ]
            
        ];

        tampilan_admin('admin/admin-satuan/v_satuan', 'admin/admin-satuan/v_js_satuan', $data);
     
    }

    public function tambah(){

        $validasi = $this->modelSatuan->tambahSatuan();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_satuan',  $validasi);
            return redirect()->to(base_url('/suplai/satuan'));
        }else{
            
            $this->session->setFlashdata('pesan_satuan', 'Satuan baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/satuan'));
        }
    }

    public function ubah(){


        $id = $this->request->getPost('id_satuanE');

        $validasi = $this->modelSatuan->ubahSatuan($id);
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_satuan',  $validasi);
            return redirect()->to(base_url('/suplai/satuan'));
        }else{
            $this->session->setFlashdata('pesan_satuan', 'Satuan baru berhasil diubah!');
                return redirect()->to(base_url('/suplai/satuan'));
        }
                
       
        
    }


    public function hapus(){
        $id_satuan = $this->request->getPost('id_satuanH');
        $this->modelSatuan->hapusSatuan($id_satuan);
        $this->session->setFlashdata('pesan_hapus_satuan', 'Satuan berhasil dihapus!');
        return redirect()->to(base_url('/suplai/satuan'));
        
    
    }

}
