<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_transaksi_retur;

class LaporanRetur extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko = new Model_toko();
        $this->model_transaksi_retur = new Model_transaksi_retur();
		$this->request = \Config\Services::request();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index(){
		
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
	

        date_default_timezone_set("Asia/Jakarta");

        $awal = $this->request->getPost('cari_awal');
        $akhir = $this->request->getPost('cari_akhir');

        $retur = '';
        $retur_ini = '';
        $pesan =  '';

        if($awal && $akhir){
            $retur = $this->model_transaksi_retur->GetAllReturCari($awal, $akhir);
            $retur_ini = $awal.' ~ '.$akhir;
            $pesan = '<div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                Transaksi berhasil dicari!
            </div>
            </div>
        ';
        }
        
        $data = [
            'title' => ucfirst('Laporan Retur'),
            'nama_menu_utama' => ucfirst('Retur'),
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
            'session' => $this->session,
            'toko' => $this->model_toko->select('nama_toko, telepon_toko, alamat_toko, logo_toko, logo_koperasi_inter')
                    ->asArray()->where('id_toko', 1)
                    ->first(),
            'retur' => $retur,
            'pesan_retur' => $pesan,
            'form_retur' =>  ['id' => 'formRetur', 'name'=>'formRetur'],
            'retur_ini' => $retur_ini,
            'input_awal' => [
                'type' => 'text',
                'name' => 'cari_awal',
                'id' => 'cari_awal',
                'placeholder' => 'Cari awal ....',
                'class' => 'form-control',
                'required' => ''
            ],
            'input_akhir' => [
                'type' => 'text',
                'name' => 'cari_akhir',
                'id' => 'cari_akhir',
                'placeholder' => 'Cari akhir ....',
                'class' => 'form-control',
                'required' => ''
        ]   
        ];
        tampilan_admin('admin/admin-laporan-retur/v_laporan_retur', 'admin/admin-laporan-retur/v_js_laporan_retur', $data);
    }


   
    

}
?>
