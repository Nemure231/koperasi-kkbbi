<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_transaksi_sementara;

class Invoice extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function __construct(){

		
        
        $this->model_toko = new Model_toko();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		
	}

    public function index($kod){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
        $id_user = $this->session->get('id_user');

		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
		$userAccess = $this->model_user_menu->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
        

        $tk =   $this->model_transaksi_sementara->select('ts_kode_transaksi, telepon, 
                ts_uri, ts_jumlah_uang, ts_kembalian, nama, alamat, ts_harga')->asArray()
                ->where('ts_kode_transaksi', $kod)
                ->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id')
                ->join('user', 'user.id_user = transaksi_sementara.ts_user_id')
                ->groupBy('ts_kode_transaksi')
                ->first();
        if(!$tk){
            return redirect()->to(base_url('/kasir'));
        }
        $data = [
           'title' => ucfirst('Invoice'),
           'user'   => 	$this->model_user->select('id_user, nama, email, telepon, gambar, alamat, role')->asArray()
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
           'id_session' => $role,
           'validation' => $this->validation,
           'toko' =>$this->model_toko->select('id_toko, nama_toko, telepon_toko, email_toko
                    alamat_toko, deskripsi_toko, logo_toko')->asArray()
                    ->where('id_toko', 1)->first(),
           'transaksi_sementara' => $this->model_transaksi_sementara
                    ->select('nama_barang, ts_harga, ts_qty, ts_role_id, harga_konsumen, harga_anggota')
                    ->join('barang', 'barang.id_barang = transaksi_sementara.ts_barang_id')
                    ->where('ts_user_id', $id_user)
                    ->where('ts_status_transaksi', 1)
                    ->where('ts_kode_transaksi', $kod)
                    ->findAll(),
           'row_transaksi_sementara' => $tk,
           'form_invoice' => ['id' => 'formInvoice', 'name'=>'formInvoice'],
           'hidden_tt_kode_transaksi' => ['name' => 'tt_kode_transaksi', 'id'=>'tt_kode_transaksi', 'type'=> 'hidden', 'value' => ''.$tk['ts_kode_transaksi'].''],
           'hidden_tt_kembalian' => ['name' => 'tt_kembalian', 'id'=>'tt_kembalian', 'type'=> 'hidden', 'value' => ''.$tk['ts_kembalian'].''],
           'hidden_tt_jumlah_uang' => ['name' => 'tt_jumlah_uang', 'id'=>'tt_jumlah_uang', 'type'=> 'hidden', 'value' => ''.$tk['ts_jumlah_uang'].'']
        ];
        tampilan_admin('admin/admin-invoice/v_invoice', 'admin/admin-invoice/v_js_invoice', $data);
    }


    public function kecohhapusinvoice(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusinvoice($kod){
            $uri = $this->request->getPost('ts_uri');
            $this->model_transaksi_sementara->HapusAllInvoiceAdmin($kod, $uri);
			$this->session->setFlashdata('pesan_hapus_invoice', 'Invoice berhasil dihapus!');
            return redirect()->to(base_url('/kasir'));


            $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model_user_menu->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
        
        
    
    }

    // public function cetaksetruk(){
    //     $connector = new FilePrintConnector("php://stdout");
    //     $printer = new Printer($connector);
    //     $printer->initialize();
    //     $printer->text("Hello World!\n");
    //     $printer->cut();
    //     $printer->close();

    // }


    public function tambahtransaksi($kod){
		$uri = $this->request->getPost('ts_uri');
        $id_user = $this->session->get('id_user');

        if(!$this->validate([
            'tt_tanggal_beli' => [
                'label'  => 'Tanggal Beli',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Tanggal beli harus diisi!'
                ]
            ],
            'tt_telepon_penerima' => [
                'label'  => 'Nomor Telepon',
                'rules'  => 'numeric',
                'errors' => [
                    'numeric' => 'Nomor telepon harus angka!'
                ]
            ]

            ])) {
                return redirect()->to(base_url('/kasir/invoice/'.$kod.''))->withInput();
            }

            $this->model_transaksi_sementara->GetAllTransaksiSemantaraForInsertAdmin($kod);
		    $this->model_transaksi_sementara->where('ts_uri', $uri)->delete();

            $this->session->setFlashdata('pesan_transaksi', 'Transaksi berhasil disimpan!');
            return redirect()->to(base_url('/kasir'));
        
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
