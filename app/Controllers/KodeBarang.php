<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelKodeBarang;

class KodeBarang extends BaseController
{
	
	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelKodeBarang = new ModelKodeBarang();
	}

	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

    public function index(){
		
        $kode = $this->modelKodeBarang->ambilKodeBarang();

		$data = [
			'title' => ucfirst('Kode Barang'),
            'nama_menu_utama' => ucfirst('Kode'),
			'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
			'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'kode_barang' => $kode,
            'session' => $this->session,
            'edit_id_kode_barang' =>[
                'name' => 'edit_id_kode_barang',
                'value' => $kode['id_kode_barang'],
                'type' => 'hidden'
            ],
            'form_ubah' => ['id' => 'form-tambah-kode-barang']
		];
		tampilan_admin('admin/admin-kodebarang/v_kodebarang', 'admin/admin-kodebarang/v_js_kodebarang', $data);
    }

    public function ubah(){
        $validasi = $this->modelKodeBarang->ubahKodeBarang();
        
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_kode_barang',  $validasi);
            return redirect()->to(base_url('/suplai/kode/barang'));
        }else{
            $this->session->setFlashdata('pesan_kode_barang', 'Kode barang berhasil diubah!');
            return redirect()->to(base_url('/suplai/kode/barang'));
        }
    }

}
