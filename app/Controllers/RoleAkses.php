<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_role;
use App\Models\Model_user_access_menu;

class RoleAkses extends BaseController{

    public function __construct(){
        $this->model_user_menu = new Model_user_menu();
        $this->model_user = new Model_user();
        $this->model_user_access_menu = new Model_user_access_menu();
        $this->model_role = new Model_role();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index($role_id = null){
		
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
            'idrole' => $this->model_role->select('id as id_role, nama as role')->asArray()
                        ->where('id', $role_id)->first(),
            'menurole'  =>$this->model_user_menu->select('id_menu, menu')->asArray()
                        //->where('id_menu !=', 1)->where('menu !=', 'Role')
                        ->findAll(),
            'session' => $this->session,

        ];
        tampilan_admin('admin/admin-roleakses/v_roleakses', 'admin/admin-roleakses/v_js_roleakses', $data);
    }
    
    public function ubah($menu_id = null, $role_id = null){
       
            $this->model_user_access_menu->UbahRole($menu_id, $role_id);
            $this->session->setFlashdata('pesan_akses', 'Role akses berhasil diubah!');
        
	
	}

	


   

}
