<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelMerek;
class Merek extends BaseController
{
	
	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelMerek = new ModelMerek();
	}

	protected $helpers = ['url', 'form', 'kpos', 'cookie'];


    public function index(){
		
        $data = [
            'title' => ucfirst('Daftar Merek'),
            'nama_menu_utama' => ucfirst('Gudang'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'merek' =>  $this->modelMerek->ambilMerek(),
            'session' => $this->session,
            'form_tambah' => ['id' => 'form-tambah-merek'],
            'form_edit' =>  ['id' => 'form-edit-merek'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hapus_id_merek' => ['name' => 'hapus_id_merek', 'id'=>'hapus_id_merek', 'type'=> 'hidden']
        ];
        tampilan_admin('admin/admin-merek/v_merek', 'admin/admin-merek/v_js_merek', $data);
     
    }

    public function tambah(){

        $validasi = $this->modelMerek->tambahMerek();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_tambah_merek',  $validasi);
            return redirect()->to(base_url('/suplai/merek'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_merek', 'Merek baru berhasil ditambahkan!');
            return redirect()->to(base_url('/suplai/merek'));
        }
    }

    public function ubah(){

        $validasi = $this->modelMerek->ubahMerek();

        $old = [
            'id_merek' => $this->request->getPost('edit_id_merek')
        ];
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_merek',  $validasi);
            $this->session->setFlashdata('old_edit_input',  $old);
            return redirect()->to(base_url('/suplai/merek'))->withInput();
        }else{
            $this->session->setFlashdata('pesan_merek', 'Merek berhasil diubah!');
            return redirect()->to(base_url('/suplai/merek'));
        }
    }


    public function hapus(){
        $this->modelMerek->hapusMerek();
        $this->session->setFlashdata('pesan_hapus_merek', 'Merek berhasil dihapus!');
        return redirect()->to(base_url('/suplai/merek'));
    }

}
