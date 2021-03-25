<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelBarang;

class Stok extends BaseController
{
	
	public function __construct(){
        $this->request = \Config\Services::request();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelBarang = new ModelBarang();
	}

	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

    public function index(){

		$data = [
			'title' => ucfirst('Pengaturan Stok'),
            'nama_menu_utama' => ucfirst('Stok'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'session' => $this->session,
            'input_minimal_stok' => [
                'type' => 'text', 
                'name'=> 'min_stok',
                'class'=>'form-control',
                'placeholder'=> 'Minimal stok ....'
            ],
            'form_stok' => [
                'id' => 'formStok',
                'name'=>'formStok',
                'class' => 'card-header-form'
            ]
		];
		tampilan_admin('admin/admin-stok/v_stok', 'admin/admin-stok/v_js_stok', $data);
    }

    public function cari(){

        $min_stok = $this->request->getPost('min_stok');

        if($min_stok){
            $stok = $this->modelBarang->cariStok($min_stok);
        }else{
            $stok = '';
        }
        $this->session->setFlashdata('pesan_stok', 'Stok berhasil dicari!');
        $this->session->setFlashdata('data_stok', $stok);
        return redirect()->to(base_url('/suplai/stok'))->withInput();

    }
}
