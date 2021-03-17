<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user_sub_menu;
use App\Models\Model_menu_utama;
use App\Models\Model_user;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelSubmenu;
use App\Models\ModelMenuUtama;

class Submenu extends BaseController{

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->model_user = new Model_user();
        $this->model_menu_utama = new Model_menu_utama();
        $this->model_user_menu = new Model_user_menu();
        $this->model_user_sub_menu = new Model_user_sub_menu();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelSubmenu = new ModelSubmenu();
        $this->modelMenuUtama= new ModelMenuUtama();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];


    public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');

        $data = [
            
            'title' => ucfirst('Submenu'),
            'nama_menu_utama' => ucfirst('Menu'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'mmenu' => $this->modelMenu->ambilMenu(),
            'menu_utama' => $this->model_menu_utama->select('id_menu_utama, nama_menu_utama, ikon_menu_utama')->asArray()->findAll(),
            'submenu'=> $this->modelSubmenu->ambilSubmenu(),
            'session' => $this->session,
            'validation' => $this->validation,
            'attr' => ['id' => 'formSubMenu', 'name'=>'formSubMenu'],
            'form_hapus_submenu' => ['id' => 'formHapusSubmenu', 'name'=>'formHapusSubmenu', 'class' => 'btn btn-block'],
            'hidden_submenu_id' => ['name' => 'submenu_id', 'id'=>'submenu_id', 'type'=> 'hidden'],
            'hidden_hapus_id_submenu' => ['name' => 'hidden_hapus_id_submenu', 'id'=>'hidden_hapus_id_submenu', 'type'=> 'hidden'],
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
    

    public function tambah(){
        // if(!$this->validate([
        //     'judul' => [
        //         'label'  => 'Nama Submenu',
        //         'rules'  => 'required',
        //         'errors' => [
        //         'required' => 'Nama submenu harus diisi!'
        //         ]
        //     ],
        //     'url' => [
        //             'label'  => 'Url',
        //             'rules'  => 'required',
        //             'errors' => [
        //             'required' => 'Url harus diisi!',
        //             ]
        //     ],
        //     'icon' => [
        //         'label'  => 'Icon',
        //         'rules'  => 'required',
        //         'errors' => [
        //         'required' => 'Icon harus diisi!'
        //         ]
        //     ],
        //     'menu_id' => [
        //         'label'  => 'Menu',
        //         'rules'  => 'required',
        //         'errors' => [
        //         'required' => 'Menu harus dipilih!'
        //         ]
        //     ],
        //     'menu_utama_id' => [
        //         'label'  => 'Menu Utama',
        //         'rules'  => 'required',
        //         'errors' => [
        //         'required' => 'Menu Utama harus dipilih!'
        //         ]
        //     ]
            
        // ])) {
            
        //     return redirect()->to(base_url('/pengaturan/submenu'))->withInput();
        // }
            // $ikon = htmlspecialchars($this->request->getPost('icon'), ENT_QUOTES);

            // $mei = $this->request->getPost('menu_id');
            // $menu_utama = $this->request->getPost('menu_utama_id');

            // if (is_numeric($mei)){
            //     $menu_id = $mei;
            // }else{
            //     $menu_id = $this->modelMenu->tambahMenuDariSubmenu($mei);
            //     $this->session->setFlashdata('pesan_validasi_submenu',  '<div class="errors">'.$menu_id['nama_menu'][0].'</div>');
            //     return redirect()->to(base_url('/pengaturan/submenu'));
                
            // }
            // if (is_numeric($menu_utama)){
            //     $menu_utama_id = $menu_utama;
            // }else{

            //     $menu_utama_id = $this->modelMenuUtama->tambahMenuUtamaDariSubmenu($menu_utama, $menu_id, $ikon);
            //     $this->session->setFlashdata('pesan_validasi_submenu',  '<div class="errors">'.$menu_utama_id['nama_menu_utama'][0].'</div>');
            //     return redirect()->to(base_url('/pengaturan/submenu'));
            // }

            $validasi = $this->modelSubmenu->tambahSubmenu();

            if($validasi){
                // dd($validasi);
                // if($validasi == ''){
                //     $nama = '';
                // }else{
                //     $nama = $validasi['nama_submenu'][0];
                // }

                // if($validasi == ''){
                //     $menu = '';
                // }else{
                //     $menu = $validasi['menu_id'][0];
                // }

                // if($validasi == ''){
                //     $menu_utama = '';
                // }else{
                //     $menu_utama = $validasi['menu_utama_id'][0];
                // }

                // if($validasi == ''){
                //     $url = '';
                // }else{
                //     $url = $validasi['url_submenu'][0];
                // }

                // if($validasi == ''){
                //     $ikon = '';
                // }else{
                //     $ikon = $validasi['ikon_submenu'][0];
                // }

                // if (is_array($validasi) || is_object($validasi))
                // {
                //     foreach ($validasi as $row){  //Go through every row in the result

                //         echo('<div class="errors text-danger">');
                //         $nama = $row['nama_submenu'];
                //         $menu_id = $row['menu_id'];
                //         $menu_utama_id = $row['menu_utama_id'];
                //         $ikon = $row['ikon_submenu'];
                //         $url = $row['url_submenu'];
                //         foreach ($row as $value){    //Go through every value in the row
                //             echo "<li>'$nama'</li>";
                //             echo "<li>'$menu_id'</li>";
                //             echo "<li>'$menu_utama_id'</li>";
                //             echo "<li>'$ikon'</li>";
                //             echo "<li>'$url'</li>";
                //         }
                //         echo('</>');
                //     }
                // }

                // foreach ($validasi as $s =>$val)
                //   {
                //     // dd($s);
                //     $dm= '<div class="errors text-danger">'
                //       .'<li>'.$val[$s]['nama_submenu'].'</li>'
                //       .'<li>'.$val[$s]['menu_id'].'</li>'
                //       .'<li>'.$val[$s]['menu_utama_id'].'</li>'
                //       .'<li>'.$val[$s]['ikon_submenu'].'</li>'
                //       .'<li>'.$val[$s]['url_submenu'].'</li>'
                //       .'</div>';
                //   }

                $this->session->setFlashdata('pesan_validasi_submenu',  $validasi);
                // .'<li>'.$nama.'</li>'
                // .'<li>'.$menu.'</li>'
                // .'<li>'.$menu_utama.'</li>'
                // .'<li>'.$url.'</li>'
                // .'<li>'.$ikon.'</li>'
                // .'</div>'
            
                return redirect()->to(base_url('/pengaturan/submenu'));
            }else{
                $this->session->setFlashdata('pesan_submenu', 'Menu baru berhasil ditambahkan!');
                return redirect()->to(base_url('/pengaturan/submenu'));
            }

    }

    public function ubah(){
       
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
                ],
                'menu_utama_idE' => [
                    'label'  => 'Menu Utama',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Menu Utama harus dipilih!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/pengaturan/submenu'))->withInput();
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

                $menu_utama = $this->request->getPost('menu_utama_idE');

            if (is_numeric($menu_utama)){
                $mu = $menu_utama;
            }else{
                $this->model_menu_utama->set('nama_menu_utama', $menu_utama)->insert();
                $mu = $this->db->insertID();
            }

                $data = array(
                    'menu_id' => htmlspecialchars($me, ENT_QUOTES),
                    'judul' => htmlspecialchars($this->request->getPost('judulE'), ENT_QUOTES),
                    'url' => htmlspecialchars($this->request->getPost('urlE'), ENT_QUOTES),
                    'icon' => htmlspecialchars($this->request->getPost('iconE'), ENT_QUOTES),
                    'is_active' => $isaktif,
                    'menu_utama_id' => htmlspecialchars($mu, ENT_QUOTES)
                );

                $this->model_user_sub_menu->update($id, $data);
                $this->session->setFlashdata('pesan_edit_submenu', 'Submenu baru berhasil diedit!');
                return redirect()->to(base_url('/pengaturan/submenu'));
              
                
    }


    public function hapus(){
        $id_submenu = $this->request->getPost('hidden_hapus_id_submenu');
            $this->model_user_sub_menu->delete($id_submenu);
            $this->session->setFlashdata('pesan_hapus_submenu', 'Submenu berhasil dihapus!');
            return redirect()->to(base_url('/pengaturan/submenu'));
        
       
        
    
    }
	
}
?>
