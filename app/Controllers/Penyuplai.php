<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Model_penyuplai;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;

class Penyuplai extends BaseController
{
	
	public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_penyuplai = new Model_penyuplai();
        $this->model_pendaftaran =  new Model_pendaftaran();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
	}

	protected $helpers = ['url', 'array', 'form', 'kpos'];



    public function index(){
		
		$role = $this->session->get('role_id');
		$email = $this->session->get('email');
        

        $data = [
            'title' => 'Daftar Supplier',
            'nama_menu_utama' => 'Gudang',
            'user' 	=> 	$this->model_user->select('user.nama as nama')->asArray()
						->where('surel', $email)
						->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                        ->where('user_access_menu.role_id =', $role)
                        ->orderBy('user_access_menu.menu_id', 'ASC')
                        ->orderBy('user_access_menu.role_id', 'ASC')
                        ->findAll(),
            'supplier'=>$this->model_penyuplai->select('user.id as id_user, penyuplai.id as id_pengirim_barang,
                        user.nama as nama_pengirim_barang, surel, telepon, status, no_rekening, alamat, no_ktp, 
                        pekerjaan, bank, atas_nama')
                        ->where('user.role_id', 5)
                        // ->where('user.status', 1)
                        ->join('user', 'user.id = penyuplai.user_id') 
                        ->findAll(),
            'validation' => $this->validation,
            'session' => $this->session,
            'form_tambah_supplier' => ['id' => 'formTambahSupplier', 'name'=>'formTambahSupplier'],
            'form_edit_supplier' =>  ['id' => 'formEditSupplier', 'name'=>'formEditSupplier'],
            'form_hapus_supplier' =>  ['id' => 'formHapusSupplier', 'name'=>'formHapusSupplier', 'class' => 'btn btn-block'],
            'hidden_id_supplier' => ['name' => 'id_supplierE', 'id'=>'id_supplierE', 'type'=> 'hidden'],
            'hidden_id_supplierH' => ['name' => 'id_supplierH', 'id'=>'id_supplierH', 'type'=> 'hidden'],
            'hidden_old_nama_supplier' => [
                'type' => 'hidden',
                'name' => 'old_nama_supplier',
                'id' => 'old_nama_supplier',
                'class' => 'form-control'
                
            ]

            
        ];
        tampilan_admin('admin/admin-penyuplai/v_penyuplai', 'admin/admin-penyuplai/v_js_penyuplai', $data);
     
    }

    public function tambah(){

        
	    if(!$this->validate([
			'nama' => [
				'rules'  => 'required',
				'errors' => [
					'required' => 'Nama harus diisi!'
				]
			],
			'telepon' => [
				'rules'  => 'required|numeric|is_unique[user.telepon]|greater_than[0]',
				'errors' => [
					'required' => 'Telepon harus diisi!',
					'numeric' => 'Telepon harus angka!',
					'is_unique' => 'Telepon itu sudah pernah didaftarkan!',
					'greater_than' => 'Tidak boleh 0!'
				]
			],
			'surel' => [
				'rules'  => 'required|valid_email|is_unique[user.surel]',
				'errors' => [
					'required' => 'Surel harus disi!',
					'valid_emsil' => 'Surel harus berformat surel!',
					'is_unique' => 'Surel itu sudah pernah didaftarkan!'
				
				]
			],
			'pekerjaan' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Pekerjaan harus diisi!'
				
				]
			],
			'no_ktp' => [
				'rules'  => 'required|numeric|greater_than[0]',
				'errors' => [
				'required' => 'NIK harus diisi!',
				'numeric' => 'NIK harus angka!',
				'greater_than' => 'NIK tidak boleh 0!'
				
				]
			],
			'bank' => [
				'rules'  => 'required_with[atas_nama,no_rekening]|permit_empty|in_list[BCA,BRI,MANDIRI]',
				'errors' => [
					'required_with' => 'Bank harus diisi saat Atas Nama atau No Rekening ikut diisi!',
                    'in_list' => 'Pilihan bank tidak sesuai!'
				
				]
			],
			'atas_nama' => [
				'rules'  => 'required_with[no_rekening,bank]|permit_empty',
				'errors' => [
			
					'required_with' => 'Atas Nama harus diisi saat No Rekening atau Bank ikut diisi!'
				
				]
			],
			'no_rekening' => [
				'rules'  => 'required_with[atas_nama,bank]|numeric|permit_empty|greater_than[0]|numeric',
				'errors' => [
				'numeric' => 'Harus angka!',
				'greater_than' => 'Tidak boleh 0!',
				'required_with' => 'No rekening harus diisi saat Atas Nama atau Bank ikut diisi!'
				
				]
			],
			'alamat' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Alamat harus diisi!'
				
				]
			],
			'sandi' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Sandi harus diisi!',
					'min_length' => 'Sandi tidak boleh kurang dari 8!'
                    
            	]
            ],
            'ulang_sandi' => [
                'rules'  => 'matches[sandi]',
                'errors' => [
                    'matches' => 'Ulangi Sandi harus sama dengan sandi!'
                ]
            ]
				

		])) {
			return redirect()->to(base_url('suplai/penyuplai'))->withInput();
		}

		$surel = $this->request->getPost('surel');

		$user = [
			'role_id' => 5,
			'nama' => htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES),
			'surel' => $surel,
			'sandi' => password_hash($this->request->getPost('sandi'), PASSWORD_DEFAULT),
			'telepon' => $this->request->getPost('telepon'),
			'alamat' =>  htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES),		
			'status' => 1,		
		];
		$this->model_user->insert($user);
		$user_id = $this->db->insertID();

		$penyuplai = [
			'user_id' => $user_id,
			'no_ktp' => $this->request->getPost('no_ktp'),
			'pekerjaan' => htmlspecialchars($this->request->getPost('pekerjaan'), ENT_QUOTES),
			'no_rekening' => $this->request->getPost('no_rekening'),
			'bank' => htmlspecialchars($this->request->getPost('bank'), ENT_QUOTES),
			'atas_nama' => htmlspecialchars($this->request->getPost('atas_nama'), ENT_QUOTES)			
		];

		$this->model_penyuplai->insert($penyuplai);
		$penyuplai_id = $this->db->insertID();

		$pendaftaran = [
			'penyuplai_id'=> $penyuplai_id,
			'kode' => 'PND'.$user_id.'5'.date('jny'),
			'biaya' => 100000,
			'status' => 1
			];

		$this->model_pendaftaran->insert($pendaftaran);
		$this->session->setFlashdata('pesan_pendaftaran',
		'<div class="alert alert-success">Pendaftaran berhasil! 
		Silakan periksa surel anda untuk melakukan verifikasi!</div>');
		return redirect()->to(base_url('suplai/penyuplai'));
	
	}
       
        
    

    public function ubah(){

       
        $id_user = $this->request->getPost('edit_id_user');

            if(!$this->validate([
                'edit_nama' => [
                    'label'  => 'Nama Supplier',
                    'rules'  =>  'required|is_unique[user.nama,id,'.$id_user.']',
                    'errors' => [
                    'required' => 'Nama supplier harus diisi!',
                    'is_unique' => 'Nama supplier sudah ada!'
                    ]
                ],
                'edit_telepon' => [
                    'rules'  => 'required|numeric|is_unique[user.telepon,id,'.$id_user.']|greater_than[0]',
                    'errors' => [
                        'required' => 'Telepon harus diisi!',
                        'numeric' => 'Telepon harus angka!',
                        'is_unique' => 'Telepon itu sudah pernah didaftarkan!',
                        'greater_than' => 'Tidak boleh 0!'
                    ]
                ],
                'edit_surel' => [
                    'rules'  => 'required|valid_email|is_unique[user.surel,id,'.$id_user.']',
                    'errors' => [
                        'required' => 'Surel harus disi!',
                        'valid_emsil' => 'Surel harus berformat surel!',
                        'is_unique' => 'Surel itu sudah pernah didaftarkan!'
                    
                    ]
                ],
                'edit_pekerjaan' => [
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Pekerjaan harus diisi!'
                    
                    ]
                ],
                'edit_no_ktp' => [
                    'rules'  => 'required|numeric|greater_than[0]',
                    'errors' => [
                    'required' => 'NIK harus diisi!',
                    'numeric' => 'NIK harus angka!',
                    'greater_than' => 'NIK tidak boleh 0!'
                    
                    ]
                ],
                'edit_bank' => [
                    'rules'  => 'required_with[edit_atas_nama,edit_no_rekening]|permit_empty|in_list[BCA,BRI,MANDIRI]',
                    'errors' => [
                        'required_with' => 'Bank harus diisi saat Atas Nama atau No Rekening ikut diisi!',
                        'in_list' => 'Pilihan bank tidak sesuai!'
                    
                    ]
                ],
                'edit_atas_nama' => [
                    'rules'  => 'required_with[edit_no_rekening,edit_bank]|permit_empty',
                    'errors' => [
                        'required_with' => 'Atas Nama harus diisi saat No Rekening atau Bank ikut diisi!'
                    
                    ]
                ],
                'edit_no_rekening' => [
                    'rules'  => 'required_with[edit_atas_nama,edit_bank]|numeric|permit_empty|greater_than[0]|numeric',
                    'errors' => [
                    'numeric' => 'Harus angka!',
                    'greater_than' => 'Tidak boleh 0!',
                    'required_with' => 'No rekening harus diisi saat Atas Nama atau Bank ikut diisi!'
                    
                    ]
                ],
                'edit_alamat' => [
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Alamat harus diisi!'
                    
                    ]
                ]
            ])) {
                
                return redirect()->to(base_url('/suplai/penyuplai'))->withInput();

            }
                $id = $this->request->getPost('id_supplierE');
                $data_penyuplai = array(
                    'no_ktp' => $this->request->getPost('edit_no_ktp'),
                    'pekerjaan' => htmlspecialchars($this->request->getPost('edit_pekerjaan'), ENT_QUOTES),
                    'no_rekening' => $this->request->getPost('edit_no_rekening'),
                    'bank' => htmlspecialchars($this->request->getPost('edit_bank'), ENT_QUOTES),
                    'atas_nama' => htmlspecialchars($this->request->getPost('edit_atas_nama'), ENT_QUOTES),
                );
                $this->model_penyuplai->update($id, $data_penyuplai);

                $data_user = array(
                    'nama' => htmlspecialchars($this->request->getPost('edit_nama'), ENT_QUOTES),
                    'surel' => $this->request->getPost('edit_surel'),
                    'telepon' => $this->request->getPost('edit_telepon'),
                    'alamat' => htmlspecialchars($this->request->getPost('edit_alamat'), ENT_QUOTES),
                    'status' => $this->request->getPost('edit_status')
                );
                
                $this->model_user->update($id_user, $data_user);
                $this->session->setFlashdata('pesan_supplier', 'Supplier berhasil diedit!');
                return redirect()->to(base_url('/suplai/penyuplai'));

        
    }


    public function hapus(){

        $id_supplier = $this->request->getPost('id_supplierH');
        $this->model_penyuplai->delete($id_supplier);
        $this->session->setFlashdata('pesan_hapus_supplier', 'Supplier berhasil dihapus!');
        return redirect()->to(base_url('/suplai/penyuplai'));
        
    
    }

}
