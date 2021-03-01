<?php namespace App\Models;
use CodeIgniter\Model;

class Model_transaksi_retur_total extends Model{

    protected $table = 'transaksi_retur_total';
    protected $primaryKey = 'id_transaksi_retur_total';
    protected $returnType = 'array';
    protected $allowedFields = [
        'trt_transaksi_total_id', 'trt_kode_retur', 'trt_role_id',
        'trt_user_id', 'trt_r_total_harga', 'trt_r_qty','trt_n_total_harga',
        'trt_n_qty','trt_hp_kembalian', 'trt_hk_total_bayar', 'trt_hk_jumlah_uang',
        'trt_hk_kembalian','trt_tanggal'
    ];
    
}
?>