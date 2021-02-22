<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;

class Role extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
		//$session = \Config\Services::session();
		
        
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }

		
        $data = [
           
           'title' => ucfirst('Role'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'role' => $this->model->GetAllRole(),
           'session' => $this->session,
           'validation' => $this->validation,
           'attr' => ['id' => 'formRole', 'name'=>'formRole'],
           'hidden_role_id' => ['name' => 'role_id', 'id'=>'role_id', 'type'=> 'hidden'],
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
    
    public function tambahrole(){
        if(!$this->validate([
            'role' => [
                'label'  => 'Nama Role',
                'rules'  => 'required|is_unique[user_role.role]',
                'errors' => [
                'required' => 'Nama role harus diisi!',
                'is_unique' => 'Nama role sudah ada!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/role'))->withInput();

        }

            $data = array(
                'role' => htmlspecialchars($this->request->getPost('role'), ENT_QUOTES)
            );

            $this->model->TambahRole($data);
        
            $this->session->setFlashdata('pesan_role', 'Role baru berhasil ditambahkan!');
            return redirect()->to(base_url('/role'));
            
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
    }

    public function editrole(){
       
        $old =  $this->request->getPost('old_role');
        $new =  $this->request->getPost('roleE');

        $rules = 'required';

        if($old != $new){
            $rules =  'required|is_unique[user_role.role]';
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
                
                return redirect()->to(base_url('/role'))->withInput();

            }
                $id_role = $this->request->getPost('role_id');
                $data = array(
                    'role' => htmlspecialchars($this->request->getPost('roleE'), ENT_QUOTES)
                );

                $this->model->EditRole($data, $id_role);
                $this->session->setFlashdata('pesan_edit_role', 'Role baru berhasil diedit!');
                return redirect()->to(base_url('/role'));
                
                $role = $this->session->get('role_id');

                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                $userAccess = $this->model->Tendang();
                if ($userAccess < 1) {
                    return redirect()->to(base_url('blokir'));
                }    
    }

    public function kecohhapusrole(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusrole($id_role){
        
            $this->model->HapusRole($id_role);
            $this->session->setFlashdata('pesan_hapus_role', 'Role berhasil dihapus!');
            return redirect()->to(base_url('/role'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }


	// public function ambilidr(){
		
		
    //     $id = $this->request->getPost('id');
    //     $data = $this->model->GetIdRole($id);
    //     $arr = array('success' => false, 'data' => '');
    //     if($data){
    //         $arr = array('success' => true, 'data' => $data);
    //     }
    //         echo json_encode($arr);

        
	// 	$role = $this->session->get('role_id');
		
	// 	if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
	// 		$userAccess = $this->model->Tendang();
    //         if ($userAccess < 1) {
    //             return redirect()->to(base_url('blokir'));
    //         }
    // }

    // public function tambahneditrole(){
		
		
    //     $data = array(
    //     'role' => htmlspecialchars($this->request->getPost('role'), ENT_QUOTES),
    //     );
    //     $status = false;
    //     $id = $this->request->getPost('role_id');
    //     if($id){
    //         $update = $this->model->EditRole($data);
    //         $status = true;
    //     }
    //     if(!$id){
    //         $id = $this->model->TambahRole($data);
    //         $status = true;
    //         $this->session->setFlashdata('pesan', 'Role baru berhasil ditambahkan!');
    //     }
    //     $data = $this->model->GetIdRole($id);
    //     echo json_encode(array("status" => $status , 'data' => $data));


	// 	$role = $this->session->get('role_id');
		
	// 	if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
	// 		$userAccess = $this->model->Tendang();
    //         if ($userAccess < 1) {
    //             return redirect()->to(base_url('blokir'));
    //         }
    // }

    // public function hapusrole($id = null){
		
    //     $this->model->HapusRole($id);
    //     echo json_encode(array("status" => TRUE));


	// 	$role = $this->session->get('role_id');
		
	// 	if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
	// 		$userAccess = $this->model->Tendang();
    //         if ($userAccess < 1) {
    //             return redirect()->to(base_url('blokir'));
    //         }
    // }

    // public function unikrole($uniq = null){
		
    //     $get= $this->model->UnikRole($uniq);

    //     if($get == 0){
    //         echo 'true';
    //     }else{
    //         echo 'false';
    //     }
    // }

    public function roleakses($role_id = null){
        //$session = \Config\Services::session();
        //$view = \Config\Services::renderer();
		
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
	
        $data = [
            'title' => ucfirst('Role Akses'),
            'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'idrole' => $this->model->GetIdRole2($role_id),
            'menurole' => $this->model->GetAllMenuNRole(),
            'session' => $this->session,

        ];
        tampilan_admin('admin/admin-roleakses/v_roleakses', 'admin/admin-roleakses/v_js_roleakses', $data);
    }
    
    public function ubahakses($menu_id = null, $role_id = null){
       
            $this->model->UbahRole($menu_id, $role_id);
            $this->session->setFlashdata('pesan_akses', 'Role akses berhasil diubah!');
        
		$role = $this->session->get('role_id');
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
	}
   

}
