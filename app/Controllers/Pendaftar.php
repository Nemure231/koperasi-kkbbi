<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;
use App\Models\Model_penyuplai;
use App\Models\Model_toko;
class Pendaftar extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko =  new Model_toko();
        $this->model_pendaftaran = new Model_pendaftaran();
        $this->model_penyuplai =  new Model_penyuplai();
        $this->email = \Config\Services::email();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        $data = [
        
            'title' => 'Pendaftar',
            'nama_menu_utama' => 'Pendaftaran',
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
           'pendaftar' => $this->model_pendaftaran->select('penyuplai.id as id_penyuplai, user.id as id_user, nama, telepon,
                    pendaftaran.status as status_konfirmasi, user.status as status_user,
                    no_ktp, surel, pekerjaan, no_rekening, bank, atas_nama, alamat, pendaftaran.tanggal as tanggal, bukti')
                    ->join('penyuplai', 'penyuplai.id = pendaftaran.penyuplai_id')
                    ->join('user', 'user.id = penyuplai.user_id')
                    ->where('user.status', 2)
                    ->asArray()->findAll(),
           'validation' => $this->validation,
           'session' => $this->session,


        ];
        tampilan_admin('admin/admin-pendaftar/v_pendaftar', 'admin/admin-pendaftar/v_js_pendaftar', $data);
    }
    

    public function konfirm_offline(){

        $id = $this->request->getPost('id_penyuplai');
        $kode = $this->model_pendaftaran->select('kode')->asArray()->where('penyuplai_id', $id)->first();
    
        if(!$this->validate([
            'kode' => [
                'rules'  => 'required|in_list['.$kode['kode'].']',
                'errors' => [
                'required' => 'Kode Konfirmasi harus diisi!',
                'in_list' =>  'Kode Konfirmasi salah!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/fitur/pendaftar'))->withInput();

        }

        $this->session->setFlashdata('pesan_sukses', 'Invoice berhasil ditemukan!');
        return redirect()->to(base_url('/fitur/pendaftar/invoice/'. $kode['kode']));
    }


    public function konfirm_online(){

        if(!$this->validate([
            'biaya' => [
                'rules'  => 'required|numeric',
                'errors' => [
                'required' => 'Jumlah uang harus disi!',
                'numeric' =>  'Jumlah uang harus angka!'
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/fitur/pendaftar'))->withInput();

        }

        $id_penyuplai = $this->request->getPost('id_penyuplai');
        $biaya = $this->request->getPost('biaya');
        $this->model_pendaftaran->set('biaya', $biaya)->where('penyuplai_id', $id_penyuplai)->update();

        $id_user = $this->request->getPost('id_user');
        $this->model_user->set('status', 1)->where('id', $id_user)->update();

        $pendaftaran = $this->model_pendaftaran->select('user.nama as nama, user.surel as surel, pendaftaran.kode as kode, pendaftaran.tanggal as tanggal')
        ->where('user.id', $id_user)
        ->join('penyuplai', 'penyuplai.id = pendaftaran.penyuplai_id')
        ->join('user', 'user.id = penyuplai.user_id') 
        ->first();

        // dd($pendaftaran);

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
