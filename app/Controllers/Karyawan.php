<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_user_menu;
use App\Models\Model_user_role;

class Karyawan extends BaseController{

	public function __construct(){
        $this->model_user_role = new Model_user_role();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function index(){
		
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		// if (!$role){
        //     return redirect()->to(base_url('/'));
        // }
		// 	$userAccess = $this->model_user_menu->Tendang();
        //     if ($userAccess < 1) {
        //         return redirect()->to(base_url('blokir'));
        //     }

        $nama = set_value('nama', '');
        $email_val = set_value('email', '');
        $telepon = set_value('telepon', '');
        $alamat = set_value('alamat', '');

       
        $data = [
            'title' => ucfirst('Daftar Karyawan'),
            'nama_menu_utama' => ucfirst('Karyawan'),
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
            'karyawan' => $this->model_user->select('id_user, role_id, nama, email, gambar, alamat, 
                        telepon, is_active, role')->asArray()
                        ->join('user_role', 'user_role.id_role = user.role_id')
                        ->findAll(),
            'role' =>   $this->model_user_role->select('id_role, role')->asArray()
                        ->where('id_role!=', 4)->where('id_role!=', 5)
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'formtambah' => ['id' => 'formTambahKaryawan', 'name'=>'formTambahKaryawan'],
            'formedit' =>  ['id' => 'formEditKaryawan', 'name'=>'formEditKaryawan'],
            'form_hapus' =>  ['class' => 'btn btn-block'],
            'hiddenIdKaryawan' => ['name' => 'user_id', 'id'=>'user_id', 'type'=> 'hidden'],
            'hidden_id_user' => ['name' => 'hidden_id_user', 'id'=>'hidden_id_user', 'type'=> 'hidden'],
            'nama' => [
                'type' => 'text',
                'name' => 'nama',
                'id' => 'nama',
                'class' => 'form-control',
                'autofocus' => '',
                'value' => ''.$nama.''
            ],
            'email' => [
                'name' => 'email',
                'id' => 'email',
                'class' => 'form-control',
                'type' => 'text',
                'value' => ''.$email_val.''
            ],
            'sandi' => [
                'type' => 'password',
                'name' => 'sandi',
                'id' => 'sandi',
                'class' => 'form-control '
            ],
            'ulang_sandi' => [
                'type' => 'password',
                'name' => 'ulang_sandi',
                'id' => 'ulang_sandi',
                'class' => 'form-control'
            ],
            'telepon' => [
                'type' => 'text',
                'name' => 'telepon',
                'id' => 'telepon',
                'class' => 'form-control',
                'value' => ''.$telepon.''
            ],
            'alamat' => [
                'type' => 'text',
                'name' => 'alamat',
                'id' => 'alamat',
                'class' => 'form-control',
                'value' => ''.$alamat.''
            ],
            'is_active' => [
                'name' => 'is_active',
                'id'=>'is_active',
                'type'=> 'checkbox',
                'value'=> '1',
                'class'=> 'form-check-input',
                'checked' => ''
            ],
            'is_active1' => [
                'name' => 'is_active',
                'id'=>'is_active',
                'type'=> 'hidden',
                'value'=> '2',
                'class'=> 'form-check-input',
                'checked' => ''
            ],
            'namaE' => [
                'type' => 'text',
                'name' => 'namaE',
                'id' => 'namaE',
                'class' => 'form-control',
            ],
            'emailE' => [
                'name' => 'emailE',
                'id' => 'emailE',
                'class' => 'form-control',
                'type' => 'text'
            ],
            'teleponE' => [
                'type' => 'text',
                'name' => 'teleponE',
                'id' => 'teleponE',
                'class' => 'form-control'
            ],
            'alamatE' => [
                'type' => 'text',
                'name' => 'alamatE',
                'id' => 'alamatE',
                'class' => 'form-control'
            ]
        ];
        tampilan_admin('admin/admin-karyawan/v_karyawan', 'admin/admin-karyawan/v_js_karyawan', $data);
    }


    public function tambah(){


            if(!$this->validate([
                'nama' => [
                    'label'  => 'Nama',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Nama harus diisi!'
                    ]
                ],
                'email' => [
                    'label'  => 'E-mail',
                    'rules'  => 'required|valid_email',
                    'errors' => [
                    'required' => 'E-mail harus diisi!',
                    'valid_email' => 'Format e-mail salah!'
                    ]
                ],
                'telepon' => [
                    'label'  => 'Penulis',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Nomor telepon harus diisi!',
                    'numeric' => 'Nomor telepon harus angka!'
                    ]
                ],
                'alamat' => [
                    'label'  => 'Alamat',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Alamat harus diisi!'
                    ]
                ],
                'role_id' => [
                    'label'  => 'Role',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Role harus dipilih!'
                    ]
                ],
                'sandi' => [
                    'label'  => 'Kata sandi',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Kata sandi harus diisi!'
                    
                    ]
                ],
                'ulang_sandi' => [
                    'label'  => 'Ulangi kata sandi',
                    'rules'  => 'matches[sandi]',
                    'errors' => [
                    'matches' => 'Kata sandi harus sama!'
                    ]
                ],
                'gambar' => [
                    'label'  => 'Gambar',
                    'rules'  => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        //'uploaded' => 'Sampul buku harus dipilih!',
                        'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
                        'is_image' => 'Format file yang anda upload bukan gambar!',
                        'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
                    ]
                ]


            ])) {
                return redirect()->to(base_url('/tempat/karyawan'))->withInput();

            }

                $sampul_buku = $this->request->getFile('gambar');
                //dd($sampul_buku);

                if($sampul_buku->getError() == 4){
                    $nama_gambar = 'default.png';
                }else{
                    ///pindahkan gambar
                    $nama_gambar = $sampul_buku->getRandomName();
                    $sampul_buku->move('admin/assets/profile/', $nama_gambar);
                    ///ambil namam gambar
                   
                }

                $tambah = [
                    'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
                    'email' => $this->request->getPost('email'),
                    'gambar' => $nama_gambar,
                    'sandi' => password_hash($this->request->getPost('sandi'), PASSWORD_DEFAULT),
                    'telepon' => $this->request->getPost('telepon'),
                    'alamat' => htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES),
                    'role_id' => $this->request->getPost('role_id'),
                    'is_active' => $this->request->getPost('is_active'),
                ];
                
                $this->model_user->TambahKaryawan($tambah);

            
                $this->session->setFlashdata('pesan', 'Karyawan baru berhasil ditambahkan!');
                return redirect()->to(base_url('/tempat/karyawan'));
                
            
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

            if(!$this->validate([
                'namaE' => [
                    'label'  => 'Nama',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Nama harus diisi!'
                    ]
                ],
                'emailE' => [
                    'label'  => 'E-mail',
                    'rules'  => 'required|valid_email',
                    'errors' => [
                    'required' => 'E-mail harus diisi!',
                    'valid_email' => 'Format e-mail salah!'
                    ]
                ],
                'teleponE' => [
                    'label'  => 'Penulis',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Nomor telepon harus diisi!',
                    'numeric' => 'Nomor telepon harus angka!'
                    ]
                ],
                'alamatE' => [
                    'label'  => 'Alamat',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Alamat harus diisi!'
                    ]
                ],
                'role_idE' => [
                    'label'  => 'Role',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Role harus dipilih!'
                    ]
                ],
                'gambarE' => [
                    'label'  => 'Gambar',
                    'rules'  => 'max_size[gambarE,1024]|is_image[gambarE]|mime_in[gambarE,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        //'uploaded' => 'Sampul buku harus dipilih!',
                        'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
                        'is_image' => 'Format file yang anda upload bukan gambar!',
                        'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
                    ]
                ]

            ])) {
                
                return redirect()->to(base_url('/tempat/karyawan'))->withInput();

            }

                $foto = $this->request->getFile('gambarE');

                //cek gambar aapakah tetap gambar lama
                if($foto->getError() == 4){
                    $nama_foto = $this->request->getPost('gambarE_lama');
                }else{
                    $nama_foto = $foto->getRandomName();
                    $foto->move('admin/assets/profile/', $nama_foto);
                    //hapus file lama
                    unlink('admin/assets/profile/'. $this->request->getPost('gambarE_lama'));
                }
                $id_user = $this->request->getPost('user_id');
                $edit = [
                    'nama' => htmlspecialchars($this->request->getPost('namaE'), ENT_QUOTES),
                    'email' => $this->request->getPost('emailE'),
                    'gambar' => $nama_foto,
                    'telepon' => $this->request->getPost('teleponE'),
                    'alamat' => htmlspecialchars($this->request->getPost('alamatE'), ENT_QUOTES),
                    'role_id' => $this->request->getPost('role_idE'),
                    'is_active' => $this->request->getPost('is_activeE'),
                ];

               

                $berhasil = $this->model_user->update($id_user, $edit);
                $this->session->setFlashdata('pesan', 'Karyawan berhasil diedit!');
                return redirect()->to(base_url('/tempat/karyawan'));
            
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
        $user_id = $this->request->getPost('hidden_id_user');
            $hapus = $this->model_user->asArray()->find($user_id);
            if($hapus['gambar'] != 'default.png'){
                unlink('admin/assets/profile/'. $hapus['gambar']);
            }
            $this->model_user->HapusKaryawan($user_id);
            $this->session->setFlashdata('hapus_karyawan', 'Karyawan berhasil dihapus!');
            return redirect()->to(base_url('/tempat/karyawan'));

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