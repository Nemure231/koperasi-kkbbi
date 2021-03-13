<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_transaksi_sementara;
use App\Models\Users;

class Invoice extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function __construct(){

	
        $this->model_toko = new Model_toko();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->user = new Users();
		
	}

    public function index($kod){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
        $id_user = $this->session->get('id_user');

		
        

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
           'user' 	=> 	$this->user->ambilSatuUserBuatProfil()['users'],
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
            'form_hapus_invoice' => ['id' => 'formHapusInvoice', 'name'=>'formHapusInvoice', 'class' => 'btn btn-block'],
            'hidden_kode_transaksi' => [
                'name' => 'hidden_kode_transaksi', 
                'id'=>'hidden_kode_transaksi', 
                'type'=> 'hidden', 
                'value' => ''.$tk['ts_kode_transaksi'].''
            ],
            'hidden_uri' => [
                'name' => 'hidden_uri', 
                'id'=>'hidden_uri', 
                'type'=> 'hidden', 
                'value' => ''.$tk['ts_uri'].''
            ],
            'hidden_tt_kembalian' => [
                'name' => 'tt_kembalian', 
                'id'=>'tt_kembalian', 
                'type'=> 'hidden', 
                'value' => ''.$tk['ts_kembalian'].''
            ],
        ];
        tampilan_admin('admin/admin-invoice/v_invoice', 'admin/admin-invoice/v_js_invoice', $data);
    }


    public function hapus(){
            $uri = $this->request->getPost('hidden_uri');
            $kode = $this->request->getPost('hidden_kode_transaksi');
            $this->model_transaksi_sementara->HapusAllInvoiceAdmin($kode, $uri);
			$this->session->setFlashdata('pesan_hapus_invoice', 'Invoice berhasil dihapus!');
            return redirect()->to(base_url('/fitur/kasir'));
        
    
    }

    // public function cetaksetruk(){
    //     $connector = new FilePrintConnector("php://stdout");
    //     $printer = new Printer($connector);
    //     $printer->initialize();
    //     $printer->text("Hello World!\n");
    //     $printer->cut();
    //     $printer->close();

    // }


    public function tambah(){
        $kod = $this->request->getPost('hidden_kode_transaksi');
		$uri = $this->request->getPost('hidden_uri');
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
            return redirect()->to(base_url('/fitur/kasir'));
        
            
        
    }
}
?>
