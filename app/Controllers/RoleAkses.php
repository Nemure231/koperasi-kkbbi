<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelAksesRole;
use App\Models\ModelRole;

class RoleAkses extends BaseController{

    public function __construct(){

        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelRole = new ModelRole();
        $this->modelAksesRole = new ModelAksesRole();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

    public function index($role_id = null){
		
		$email = $this->session->get('email');
	
        $data = [
            'title' => ucfirst('Role'),
            'nama_menu_utama' => ucfirst('Role'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'idrole' => $this->modelRole->ambilRoleUntukCekCentang(),
            'menurole'=>$this->modelMenu->ambilMenuUntukDaftarRoleAkses(),
            'session' => $this->session,

        ];
        tampilan_admin('admin/admin-roleakses/v_roleakses', 'admin/admin-roleakses/v_js_roleakses', $data);
    }
    
    public function ubah(){
        
        $role_id= $this->request->getPost('roleId');
        $menu_id= $this->request->getPost('menuId');
        $this->modelAksesRole->ubahAksesRole($role_id, $menu_id);
        $this->session->setFlashdata('pesan_akses', 'Role akses berhasil diubah!');
        
	
	}

	


   

}
