<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Users;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_transaksi_sementara_retur;

class InvoiceRetur extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos', 'cookie'];

	public function __construct(){

        $this->model_toko = new Model_toko();
        $this->model_transaksi_retur_sementara = new Model_transaksi_sementara_retur();
        $this->model_user = new Model_user();
        $this->model_user_menu = new Model_user_menu();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
        $this->user = new Users();
		
	}


    public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
        $id_user = $this->session->get('id_user');
		

        

        $tk=$this->model_transaksi_retur_sementara->select('tsr_kode_retur, tsr_kembalian_pl, 
        tsr_total_bayar_k, tsr_jumlah_uang_k, tsr_kembalian_k, nama')->asArray()
            ->where('tsr_user_id', $id_user)
            ->join('user', 'user.id_user = transaksi_sementara_retur.tsr_user_id')
            ->groupBy('tsr_kode_retur')
            ->first();

        if(!$tk){
            return redirect()->to(base_url('/fitur/retur'));
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
            'toko'  =>$this->model_toko->select('id_toko, nama_toko, telepon_toko, email_toko, alamat_toko, 
                        deskripsi_toko, logo_toko')->asArray()
                    ->where('id_toko', 1)
                    ->first(),
            'retur_riwayat' => $this->model_transaksi_retur_sementara
                    ->select('nama_barang, tsr_role_id, tsr_r_qty, tsr_r_subtotal, tsr_r_barang_id')
                    ->select('harga_konsumen, harga_anggota')->asArray()
                    ->where('tsr_r_barang_id >', 0)
                    ->where('tsr_user_id', $id_user)
                    ->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_r_barang_id')
                    ->findAll(),
            'retur_new' => $this->model_transaksi_retur_sementara->select('nama_barang, tsr_role_id, 
                    tsr_n_qty, tsr_n_subtotal, tsr_n_barang_id')
                    ->select('harga_konsumen, harga_anggota')->asArray()
                    ->where('tsr_n_barang_id >', 0)
                    ->join('barang', 'barang.id_barang = transaksi_sementara_retur.tsr_n_barang_id')
                    ->where('tsr_user_id', $id_user)
                    ->findAll(),
            'row_retur' => $tk,
            'form_invoice' => ['id' => 'formInvoice', 'name'=>'formInvoice'],
            'form_hapus_invoice' => ['id' => 'formHapusInvoice', 'name'=>'formHapusInvoice', 'class' => 'btn btn-block'],
        ];
        tampilan_admin('admin/admin-invoice-retur/v_invoice_retur', 'admin/admin-invoice-retur/v_js_invoice_retur', $data);
    }


    public function hapus(){

        $this->model_transaksi_retur_sementara->HapusAllInvoiceRetur();
		$this->session->setFlashdata('pesan_hapus_invoice', 'Invoice berhasil dihapus!');
        return redirect()->to(base_url('/fitur/retur'));
        
    
    }
    
    public function tambah(){
        
        if(!$this->validate([
            'tt_tanggal_beli' => [
                'label'  => 'Tanggal Beli',
                'rules'  => 'required',
                'errors' => [
                'required' => 'Tanggal beli harus diisi!'
                ]
            ]

        ])) {
            return redirect()->to(base_url('/fitur/retur/invoice'))->withInput();
        }
            $id_user = $this->session->get('id_user');
            $this->model_transaksi_retur_sementara->GetAllTransaksiSemantaraReturForInsertRetur();
            $this->model_transaksi_retur_sementara->where('tsr_user_id', $id_user)->delete();
            $this->session->setFlashdata('pesan_transaksi', 'Transaksi retur berhasil disimpan!');
            return redirect()->to(base_url('/fitur/retur'));
            
    
    }
}
?>
