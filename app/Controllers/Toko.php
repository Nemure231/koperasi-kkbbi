<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_user_menu;
use App\Models\Model_toko;
use App\Models\Users;

class Toko extends BaseController{

	public function __construct(){
        $this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_user_menu = new Model_user_menu();
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->user = new Users();
		
	}
	protected $helpers = ['url', 'array', 'form', 'kpos'];

    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
        
        $toko = $this->model_toko->select('id_toko, nama_toko, telepon_toko, email_toko, alamat_toko, 
                deskripsi_toko, logo_toko')->asArray()
                ->where('id_toko', 1)
                ->first();
    
        
        $data = [
            'title' => ucfirst('Profil Toko'),
            'nama_menu_utama' => ucfirst('Toko'),
            'user' 	=> 	$this->user->ambilSatuUserBuatProfil()['users'],
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                        ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                        ->where('user_access_menu.role_id =', $role)
                        ->orderBy('user_access_menu.menu_id', 'ASC')
                        ->orderBy('user_access_menu.role_id', 'ASC')
                        ->findAll(),
            'toko' => $toko,
            'validation' => $this->validation,
            'session' => $this->session,
            'form_toko' =>  ['id' => 'formToko', 'name'=>'formToko'],
            'hidden_id_toko' => ['name' => 'toko_id', 'id'=>'toko_id', 'type'=> 'hidden', 'value' => ''.$toko['id_toko'].''],
            'hidden_logo_lama' => ['name' => 'logo_lama', 'id'=>'logo_lama', 'type'=> 'hidden', 'value' => ''.$toko['logo_toko'].''],
        ];
        tampilan_admin('admin/admin-toko/v_toko', 'admin/admin-toko/v_js_toko', $data);
    }

    public function ubah(){

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
                
                return redirect()->to(base_url('/tempat/toko'))->withInput();

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
    
                $this->model_toko->update($id_toko, $edit);
                $this->session->setFlashdata('pesan_toko', 'Toko berhasil diedit!');
                return redirect()->to(base_url('/tempat/toko'));

    }

}
?>