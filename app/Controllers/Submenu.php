<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_user_menu;
use App\Models\Model_user_sub_menu;
use App\Models\Model_user;
class Submenu extends BaseController{

    public function __construct(){
        $this->db = \Config\Database::connect();
		$this->model = new Model_all();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
        $this->model_user_sub_menu = new Model_user_sub_menu();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	 ///////////////////////////////SUBMENU//////////////////////////////

     public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
        if(!$role){
            return redirect()->to(base_url('/'));
        }
        
        $userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }

        $data = [

            
            'title' => ucfirst('Manajemen Submenu'),
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
            'submenu'=>$this->model_user_sub_menu->select('id_menu, menu_id,menu, judul, url, icon, is_active, id_submenu')
                    ->asArray()->join('user_menu', 'user_menu.id_menu = user_sub_menu.menu_id')
                    ->findAll(),
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
                    $this->model_user_menu->set('menu', $mei)->insert();
                    $me = $this->db->insertID();
            
                }

            $data = array(
                'menu_id' => htmlspecialchars($me, ENT_QUOTES),
                'judul' => htmlspecialchars($this->request->getPost('judul'), ENT_QUOTES),
                'url' => htmlspecialchars($this->request->getPost('url'), ENT_QUOTES),
                'icon' => htmlspecialchars($this->request->getPost('icon'), ENT_QUOTES),
                'is_active' => $isaktif 
            );

            $this->model_user_sub_menu->insert($data);
        
            $this->session->setFlashdata('pesan_submenu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/menu/submenu'));
            
            $role = $this->session->get('role_id');
            if (!$role){
                return redirect()->to(base_url('/'));
            }
            $userAccess = $this->model_user_menu->Tendang();
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
                    $this->model_user_menu->set('menu', $mei)->insert();
                    $me = $this->db->insertID();
            
                }

                $data = array(
                    'menu_id' => htmlspecialchars($me, ENT_QUOTES),
                    'judul' => htmlspecialchars($this->request->getPost('judulE'), ENT_QUOTES),
                    'url' => htmlspecialchars($this->request->getPost('urlE'), ENT_QUOTES),
                    'icon' => htmlspecialchars($this->request->getPost('iconE'), ENT_QUOTES),
                    'is_active' => $isaktif 
                );

                $this->model_user_sub_menu->update($id, $data);
                $this->session->setFlashdata('pesan_edit_submenu', 'Submenu baru berhasil diedit!');
                return redirect()->to(base_url('/menu/submenu'));
                
                $role = $this->session->get('role_id');

                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                $userAccess = $this->model_user_menu->Tendang();
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

            $this->model_user_sub_menu->delete($id_submenu);
            $this->session->setFlashdata('pesan_hapus_submenu', 'Submenu berhasil dihapus!');
            return redirect()->to(base_url('/menu/submenu'));
        
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
