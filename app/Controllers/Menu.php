<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_user_menu;
class Menu extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
        $this->model_menu = new Model_user_menu();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
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
           
           'title' => ucfirst('Manajemen Menu'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'mmenu' => $this->model->GetAllMenu(),
           'validation' => $this->validation,
           'session' => $this->session,
           'attr' => ['id' => 'formMenu', 'name'=>'formMenu'],
           'form_edit_menu' => ['id' => 'formEditMenu', 'name'=>'formEditMenu'],
           'hidden_menu_id' => ['name' => 'hidden_menu_id', 'id'=>'hidden_menu_id', 'type'=> 'hidden'],
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
    

    public function tambahmenu(){
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
            
            return redirect()->to(base_url('/menu'))->withInput();

        }

            $data = array(
                'menu' => htmlspecialchars($this->request->getPost('menu'), ENT_QUOTES)
            );

            $this->model->TambahMenu($data);
        
            $this->session->setFlashdata('pesan_menu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/menu'));
            
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
    }

    public function editmenu(){
       
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

                $this->model->EditMenu($data, $id);
                $this->session->setFlashdata('pesan_edit_menu', 'Menu baru berhasil diedit!');
                return redirect()->to(base_url('/menu'));
                
                $role = $this->session->get('role_id');

                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                $userAccess = $this->model->Tendang();
                if ($userAccess < 1) {
                    return redirect()->to(base_url('blokir'));
                }    
    }

    public function kecohhapusmenu(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusmenu($id_menu){

        
            $this->model->HapusMenu($id_menu);
            $this->session->setFlashdata('pesan_hapus_menu', 'Menu berhasil dihapus!');
            return redirect()->to(base_url('/menu'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }

    ///////////////////////////////SUBMENU//////////////////////////////

    public function submenu(){
		$role = $this->session->get('role_id');
        if(!$role){
            return redirect()->to(base_url('/'));
        }
        
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }

        $data = [

            
            'title' => ucfirst('Manajemen Submenu'),
            'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'mmenu' => $this->model->GetAllMenu(),
            'submenu' => $this->model->GetAllSubMenu(),
            // 'hitung' => $this->model->HitungSubMenu(),
            'session' => $this->session,
            'validation' => $this->validation,
            'attr' => ['id' => 'formSubMenu', 'name'=>'formSubMenu'],
            'hidden_submenu_id' => ['name' => 'submenu_id', 'id'=>'submenu_id', 'type'=> 'hidden'],
            'hidden_judul_old' => ['name' => 'judul_old', 'id'=>'judul_old', 'type'=> 'hidden'],
            'hidden_url_old' => ['name' => 'url_old', 'id'=>'url_old', 'type'=> 'hidden'],
            'cecc' =>[
                'name' => 'is_active',
                'id'=>'is_active',
                'type'=> 'checkbox',
                'value'=> '1',
                'class'=> 'form-check-input',
                'checked' => ''
            ],
            'judul' => [
                'type' => 'text',
                'name' => 'judul',
                'id' => 'judul',
                'class' => 'form-control judul'
            ],
            'url' => [
                'type' => 'text',
                'name' => 'url',
                'id' => 'url',
                'class' => 'form-control url'
            ],
            'icon' => [
                'type' => 'text',
                'name' => 'icon',
                'id' => 'icon',
                'class' => 'form-control'
            ],
            'ceccE' =>[
                'name' => 'is_activeE',
                'id'=>'is_activeE',
                'type'=> 'checkbox',
                'value'=> '1',
                'class'=> 'form-check-input'
            ],
            'judulE' => [
                'type' => 'text',
                'name' => 'judulE',
                'id' => 'judulE',
                'class' => 'form-control'
            ],
            'urlE' => [
                'type' => 'text',
                'name' => 'urlE',
                'id' => 'urlE',
                'class' => 'form-control url'
            ],
            'iconE' => [
                'type' => 'text',
                'name' => 'iconE',
                'id' => 'iconE',
                'class' => 'form-control'
            ]
        ];
        
        tampilan_admin('admin/admin-submenu/v_submenu', 'admin/admin-submenu/v_js_submenu', $data);
    }
    

    public function tambahsubmenu(){
        if(!$this->validate([
            'judul' => [
                'label'  => 'Nama Submenu',
                'rules'  => 'required|is_unique[user_sub_menu.judul]',
                'errors' => [
                'required' => 'Nama submenu harus diisi!',
                'is_unique' => 'Nama submenu sudah ada!'
                ]
            ],
            'url' => [
                    'label'  => 'Url',
                    'rules'  => 'required|is_unique[user_sub_menu.url]',
                    'errors' => [
                    'required' => 'Url harus diisi!',
                    'is_unique' => 'Url sudah ada!'
                    ]
            ],
            'icon' => [
                'label'  => 'Icon',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Icon harus diisi!'
                ]
            ],
            'menu_id' => [
                'label'  => 'Menu',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Menu harus dipilih!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/menu/submenu'))->withInput();

        }
            $isaktif = $this->request->getPost('is_active');

            if(!$isaktif){
                $isaktif = 2;
            }

            $mei = $this->request->getPost('menu_id');

                if (is_numeric($mei)){
                    $me = $mei;
                }else{
                    $me = $this->model->TambahMenu1($mei);   
                }

            $data = array(
                'menu_id' => htmlspecialchars($me, ENT_QUOTES),
                'judul' => htmlspecialchars($this->request->getPost('judul'), ENT_QUOTES),
                'url' => htmlspecialchars($this->request->getPost('url'), ENT_QUOTES),
                'icon' => htmlspecialchars($this->request->getPost('icon'), ENT_QUOTES),
                'is_active' => $isaktif 
            );

            $this->model->TambahSubMenu($data);
        
            $this->session->setFlashdata('pesan_submenu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/menu/submenu'));
            
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
    }

    public function editsubmenu(){
       
        $old_judul =  $this->request->getPost('judul_old');
        $new_judul =  $this->request->getPost('judulE');

        $old_url =  $this->request->getPost('url_old');
        $new_url =  $this->request->getPost('urlE');

        $rules_judul = 'required';
        $rules_url = 'required';

        if($old_judul != $new_judul){
            $rules_judul =  'required|is_unique[user_sub_menu.judul]';
        }

        if($old_url != $new_url){
            $rules_url =  'required|is_unique[user_sub_menu.url]';
        }

            if(!$this->validate([
                'judulE' => [
                    'label'  => 'Nama Submenu',
                    'rules'  => $rules_judul,
                    'errors' => [
                    'required' => 'Nama submenu harus diisi!',
                    'is_unique' => 'Nama submenu sudah ada!'
                    ]
                ],
                'urlE' => [
                        'label'  => 'Url',
                        'rules'  => $rules_url,
                        'errors' => [
                        'required' => 'Url harus diisi!',
                        'is_unique' => 'Url sudah ada!'
                        ]
                ],
                'iconE' => [
                    'label'  => 'Icon',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Icon harus diisi!'
                    ]
                ],
                'menu_idE' => [
                    'label'  => 'Menu',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Menu harus dipilih!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/menu/submenu'))->withInput();
            }

                $isaktif = $this->request->getPost('is_activeE');

                if(!$isaktif){
                    $isaktif = 2;
                }else{
                    $isaktif = 1;
                }

                $id = $this->request->getPost('submenu_id');


                $mei = $this->request->getPost('menu_idE');

                if (is_numeric($mei)){
                    $me = $mei;
                }else{
                    $me = $this->model->TambahMenu1($mei);   
                }

                $data = array(
                    'menu_id' => htmlspecialchars($me, ENT_QUOTES),
                    'judul' => htmlspecialchars($this->request->getPost('judulE'), ENT_QUOTES),
                    'url' => htmlspecialchars($this->request->getPost('urlE'), ENT_QUOTES),
                    'icon' => htmlspecialchars($this->request->getPost('iconE'), ENT_QUOTES),
                    'is_active' => $isaktif 
                );

                $this->model->EditSubMenu($data, $id);
                $this->session->setFlashdata('pesan_edit_submenu', 'Submenu baru berhasil diedit!');
                return redirect()->to(base_url('/menu/submenu'));
                
                $role = $this->session->get('role_id');

                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                $userAccess = $this->model->Tendang();
                if ($userAccess < 1) {
                    return redirect()->to(base_url('blokir'));
                }
                
    }

    public function kecohhapussubmenu(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapussubmenu($id_submenu){

            $this->model->HapusSubMenu($id_submenu);
            $this->session->setFlashdata('pesan_hapus_submenu', 'Submenu berhasil dihapus!');
            return redirect()->to(base_url('/menu/submenu'));
        
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
?>
