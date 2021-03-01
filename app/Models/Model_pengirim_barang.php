<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_pengirim_barang extends Model{

    protected $table = 'pengirim_barang';
    protected $primaryKey = 'id_pengirim_barang';
    protected $returnType  = 'array';
    protected $allowedFields = ['nama_pengirim_barang'];
    
}
?>