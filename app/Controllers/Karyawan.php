<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_user_menu;
use App\Models\Model_role;
use App\Models\Model_jenis_kasir;

class Karyawan extends BaseController{

	public function __construct(){
        $this->model_role = new Model_role();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
        $this->model_jenis_kasir =  new Model_jenis_kasir();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
		
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function index(){
		
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		

        $nama = set_value('nama', '');
        $email_val = set_value('email', '');
        $telepon = set_value('telepon', '');
        $alamat = set_value('alamat', '');

       
        $data = [
            'title' => 'Daftar Karyawan',
            'nama_menu_utama' => 'Karyawan',
            'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
						->where('surel', $email)
						->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                        ->where('user_access_menu.role_id =', $role)
                        ->orderBy('user_access_menu.menu_id', 'ASC')
                        ->orderBy('user_access_menu.role_id', 'ASC')
                        ->findAll(),
            'karyawan' => $this->model_user->select('user.id as id_user, role_id, user.nama as nama, surel as email, 
                        alamat,telepon, status as is_active, role.nama as role')->asArray()
                        ->where('role_id!=',5)
                        ->join('role', 'role.id = user.role_id')
                        ->findAll(),
            'role' =>   $this->model_role->select('id as id_role, nama as role')->asArray()
                        ->where('id!=', 4)->where('id!=', 5)
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
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Nama harus diisi!'
                    ]
                ],
                'email' => [

                    'rules'  => 'required|valid_email|is_unique[user.surel]',
                    'errors' => [
                    'required' => 'Surel harus diisi!',
                    'valid_email' => 'Format surel salah!',
                    'is_unique' => 'Surel itu sudah terdaftar!'
                    ]
                ],
                'telepon' => [
        
                    'rules'  => 'required|numeric|is_unique[user.telepon]|greater_than[0]',
                    'errors' => [
                    'required' => 'Telepon harus diisi!',
                    'greater_than' => 'Telepon harus diisi!',
                    'is_unique' => 'Telepon itu sudah terdaftar!',
                    'numeric' => 'Telepon harus angka!'
                    ]
                ],
                'alamat' => [
    
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Alamat harus diisi!'
                    ]
                ],
                'role_id' => [
                
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Role harus dipilih!'
                    ]
                ],
                'sandi' => [
                    
                    'rules'  => 'required|min_length[8]',
                    'errors' => [
                    'required' => 'Sandi harus diisi!',
                    'min_length' => 'Sandi tidak boleh kurang dari 8 karakter!'
                    
                    ]
                ],
                'ulang_sandi' => [
                
                    'rules'  => 'matches[sandi]',
                    'errors' => [
                    'matches' => 'Ulangi Sandi harus sama dengan Sandi!'
                    ]
                ],

            ])) {
                return redirect()->to(base_url('/tempat/karyawan'))->withInput();

            }

                $data_user = [
                    'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
                    'surel' => $this->request->getPost('email'),
                    'sandi' => password_hash($this->request->getPost('sandi'), PASSWORD_DEFAULT),
                    'telepon' => $this->request->getPost('telepon'),
                    'alamat' => htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES),
                    'role_id' => $this->request->getPost('role_id'),
                    'status' => $this->request->getPost('is_active'),
                ];
                
                $this->model_user->insert($data_user);
                $id = $this->db->insertID();

                $data_jenis_kasir = [
                    'user_id' => $id,
                    'role_id' => 5
                ];

            $this->model_jenis_kasir->insert($data_jenis_kasir);
            $this->session->setFlashdata('pesan', 'Karyawan baru berhasil ditambahkan!');
            return redirect()->to(base_url('/tempat/karyawan'));
    }

    public function ubah(){
        $id_user = $this->request->getPost('user_id');

            if(!$this->validate([
                'namaE' => [
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Nama harus diisi!'
                    ]
                ],
                'emailE' => [
                    'rules'  => 'required|valid_email|is_unique[user.surel,id,'.$id_user.']',
                    'errors' => [
                    'required' => 'Surel harus diisi!',
                    'valid_email' => 'Format surel salah!',
                    'is_unique' => 'Surel itu sudah terdaftar!'
                    ]
                ],
                'teleponE' => [
                    'rules'  => 'required|numeric|greater_than[0]|is_unique[user.telepon,id,'.$id_user.']',
                    'errors' => [
                    'required' => 'Telepon harus diisi!',
                    'numeric' => 'Telepon harus angka!',
                    'greater_than' => 'Telepon harus diisi!',
                    'is_unique' => 'Telepon itu sudah terdaftar!'
                    ]
                ],
                'alamatE' => [
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Alamat harus diisi!'
                    ]
                ],
                'role_idE' => [
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Role harus dipilih!'
                    ]
                ],
               
            ])) {
                
                return redirect()->to(base_url('/tempat/karyawan'))->withInput();

            }

                $edit = [
                    'nama' => htmlspecialchars($this->request->getPost('namaE'), ENT_QUOTES),
                    'surel' => $this->request->getPost('emailE'),
                    'telepon' => $this->request->getPost('teleponE'),
                    'alamat' => htmlspecialchars($this->request->getPost('alamatE'), ENT_QUOTES),
                    'role_id' => $this->request->getPost('role_idE'),
                    'status' => $this->request->getPost('is_activeE'),
                ];

                $berhasil = $this->model_user->update($id_user, $edit);
                $this->session->setFlashdata('pesan', 'Karyawan berhasil diedit!');
                return redirect()->to(base_url('/tempat/karyawan'));
    }

    public function hapus(){
        $user_id = $this->request->getPost('hidden_id_user');
    
        $this->model_user->delete($user_id);
        $this->model_jenis_kasir->where('user_id', $user_id)->delete();
        
        $this->session->setFlashdata('hapus_karyawan', 'Karyawan berhasil dihapus!');
        return redirect()->to(base_url('/tempat/karyawan'));


    
    }


}
?>