<?php namespace App\Models;
use CodeIgniter\Model;
 
class Model_satuan extends Model{

    protected $table = 'satuan';
    protected $primaryKey = 'id_satuan';
    protected $allowedFields = ['nama_satuan'];
    
}
?>