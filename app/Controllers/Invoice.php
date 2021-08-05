<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_toko;
use App\Models\Model_transaksi_sementara;
use App\Models\Model_transaksi;
use App\Models\Model_penyuplai;
use App\Models\Model_detail_transaksi;

class Invoice extends BaseController{

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function __construct(){	
        $this->model_toko = new Model_toko();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->model_transaksi = new Model_transaksi();
        $this->model_detail_transaksi = new Model_detail_transaksi();
        $this->model_user = new Model_user();
        $this->model_penyuplai = new Model_penyuplai();
        $this->model_user_menu = new Model_user_menu();
        $this->email = \Config\Services::email();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();	
	}

    public function index($kod){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
        $id_user = $this->session->get('id_user');


        $tk = $this->model_transaksi
            ->select('detail_transaksi.kode as ts_kode_transaksi,
            jumlah_uang as ts_jumlah_uang, kembalian as ts_kembalian,detail_transaksi_id,
            transaksi.harga as ts_harga')->asArray()
            ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
            ->where('detail_transaksi.kode', $kod)
            ->where('detail_transaksi.status', 2)
            ->groupBy('ts_kode_transaksi')
            ->first();


        if(!$tk){
            return redirect()->to(base_url('/kasir'));
        }
        $data = [
            'title' => 'Kasir',
            'nama_menu_utama' => 'Penjualan',
            'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama,
                surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
					->join('role', 'role.id = user.role_id')
					->where('surel', $email)
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
            'penyuplai' => $this->model_penyuplai->select('penyuplai.id as id, user.nama as nama')
                    ->asArray()
                    ->where('user.status', 1)
                    ->join('user', 'user.id = penyuplai.user_id') 
                    ->findAll(),
            'role_id_trans' => $tk['ts_kode_transaksi'][3],
            'transaksi_sementara' => $this->model_transaksi
                    ->select('barang.nama as nama_barang, transaksi.harga as ts_harga, transaksi.qty as ts_qty
                    ,harga_konsumen, harga_anggota')
                    ->join('barang', 'barang.id = transaksi.barang_id')
                    ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
                    ->join('user', 'user.id = detail_transaksi.user_id')
                    ->where('detail_transaksi.user_id', $id_user)
                    ->where('detail_transaksi.status', 2)
                    ->where('detail_transaksi.kode', $kod)
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


    public function ambil_surel(){

        $penyuplai_id = $this->request->getPost('penyuplai_id');

        $surel=$this->model_penyuplai->select('user.surel as surel')
                ->asArray()
                ->where('user.status', 1)
                ->where('penyuplai.id', $penyuplai_id)
                ->join('user', 'user.id = penyuplai.user_id') 
                ->first();

        echo json_encode(['data' => $surel, 'csrf_hash' => csrf_hash()]);
    }

    public function ubah(){
        $kod = $this->request->getPost('hidden_kode_transaksi');
        $role_id = $kod[3];
        $id_user = $this->session->get('id_user');

        if($role_id == 4){
            $rule_penyuplai = '';
            $rule_surel = 'requiredvalid_email'; 

        }else{
            $rule_penyuplai = 'required';
            $rule_surel = 'required|valid_email';
        }

        if(!$this->validate([
            
            'penyuplai_id' => [
                'label'  => 'Penyuplai',
                'rules'  => $rule_penyuplai,
                'errors' => [
                    'required' => 'Harus dipilih!'
                ]
            ],
            'surel' => [
                'label'  => 'Surel',
                'rules'  => $rule_surel,
                'errors' => [
                    'required' => 'Harus diisi!'
                ]
            ]

            ]))
        {
        return redirect()->to(base_url('/fitur/kasir/invoice/'.$kod.''))->withInput();
        }

        $data = array(
            'penyuplai_id' => $this->request->getPost('penyuplai_id'),
        );

        $id = $this->request->getPost('detail_transaksi_id');
        $this->model_detail_transaksi->update($id, $data);
        $transaksi = $this->model_detail_transaksi->select('user.nama as nama,
            user.surel as surel,
            detail_transaksi.kode as kode,
            detail_transaksi.tanggal as tanggal, total_harga, total_qty, jumlah_uang,
            kembalian')
            ->asArray()
            ->where('detail_transaksi.kode', $kod)
            ->join('penyuplai', 'penyuplai.id = detail_transaksi.penyuplai_id')
            ->join('user', 'user.id = penyuplai.user_id')
            ->first();
            
        if($role_id == 5){
            $barang = $this->model_transaksi->select('barang.nama as nama_barang,
                transaksi.qty as qty,
                transaksi.harga as subtotal, harga_anggota as harga,')->asArray()
                ->where('detail_transaksi.kode', $kod)
                ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
                ->join('barang', 'barang.id = transaksi.barang_id')
                ->findAll();
        }
        if($role_id == 4){
            $barang = $this->model_transaksi->select('barang.nama as nama_barang,
                transaksi.qty as qty,
                transaksi.harga as subtotal, harga_konsumen as harga,')->asArray()
            ->where('detail_transaksi.kode', $kod)
            ->join('detail_transaksi', 'detail_transaksi.id = transaksi.detail_transaksi_id')
            ->join('barang', 'barang.id = transaksi.barang_id')
            ->findAll();
        }
        $this->_sendEmail($transaksi, $barang);
        $this->session->setFlashdata('pesan_transaksi', 'Transaksi berhasil disimpan!');
        return redirect()->to(base_url('/fitur/kasir'));   
    }

    public function _sendEmail($transaksi, $barang){

		$config =[
            'protocol'  => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => 'karol.web980@gmail.com',
            'SMTPPass' => '95h:*351dj',
            'SMTPPort' => 465,
            'mailType'  => 'html',
            'charset'   => 'utf-8',
			'newline'   => "\r\n",
			'SMTPCrypto' => 'ssl'
		];
        $toko = $this->model_toko->select('nama_toko, telepon_toko, email_toko,
        alamat_toko')->asArray()
        ->where('id_toko', 1)->first();

		$this->email->initialize($config);
        $this->email->setFrom('karol.web980@gmail.com', 'Karol Web');
        $this->email->setTo($transaksi['surel']);
        $this->email->setSubject('KKBBI: Kuitansi');
        $this->email->setMessage(email_kuitansi($transaksi, $toko,  $barang));       
        if ($this->email->send()) {
            return true;
		}else{
            echo $this->email->printDebugger();
            die;
        }
    }
}
?>
