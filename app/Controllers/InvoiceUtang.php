<?php namespace App\Controllers;

//require ROOTPATH. 'vendor/autoload.php';

use CodeIgniter\Controller;
use App\Models\Model_all;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_transaksi_sementara;


class InvoiceUtang extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index($kod){

		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
		
		$data = [
			'title' => ucfirst('Invoice Utang'),
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
            'validation' => $this->validation,
			'session' => $this->session,
			'utang' =>$this->model_transaksi_sementara->select('nama_barang, ts_kode_transaksi, harga_konsumen, 
                    harga_anggota, ts_qty, ts_harga, ts_role_id')->asArray()
                    ->where('ts_kode_transaksi', $kod)
                    ->where('ts_status_transaksi', 2)
                    ->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id')
                    ->findAll(),
			'utang_row' => $this->model_transaksi_sementara->select('ts_kode_transaksi, ts_uri, telepon, nama, 
                    alamat, ts_jumlah_uang, ts_kembalian, ts_nama_pengutang, 
                    ts_nomor_pengutang, ts_tanggal_sementara')
                    ->where('ts_kode_transaksi', $kod)
                    ->where('ts_status_transaksi', 2)
                    ->join('user', 'user.id_user = transaksi_sementara.ts_user_id')
                    ->groupBy('ts_kode_transaksi')
                    ->first(),
			'form_utang' => ['id' => 'formUtang', 'name'=>'formUtang']
		];
		tampilan_admin('admin/admin-invoice-utang/v_invoice_utang', 'admin/admin-invoice-utang/v_js_invoice_utang', $data);
    }
    
    public function simpan_invoice_utang(){
        $uri = $this->request->getPost('tt_kode_transaksi');
        $kod = $this->request->getPost('tt_kode_transaksi2');
        $id_user = $this->session->get('id_user');
	
            if(!$this->validate([
                'tt_kode_transaksi' => [
                    'label'  => 'Kode Transaksi',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Kode transaksi harus diisi!'
                    ]
                ],
                'tt_kembalian' => [
                    'label'  => 'Kembalian',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Kembalian harus diisi!',
					'numeric' => 'Kembalian harus angka!'
					
                    ]
				],
                'tt_jumlah_uang' => [
                    'label'  => 'Jumlah Uang',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Jumlah uang harus diisi!',
					'numeric' => 'Jumlah uang harus angka!'
					
					]
				]

            ])) {
                return redirect()->to(base_url('/kasir/invoice_utang'.'/'. ''.$uri.''))->withInput();
            }
            $this->model_transaksi_sementara->GetAllTransaksiSemantaraForInsertUtang($kod);
			$this->model_transaksi_sementara->where('ts_uri', $uri)->delete();
            $this->session->setFlashdata('pesan_simpan_invoice_utang', 'Transaksi berhasil disimpan!');
            return redirect()->to(base_url('/kasir/utang'));
            
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