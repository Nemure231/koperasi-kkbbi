<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_sementara_retur extends Model{

    protected $table = 'transaksi_sementara_retur';
    protected $primaryKey = 'id_transaksi_sementara_retur';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tsr_transaksi_total_retur_id', 'tsr_role_id',
        'tsr_user_id', 'tsr_kode_retur', 'tsr_r_barang_id',
        'tsr_r_qty', 'tsr_subtotal', 'tsr_n_barang_id',
        'tsr_n_qty', 'tsr_n_subtotal', 'tsr_kembalian_pl',
        'tsr_total_bayar_k', 'tsr_jumlah_uang_k', 'tsr_kembalian_k'

    ];
    
}
?>