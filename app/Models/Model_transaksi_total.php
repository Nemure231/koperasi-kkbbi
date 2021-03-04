<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_total extends Model{

    public function __construct(){
        
		$this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
	}

    protected $table = 'transaksi_total';
    protected $primaryKey = 'id_transaksi_total';
    protected $allowedFields = ['tt_kode_transaksi', 'tt_user_id', 'tt_role_id', 'tt_total_harga', 'tt_total_qty', 'tt_jumlah_uang', 'tt_kembalian', 'tt_nama_penerima', 'tt_telepon_penerima', 'tt_tanggal_beli'];
    

    public function AutoKodeTransaksi(){
        date_default_timezone_set("Asia/Jakarta");
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $query = $this->db->table('transaksi_total')
                        ->select('RIGHT(transaksi_total.tt_kode_transaksi,2) as tt_kode_transaksi', FALSE)
                        ->orderBy('tt_kode_transaksi', 'DESC')
                        ->limit(1)->get()->getRowArray();

            if (count($query) <> 0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['tt_kode_transaksi']) + 1;
            }else{
                $kode =1;
            }
       
        $kode1 = $this->db->table('tb_kode_transaksi')
                            ->select('huruf_kode_transaksi, jumlah_angka')
                            ->get()->getRowArray();
    
            $batas= str_pad($kode, "".$kode1['jumlah_angka']."","0", STR_PAD_LEFT);
            $bulan = date('my');
            $random = rand(1, 1000);
            $kodetampil= "".$kode1['huruf_kode_transaksi']."" .$random.$bulan.$id_user.$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }

    public function GetAllBarangKeluarHariCari($tanggal = null) {

        date_default_timezone_set("Asia/Jakarta");
    
        if(!$tanggal){
            $tanggal = date('Y-m-d');
        }
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as jam, tt_role_id, stok_barang ,nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)', $tanggal);
        //$builder->groupBy('tt_kode_transaksi');
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangKeluarHariCariTambah($tanggal = null) {

        date_default_timezone_set("Asia/Jakarta");
    
        if(!$tanggal){
            $tanggal = date('Y-m-d');
        }
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as jam, tt_role_id, stok_barang, nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)', $tanggal);
        $builder->groupBy('id_barang');
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangKeluarMingguCari($awal_minggu, $akhir_minggu) {

        date_default_timezone_set("Asia/Jakarta");
        // $day= date('d');
        // $month= date('m');
        // $years= date('Y');
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as tanggal, tt_role_id, nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)>=', $awal_minggu);
        $builder->where('DATE(tt_tanggal_beli)<=', $akhir_minggu);
        $builder->orderBy('tt_kode_transaksi', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangKeluarMingguCariTambah($awal_minggu, $akhir_minggu) {

        date_default_timezone_set("Asia/Jakarta");
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as tanggal, tt_role_id, stok_barang,nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima,  nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('DATE(tt_tanggal_beli)>=', $awal_minggu);
        $builder->where('DATE(tt_tanggal_beli)<=', $akhir_minggu);
        $builder->orderBy('tt_kode_transaksi', 'ASC');
        $builder->groupBy('id_barang');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangKeluarBulanCari($month = null, $year = null) {


        date_default_timezone_set("Asia/Jakarta");
        if(!$month && !$year){
            $month= date('m');
            $year= date('Y');
        }
       
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as tanggal, nama_pengirim_barang,tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $year);
        //$builder->like('YEAR(tt_tanggal_beli)', $year);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }



    public function GetAllBarangKeluarBulanCariTambah($month = null, $year = null) {


        date_default_timezone_set("Asia/Jakarta");
        if(!$month && !$year){
            $month= date('m');
            $year= date('Y');
        }
       
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as tanggal, stok_barang,nama_pengirim_barang,tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('MONTH(tt_tanggal_beli)', $month);
        $builder->where('YEAR(tt_tanggal_beli)', $year);
        $builder->groupBy('id_barang');
        //$builder->like('YEAR(tt_tanggal_beli)', $year);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }





    public function GetAllBarangKeluarTahunCari($cari_tahun = null) {

        date_default_timezone_set("Asia/Jakarta");
        if(!$cari_tahun){
            $cari_tahun = date('Y');
        }
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as tanggal,nama_pengirim_barang, tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('YEAR(tt_tanggal_beli)', $cari_tahun);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }


    public function GetAllBarangKeluarTahunCariTambah($cari_tahun = null) {

        date_default_timezone_set("Asia/Jakarta");
        if(!$cari_tahun){
            $cari_tahun = date('Y');
        }
        $builder = $this->db->table('transaksi_total');
        $builder->select('tt_tanggal_beli as tanggal,nama_pengirim_barang, stok_barang, tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('t_qty');
        $builder->selectSUM('t_harga');
        $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
        $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
        $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
        $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
        $builder->where('id_transaksi_total>', 1);
        $builder->where('YEAR(tt_tanggal_beli)', $cari_tahun);
        $builder->orderBy('tt_tanggal_beli', 'ASC');
        $builder->groupBy('id_barang');
        $query = $builder->get()->getResultArray();
        return $query;
    }


}
?>