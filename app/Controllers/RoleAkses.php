<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_user_role;
use App\Models\Model_user_access_menu;

class RoleAkses extends BaseController{

    public function __construct(){
        $this->model_user_menu = new Model_user_menu();
        $this->model_user = new Model_user();
        $this->model_user_access_menu = new Model_user_access_menu();
        $this->model_user_role = new Model_user_role();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index($role_id = null){
		
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
            'title' => ucfirst('Role Akses'),
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
            'idrole' => $this->model_user_role->select('id_role, role')->asArray()
                        ->where('id_role', $role_id)->first(),
            'menurole'  =>$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->where('id_menu !=', 1)->where('menu !=', 'Role')
                        ->findAll(),
            'session' => $this->session,

        ];
        tampilan_admin('admin/admin-roleakses/v_roleakses', 'admin/admin-roleakses/v_js_roleakses', $data);
    }
    
    public function ubah($menu_id = null, $role_id = null){
       
            $this->model_user_access_menu->UbahRole($menu_id, $role_id);
            $this->session->setFlashdata('pesan_akses', 'Role akses berhasil diubah!');
        
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
