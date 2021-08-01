<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_detail_transaksi extends Model{

    public function __construct(){
        
		$this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
	}

    protected $table = 'detail_transaksi';
    protected $allowedFields = [
        'kode', 'user_id', 'role_id', 'total_harga', 'total_qty', 
        'jumlah_uang','penyuplai_id', 'status', 'kembalian', 'tt_nama_penerima', 'tt_telepon_penerima', 'tanggal'];
    

    public function AutoKodeTransaksi($kode_jenis_kasir){
        date_default_timezone_set("Asia/Jakarta");
        $id_user = $this->session->get('id_user');
        $this->db->transStart();
        $query = $this->db->table('detail_transaksi')
            ->select('RIGHT(detail_transaksi.kode,3) as kode', FALSE)
            ->orderBy('kode', 'DESC')
            ->limit(1)->get()->getRowArray();

            if (count($query) <> 0) {
                //$query2 = $query->get()->getRowArray();
                $kode= intval($query['kode']) + 1;
            }else{
                $kode =1;
            }
       
        // $kode1 = $this->db->table('tb_kode_transaksi')
        //                     ->select('huruf_kode_transaksi, jumlah_angka')
        //                     ->get()->getRowArray();
    
            $batas= str_pad($kode, ""."3"."","0", STR_PAD_LEFT);
            $bulan = date('dmy');
            $random = rand(1, 1000);
            $kodetampil= "".'TSK'."" .$kode_jenis_kasir.$id_user.$bulan.$batas;
            return $kodetampil;
            
        $this->db->transComplete();
    }




















    // public function GetAllBarangKeluarHariCari($tanggal = null) {

    //     date_default_timezone_set("Asia/Jakarta");
    
    //     if(!$tanggal){
    //         $tanggal = date('Y-m-d');
    //     }
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('tt_tanggal_beli as jam, tt_role_id, stok_barang ,nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
    //     $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
    //     $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
    //     $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
    //     $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
    //     $builder->where('id_transaksi_total>', 1);
    //     $builder->where('DATE(tt_tanggal_beli)', $tanggal);
    //     //$builder->groupBy('tt_kode_transaksi');
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllBarangKeluarHariCariTambah($tanggal = null) {

    //     date_default_timezone_set("Asia/Jakarta");
    
    //     if(!$tanggal){
    //         $tanggal = date('Y-m-d');
    //     }
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('tt_tanggal_beli as jam, tt_role_id, stok_barang, nama_pengirim_barang,tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
    //     $builder->selectSUM('t_qty');
    //     $builder->selectSUM('t_harga');
    //     $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
    //     $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
    //     $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
    //     $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
    //     $builder->where('id_transaksi_total>', 1);
    //     $builder->where('DATE(tt_tanggal_beli)', $tanggal);
    //     $builder->groupBy('id_barang');
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }


    public function GetAllBarangKeluarMingguCari($awal_minggu, $akhir_minggu) {

        date_default_timezone_set("Asia/Jakarta");
        // $day= date('d');
        // $month= date('m');
        // $years= date('Y');
        $builder = $this->db->table('detail_transaksi');
        $builder->select('detail_transaksi.tanggal as tanggal, tt_role_id, penyuplai.nama as nama_pengirim_barang,
        detail_transaksi.kembalian as tt_kembalian, user.nama as nama, role.nama as role,
        detail_transaksi.kode as tt_kode_transaksi, tt_nama_penerima, barang.nama as nama_barang, transaksi.qty as t_qty, 
        transaksi.harga as t_harga, detail_transaksi.total_harga as tt_total_harga, detail_transaksi.jumlah_uang as tt_jumlah_uang,
        harga_konsumen, harga_anggota');
        $builder->join('transaksi', 'transaksi.detail_transaksi_id = detail_transaksi.id');
        $builder->join('barang', 'barang.id = transaksi.barang_id');
        $builder->join('role', 'role.id = detail_transaksi.tt_role_id');
        $builder->join('user', 'user.id = detail_transaksi.user_id');
        $builder->join('penyuplai', 'penyuplai.id = barang.penyuplai_id');
        $builder->where('detail_transaksi.id>', 1);
        $builder->where('DATE(detail_transaksi.tanggal)>=', $awal_minggu);
        $builder->where('DATE(detail_transaksi.tanggal)<=', $akhir_minggu);
        $builder->orderBy('detail_transaksi.kode', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function GetAllBarangKeluarMingguCariTambah($awal_minggu, $akhir_minggu) {

        date_default_timezone_set("Asia/Jakarta");
        $builder = $this->db->table('detail_transaksi');
        $builder->select('detail_transaksi.tanggal as tanggal, tt_role_id, barang.stok as stok_barang,
        penyuplai.nama as nama_pengirim_barang, detail_transaksi.kembalian as tt_kembalian, user.nama as nama, role.nama as role,
        detail_transaksi.kode as tt_kode_transaksi, tt_nama_penerima, barang.nama as nama_barang, detail_transaksi.total_harga
        as tt_total_harga, detail_transaksi.jumlah_uang as tt_jumlah_uang, harga_konsumen, harga_anggota');
        $builder->selectSUM('transaksi.qty', 't_qty');
        $builder->selectSUM('transaksi.harga', 't_harga');
        $builder->join('transaksi', 'transaksi.detail_transaksi_id = detail_transaksi.id');
        $builder->join('barang', 'barang.id = transaksi.barang_id');
        $builder->join('role', 'role.id = detail_transaksi.tt_role_id');
        $builder->join('user', 'user.id = detail_transaksi.user_id');
        $builder->join('penyuplai', 'penyuplai.id = barang.penyuplai_id');
        $builder->where('detail_transaksi.id>', 1);
        $builder->where('DATE(detail_transaksi.tanggal)>=', $awal_minggu);
        $builder->where('DATE(detail_transaksi.tanggal)<=', $akhir_minggu);
        $builder->orderBy('detail_transaksi.kode', 'ASC');
        $builder->groupBy('barang.id');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    // public function GetAllBarangKeluarBulanCari($month = null, $year = null) {


    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$month && !$year){
    //         $month= date('m');
    //         $year= date('Y');
    //     }
       
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('tt_tanggal_beli as tanggal, nama_pengirim_barang,tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
    //     $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
    //     $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
    //     $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
    //     $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
    //     $builder->where('id_transaksi_total>', 1);
    //     $builder->where('MONTH(tt_tanggal_beli)', $month);
    //     $builder->where('YEAR(tt_tanggal_beli)', $year);
    //     //$builder->like('YEAR(tt_tanggal_beli)', $year);
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }



    // public function GetAllBarangKeluarBulanCariTambah($month = null, $year = null) {


    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$month && !$year){
    //         $month= date('m');
    //         $year= date('Y');
    //     }
       
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('tt_tanggal_beli as tanggal, stok_barang,nama_pengirim_barang,tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
    //     $builder->selectSUM('t_qty');
    //     $builder->selectSUM('t_harga');
    //     $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
    //     $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
    //     $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
    //     $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
    //     $builder->where('id_transaksi_total>', 1);
    //     $builder->where('MONTH(tt_tanggal_beli)', $month);
    //     $builder->where('YEAR(tt_tanggal_beli)', $year);
    //     $builder->groupBy('id_barang');
    //     //$builder->like('YEAR(tt_tanggal_beli)', $year);
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }





    // public function GetAllBarangKeluarTahunCari($cari_tahun = null) {

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$cari_tahun){
    //         $cari_tahun = date('Y');
    //     }
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('tt_tanggal_beli as tanggal,nama_pengirim_barang, tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, t_qty, t_harga, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
    //     $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
    //     $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
    //     $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
    //     $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
    //     $builder->where('id_transaksi_total>', 1);
    //     $builder->where('YEAR(tt_tanggal_beli)', $cari_tahun);
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }


    // public function GetAllBarangKeluarTahunCariTambah($cari_tahun = null) {

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$cari_tahun){
    //         $cari_tahun = date('Y');
    //     }
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('tt_tanggal_beli as tanggal,nama_pengirim_barang, stok_barang, tt_role_id, tt_kembalian,nama, role,tt_kode_transaksi, tt_nama_penerima, nama_barang, tt_total_harga, tt_jumlah_uang, harga_konsumen, harga_anggota');
    //     $builder->selectSUM('t_qty');
    //     $builder->selectSUM('t_harga');
    //     $builder->join('transaksi', 'transaksi.t_transaksi_total_id = transaksi_total.id_transaksi_total');
    //     $builder->join('barang', 'barang.id_barang = transaksi.t_barang_id');
    //     $builder->join('user_role', 'user_role.id_role = transaksi_total.tt_role_id');
    //     $builder->join('user', 'user.id_user = transaksi_total.tt_user_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang.pengirim_barang_id');
    //     $builder->where('id_transaksi_total>', 1);
    //     $builder->where('YEAR(tt_tanggal_beli)', $cari_tahun);
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $builder->groupBy('id_barang');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllSummaryTanggalKeluar($bulan = null, $tahun = null){

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$bulan && !$tahun){
    //         $bulan= date('m');
    //         $tahun= date('Y');
    //     }
        
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('DATE(tt_tanggal_beli) as nama_tanggal');
    //     $builder->selectSUM('tt_total_harga', 'hargasum');
    //     $builder->where('tt_total_harga>', 0);
    //     $builder->where('MONTH(tt_tanggal_beli)', $bulan);
    //     $builder->where('YEAR(tt_tanggal_beli)', $tahun);
    //     $builder->groupBy('DATE(tt_tanggal_beli)');
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllSummaryBulanKeluar($tahun = null){

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$tahun){
    //         $tahun= date('Y');
    //     }
        
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('MONTHNAME(tt_tanggal_beli) as nama_bulan');
    //     $builder->selectSUM('tt_total_harga', 'hargasum');
    //     $builder->where('tt_total_harga>', 0);
    //     $builder->where('YEAR(tt_tanggal_beli)', $tahun);
    //     $builder->groupBy('MONTH(tt_tanggal_beli)');
    //     $builder->orderBy('tt_tanggal_beli', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllSummaryTahunKeluar($awal, $akhir){
        
    //     $builder = $this->db->table('transaksi_total');
    //     $builder->select('YEAR(tt_tanggal_beli) as nama_tahun');
    //     $builder->selectSUM('tt_total_harga', 'hargasum');
    //     $builder->where('tt_total_harga>', 0);
    //     $builder->where('YEAR(tt_tanggal_beli)>=', $awal);
    //     $builder->where('YEAR(tt_tanggal_beli)<=', $akhir);
    //     $builder->groupBy('YEAR(tt_tanggal_beli)');
    //     $builder->orderBy('YEAR(tt_tanggal_beli)', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }


}
?>