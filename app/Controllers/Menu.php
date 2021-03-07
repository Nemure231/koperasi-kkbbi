<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
class Menu extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

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
        
            'title' => ucfirst('Manajemen Menu'),
            'user' 	=>  $this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
                    ->join('user_role', 'user_role.id_role = user.role_id')
                    ->where('email', $email)
                    ->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
           'mmenu' => $this->model_user_menu->select('id_menu, menu')->asArray()->findAll(),
           'validation' => $this->validation,
           'session' => $this->session,
           'attr' => ['id' => 'formMenu', 'name'=>'formMenu'],
           'form_edit_menu' => ['id' => 'formEditMenu', 'name'=>'formEditMenu'],
           'form_hapus_menu' => ['id' => 'formHapusMenu', 'name'=>'formHapusMenu', 'class' => 'btn btn-block'],
           'hidden_menu_id' => ['name' => 'hidden_menu_id', 'id'=>'hidden_menu_id', 'type'=> 'hidden'],
           'hidden_hapus_menu_id' => ['name' => 'hidden_hapus_menu_id', 'id'=>'hidden_hapus_menu_id', 'type'=> 'hidden'],
           'hidden_old_menu' => ['name' => 'old_menu', 'id'=>'old_menu', 'type'=> 'hidden'],
           'menunu' => [
                'type' => 'text',
                'name' => 'menu',
                'id' => 'menu',
                'placeholder' => 'Nama menu ....',
                'class' => 'form-control menu'
           ],
           'menuE' => [
            'type' => 'text',
            'name' => 'menuE',
            'id' => 'menuE',
            'placeholder' => 'Nama menu ....',
            'class' => 'form-control menu'
        ]

        ];
        //dd(time());
        tampilan_admin('admin/admin-menu/v_menu', 'admin/admin-menu/v_js_menu', $data);
    }
    

    public function tambah(){
        if(!$this->validate([
            'menu' => [
                'label'  => 'Nama Menu',
                'rules'  => 'required|is_unique[user_menu.menu]',
                'errors' => [
                'required' => 'Nama menu harus diisi!',
                'is_unique' => 'Nama menu sudah ada!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/pengaturan/menu'))->withInput();

        }

            $data = array(
                'menu' => htmlspecialchars($this->request->getPost('menu'), ENT_QUOTES)
            );

            $this->model_user_menu->insert($data);
        
            $this->session->setFlashdata('pesan_menu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu'));
            
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
       
        $old =  $this->request->getPost('old_menu');
        $new =  $this->request->getPost('menuE');

        $rules = 'required';

        if($old != $new){
            $rules =  'required|is_unique[user_menu.menu]';
        }

            if(!$this->validate([
                'menuE' => [
                    'label'  => 'Nama Menu',
                    'rules'  => $rules,
                    'errors' => [
                    'required' => 'Nama menu harus diisi!',
                    'is_unique' => 'Nama menu sudah ada!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/menu'))->withInput();

            }
                $id = $this->request->getPost('hidden_menu_id');
                $data = array(
                    'menu' => htmlspecialchars($this->request->getPost('menuE'), ENT_QUOTES)
                );

                $this->model_user_menu->update($id, $data);
                $this->session->setFlashdata('pesan_edit_menu', 'Menu baru berhasil diedit!');
                return redirect()->to(base_url('/pengaturan/menu'));
                
                $role = $this->session->get('role_id');

                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                $userAccess = $this->model_user_menu->Tendang();
                if ($userAccess < 1) {
                    return redirect()->to(base_url('blokir'));
                }    
    }

    public function hapus(){

        $id_menu = $this->request->getPost('hidden_hapus_menu_id');
        $this->model_user_menu->delete($id_menu);
        $this->session->setFlashdata('pesan_hapus_menu', 'Menu berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/menu'));
        
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
?>
