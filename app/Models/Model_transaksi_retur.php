<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_retur extends Model{

    public function __construct(){
        $this->db = \Config\Database::connect();
     }

    protected $table = 'transaksi_retur';
    protected $primaryKey = 'id_transaksi_retur';
    protected $allowedFields = [
        'transaksi_total_retur_id', 'r_barang_id', 'r_qty', 'r_subtotal',
        'n_barang_id', 'n_qty', 'n_subtotal'

    ];

    public function GetAllReturCari($awal, $akhir) {

        date_default_timezone_set("Asia/Jakarta");
        
        $builder = $this->db->table('transaksi_retur');
        $builder->select('barang_r.nama_barang as r_nama, barang_n.nama_barang as n_nama, r_qty, 
        r_subtotal, n_qty, n_subtotal, trt_kode_retur, role, nama, trt_r_total_harga, trt_n_qty,
        trt_n_total_harga, trt_role_id,trt_r_qty, trt_hp_kembalian, trt_hk_kembalian, trt_hk_total_bayar, 
        trt_hk_jumlah_uang, trt_tanggal, ,tt_kode_transaksi, tt_nama_penerima, barang_r.harga_konsumen as r_harga_konsumen, barang_r.harga_anggota as r_harga_anggota, barang_n.harga_konsumen as n_harga_konsumen, barang_n.harga_anggota as n_harga_anggota');
        $builder->join('transaksi_retur_total', 'transaksi_retur_total.id_transaksi_retur_total = transaksi_retur.transaksi_total_retur_id');
        $builder->join('transaksi_total', 'transaksi_total.id_transaksi_total = transaksi_retur_total.trt_transaksi_total_id');
        $builder->join('barang as barang_r', 'barang_r.id_barang = transaksi_retur.r_barang_id');
        $builder->join('barang as barang_n', 'barang_n.id_barang = transaksi_retur.n_barang_id');
        $builder->join('user_role', 'user_role.id_role = transaksi_retur_total.trt_role_id');
        $builder->join('user', 'user.id_user = transaksi_retur_total.trt_user_id');
        // $builder->where('barang_r.id_barang!=', 0);
        //$builder->where('barang_n.id_barang>', 0);
        $builder->where('DATE(trt_tanggal)>=', $awal);
        $builder->where('DATE(trt_tanggal)<=', $akhir);
        //$builder->orderBy('n_nama', 'DESC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    


    
}
?>