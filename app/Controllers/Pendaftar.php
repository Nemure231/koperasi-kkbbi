<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;
use App\Models\Model_penyuplai;
class Pendaftar extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_pendaftaran = new Model_pendaftaran();
        $this->model_penyuplai =  new Model_penyuplai();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        $data = [
        
            'title' => 'Pendaftar',
            'nama_menu_utama' => 'Pendaftaran',
            'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
						->join('role', 'role.id = user.role_id')
						->where('surel', $email)
						->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
           'pendaftar' => $this->model_pendaftaran->select('penyuplai.id as id_penyuplai, nama, telepon,
                    pendaftaran.status as status_konfirmasi, user.status as status_user,
                    no_ktp, surel, pekerjaan, no_rekening, bank, atas_nama, alamat, pendaftaran.tanggal as tanggal, bukti')
                    ->join('penyuplai', 'penyuplai.id = pendaftaran.penyuplai_id')
                    ->join('user', 'user.id = penyuplai.user_id')
                    ->where('user.status', 2)
                    ->asArray()->findAll(),
           'validation' => $this->validation,
           'session' => $this->session,


        ];
        tampilan_admin('admin/admin-pendaftar/v_pendaftar', 'admin/admin-pendaftar/v_js_pendaftar', $data);
    }
    

    public function konfirmasi(){
        $data = [ 
            'id' => $this->request->getPost('id_penyuplai'),
            'kode' => $this->request->getPost('kode')
        ];
//        dd($data);
        if(!$this->validate([
            'kode' => [
                'rules'  => 'required',
                'errors' => [
                'required' => 'Harus diisi!',
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/fitur/pendaftar'))->withInput();

        }

            $data = array(
                'menu' => htmlspecialchars($this->request->getPost('menu'), ENT_QUOTES)
            );

            $this->model_user_menu->insert($data);
        
            $this->session->setFlashdata('pesan_menu', 'Menu baru berhasil ditambahkan!');
            return redirect()->to(base_url('/pengaturan/menu'));
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
                
                return redirect()->to(base_url('/pengaturan/menu'))->withInput();

            }
                $id = $this->request->getPost('hidden_menu_id');
                $data = array(
                    'menu' => htmlspecialchars($this->request->getPost('menuE'), ENT_QUOTES)
                );

                $this->model_user_menu->update($id, $data);
                $this->session->setFlashdata('pesan_edit_menu', 'Menu baru berhasil diedit!');
                return redirect()->to(base_url('/pengaturan/menu'));
                
      
    }

    public function hapus(){

        $id_menu = $this->request->getPost('hidden_hapus_menu_id');
        $this->model_user_menu->delete($id_menu);
        $this->session->setFlashdata('pesan_hapus_menu', 'Menu berhasil dihapus!');
        return redirect()->to(base_url('/pengaturan/menu'));
        
    
    }

   

	
}
?>
