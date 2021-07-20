<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_transaksi extends Model{


    protected $table = 'transaksi';
    protected $allowedFields = [ 
        'detail_transaksi_id',
        'barang_id',
        'harga',
        'qty'
    ];


    


    
}
?>