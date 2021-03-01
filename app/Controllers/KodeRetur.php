<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_kode_retur;
use App\Models\Model_all;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class KodeRetur extends BaseController
{
	
	public function __construct(){
        $this->model = new Model_all();
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_kode_retur = new Model_kode_retur();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];


    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		

		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        
        $kode = $this->model->GetRowTbKodeRetur();
		$data = [
			'title' =>  ucfirst('Pengaturan Kode Retur'),
            'user' 	=> 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')
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
    

    public function editkoderetur(){
       
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
               
                return redirect()->to(base_url('barang/pengaturankoderetur'))->withInput();

            }

                $id = $this->request->getPost('tb_kode_retur_id');
                $ubah = [
                    'huruf_kode_retur' =>  htmlspecialchars($this->request->getPost('huruf_kode_retur'), ENT_QUOTES),
                    'jumlah_angka' =>  htmlspecialchars($this->request->getPost('jumlah_angka'), ENT_QUOTES)
                ];

                
                $this->model_kode_retur->update($id, $ubah);
                
                $this->session->setFlashdata('pesan_kode_retur', 'Kode retur berhasil diubah!');
                return redirect()->to(base_url('/barang/pengaturankoderetur'));
                
            
        if (!$role){
            return redirect()->to(base_url('/'));
        
        }
        if ($userAccess = $this->model->Tendang() < 1) {
                return redirect()->to(base_url('blokir'));
        }
        
    }

}