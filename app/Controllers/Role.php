<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_role;

class Role extends BaseController{

    public function __construct(){
        $this->model_user_menu = new Model_user_menu();
        $this->model_user = new Model_user();
        $this->model_role = new Model_role();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
		
        
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		


		
        $data = [
            'title' => 'Role',
            'nama_menu_utama' => 'Role',
            'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
            ->where('surel', $email)
            ->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
            'role' => $this->model_role->select('id as id_role, nama as role')->asArray()
                    ->where('id!=', 4)->where('id!=', 5)
                    ->findAll(),
            'session' => $this->session,
            'validation' => $this->validation,
            'attr' => ['id' => 'formRole', 'name'=>'formRole'],
            'form_hapus_role' => ['id' => 'formHapusRole', 'name'=>'formHapusRole', 'class' => 'btn btn-block'],
            'hidden_role_id' => ['name' => 'role_id', 'id'=>'role_id', 'type'=> 'hidden'],
            'hidden_role_id_hapus' => ['name' => 'hidden_role_id_hapus', 'id'=>'hidden_role_id_hapus', 'type'=> 'hidden'],
            'hidden_old_role' => ['name' => 'old_role', 'id'=>'old_role', 'type'=> 'hidden'],
            'nama_role' => [
                'type' => 'text',
                'name' => 'role',
                'id' => 'role',
                'placeholder' => 'Nama role ....',
                'class' => 'form-control role'
            ],
            'roleE' => [
                'type' => 'text',
                'name' => 'roleE',
                'id' => 'roleE',
                'placeholder' => 'Nama role ....',
                'class' => 'form-control role'
            ],
        ];
		
        tampilan_admin('admin/admin-role/v_role', 'admin/admin-role/v_js_role', $data);
    }
    
    public function tambah(){
        if(!$this->validate([
            'role' => [
                'label'  => 'Nama Role',
                'rules'  => 'required|is_unique[role.nama]',
                'errors' => [
                'required' => 'Nama role harus diisi!',
                'is_unique' => 'Nama role sudah ada!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/pengaturan/role'))->withInput();

        }

            $data = array(
                'nama' => htmlspecialchars($this->request->getPost('role'), ENT_QUOTES)
            );

            $this->model_role->insert($data);
        
            $this->session->setFlashdata('pesan_role', 'Role baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/role'));
            
    }

    public function ubah(){
       
        $old =  $this->request->getPost('old_role');
        $new =  $this->request->getPost('roleE');

        $rules = 'required';

        if($old != $new){
            $rules =  'required|is_unique[role.nama]';
        }

            if(!$this->validate([
                'roleE' => [
                    'label'  => 'Nama Role',
                    'rules'  => $rules,
                    'errors' => [
                    'required' => 'Nama role harus diisi!',
                    'is_unique' => 'Nama role sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/pengaturan/role'))->withInput();

            }
                $id_role = $this->request->getPost('role_id');
                $data = array(
                    'nama' => htmlspecialchars($this->request->getPost('roleE'), ENT_QUOTES)
                );

                $this->model_role->update($id_role, $data);
                $this->session->setFlashdata('pesan_edit_role', 'Role baru berhasil diedit!');
                return redirect()->to(base_url('/pengaturan/role'));
                  
    }

  

    public function hapus(){
        $id_role =  $this->request->getPost('hidden_role_id_hapus');
            $this->model_role->delete($id_role);
            $this->session->setFlashdata('pesan_hapus_role', 'Role berhasil dihapus!');
            return redirect()->to(base_url('/pengaturan/role'));
        
        
    
    }


	
   

}
