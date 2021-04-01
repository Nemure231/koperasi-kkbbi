<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSatuan;

class Satuan extends BaseController
{
	
	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelSatuan = new ModelSatuan();
	}

	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

	public function index(){
		
        $data = [
            'title' => ucfirst('Daftar Satuan'),
            'nama_menu_utama' => ucfirst('Gudang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'satuan' => $this->modelSatuan->ambilSatuan(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-satuan'],
            'form_edit' =>  ['id' => 'form-edit-satuan'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_id_satuan' => ['name' => 'hapus_id_satuan', 'id'=>'hapus_id_satuan', 'type'=> 'hidden'],
            
        ];

        tampilan_admin('admin/admin-satuan/v_satuan', 'admin/admin-satuan/v_js_satuan', $data);
     
    }

    public function tambah(){

        $validasi = $this->modelSatuan->tambahSatuan();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_satuan',  $validasi);
            return redirect()->to(base_url('/suplai/satuan'))->withInput();
        }else{
            
            $this->session->setFlashdata('pesan_satuan', 'Satuan baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/satuan'));
        }
    }

    public function ubah(){

        $validasi = $this->modelSatuan->ubahSatuan();
        $old = [
            'id_satuan' => $this->request->getPost('edit_id_satuan')
        ];
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_satuan',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/suplai/satuan'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_satuan', 'Satuan berhasil diubah!');
                return redirect()->to(base_url('/suplai/satuan'));
        }
    }


    public function hapus(){
        $this->modelSatuan->hapusSatuan();
        $this->session->setFlashdata('pesan_hapus_satuan', 'Satuan berhasil dihapus!');
        return redirect()->to(base_url('/suplai/satuan'));
        
    
    }

}
