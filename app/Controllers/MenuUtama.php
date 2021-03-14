<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_menu_utama;
use App\Models\Users;
class MenuUtama extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_menu_utama = new Model_menu_utama();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->user = new Users();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        $data = [
            'title' => ucfirst('Menu Utama'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->user->ambilSatuUserBuatProfil()['users'],
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
           'menu_utama' => $this->model_menu_utama->select('id_menu_utama, nama_menu_utama, ikon_menu_utama')->asArray()->findAll(),
           'validation' => $this->validation,
           'session' => $this->session,
           'form_tambah' => ['id' => 'formMenuUtama'],
           'form_edit' => ['id' => 'formEditMenuUtama'],
           'form_hapus' => ['class' => 'btn btn-block'],
           'hidden_menu_utama_id' => ['name' => 'hidden_menu_utama_id', 'id'=>'hidden_menu_utama_id', 'type'=> 'hidden'],
           'hidden_hapus_menu_utama_id' => ['name' => 'hidden_hapus_menu_utama_id', 'id'=>'hidden_hapus_menu_utama_id', 'type'=> 'hidden'],
           'hidden_old_menu_utama' => ['name' => 'old_nama_menu_utama', 'id'=>'old_nama_menu_utama', 'type'=> 'hidden'],
           'nama_menu_utama' => [
                'type' => 'text',
                'name' => 'nama_menu_utama',
                'id' => 'nama_menu_utama',
                'placeholder' => 'Nama menu utama ....',
                'class' => 'form-control'
            ],
            'ikon_menu_utama' => [
                'type' => 'text',
                'name' => 'ikon_menu_utama',
                'id' => 'ikon_menu_utama',
                'placeholder' => 'Ikon menu utama ....',
                'class' => 'form-control'
            ],
            'nama_menu_utamaE' => [
                'type' => 'text',
                'name' => 'nama_menu_utamaE',
                'id' => 'nama_menu_utamaE',
                'placeholder' => 'Nama menu utama ....',
                'class' => 'form-control menu'
            ],
            'ikon_menu_utamaE' => [
                'type' => 'text',
                'name' => 'ikon_menu_utamaE',
                'id' => 'ikon_menu_utamaE',
                'placeholder' => 'Ikon menu utama ....',
                'class' => 'form-control'
         ],

        ];
        tampilan_admin('admin/admin-menu-utama/v_menu_utama', 'admin/admin-menu-utama/v_js_menu_utama', $data);
    }
    

    public function tambah(){
        if(!$this->validate([
            'nama_menu_utama' => [
                'label'  => 'Nama Menu Utama',
                'rules'  => 'required|is_unique[menu_utama.nama_menu_utama]',
                'errors' => [
                'required' => 'Nama menu utama harus diisi!',
                'is_unique' => 'Nama menu utama sudah ada!'
                ]
            ],
            'ikon_menu_utama' => [
                'label'  => 'Ikon Menu Utama',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Ikon menu utama harus diisi!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/pengaturan/menu_utama'))->withInput();

        }

            $data = array(
                'nama_menu_utama' => htmlspecialchars($this->request->getPost('nama_menu_utama'), ENT_QUOTES),
                'ikon_menu_utama' => htmlspecialchars($this->request->getPost('ikon_menu_utama'), ENT_QUOTES)
            );

            $this->model_menu_utama->insert($data);
        
            $this->session->setFlashdata('pesan_menu_utama', 'Menu utama baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu_utama'));
    }

    public function ubah(){
       
        $old =  $this->request->getPost('old_nama_menu_utama');
        $new =  $this->request->getPost('nama_menu_utamaE');

        $rules = 'required';

        if($old != $new){
            $rules =  'required|is_unique[menu_utama.nama_menu_utama]';
        }

        if(!$this->validate([
            'nama_menu_utamaE' => [
                'label'  => 'Nama Menu Utama',
                'rules'  => $rules,
                'errors' => [
                'required' => 'Nama menu utama harus diisi!',
                'is_unique' => 'Nama menu utama sudah ada!'
                ]
            ],
            'ikon_menu_utamaE' => [
                'label'  => 'Ikon Menu Utama',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Ikon menu utama harus diisi!'
                ]
            ]
                
            ])) {
                
                return redirect()->to(base_url('/pengaturan/menu_utama'))->withInput();

            }
                $id = $this->request->getPost('hidden_menu_utama_id');
                $data = array(
                    'nama_menu_utama' => htmlspecialchars($this->request->getPost('nama_menu_utamaE'), ENT_QUOTES),
                    'ikon_menu_utama' => htmlspecialchars($this->request->getPost('ikon_menu_utamaE'), ENT_QUOTES)
                );

                $this->model_menu_utama->update($id, $data);
                $this->session->setFlashdata('pesan_edit_menu_utama', 'Menu utama baru berhasil diedit!');
                return redirect()->to(base_url('/pengaturan/menu_utama'));
                
      
    }

    public function hapus(){

        $id = $this->request->getPost('hidden_hapus_menu_utama_id');
        $this->model_menu_utama->delete($id);
        $this->session->setFlashdata('pesan_hapus_menu_utama', 'Menu utama berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/menu_utama'));
        
    
    }

   

	
}
?>
