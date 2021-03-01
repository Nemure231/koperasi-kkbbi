<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi_retur extends Model{

    protected $table = 'transaksi_retur';
    protected $primaryKey = 'id_transaksi_retur';
    protected $returnType = 'array';
    protected $allowedFields = [
        'transaksi_total_retur_id', 'r_barang_id', 'r_qty', 'r_subtotal',
        'n_barang_id', 'n_qty', 'n_subtotal'

    ];
    
}
?>