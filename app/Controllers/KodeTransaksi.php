<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelKodeTransaksi;
class KodeTransaksi extends BaseController
{
	
	public function __construct(){
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelKodeTransaksi = new ModelKodeTransaksi();
	}

	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

    public function index(){
	
        $kode = $this->modelKodeTransaksi->ambilKodeTransaksi();

		$data = [
			'title' => ucfirst('Kode Transaksi'),
            'nama_menu_utama' => ucfirst('Kode'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'kode_transaksi' => $kode,
            'session' => $this->session,
            'form_ubah' => ['id' => 'form-tambah-kode-transaksi'],
			'edit_id_kode_transaksi' => [
				'name' => 'edit_id_kode_transaksi',
				'value' => $kode['id_kode_transaksi'], 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-kodetransaksi/v_kodetransaksi', 'admin/admin-kodetransaksi/v_js_kodetransaksi', $data);
    }
    

    public function ubah(){
        $validasi = $this->modelKodeTransaksi->ubahKodeTransaksi();
        if($validasi){
            $this->session->setFlashdata('pesan_validasi_edit_kode_transaksi',  $validasi);
            return redirect()->to(base_url('/suplai/kode/transaksi'));
        }else{
            $this->session->setFlashdata('pesan_kode_transaksi', 'Kode transaksi berhasil diubah!');
            return redirect()->to(base_url('/suplai/kode/transaksi'));
        }
    }

}
