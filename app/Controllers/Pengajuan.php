<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Model_user;
use App\Models\Model_pendaftaran;
use App\Models\Model_penyuplai;
use App\Models\Model_toko;
use App\Models\Model_barang;
use App\Models\Model_satuan;
use App\Models\Model_merek;
use App\Models\Model_kategori;
use App\Models\Model_pengajuan;
use App\Models\Model_barang_masuk;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Pengajuan extends BaseController{

	protected $helpers = ['url', 'array', 'form', 'kpos'];

	public function __construct(){
		$this->model_user =  new Model_user();
		$this->model_toko =  new Model_toko();
		$this->model_barang =  new Model_barang();
		$this->model_satuan = new Model_satuan();
        $this->model_merek = new Model_merek();
        $this->model_kategori = new Model_kategori();
		$this->model_penyuplai = new Model_penyuplai();
		$this->model_pendaftaran = new Model_pendaftaran();
		$this->model_pengajuan = new Model_pengajuan();
		$this->model_barang_masuk =  new Model_barang_masuk();
		$this->request = \Config\Services::request();
		$this->validation = \Config\Services::validation();
		$this->email = \Config\Services::email();
		$this->db = \Config\Database::connect();
	}

	public function index(){
		$role = $this->session->get('role_id');
		$id_user = $this->session->get('id_user');
		$email = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();
		
		if($konfirm['status'] != 1){
			return redirect()->to(base_url('/'));
		}
		
		$data = [
			'title' => 'Pengajuan',
			'user' => $this->model_user->select('user.id as id_user,
				user.nama as nama, surel as email, telepon,
				alamat, role.nama as role')->asArray()
				->join('role', 'role.id = user.role_id')
				->where('surel', $email)
				->first(),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
						->where('id_toko', 1)->first(),
			'barang' => $this->model_barang->select('barang.nama as nama, 
				barang.id as id')->asArray()
				->where('user.id', $id_user)
				->where('barang.status', 1)
				->orWhere('barang.status', 3)
				->join('penyuplai', 'penyuplai.id = barang.penyuplai_id')
				->join('user', 'user.id = penyuplai.user_id')
				->findAll(),
			'satuan' => $this->model_satuan->select('id, nama')->asArray()
				->findAll(),
			'merek' =>  $this->model_merek->select('id, nama')->asArray()
				->findAll(),
			'kategori'=>$this->model_kategori->select('id, nama')->asArray()
				->findAll(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'validation' => $this->validation,
			'session' => $this->session,
			'role_log' => $role,
			
		];
		tampilan_user(
			'user/user-pengajuan/v_pengajuan',
			'user/user-pengajuan/v_js_pengajuan',
			$data
		);
		
	}

	public function ambil_barang(){

        $id_barang = $this->request->getPost('nama');

        $barang=$this->model_barang->select('barang.id as id_barang, merek_id, satuan_id,
			 stok, kategori_id, harga_pokok, harga_konsumen, harga_anggota, deskripsi, gambar')->asArray()
            ->where('barang.id', $id_barang)
			->where('barang.status', 1)
			->orWhere('barang.status', 3)
            ->join('satuan', 'satuan.id = barang.satuan_id')
			->join('kategori', 'kategori.id = barang.kategori_id')
            ->join('merek', 'merek.id = barang.merek_id')
            ->first();
        
        echo json_encode(['data' => $barang, 'csrf_hash' => csrf_hash()]);
    }

	public function tambah(){

		$id_barang = $this->request->getPost('nama');
		if (is_numeric($id_barang)){
			$rule = 'required_without[nama]';
			
		}else{
			$rule = 'uploaded[input_gambar]|max_size[input_gambar,3072]|is_image[input_gambar]|mime_in[input_gambar,image/jpg,image/jpeg,image/png]';
		}

		if(!$this->validate([
			'nama' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus dipilih atau diisi!',
				]
			],
			'kategori_id' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus dipilih atau diisi!',
				]
			],
			'satuan_id' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus dipilih atau disi!'
				
				]
			],
			'merek_id' => [
				'rules'  => 'required',
				'errors' => [
				'required' => 'Harus dipilih atau diisi!',
				]
			],
			'harga_konsumen' => [
				'rules'  => 'required|numeric|greater_than[0]',
				'errors' => [
				'required' => 'Harus diisi!',
				'greater_than' => 'Harus diisi!',
				'numeric' => 'Harus angka!'
				]
			],
			'harga_pokok' => [
				'rules'  => 'required|numeric|greater_than[0]',
				'errors' => [
				'required' => 'Harus diisi!',
				'greater_than' => 'Harus diisi!',
				'numeric' => 'Harus angka!'
				]
			],
			'harga_anggota' => [
				'rules'  => 'required|numeric|greater_than[0]',
				'errors' => [
				'required' => 'Harus diisi!',
				'greater_than' => 'Harus diisi!',
				'numeric' => 'Harus angka!'
				]
			],
			'stok' => [
				'rules'  => 'required|numeric|greater_than[0]',
				'errors' => [
				'required' => 'Harus diisi!',
				'greater_than' => 'Harus diisi!',
				'numeric' => 'Harus angka!'
				]
			],	
            'input_gambar' => [
                'rules'  => $rule,
                'errors' => [
                'uploaded' => 'Harus diunggah!',
                'max_size' => 'Ukuran gambar tidak boleh lebih dari 3MB!',
                'is_image' => 'Format gambar salah!',
                'mime_in' => 'Format gambar yang diperbolehkan JPG, JEPG, dan PNG!'
                ]
			],
		])) {
			return redirect()->to(base_url('pengajuan'))->withInput();
		}

		$id_barang = $this->request->getPost('nama');
		$id_satuan = $this->request->getPost('satuan_id');
		$id_kategori = $this->request->getPost('kategori_id');
		$id_merek = $this->request->getPost('merek_id');
		$id_user = $this->session->get('id_user');
		$id_penyuplai = $this->model_penyuplai->select('id as id_penyuplai')
				->asArray()
				->where('user_id', $id_user)
				->first();
		$harga_pokok = $this->request->getPost('harga_pokok');
		$stok = $this->request->getPost('stok');

		if (is_numeric($id_barang)){
			$barang_id = $id_barang;			
		}else{
            if (is_numeric($id_satuan)){
                $satuan_id = $id_satuan;
            }else{
                $this->model_satuan->set('nama', $id_satuan)->insert();
                $satuan_id = $this->db->insertID();
            }
            
			if (is_numeric($id_kategori)){
                $kategori_id = $id_kategori;
            }else{
                $this->model_kategori->set('nama', $id_kategori)->insert();
                $kategori_id = $this->db->insertID();   
            }

            if (is_numeric($id_merek)){
                $merek_id = $id_merek;
            }else{
                $this->model_merek->set('nama', $id_merek)->insert();
                $merek_id = $this->db->insertID();    
            }
			$kode = auto_kode_barang();
			$writer = new PngWriter();

			$qrCode = QrCode::create($kode)
				->setEncoding(new Encoding('UTF-8'))
				->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
				->setSize(300)
				->setMargin(10)
				->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
				->setForegroundColor(new Color(0, 0, 0))
				->setBackgroundColor(new Color(255, 255, 255));

			$label = Label::create($kode)
				->setTextColor(new Color(0, 0, 0));
			$result = $writer->write($qrCode, null, $label);
			$result->saveToFile(FCPATH.'/admin/assets/qr/'.$kode.'.png');

			$gambar = $this->request->getFile('input_gambar');
			$nama_gambar = time().'.'.$gambar->guessExtension();
			$gambar->move('admin/assets/barang/', $nama_gambar);
		
			$data_barang = [
				'nama' => $id_barang,
				'kode' => $kode,
				'kategori_id' => $kategori_id,
				'satuan_id' => $satuan_id,
				'merek_id'=> $merek_id,
				'penyuplai_id' => $id_penyuplai['id_penyuplai'],
				'harga_pokok' => $harga_pokok,
				'harga_konsumen' => $this->request->getPost('harga_konsumen'),
				'harga_anggota' => $this->request->getPost('harga_anggota'),
				'stok' => 0,
				'deskripsi' => $this->request->getPost('deskripsi'),
				'gambar' => $nama_gambar,
				'qr' => $kode.'.png',
				'status' => 2,
			];
			$this->model_barang->insert($data_barang);
			$barang_id = $this->db->insertID();    
		}

		$data_pengajuan = [
			'penyuplai_id' => $id_penyuplai['id_penyuplai'],
			'kode' => 'PNJ'.$id_user.date('jny').rand(1, 999),
			'stok' => $stok,
			'alasan' => '',		
			'status' => 2,		
		];
		$this->model_pengajuan->insert($data_pengajuan);
		$pengajuan_id = $this->db->insertID(); 
			
		$data_barang_masuk = [
			'barang_id' => $barang_id,
			'pengajuan_id' => $pengajuan_id,
			'user_id' => '',
			'penyuplai_id' => $id_penyuplai['id_penyuplai'],
			'jumlah' => $stok,
			'harga_pokok' => $harga_pokok,
			'total_harga_pokok' => ($harga_pokok * $stok),
			'status' => 2
		];
			
		$this->model_barang_masuk->insert($data_barang_masuk);
		
		$sekretaris = $this->model_user->select('surel, nama')
			->where('id', 124)->where('role_id', 3)->asArray()
			->first();
		$anggota = $this->model_user->select('nama')->asArray()
			->where('penyuplai.id', $id_penyuplai['id_penyuplai'])
			->join('penyuplai', 'penyuplai.user_id = user.id')
			->first();

		$this->session->setFlashdata('pesan_sukses', 'Pengajuan berhasil disimpan!');
		$this->_sendEmail($sekretaris, $anggota);
		return redirect()->to(base_url('pengajuan'));
	
	}

	public function _sendEmail($sekretaris, $anggota){
		$toko = $this->model_toko->select('nama_toko, telepon_toko, email_toko,
                alamat_toko')->asArray()
                ->where('id_toko', 1)->first();

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
		
		$this->email->initialize($config);
        $this->email->setFrom('karol.web980@gmail.com', 'Karol Web');
        $this->email->setTo($sekretaris['surel']);
		$this->email->setSubject('KKBBI: Pengajuan - '.$anggota['nama']);
		$this->email->setMessage(email_notifikasi($sekretaris,''.$anggota['nama'].' baru saja mengajukan barang!',$toko, 'Pengajuan'));
      
        if ($this->email->send()) {
            return true;
		}else{
            echo $this->email->printDebugger();
            die;
        }
    }

	public function riwayat(){
	
		$role = $this->session->get('role_id');
		$id_user = $this->session->get('id_user');
		$email = $this->session->get('email');
		$konfirm = $this->model_user->select('status')->asArray()
		->where('surel', $email)
		->first();
		
		if($konfirm['status'] != 1){
			return redirect()->to(base_url('/'));
		}

		$id_penyuplai = $this->model_penyuplai->select('id')
			->where('user_id', $id_user)->first();
		
		$data = [
			'title' => 'Riwayat Pengajuan',
			'user' => $this->model_user->select('user.id as id_user, user.nama as nama,
				surel as email, telepon, alamat, role.nama as role')->asArray()
				->join('role', 'role.id = user.role_id')
				->where('surel', $email)
				->first(),
			'toko' => $this->model_toko->select('alamat_toko, telepon_toko, deskripsi_toko, email_toko, logo_toko')->asArray()
				->where('id_toko', 1)->first(),
			'pengajuan' => $this->model_pengajuan->select('alasan, barang.nama as nama_barang,
				pengajuan.status as status_pengajuan,
				barang.status as status_barang, pengajuan.kode as kode_pengajuan, pengajuan.tanggal as tanggal_pengajuan,
				pengajuan.stok as jumlah, satuan.nama as nama_satuan,
				merek.nama as nama_merek, kategori.nama as nama_kategori,
				barang.harga_anggota as harga_anggota, barang.harga_konsumen as harga_konsumen,
				barang.harga_pokok as harga_pokok,
				barang.deskripsi as deskripsi')->asArray()
				->where('pengajuan.penyuplai_id', $id_penyuplai)
				->join('barang_masuk', 'barang_masuk.pengajuan_id = pengajuan.id')
				->join('barang', 'barang.id = barang_masuk.barang_id')
				->join('satuan', 'satuan.id = barang.satuan_id')
				->join('kategori', 'kategori.id = barang.kategori_id')
				->join('merek', 'merek.id = barang.merek_id')
				->groupBy('pengajuan.id')
				->findAll(),
			'konfirmasi' => $konfirm['status'] ?? NULL,
			'validation' => $this->validation,
			'session' => $this->session,
			'role_log' => $role,
			
		];
		
		tampilan_user(
			'user/user-riwayat-pengajuan/v_riwayat_pengajuan',
			'user/user-riwayat-pengajuan/v_js_riwayat_pengajuan',
			$data
		);
		
	}
}
