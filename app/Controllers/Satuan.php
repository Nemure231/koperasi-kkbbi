<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_satuan;
use App\Models\Model_user_menu;
use App\Models\Model_user;

class Satuan extends BaseController
{
	
	public function __construct(){
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_satuan = new Model_satuan();
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
			$userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $data = [
            'title' => ucfirst('Daftar Satuan'),
            'nama_menu_utama' => ucfirst('Barang'),
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
            'satuan' => $this->model_satuan->select('id_satuan, nama_satuan')
						->findAll(),
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

        if(!$this->validate([
                'nama_satuan' => [
                    'label'  => 'Nama Satuan',
                    'rules'  => 'required|is_unique[satuan.nama_satuan]',
                    'errors' => [
                    'required' => 'Nama satuan harus diisi!',
                    'is_unique' => 'Nama satuan sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/suplai/satuan'))->withInput();

            }

                $data = array(
                    'nama_satuan' => htmlspecialchars($this->request->getPost('nama_satuan'), ENT_QUOTES)
                );

                $this->model_satuan->insert($data);
            
                $this->session->setFlashdata('pesan_satuan', 'Satuan baru berhasil ditambahkan!');
                return redirect()->to(base_url('/suplai/satuan'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function ubah(){

        $new = $this->request->getPost('edit_nama_satuan');
        $old = $this->request->getPost('old_nama_satuan');

        $nama = 'required';

        if($old != $new){
            $nama =  'required|is_unique[satuan.nama_satuan]';
        }
            if(!$this->validate([
                'edit_nama_satuan' => [
                    'label'  => 'Nama Satuan',
                    'rules'  => $nama,
                    'errors' => [
                    'required' => 'Nama satuan harus diisi!',
                    'is_unique' => 'Nama satuan sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/suplai/satuan'))->withInput();

            }

                $id = $this->request->getPost('id_satuanE');
                $data = array(
                    'nama_satuan' => htmlspecialchars($this->request->getPost('edit_nama_satuan'), ENT_QUOTES)
                );

                $this->model_satuan->update($id, $data);
            
                $this->session->setFlashdata('pesan_satuan', 'Satuan baru berhasil diedit!');
                return redirect()->to(base_url('/suplai/satuan'));
                
                $role = $this->session->get('role_id');    
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }



    // public function kecohhapusatuan(){
    //     $role = $this->session->get('role_id');

    //     if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
    //     if ($role > 0) {
    //             return redirect()->to(base_url('blokir'));
    //     }
    // }
    public function hapus(){
            $id_satuan = $this->request->getPost('id_satuanH');
            $this->model_satuan->delete($id_satuan);
            $this->session->setFlashdata('pesan_hapus_satuan', 'Satuan berhasil dihapus!');
            return redirect()->to(base_url('/suplai/satuan'));

        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }

}
