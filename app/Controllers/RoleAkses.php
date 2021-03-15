<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_user_role;
use App\Models\Model_user_access_menu;
use App\Models\ModelUser;
use App\Models\ModelMenu;

class RoleAkses extends BaseController{

    public function __construct(){
        $this->model_user_menu = new Model_user_menu();
        $this->model_user = new Model_user();
        $this->model_user_access_menu = new Model_user_access_menu();
        $this->model_user_role = new Model_user_role();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

    public function index($role_id = null){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
		
	
        $data = [
            'title' => ucfirst('Role'),
            'nama_menu_utama' => ucfirst('Role'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
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
        
	
	}

	


   

}
