<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi extends Model{


    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'id_transaksi', 't_transaksi_total_id','t_barang_id',
        't_harga', 't_qty'
    ];


    
}
?>