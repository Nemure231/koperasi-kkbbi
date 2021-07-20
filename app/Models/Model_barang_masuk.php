<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang_masuk extends Model{


    public function __construct(){
        $this->db = \Config\Database::connect();
    }

    protected $table = 'barang_masuk';
    // protected $primaryKey = 'id_barang_masuk';
    protected $allowedFields = [
        'barang_id', 'penyuplai_id', 'jumlah', 
        'harga_pokok', 'total_harga_pokok', 'tanggal'
    ];

    public function TambahBarangMasuk($data, $data2){
        $this->db->transStart();
        $builder = $this->db->table('barang_masuk');
        $builder->insertBatch($data);

        foreach ($data2 as  $dt):
            $datas[] = array(
                'bi' => $dt['barang_id'],
                'jml' =>  $dt['jumlah'],
                'pbi' =>  $dt['penyuplai_id'],
                'hp' => $dt['harga_pokok'],
                'ha' =>  $dt['harga_anggota'],
                'hk' =>  $dt['harga_konsumen'],
                
            );
            $jml = $dt['jumlah'];
            $idb = $dt['barang_id'];
            $hp = $dt['harga_pokok'];
            $ha = $dt['harga_anggota'];
            $hk = $dt['harga_konsumen'];
            $pbi = $dt['penyuplai_id'];
            $jmlesc = $this->db->escapeString($jml);
            $idbesc = $this->db->escapeString($idb);
            $hpesc = $this->db->escapeString($hp);
            $hkesc = $this->db->escapeString($hk);
            $haesc = $this->db->escapeString($ha);
            $pbiesc = $this->db->escapeString($pbi);
            $this->db->query("update barang set stok=stok+'$jmlesc' where id='$idbesc'");
            $this->db->table('barang')->set('harga_pokok', $hpesc)
            ->set('harga_konsumen', $hkesc)->set('harga_anggota', $haesc)
            ->set('penyuplai_id', $pbiesc)
            ->where('id', $idbesc)->update();
        endforeach;

        $this->db->transComplete();

    }

    // public function GetAllBarangMasukHariCari($tanggal = null) {

    //     date_default_timezone_set("Asia/Jakarta");
        
    //     if(!$tanggal){
    //     $tanggal= date('Y-m-d');
    //     }
    //     $builder = $this->db->table('barang_masuk');
    //     $builder->select('jumlah_barang_masuk,nama_barang, total_harga_pokok ,harga_pokok_pb, nama_pengirim_barang, tanggal_masuk, tanggal_masuk as jam');
    //     //$builder->selectSum('total_harga_pokok')->where('pengirim_barang_id', 'pengirim_barang_id');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
    //     $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
    //     $builder->where('DATE(tanggal_masuk)', $tanggal);
    //     $builder->orderBy('tanggal_masuk', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }


    public function GetAllBarangMasukMingguCari($awal_minggu, $akhir_minggu) {

        $builder = $this->db->table('barang_masuk');
        $builder->select('jumlah as jumlah_barang_masuk, barang.nama as nama_barang, total_harga_pokok,
        barang_masuk.harga_pokok as harga_pokok_pb, penyuplai.nama as nama_pengirim_barang, 
        barang_masuk.tanggal as tanggal_masuk, barang_masuk.tanggal as jam');
        $builder->join('penyuplai', 'penyuplai.id = barang_masuk.penyuplai_id');
        $builder->join('barang', 'barang.id = barang_masuk.barang_id');
        $builder->where('DATE(barang_masuk.tanggal)>=', $awal_minggu);
        $builder->where('DATE(barang_masuk.tanggal)<=', $akhir_minggu);
        $query = $builder->get()->getResultArray();
        return $query;
    }



    // public function GetAllBarangMasukBulanCari($bulan = null, $tahun = null) {

    //     date_default_timezone_set("Asia/Jakarta");
        
    //     if(!$bulan && !$tahun){
    //     $bulan= date('m');
    //     $tahun= date('Y');
    //     }

    //     $builder = $this->db->table('barang_masuk');
    //     $builder->select('jumlah_barang_masuk, total_harga_pokok, nama_barang, harga_pokok_pb, nama_pengirim_barang, tanggal_masuk as bulan');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
    //     $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
    //     //$builder->where('DAY(tanggal_masuk)', $day);
    //     $builder->where('MONTH(tanggal_masuk)', $bulan);
    //     $builder->where('YEAR(tanggal_masuk)', $tahun);
    //     $builder->orderBy('tanggal_masuk', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllBarangMasukTahunCari($cari_tahun = null) {

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$cari_tahun){
    //         $cari_tahun = date('Y');
    //     }

    //     $builder = $this->db->table('barang_masuk');
    //     $builder->select('jumlah_barang_masuk, total_harga_pokok, nama_barang, harga_pokok_pb, nama_pengirim_barang, tanggal_masuk');
    //     $builder->join('pengirim_barang', 'pengirim_barang.id_pengirim_barang = barang_masuk.pengirim_barang_id');
    //     $builder->join('barang', 'barang.id_barang = barang_masuk.barang_id');
    //     //$builder->where('DAY(tanggal_masuk)', $day);
    //     // $builder->where('MONTH(tanggal_masuk)', $month);
    //     $builder->where('YEAR(tanggal_masuk)', $cari_tahun);
    //     $builder->orderBy('tanggal_masuk', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllSummaryTanggalMasuk($bulan = null, $tahun = null){

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$bulan && !$tahun){
    //         $bulan= date('m');
    //         $tahun= date('Y');
    //     }
        
    //     $builder = $this->db->table('barang_masuk');
    //     $builder->select('DATE(tanggal_masuk) as nama_tanggal');
    //     $builder->selectSUM('total_harga_pokok', 'hargasum');
    //     $builder->where('MONTH(tanggal_masuk)', $bulan);
    //     $builder->where('YEAR(tanggal_masuk)', $tahun);
    //     $builder->groupBy('DATE(tanggal_masuk)');
    //     $builder->orderBy('tanggal_masuk', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllSummaryBulanMasuk($tahun = null){

    //     date_default_timezone_set("Asia/Jakarta");
    //     if(!$tahun){
    //         $tahun= date('Y');
    //     }
        
    //     $builder = $this->db->table('barang_masuk');
    //     $builder->select('MONTHNAME(tanggal_masuk) as nama_bulan');
    //     $builder->selectSUM('total_harga_pokok', 'hargasum');
    //     $builder->where('YEAR(tanggal_masuk)', $tahun);
    //     $builder->groupBy('MONTH(tanggal_masuk)');
    //     $builder->orderBy('tanggal_masuk', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }

    // public function GetAllSummaryTahunMasuk($awal, $akhir){

    //     $builder = $this->db->table('barang_masuk');
    //     $builder->select('YEAR(tanggal_masuk) as nama_tahun');
    //     $builder->selectSUM('total_harga_pokok', 'hargasum');
    //     $builder->where('YEAR(tanggal_masuk)>=', $awal);
    //     $builder->where('YEAR(tanggal_masuk)<=', $akhir);
    //     $builder->groupBy('YEAR(tanggal_masuk)');
    //     $builder->orderBy('YEAR(tanggal_masuk)', 'ASC');
    //     $query = $builder->get()->getResultArray();
    //     return $query;
    // }


    
}
?>