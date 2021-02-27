<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_barang_masuk extends Model{

    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $allowedFields = ['barang_id', 'pengirim_barang_id', 'jumlah_barang_masuk', 'harga_pokok_pb', 'total_harga_pokok', 'tanggal_masuk'];
    protected $useAutoIncrement = true;
    
}
?>