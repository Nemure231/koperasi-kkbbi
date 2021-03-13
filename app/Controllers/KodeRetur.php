<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_kode_retur;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Users;

class KodeRetur extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_kode_retur = new Model_kode_retur();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->user = new Users();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];


    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        $kode = $this->model_kode_retur->select('id_tb_kode_retur, huruf_kode_retur, jumlah_angka')->asArray()
                ->first();
		$data = [
			'title' =>  ucfirst('Kode Retur'),
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
            'form_koderetur' => [
                'id' => 'formKoderetur',
                'name'=>'formKoderetur'
            ],
			'hidd_id_kode_retur' => [
				'name' => 'tb_kode_retur_id',
				'id'=> 'tb_kode_retur_id', 
				'value' => ''.$kode['id_tb_kode_retur'].'', 
				'type'=> 'hidden'
            ]   
		];
		tampilan_admin('admin/admin-koderetur/v_koderetur', 'admin/admin-koderetur/v_js_koderetur', $data);
    }
    

    public function ubah(){
       
        if(!$this->validate([
            'huruf_kode_retur' => [
                'label'  => 'Huruf kode retur',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Huruf kode retur harus diisi!'
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
               
                return redirect()->to(base_url('/pengaturan/kode/retur'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_retur_id');
                $ubah = [
                    'huruf_kode_retur' =>  htmlspecialchars($this->request->getPost('huruf_kode_retur'), ENT_QUOTES),
                    'jumlah_angka' =>  htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                $this->model_kode_retur->update($id, $ubah);
                
                $this->session->setFlashdata('pesan_kode_retur', 'Kode retur berhasil diubah!');
                return redirect()->to(base_url('/pengaturan/kode/retur'));
                
            
     
        
    }

}
