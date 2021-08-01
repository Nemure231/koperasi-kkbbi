<?php namespace App\Controllers;


use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_transaksi_sementara;
use App\Models\Model_pendaftaran;
use App\Models\Model_toko;


class InvoicePendaftar extends BaseController{

    public function __construct(){
	
        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko =  new Model_toko();
        $this->model_transaksi_sementara = new Model_transaksi_sementara();
        $this->model_pendaftaran =  new Model_pendaftaran();
        $this->email = \Config\Services::email();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

    public function index($kode){

		$role = $this->session->get('role_id');
        $email = $this->session->get('email');

		
		$data = [
			'title' => ucfirst('Invoice Utang'),
            'nama_menu_utama' => 'Fitur',
            'user' 	=> 	$this->model_user->select('user.id as id_user, user.nama as nama, surel as email, telepon, gambar, alamat, role.nama as role')->asArray()
						->join('role', 'role.id = user.role_id')
						->where('surel', $email)
						->first(),
            'menu' 	=> 	$this->model_user_menu->select('id_menu, menu')->asArray()
                    ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                    ->where('user_access_menu.role_id =', $role)
                    ->orderBy('user_access_menu.menu_id', 'ASC')
                    ->orderBy('user_access_menu.role_id', 'ASC')
                    ->findAll(),
            'validation' => $this->validation,
			'session' => $this->session,
            'toko' =>$this->model_toko->select('alamat_toko, nama_toko, telepon_toko, email_toko')->asArray()
                    ->where('id_toko', 1)->first(),
            'pendaftar' => $this->model_pendaftaran->select('user.nama as nama, pendaftaran.kode as kode, pendaftaran.tanggal as tanggal')
                    ->where('pendaftaran.kode', $kode)
                    ->where('user.status', 2)
                    ->join('penyuplai', 'penyuplai.id = pendaftaran.penyuplai_id')
                    ->join('user', 'user.id = penyuplai.user_id')
                    // ->groupBy('pendaftaran.kode')
                    ->first(),
			'form_utang' => ['id' => 'formUtang', 'name'=>'formUtang']
		];
		tampilan_admin('admin/admin-invoice-pendaftar/v_invoice_pendaftar', 'admin/admin-invoice-pendaftar/v_js_invoice_pendaftar', $data);
    }
    
    public function ubah(){
        $kode = $this->request->getPost('kode');
	
            if(!$this->validate([
                'biaya' => [
                    'rules'  => 'required|numeric',
                    'errors' => [
                    'required' => 'Harus diisi!',
                    'numeric'=> 'Harus angka!'
                    ]
                ]

            ])) {
                return redirect()->to(base_url('/fitur/pendaftar/invoice'.'/'. ''.$kode.''))->withInput();
            }

            $user= $this->model_pendaftaran->select('user.id as id_user, pendaftaran.id as id_pendaftaran')->asArray()
                ->where('pendaftaran.kode', $kode)
                ->join('penyuplai', 'penyuplai.id = pendaftaran.penyuplai_id')
                ->join('user', 'user.id = penyuplai.user_id')->first();


            $biaya = $this->request->getPost('biaya');
            $this->model_user->set('status', 1)->where('id', $user['id_user'])->update();
            $this->model_pendaftaran->set('biaya', $biaya)->where('id', $user['id_pendaftaran'])->update();
            
            $pendaftaran = $this->model_pendaftaran->select('user.nama as nama, user.surel as surel, pendaftaran.kode as kode, pendaftaran.tanggal as tanggal')
            ->where('user.id', $user['id_user'])
            ->join('penyuplai', 'penyuplai.id = pendaftaran.penyuplai_id')
            ->join('user', 'user.id = penyuplai.user_id') 
            ->first();

            $this->_sendEmail($pendaftaran);


            $this->session->setFlashdata('pesan_sukses', 'Transaksi berhasil disimpan!');
            return redirect()->to(base_url('/fitur/pendaftar'));
            
	}


    public function _sendEmail($pendaftaran){

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

		$pembayaran = [
            'uang' => 100000,
            'qty'   => 1,
            'subtotal' => (100000 * 1)
        ];
		$this->email->initialize($config);
        $this->email->setFrom('karol.web980@gmail.com', 'Karol Web');
        $this->email->setTo($pendaftaran['surel']);
        $this->email->setSubject('KKBBI: Kuitansi');
        $this->email->setMessage(email_kuitansi_pendaftar($pendaftaran, $pembayaran, $toko));
		       
        if ($this->email->send()) {
            return true;
		}else{
            echo $this->email->printDebugger();
            die;
        }
    }



}
?>
