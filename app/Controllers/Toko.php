<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_user;

class Toko extends BaseController{

	public function __construct(){
        $this->model = new Model_all();
        $this->model2 = new Model_user();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function index(){
		
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }

        $nama = set_value('nama', '');
        $email = set_value('email', '');
        $telepon = set_value('telepon', '');
        $alamat = set_value('alamat', '');

       
        $data = [
            'title' => ucfirst('Daftar Karyawan'),
            'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'karyawan' => $this->model->GetAllUser(),
            'role' => $this->model->GetAllRole(),
            'hitung'=> $this->model->CountUser(),
            'validation' => $this->validation,
            'session' => $this->session,
            'formtambah' => ['id' => 'formTambahKaryawan', 'name'=>'formTambahKaryawan'],
            'formedit' =>  ['id' => 'formEditKaryawan', 'name'=>'formEditKaryawan'],
            'hiddenIdKaryawan' => ['name' => 'user_id', 'id'=>'user_id', 'type'=> 'hidden'],
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
                'value' => ''.$email.''
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


    public function tambahkaryawan(){


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
                return redirect()->to(base_url('/toko'))->withInput();

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
               
                
                $this->model->TambahKaryawan($tambah);

            
                    $this->session->setFlashdata('pesan', 'Karyawan baru berhasil ditambahkan!');
                    return redirect()->to(base_url('/toko'));
                
            
                    $role = $this->session->get('role_id');
		
                    if (!$role){
                        return redirect()->to(base_url('/'));
                    }
                        $userAccess = $this->model->Tendang();
                        if ($userAccess < 1) {
                            return redirect()->to(base_url('blokir'));
                        }
    }

    public function editkaryawan(){

       

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
                
                return redirect()->to(base_url('/toko'))->withInput();

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

               

                $berhasil = $this->model->EditKaryawan($edit, $id_user);
                $this->session->setFlashdata('pesan', 'Karyawan berhasil diedit!');
                return redirect()->to(base_url('/toko'));
            
                $role = $this->session->get('role_id');
		
                if (!$role){
                    return redirect()->to(base_url('/'));
                }
                    $userAccess = $this->model->Tendang();
                    if ($userAccess < 1) {
                        return redirect()->to(base_url('blokir'));
                    }
    }

    public function kecohhapuskaryawan(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapuskaryawan($user_id){

            $hapus = $this->model2->find($user_id);

            if($hapus['gambar'] != 'default.png'){
                unlink('admin/assets/profile/'. $hapus['gambar']);
            }
            $this->model->HapusKaryawan($user_id);
            $this->session->setFlashdata('hapus_karyawan', 'Karyawan berhasil dihapus!');
            return redirect()->to(base_url('/toko'));

        $role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
    
    }


    ////////////////////////////////////PROFIL TOKO///////////////////////////////////
    public function profiltoko(){
		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
        $toko =  $this->model->GetRowToko();
        $data = [
            'title' => ucfirst('Profil Toko'),
            'user' => $this->model->UserLogin(),
            'menu' => $this->model->MenuAll(),
            'toko' => $toko,
            'validation' => $this->validation,
            'session' => $this->session,
            'form_toko' =>  ['id' => 'formToko', 'name'=>'formToko'],
            'hidden_id_toko' => ['name' => 'toko_id', 'id'=>'toko_id', 'type'=> 'hidden', 'value' => ''.$toko['id_toko'].''],
            'hidden_logo_lama' => ['name' => 'logo_lama', 'id'=>'logo_lama', 'type'=> 'hidden', 'value' => ''.$toko['logo_toko'].''],
        ];
        tampilan_admin('admin/admin-toko/v_toko', 'admin/admin-toko/v_js_toko', $data);
    }

    public function editprofiltoko(){

            if(!$this->validate([
                'nama_toko' => [
                    'label'  => 'Judul Buku',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Harus diisi!'
                    ]
                ],
                'telepon_toko' => [
                    'label'  => 'Telepon Toko',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harus diisi!',
                    'numeric' => 'Harus angka!'
                    ]
                ],
                'email_toko' => [
                    'label'  => 'Email Toko',
                    'rules'  => 'required|valid_email',
                    'errors' => [
                    'required' => 'Harus diisi!',
                    'valid_email' => 'Format e-mail tidak benar!'
                    ]
                ],
                'alamat_toko' => [
                    'label'  => 'Alamat Toko',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Harus diisi!'
                    ]
                ],
                'deskripsi_toko' => [
                    'label'  => 'Deskripasi Toko',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Harus diisi!'
                    ]
                ],
                'logo_toko' => [
                    'label'  => 'Logo Toko',
                    'rules'  => 'max_size[logo_toko,1024]|is_image[logo_toko]|mime_in[logo_toko,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                    //'uploaded' => 'Harus diisi!',
                    'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Format file yang anda upload bukan gambar!',
                    'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
                    ]
                ]

            ])) {
                
                return redirect()->to(base_url('/toko/profiltoko'))->withInput();

            }
               
                $logo_toko = $this->request->getFile('logo_toko');
                //cek gambar aapakah tetap gambar lama
                if($logo_toko->getError() == 4){
                    $nama_logo = $this->request->getPost('logo_lama');
                }else{
                    $nama_logo = $logo_toko->getName();
                    $logo_toko->move('admin/assets/toko/');
                    //hapus file lama
                    unlink('admin/assets/toko/'. $this->request->getPost('logo_lama'));
                }

                $id_toko = $this->request->getPost('toko_id');

                $edit = array(
                    'nama_toko' => htmlspecialchars($this->request->getPost('nama_toko'), ENT_QUOTES),
                    'telepon_toko' => htmlspecialchars($this->request->getPost('telepon_toko'), ENT_QUOTES),
                    'email_toko' => htmlspecialchars($this->request->getPost('email_toko'), ENT_QUOTES),
                    'alamat_toko' => htmlspecialchars($this->request->getPost('alamat_toko'), ENT_QUOTES),
                    'deskripsi_toko' => htmlspecialchars($this->request->getPost('deskripsi_toko'), ENT_QUOTES),
                    'logo_toko' => $nama_logo
                );

                //dd($edit);
    
                $this->model->EditToko($edit, $id_toko);
                $this->session->setFlashdata('pesan_toko', 'Toko berhasil diedit!');
                return redirect()->to(base_url('/toko/profiltoko'));
               
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