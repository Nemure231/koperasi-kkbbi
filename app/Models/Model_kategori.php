<?php namespace App\Models;
use CodeIgniter\Model;

class Model_kategori extends Model{

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $returnType           = 'array';
    protected $allowedFields = ['nama_kategori'];
    
}
?>