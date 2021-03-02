<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_keranjang extends Model{

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $allowedFields = [
        'k_barang_id', 'k_qty',	'k_harga', 'k_user_id',	'k_kode_keranjang'	
    
    ];

   
}
?>