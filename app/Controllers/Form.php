<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_all;
//use CodeIgniter\I18n\Time;

class Form extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function __construct(){

		$this->model = new Model_all();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		
	}

	public function index(){

		
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

		$user = $this->model->UserLogin();
		
		$kode = $this->model->AutoKodeTransaksi();

		$kode_cari = $this->request->getPost('kode_transaksi');
        
		$hasil_kode = '';
		$nama_kode= '';
        $pesan_retur = '';
        $barang = '';
        $nama_jenis_kasir = '';


        if($kode_cari){
			$nama_kode = $kode_cari;
			$hasil_kode = $this->model->GetAllTransaksiForRetur($kode_cari);
            $pesan_retur = 'Transaksi berhasil dicari. ';

            $jenis_kasir = $this->model->GetRowRoleIdTransaksiForRetur($kode_cari);
            //($jenis_kasir);
    
            if($jenis_kasir['tt_role_id'] == 4){
                $barang=  $this->model->GetAllBarangAdminForPembelianKonsumen();
            }
            if($jenis_kasir['tt_role_id'] == 5){
                $barang= $this->model->GetAllBarangAdminForPembelianAnggota();
            }

            $nama_jenis_kasir = ': '.$jenis_kasir['role'];
        }
        
		
        
		$data = [
			'title' => ucfirst('Form Retur'),
            'user' => $user,
            'kode_retur' => $this->model->AutoKodeRetur(),
			'validation' => $this->validation,
			'session' => $this->session,
			'menu' => $this->model->MenuAll(),
			'nama_jenis_kasir' => $nama_jenis_kasir,
			'id_session' => $this->session->get('id_user'),
           //'role_id_jenis_kasir' => $jenis_kasir['role_id'],
           'role' => $this->model->GetAllRoleForPembelian(),
           'barang' => $barang,
           //'barang_supplier' => $this->model->GetAllBarangAdminForReturSupplier(),
		   'nama_kode' => $nama_kode,
		   'pesan_retur' => $pesan_retur,
		   'keranjang' => $this->model->GetAllKeranjangRetur(),
		   'riwayat' => $hasil_kode,
           'validation' => $this->validation,
		   'hidden_kode_transaksi' => ['name' => 'kode_transaksi', 'id'=>'kode_transaksi', 'type'=> 'hidden', 'value' => ''.$kode.''],
        //    'hidden_id_jenis_kasir' => ['name' => 'id_jenis_kasir', 'id'=>'id_jenis_kasir', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['id_jenis_kasir'].''],
        //    'hidden_role_id' => ['name' => 'role_id', 'id'=>'role_id', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['role_id'].''],
           'form_retur' => ['id' => 'formRetur', 'name'=>'formRetur'],
		   //'form_jenis_kasir' => ['id' => 'formJenisKasir', 'name'=>'formJenisKasir'],
		   'form_kode_transaksi' => ['id' => 'formKodeTransaksi', 'name'=>'formKodeTransaksi', 'class' => 'card-header-form'],
		   'input_kode_transaksi' => [
            'type' => 'text',
            'name' => 'kode_transaksi',
            'id' => 'kode_transaksi',
            'placeholder' => 'Cari kode transaksi ....',
            'class' => 'form-control',
            'required' => ''
           ],

		];

		// $myTime = new Time('now', 'Asia/Jakarta');
		// $time = Time::parse($myTime);
		// $mk = $time->getDayOfWeek();

		// dd($myTime);
		


		tampilan_admin('admin/admin-form-retur/v_form_retur', 'admin/admin-form-retur/v_js_form_retur', $data);
		
	}

	

	public function tambahkeranjangretur(){
        $bu = $this->request->getPost('kr_barang_id');
        if ($bu == null) {
            return redirect()->to(base_url('blokir'));
        }
        
		
		$arr = $this->model->TambahKeranjangRetur();
        echo json_encode($arr);
        
        $role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
       
		
	}
	
	public function kecohhapuskeranjangretur(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapuskeranjangretur($kode){

       
     
            $this->model->HapusKeranjangRetur($kode);
			$this->session->setFlashdata('pesan_hapus_keranjang_admin', 'Berhasil dihapus!');
            return redirect()->to(base_url('/form'))->withInput();
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }
    
    public function kecohhapusallkeranjangretur(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusallkeranjangretur(){

       

            $this->model->HapusAllKeranjangRetur();
			$this->session->setFlashdata('pesan_hapus_all_keranjang_admin', 'Semua barang berhasil dihapus!');
            return redirect()->to(base_url('/form'))->withInput();
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }

	public function ambilkodetransaksi(){
        $kode = $this->request->getPost('kode_transaksi');
        $data = $this->model->GetAllTransaksiForRetur($kode);
        $arr = array('response' => false, 'data' => '');

        if($data){
            $arr = array('response' => true, 'data' => $data);
        }
        echo json_encode($arr);

    }

    public function tambahretursementara(){

        $bu = $this->request->getPost('barang_id_riwayat');
        if ($bu == null) {
            $this->session->setFlashdata('pesan_belum_ceklis', 'Anda belum memilih riwayat barang mana yang ingin diretur!');
            return redirect()->to(base_url('form'));
        }


        $id_user = $this->session->get('id_user');
        $retur = $this->model->GetAllKeranjangRetur();

        if ($retur == null) {
            $this->session->setFlashdata('pesan_belum_klik', 'Anda belum memilih barang baru mana yang ingin diretur!');
            return redirect()->to(base_url('form'));
        }

        $totbay = $this->request->getPost('total_bayar_k');
        if($totbay < 0){
            $totbay = 0;
        }

     
        foreach ($retur as  $r):
            $data[] = array(
                'tsr_transaksi_total_id' => $this->request->getPost('transaksi_total_id'),
                'tsr_role_id' => $this->request->getPost('role_id'),
                'tsr_user_id' => $id_user,
                'tsr_kode_retur' => $this->request->getPost('kode_retur'),
                'tsr_n_barang_id' => $r['kr_barang_id'],
                'tsr_n_qty' => $r['tt_qty'],
                'tsr_n_subtotal' => $r['tt_qty'] * $r['harga'],
                'tsr_kembalian_pl' => $this->request->getPost('kembalian_pl'),
                'tsr_total_bayar_k' => $totbay,
                'tsr_jumlah_uang_k' => $this->request->getPost('jumlah_uang_k'),
                'tsr_kembalian_k' => $this->request->getPost('kembalian_k')
            );
          
        endforeach;

        for ($i= 0; $i < count($this->request->getPost('barang_id_riwayat')); $i++ ){
            $data1[] = array(
                'tsr_transaksi_total_id' => $this->request->getPost('transaksi_total_id'),
                'tsr_role_id' => $this->request->getPost('role_id'),
                'tsr_user_id' => $id_user,
                'tsr_kode_retur' => $this->request->getPost('kode_retur'),
                'tsr_r_barang_id' => $this->request->getPost('barang_id_riwayat')[$i],
                'tsr_r_qty' => $this->request->getPost('qty_riwayat')[$i],
                'tsr_r_subtotal' => $this->request->getPost('subtotal_riwayat')[$i],
                'tsr_kembalian_pl' => $this->request->getPost('kembalian_pl'),
                'tsr_total_bayar_k' => $totbay,
                'tsr_jumlah_uang_k' => $this->request->getPost('jumlah_uang_k'),
                'tsr_kembalian_k' => $this->request->getPost('kembalian_k')
            );



        }
        $this->model->TambahTransaksiSementararRetur($data, $data1);
        $this->model->HapusKeranjangReturSemua();
        $this->model->HapusAllKeranjang();
        $this->session->setFlashdata('pesan_transaksi_sementara_retur', 'Transaksi retur berhasil disimpan ke dalam invoice!');
        return redirect()->to(base_url('form/invoiceretur'));

        $role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }


    }


    public function invoiceretur(){
		
		$role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $tk = $this->model->GetRowReturSementara();

        if(!$tk){
            return redirect()->to(base_url('/form'));
        }

        $id_session = $this->session->get('role_id');
        $data = [
           'title' => ucfirst('Invoice'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'id_session' => $id_session,
           'validation' => $this->validation,
           'toko' => $this->model->GetRowToko(),
           'retur_riwayat' => $this->model->GetAllReturSementaraRiwayat(),
           'retur_new' => $this->model->GetAllReturSementaraNew(),
           'row_retur' => $tk,
           'form_invoice' => ['id' => 'formInvoice', 'name'=>'formInvoice'],
        //    'hidden_tt_kode_transaksi' => ['name' => 'tt_kode_transaksi', 'id'=>'tt_kode_transaksi', 'type'=> 'hidden', 'value' => ''.$ts['ts_kode_transaksi'].''],
        //    'hidden_tt_kembalian' => ['name' => 'tt_kembalian', 'id'=>'tt_kembalian', 'type'=> 'hidden', 'value' => ''.$ts['ts_kembalian'].''],
        //    'hidden_tt_jumlah_uang' => ['name' => 'tt_jumlah_uang', 'id'=>'tt_jumlah_uang', 'type'=> 'hidden', 'value' => ''.$ts['ts_jumlah_uang'].'']
        ];
        //dd(time());
        tampilan_admin('admin/admin-invoice-retur/v_invoice_retur', 'admin/admin-invoice-retur/v_js_invoice_retur', $data);
    }

    public function kecohhapusinvoiceretur(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusinvoiceretur(){

        
      
            $this->model->HapusAllInvoiceRetur();
			$this->session->setFlashdata('pesan_hapus_invoice', 'Invoice berhasil dihapus!');
            return redirect()->to(base_url('/form'));
        $role = $this->session->get('role_id');
        
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    
    }


    public function tambahtransaksiretur(){
        // $kode = $this->request->getPost('tt_kode_transaksi');
        
        ///TAMBAH VALIDASI JUGA NANTII///////
        
            if(!$this->validate([
                'tt_tanggal_beli' => [
                    'label'  => 'Tanggal Beli',
                    'rules'  => 'required',
                    'errors' => [
                    'required' => 'Tanggal beli harus diisi!'
                    ]
                ]

            ])) {
                return redirect()->to(base_url('/form/invoiceretur'))->withInput();
            }

				    $this->model->GetAllTransaksiSemantaraReturForInsertRetur();
				    $this->model->HapusTransaksiSementaraRetur();
                    $this->session->setFlashdata('pesan_transaksi', 'Transaksi retur berhasil disimpan!');
                    return redirect()->to(base_url('/form'));
                
            //}
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
