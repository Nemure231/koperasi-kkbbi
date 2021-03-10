<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_kode_transaksi;
use App\Models\Model_all;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class KodeTransaksi extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_kode_transaksi = new Model_kode_transaksi();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];

    ////////////////////////////////////////////KODE BARANG//////////////////////////
    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		

		// if (!$role){
        //     return redirect()->to(base_url('/'));
        // }
		// $userAccess = $this->model_user_menu->Tendang();
        // if ($userAccess < 1) {
        //     return redirect()->to(base_url('blokir'));
        // }
        
        $kode = $this->model_kode_transaksi->select('id_tb_kode_transaksi, huruf_kode_transaksi, jumlah_angka')
                ->asArray()
                ->first();


		$data = [
			'title' => ucfirst('Kode Transaksi'),
            'nama_menu_utama' => ucfirst('Kode'),
            'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
						->join('user_role', 'user_role.id_role = user.role_id')
						->where('email', $email)
						->first(),
			'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
						->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
						->where('user_access_menu.role_id =', $role)
						->orderBy('user_access_menu.menu_id', 'ASC')
						->orderBy('user_access_menu.role_id', 'ASC')
						->findAll(),
            'kode' => $kode,
            'session' => $this->session,
            'validation' => $this->validation,
            'form_kodetransaksi' => [
                'id' => 'formKodetransaksi',
                'name'=>'formKodetransaksi'
            ],
			'hidd_id_kode_transaksi' => [
				'name' => 'tb_kode_transaksi_id',
				'id'=> 'tb_kode_transaksi_id', 
				'value' => ''.$kode['id_tb_kode_transaksi'].'', 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-kodetransaksi/v_kodetransaksi', 'admin/admin-kodetransaksi/v_js_kodetransaksi', $data);
    }
    

    public function ubah(){

            if(!$this->validate([
                'huruf_kode_transaksi' => [
                    'label'  => 'Huruf kode transaksi',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Huruf kode transaksi harus diisi!'
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
               
                return redirect()->to(base_url('/pengaturan/kode/transaksi'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_transaksi_id');
                $ubah = [
                    'huruf_kode_transaksi' => htmlspecialchars($this->request->getPost('huruf_kode_transaksi'), ENT_QUOTES),
                    'jumlah_angka' => htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                $this->model_kode_transaksi->update($id, $ubah);            
                $this->session->setFlashdata('pesan_kode_transaksi', 'Kode transaksi berhasil diubah!');
                return redirect()->to(base_url('/pengaturan/kode/transaksi'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
        }
        
    }

}
