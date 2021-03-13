<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_kode_barang;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Users;

class KodeBarang extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_kode_barang = new Model_kode_barang();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->user = new Users();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	 ////////////////////////////////////////////KODE BARANG//////////////////////////
     public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');

        $kode = $this->model_kode_barang->select('id_tb_kode_barang, huruf_kode_barang, jumlah_angka')->asArray()
                ->first();

		$data = [
			'title' => ucfirst('Kode Barang'),
            'nama_menu_utama' => ucfirst('Kode'),
			'user' 	=> 	$this->user->ambilSatuUserBuatProfil()['users'],
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
            'kode' => $kode,
            'session' => $this->session,
            'validation' => $this->validation,
            'form_kodebarang' => [
                'id' => 'formKodebarang',
                'name'=>'formKodebarang'
            ],
			'hidd_id_kode_barang' => [
				'name' => 'tb_kode_barang_id',
				'id'=> 'tb_kode_barang_id',
				'value' => ''.$kode['id_tb_kode_barang'].'', 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-kodebarang/v_kodebarang', 'admin/admin-kodebarang/v_js_kodebarang', $data);
    }
    

    public function ubah(){
      
    
            if(!$this->validate([
                'huruf_kode_barang' => [
                    'label'  => 'Huruf kode Barang',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Huruf kode barang harus diisi!'
                    ]
                ],
                'jumlah_angka' => [
                    'label'  => 'Jumlah angka',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Jumlah angka harus diisi!'
                    ]
                ]

            ])) {
               
                return redirect()->to(base_url('/pengaturan/kode/barang'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_barang_id');
                $ubah = [
                    'huruf_kode_barang' => htmlspecialchars($this->request->getPost('huruf_kode_barang'), ENT_QUOTES),
                    'jumlah_angka' => htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                    $this->model_kode_barang->update($id, $ubah);
                    $this->session->setFlashdata('pesan_kode_barang', 'Kode barang berhasil diubah!');
                    return redirect()->to(base_url('/pengaturan/kode/barang'));
        
    }

}
