<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelUser;
use App\Models\ModelMenu;
use App\Models\ModelToko;

class Toko extends BaseController{

	public function __construct(){
        $this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->modelUser = new ModelUser();
        $this->modelMenu = new ModelMenu();
        $this->modelToko = new ModelToko();
		
	}
	protected $helpers = ['url', 'form', 'kpos', 'cookie'];

    public function index(){
		
        
        $toko = $this->modelToko->ambilToko();
    
        
        $data = [
            'title' => ucfirst('Profil Toko'),
            'nama_menu_utama' => ucfirst('Toko'),
            'user' 	=> 	$this->modelUser->ambilSatuUserBuatProfil(),
            'menu' 	=> 	$this->modelMenu->ambilMenuUntukSidebar(),
            'toko' => $toko,
            'validation' => $this->validation,
            'session' => $this->session,
            'form_toko' =>  ['id' => 'formToko'],
            'edit_id_toko' => ['name' => 'edit_id_toko', 'type'=> 'hidden', 'value' => ''.$toko['id_toko'].''],
            'logo_lama' => ['name' => 'logo_lama', 'id'=>'logo_lama', 'type'=> 'hidden', 'value' => ''.$toko['logo_toko'].''],
        ];
        tampilan_admin('admin/admin-toko/v_toko', 'admin/admin-toko/v_js_toko', $data);
    }

    public function ubah(){

        // dd($this->request->getFile('logo_toko')->getTempName());

            // if(!$this->validate([
            //     'nama_toko' => [
            //         'rules'  => 'required',
            //         'errors' => [
            //             'required' => 'Harus diisi!'
            //         ]
            //     ],
            //     'telepon_toko' => [
            //         'rules'  => 'required|numeric',
            //         'errors' => [
            //         'required' => 'Harus diisi!',
            //         'numeric' => 'Harus angka!'
            //         ]
            //     ],
            //     'email_toko' => [
            //         'rules'  => 'required|valid_email',
            //         'errors' => [
            //         'required' => 'Harus diisi!',
            //         'valid_email' => 'Format e-mail tidak benar!'
            //         ]
            //     ],
            //     'alamat_toko' => [
            //         'rules'  => 'required',
            //         'errors' => [
            //         'required' => 'Harus diisi!'
            //         ]
            //     ],
            //     'logo_toko' => [
            //         'rules'  => 'max_size[logo_toko,1024]|is_image[logo_toko]|mime_in[logo_toko,image/jpg,image/jpeg,image/png]',
            //         'errors' => [
            //         //'uploaded' => 'Harus diisi!',
            //         'max_size' => 'Ukuran sambar tidak boleh lebih dari 1MB!',
            //         'is_image' => 'Format file yang anda upload bukan gambar!',
            //         'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
            //         ]
            //     ]

            // ])) {
                
            //     return redirect()->to(base_url('/tempat/toko'))->withInput();
            // }
               
                // $logo_toko = $this->request->getFile('logo_toko');
                // //cek gambar aapakah tetap gambar lama
                // if($logo_toko->getError() == 4){
                //     $nama_logo = $this->request->getPost('logo_lama');
                // }else{
                //     $nama_logo = $logo_toko->getName();
                //     $logo_toko->move('admin/assets/toko/');
                //     //hapus file lama
                //     unlink('admin/assets/toko/'. $this->request->getPost('logo_lama'));
                // }
                $validasi = $this->modelToko->ubahToko();

                if($validasi){
                    $this->session->setFlashdata('pesan_validasi_edit_toko',  $validasi);
                    return redirect()->to(base_url('/tempat/toko'))->withInput();
                }else{
                    $this->session->setFlashdata('pesan_toko', 'Toko berhasil diedit!');
                    return redirect()->to(base_url('/tempat/toko'));
                }
    }

}
?>