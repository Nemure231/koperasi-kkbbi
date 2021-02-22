<?php namespace App\Controllers;

//require ROOTPATH. 'vendor/autoload.php';

use CodeIgniter\Controller;
use App\Models\Model_all;
// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\Printer;
// use Setruk\PrintConnectors\FilePrintConnector;
// use Printer\Escpos\Printer;

class Kasir extends BaseController{

    public function __construct(){

		$this->model = new Model_all();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        // $this->connector = new FilePrintConnector();
        // $this->printer = new Printer($this->connector);
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
        //$session = \Config\Services::session();
        //$view = \Config\Services::renderer();
		
		$role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        


        $jenis_kasir = $this->model->GetRowJenisKasir();
        //($jenis_kasir);
        $barang= $this->model->GetAllBarangAdminForPembelianAnggota();

        if($jenis_kasir['role_id'] != 5){
            $barang=  $this->model->GetAllBarangAdminForPembelianKonsumen();
        }
        
        // if($jenis_kasir['role_id'] == 5){
        //     $barang= $this->model->GetAllBarangAdminForPembelianAnggota();
        // }
        $kode = $this->model->AutoKodeTransaksi(); 
        $data = [
           'title' => ucfirst('Pembelian'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'session' => $this->session,
           'kode' => $kode,
           'id_session' => $this->session->get('id_user'),
           'nama_jenis_kasir' => $jenis_kasir['role'],
           'role_id_jenis_kasir' => $jenis_kasir['role_id'],
           'role' => $this->model->GetAllRoleForPembelian(),
           'barang' => $barang,
           'validation' => $this->validation,
           'keranjang' => $this->model->GetAllKeranjang(),
           'hidden_kode_transaksi' => ['name' => 'kode_transaksi', 'id'=>'kode_transaksi', 'type'=> 'hidden', 'value' => ''.$kode.''],
           'hidden_id_jenis_kasir' => ['name' => 'id_jenis_kasir', 'id'=>'id_jenis_kasir', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['id_jenis_kasir'].''],
           'hidden_role_id' => ['name' => 'role_id', 'id'=>'role_id', 'type'=> 'hidden', 'value' => ''.$jenis_kasir['role_id'].''],
           'form_pembelian' => ['id' => 'formPembelian', 'name'=>'formPembelian', 'class' => 'formPembelian'],
           'form_jenis_kasir' => ['id' => 'formJenisKasir', 'name'=>'formJenisKasir'],
           
        ];
        //dd(time());
        tampilan_admin('admin/admin-pembelian/v_pembelian', 'admin/admin-pembelian/v_js_pembelian', $data);
    }

    public function ubahjeniskasir(){
        
    

            if(!$this->validate([
                'role_idE' => [
                    'label'  => 'Nama Role',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Jenis kasir harus dipilih!',
                    'is_unique' => 'Harus angka!'
                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/kasir'))->withInput();

            }
                $id_sess = $this->session->get('id_user');
                //$id = $this->request->getPost('id_jenis_kasir');
                $data = array(
                    'role_id' => $this->request->getPost('role_idE'),
                );
                
                $this->model->EditJenisKasir($data, $id_sess);
                $this->session->setFlashdata('pesan_jenis_kasir', 'Jenis kasir berhasil diubah!');
                return redirect()->to(base_url('/kasir'));
                
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
    }
    
    public function tambahkeranjangadmin(){ 
        $barang = $this->request->getPost('k_barang_id');
        if (!$barang) {
            return redirect()->to(base_url('blokir'));
        }

        $arr = $this->model->TambahKeranjangAdmin();
        if (!$arr){
            return redirect()->to(base_url('/'));
        }
        echo json_encode($arr);        
        
		
    }
    
    public function tambahtransaksisementarakonsumen(){

        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        

            if(!$this->validate([
                'jumlah_uang' => [
                    'label'  => 'Nama Role',
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Jumlah uang harus diisi!',
                    'numeric' => 'Jumlah uang harus angka!'
                    //'is_natural_no_zero' => 'Jumlah uang tidak boleh nol!'
                    ]
                ],
                'kembalian' => [
                    'label'  => 'Nama Role',
                    'rules'  => 'required|numeric|alpha_numeric',
                    'errors' => [
                    'required' => 'Kembalian harus diisi!',
                    'numeric' => 'Kembalian harus angka!',
                    'alpha_numeric' => 'Kembalian tidak boleh minus!'

                    ]
                ]
                
            ])) {
                
                return redirect()->to(base_url('/kasir'))->withInput();

            }

                $loop = $this->model->GetAllKeranjang();
				$user_id = $this->session->get('id_user');
                $mm =  $this->request->getPost('kode_transaksi');
                $status = $this->request->getPost('status_transaksi');

                if(!$status){
                    $status = 1;
                }

                $nama = $this->request->getPost('nama_penghutang');
                $nomor = $this->request->getPost('nomor_telepon_hutang');

                if(!$nama && !$nomor){
                    $nama = ''; 
                    $nomor = 0;
                }
                $jumlah_uang = $this->request->getPost('jumlah_uang');
					foreach ($loop as  $item):
						$data[] = array(
							'ts_barang_id' => $item['k_barang_id'],
							'ts_qty' => $item['tt_qty'],
							'ts_harga' => $item['tt_qty'] * $item['harga'],
                            'ts_user_id' => $user_id,
                            'ts_role_id' => $this->request->getPost('role_id'),
                            'ts_kode_transaksi' => $mm,
                            'ts_jumlah_uang' => $jumlah_uang,
                            'ts_kembalian' => $this->request->getPost('kembalian'),
							'ts_uri' => url_title($mm, '', true),
							'ts_nama_pengutang' => $nama,
                            'ts_nomor_pengutang' => $nomor,
                            'ts_status_transaksi' => $status
						);
						
                    endforeach;

    

                    // if ($jumlah_uang == null){
                    //     return redirect()->to(base_url('blokir'));
                    // }
                
				$this->model->TambahTransaksiSementara($data);
                $this->model->HapusAllKeranjang();
               
                if($status != 2){
                    $this->session->setFlashdata('pesan_transaksi_sementara', 'Transaksi berhasil disimpan ke dalam invoice!');
                    return redirect()->to(base_url('/kasir/invoice/'.$mm.''));
                }else{
                    $this->session->setFlashdata('pesan_transaksi_sementara_utang', 'Utang berhasil disimpan!');
                    return redirect()->to(base_url('/kasir'));
                }

               
        
        
           
        

    }

    public function kecohhapuskeranjangadmin(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapuskeranjangadmin($kode){


            $this->model->HapusKeranjangAdmin($kode);
			$this->session->setFlashdata('pesan_hapus_keranjang_admin', 'Berhasil dihapus!');
            return redirect()->to(base_url('/kasir'));
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }
    
    public function kecohhapusallkeranjangadmin(){
        $role = $this->session->get('role_id');

        if (!$role){
            return redirect()->to(base_url('/'));
        }
        if ($role > 0) {
                return redirect()->to(base_url('blokir'));
        }
    }

    public function hapusallkeranjangadmin(){

    
    
            $this->model->HapusAllKeranjangAdmin();
			$this->session->setFlashdata('pesan_hapus_all_keranjang_admin', 'Semua barang berhasil dihapus!');
            return redirect()->to(base_url('/kasir'));
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        
    }

    public function invoice($kod){
		$role = $this->session->get('role_id');
		
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }
        

        $tk = $this->model->GetRowTransaksiSementaraAdmin($kod);
        if(!$tk){
            return redirect()->to(base_url('/kasir'));
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
           'transaksi_sementara' => $this->model->GetAllTransaksiSementaraAdmin($kod),
           'row_transaksi_sementara' => $tk,
           'form_invoice' => ['id' => 'formInvoice', 'name'=>'formInvoice'],
           'hidden_tt_kode_transaksi' => ['name' => 'tt_kode_transaksi', 'id'=>'tt_kode_transaksi', 'type'=> 'hidden', 'value' => ''.$tk['ts_kode_transaksi'].''],
           'hidden_tt_kembalian' => ['name' => 'tt_kembalian', 'id'=>'tt_kembalian', 'type'=> 'hidden', 'value' => ''.$tk['ts_kembalian'].''],
           'hidden_tt_jumlah_uang' => ['name' => 'tt_jumlah_uang', 'id'=>'tt_jumlah_uang', 'type'=> 'hidden', 'value' => ''.$tk['ts_jumlah_uang'].'']
        ];
        tampilan_admin('admin/admin-invoice/v_invoice', 'admin/admin-invoice/v_js_invoice', $data);
    }

    public function utang(){
		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }

        $id_session = $this->session->get('role_id');
        $data = [
           'title' => ucfirst('Daftar Utang'),
           'user' => $this->model->UserLogin(),
           'menu' => $this->model->MenuAll(),
           'utang' => $this->model->GetAllUtang(),
           'session' => $this->session,

        ];
        tampilan_admin('admin/admin-utang/v_utang', 'admin/admin-utang/v_js_utang', $data);
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
        
            $this->model->HapusAllInvoiceAdmin($kod, $uri);
			$this->session->setFlashdata('pesan_hapus_invoice', 'Invoice berhasil dihapus!');
            return redirect()->to(base_url('/kasir'));


            $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
            $userAccess = $this->model->Tendang();
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

				    $this->model->GetAllTransaksiSemantaraForInsertAdmin($kod);
				    $this->model->HapusTransaksiSementaraAdmin($uri);

                    $this->session->setFlashdata('pesan_transaksi', 'Transaksi berhasil disimpan!');
                    return redirect()->to(base_url('/kasir'));
        
        $role = $this->session->get('role_id');
        if (!$role){
            return redirect()->to(base_url('/'));
        }
        $userAccess = $this->model->Tendang();
        if ($userAccess < 1) {
            return redirect()->to(base_url('blokir'));
        }
                
            
        
    }
    
    public function invoice_utang($kod){

		$role = $this->session->get('role_id');
		
		if (!$role){
            return redirect()->to(base_url('/'));
        }
			$userAccess = $this->model->Tendang();
            if ($userAccess < 1) {
                return redirect()->to(base_url('blokir'));
            }

		$user = $this->model->UserLogin();
		
		$data = [
			'title' => ucfirst('Invoice Utang'),
            'user' => $user,
            'validation' => $this->validation,
			'menu' => $this->model->MenuAll(),
			'session' => $this->session,
			'utang' => $this->model->GetAllDetailUtangSementara($kod),
			'utang_row' => $this->model->GetRowDetailUtangSementara($kod),
			'form_utang' => ['id' => 'formUtang', 'name'=>'formUtang']
		];
		tampilan_admin('admin/admin-invoice-utang/v_invoice_utang', 'admin/admin-invoice-utang/v_js_invoice_utang', $data);
    }
    

    // public function kecohhapusinvoiceutang(){
    //     $role = $this->session->get('role_id');

    //     if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
    //     if ($role > 0) {
    //             return redirect()->to(base_url('blokir'));
    //     }
    // }

    // public function hapusinvoiceutang($kod){

    //     // dd($kod);

       
    //         $uri = $this->request->getPost('tt_kode_transaksi');
    //         $this->model->HapusAllInvoiceUtang($kod, $uri);
	// 		$this->session->setFlashdata('pesan_hapus_invoice_utang', 'Invoice berhasil dihapus!');
    //         return redirect()->to(base_url('/kasir/utang'));
    //     $role = $this->session->get('role_id');
        
    //     if (!$role){
    //         return redirect()->to(base_url('/'));
    //     }
    //         $userAccess = $this->model->Tendang();
    //         if ($userAccess < 1) {
    //             return redirect()->to(base_url('blokir'));
    //         }
    // }

    public function simpan_invoice_utang(){
        $uri = $this->request->getPost('tt_kode_transaksi');
        $kod = $this->request->getPost('tt_kode_transaksi2');
	
		
        
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
                
                $this->model->GetAllTransaksiSemantaraForInsertUtang($kod);
				    $this->model->HapusTransaksiSementaraUtang($uri);

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
