<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user_menu;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;
use App\Models\Model_penyuplai;
use App\Models\Model_barang;
use App\Models\Model_barang_masuk;
use App\Models\Model_toko;
use App\Models\Model_pengajuan;
class Pengaju extends BaseController{

    public function __construct(){

        $this->model_user_menu = new Model_user_menu();
		$this->model_user = new Model_user();
        $this->model_toko =  new Model_toko();
        $this->model_barang = new Model_barang();
        $this->model_barang_masuk = new Model_barang_masuk();
        $this->model_pendaftaran = new Model_pendaftaran();
        $this->model_penyuplai =  new Model_penyuplai();
        $this->model_pengajuan = new Model_pengajuan();
        $this->email = \Config\Services::email();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
	}

	protected $helpers = ['form', 'url', 'array', 'kpos'];

	public function index(){
		$role = $this->session->get('role_id');
        $email = $this->session->get('email');
		
        
        $data = [
        
            'title' => 'Pengaju',
            'nama_menu_utama' => 'Pembelian',
            'user' 	=> 	$this->model_user->select('user.id as id_user,
                user.nama as nama, surel as email, telepon, gambar,
                alamat, role.nama as role')->asArray()
				->join('role', 'role.id = user.role_id')
				->where('surel', $email)
				->first(),
            'menu' => 	$this->model_user_menu->select('id_menu, menu')
                ->asArray()
                ->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id_menu')
                ->where('user_access_menu.role_id =', $role)
                ->orderBy('user_access_menu.menu_id', 'ASC')
                ->orderBy('user_access_menu.role_id', 'ASC')
                ->findAll(),
            'pengaju' => $this->model_pengajuan->select('barang.nama as nama_barang,
                pengajuan.status as status_pengajuan,
				barang.status as status_barang, pengajuan.kode as kode_pengajuan,
                pengajuan.tanggal as tanggal_pengajuan,
				pengajuan.stok as jumlah, satuan.nama as nama_satuan,
                merek.nama as nama_merek, kategori.nama as nama_kategori,
				barang.harga_anggota as harga_anggota,
                barang.harga_konsumen as harga_konsumen, barang.harga_pokok as harga_pokok,
				barang.deskripsi as deskripsi, user.nama as nama_pengaju,
                barang.gambar as nama_gambar, barang.id as id_barang,
                barang_masuk.id as id_barang_masuk, pengajuan.id as id_pengajuan,
                pengajuan.penyuplai_id as id_penyuplai')->asArray()
                ->where('barang_masuk.status', 2)
                ->where('user.role_id', 5)
                ->where('pengajuan.status<', 3)
				->join('barang_masuk', 'barang_masuk.pengajuan_id = pengajuan.id')
				->join('barang', 'barang.id = barang_masuk.barang_id')
				->join('satuan', 'satuan.id = barang.satuan_id')
				->join('kategori', 'kategori.id = barang.kategori_id')
				->join('merek', 'merek.id = barang.merek_id')
                ->join('penyuplai', 'penyuplai.id = pengajuan.penyuplai_id')
                ->join('user', 'user.id = penyuplai.user_id')
				->groupBy('pengajuan.id')
				->findAll(),
           'validation' => $this->validation,
           'session' => $this->session,


        ];
        tampilan_admin(
            'admin/admin-pengaju/v_pengaju',
            'admin/admin-pengaju/v_js_pengaju',
            $data
        );
    }
    public function tolak(){

        if(!$this->validate([
            'alasan' => [
                'rules'  => 'required',
                'errors' => [
                'required' => 'Alasan penolakan harus diisi!',
                ]
            ]
            
        ])) {
            
            return redirect()->to(base_url('/fitur/pengaju'))->withInput();

        }

        $id_penyuplai = $this->request->getPost('id_penyuplai_tolak');
        $id_pengajuan = $this->request->getPost('id_pengajuan_tolak');
        $id_barang = $this->request->getPost('id_barang_tolak');
        $data = array(
            'alasan' => htmlspecialchars($this->request->getPost('alasan'), ENT_QUOTES),
            'status' => 3,
        );
        $this->model_pengajuan->update($id_pengajuan, $data);

        $status = $this->model_barang->select('status')->asArray()
        ->where('id', $id_barang)
        ->first();

        if($status['status'] == 2){
            $this->model_barang->set('status', 3)->where('id', $id_barang)
            ->update();
        }

        $this->model_barang_masuk->set('status', 3)->where('pengajuan_id', $id_pengajuan)->update();

        $kode = $this->request->getPost('kode_pengajuan_tolak');
        $anggota = $this->model_penyuplai->select('user.nama as nama, user.surel as surel')
        ->where('penyuplai.id', $id_penyuplai)
        ->join('user', 'user.id = penyuplai.user_id')
        ->first();

        $this->_sendEmail($anggota, 'Mohon maaf, berdasarkan hasil keputusan
            rapat yang dilakukan oleh Ketua Umum, kami memutuskan
            untuk menolak barang yang ingin Anda ajukan. Namun, jangan cemas,
            data barang Anda masih ada di web kami, jika pada kesempatan
            berikutnya Anda ingin mengajukan barang tersebut lagi, anda hanya
            perlu memilih barang tersebut. Untuk melihat detail penolakan,
            silakan periksa halaman riwayat pengajuan.', $kode, 'tolak');
        $this->session->setFlashdata('pesan_sukses', 'Pengajuan berhasil ditolak!');
        return redirect()->to(base_url('/fitur/pengaju'));
    }

    public function terima(){

        $id_penyuplai = $this->request->getPost('id_penyuplai_terima');
        $anggota = $this->model_penyuplai->select('user.nama as nama, user.surel as surel')
        ->where('penyuplai.id', $id_penyuplai)
        ->join('user', 'user.id = penyuplai.user_id')
        ->first();
        $kode = $this->request->getPost('kode_pengajuan_terima');
        $id_pengajuan = $this->request->getPost('id_pengajuan');
        $this->model_pengajuan->set('status', 1)->where('id', $id_pengajuan)->update();

        $this->_sendEmail($anggota, 'Selamat, berdasarkan hasilkeputusan rapat
        yang dilakukan oleh Ketua Umum, kami memutuskan 
        untuk menerima pengajuan barang Anda. Anda diberi waktu satu minggu mulai dari
        sekarang untuk mengirim barang tersebut ke koperasi. Untuk melihat detail riwayat pengajuan, 
        silakan periksa halaman riwayat pengajuan', $kode, 'terima');

        $this->session->setFlashdata('pesan_sukses', 'Pengajuan berhasil diterima!');
        return redirect()->to(base_url('/fitur/pengaju'));
    }

    public function konfirm(){
        $id_user = $this->session->get('id_user');
        $id_barang = $this->request->getPost('id_barang');
        $id_barang_masuk = $this->request->getPost('id_barang_masuk');
        $stok = $this->request->getPost('stok');
        $id_pengajuan = $this->request->getPost('id_pengajuan_konfirm');

        $id_penyuplai = $this->request->getPost('id_penyuplai_konfirm');
        $anggota = $this->model_penyuplai->select('user.nama as nama, user.surel as surel')
        ->where('penyuplai.id', $id_penyuplai)
        ->join('user', 'user.id = penyuplai.user_id')
        ->first();
        

        $barang = $this->model_barang_masuk->select('barang.nama as nama_barang,
            barang_masuk.harga_pokok as harga,
            ')->asArray()
            ->selectSUM('barang_masuk.total_harga_pokok', 'subtotal')
            ->selectSUM('barang_masuk.jumlah', 'qty')
            ->where('barang_masuk.pengajuan_id', $id_pengajuan)
            ->join('barang', 'barang.id = barang_masuk.barang_id')
            ->groupBy('barang_masuk.barang_id')
            ->findAll();

        $transaksi = $this->model_barang_masuk->select('user.nama as nama,
            pengajuan.kode as kode, pengajuan.tanggal as tanggal,
            user.surel as surel')->asArray()
            ->selectSUM('pengajuan.stok', 'total_qty')
            ->selectSUM('total_harga_pokok', 'total_harga')
            ->where('penyuplai.id', $id_penyuplai)
            ->where('pengajuan.id', $id_pengajuan)
            ->join('pengajuan', 'pengajuan.id = barang_masuk.pengajuan_id')
            ->join('penyuplai', 'penyuplai.id = pengajuan.penyuplai_id')
            ->join('user', 'user.id = penyuplai.user_id')
            ->groupBy('pengajuan_id')
            ->first();
        

        $this->model_barang->set('status', 1)->where('id', $id_barang)->update();
        $this->model_barang_masuk->set('status', 1)->set('user_id', $id_user)
            ->where('pengajuan_id', $id_pengajuan)->update();
        $this->model_barang->TambahStok($id_barang, $stok);

        $this->_sendEmail($transaksi, $barang, NULL, 'konfirm');
        $this->session->setFlashdata('pesan_sukses', 'Pengajuan berhasil dikonfirmasi!');
        return redirect()->to(base_url('/fitur/pengaju'));
    }

    public function _sendEmail($anggota, $teks, $kode, $tipe){

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
        $this->email->setTo($anggota['surel']);

        if($tipe == 'terima'){
            $this->email->setSubject('KKBBI: Pengajuan');
            $this->email->setMessage(email_notifikasi($anggota, $teks, $toko, 'Pengajuan: '.$kode.''));
        }

        if($tipe == 'tolak'){
            $this->email->setSubject('KKBBI: Pengajuan');
            $this->email->setMessage(email_notifikasi($anggota, $teks, $toko, 'Pengajuan: '.$kode.''));
        }

        if($tipe == 'konfirm'){
            $this->email->setSubject('KKBBI: Debit Invoice');
            $this->email->setMessage(email_debit_invoice($anggota, $toko, $teks));
        }
		       
        if ($this->email->send()) {
            return true;
		}else{
            echo $this->email->printDebugger();
            die;
        }
    }

   

	
}
?>
